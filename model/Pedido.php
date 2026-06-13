<?php

require_once __DIR__ . '/Conexao.php';
require_once __DIR__ . '/Carrinho.php';

class Pedido
{
    private static $schemaVerificado = false;

    private static function garantirCamposRetirada()
    {
        if (self::$schemaVerificado) {
            return;
        }

        $conn = Conexao::conectar();
        $colunas = array();
        $resultado = $conn->query('SHOW COLUMNS FROM pedidos');

        while ($coluna = $resultado->fetch_assoc()) {
            $colunas[$coluna['Field']] = true;
        }

        if (!isset($colunas['forma_retirada'])) {
            $conn->query("ALTER TABLE pedidos ADD COLUMN forma_retirada VARCHAR(20) NOT NULL DEFAULT 'entrega' AFTER metodo_pagamento");
        }

        if (!isset($colunas['tempo_estimado_preparo'])) {
            $conn->query('ALTER TABLE pedidos ADD COLUMN tempo_estimado_preparo INT NOT NULL DEFAULT 40 AFTER status');
        }

        self::$schemaVerificado = true;
    }

    public static function criar($clienteId, $entrega, $pagamento)
    {
        self::garantirCamposRetirada();

        $clienteId = (int) $clienteId;
        $itens = Carrinho::itens($clienteId);

        if (empty($itens)) {
            return array('ok' => false, 'mensagem' => 'Seu carrinho está vazio.');
        }

        foreach ($itens as $item) {
            if ((int) $item['quantidade'] > (int) $item['estoque']) {
                return array('ok' => false, 'mensagem' => 'O produto ' . $item['nome'] . ' não possui estoque suficiente.');
            }
        }

        $subtotal = Carrinho::subtotal($clienteId);
        $formaRetirada = ($entrega['forma_retirada'] ?? 'entrega') === 'retirada' ? 'retirada' : 'entrega';
        $frete = $formaRetirada === 'entrega' && $subtotal < 80 ? 7.90 : 0.00;
        $metodo = $pagamento['metodo_pagamento'] ?? 'pix';
        $descontoPix = $metodo === 'pix' ? round($subtotal * 0.05, 2) : 0.00;
        $desconto = $descontoPix;
        $total = max(0, $subtotal + $frete - $desconto);
        $numeroPedido = 'NB' . date('YmdHis') . random_int(10, 99);
        $status = 'Recebido';
        $tempoEstimado = 40;

        $conn = Conexao::conectar();
        $conn->begin_transaction();

        try {
            $idEndereco = null;

            if ($formaRetirada === 'entrega') {
                $nomeDestinatario = trim($entrega['nome_destinatario'] ?? '');
                $telefone = trim($entrega['telefone'] ?? '');
                $cep = trim($entrega['cep'] ?? '');
                $endereco = trim($entrega['endereco'] ?? '');
                $numero = trim($entrega['numero'] ?? '');
                $complemento = trim($entrega['complemento'] ?? '');
                $bairro = trim($entrega['bairro'] ?? '');
                $cidade = trim($entrega['cidade'] ?? '');
                $uf = strtoupper(trim($entrega['uf'] ?? ''));

                $stmt = $conn->prepare(
                    'INSERT INTO enderecos
                     (id_cliente, nome_destinatario, telefone, cep, endereco, numero, complemento, bairro, cidade, uf, frete)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
                );
                $stmt->bind_param(
                    'isssssssssd',
                    $clienteId,
                    $nomeDestinatario,
                    $telefone,
                    $cep,
                    $endereco,
                    $numero,
                    $complemento,
                    $bairro,
                    $cidade,
                    $uf,
                    $frete
                );
                $stmt->execute();
                $idEndereco = $conn->insert_id;
            }

            $stmt = $conn->prepare(
                'INSERT INTO pedidos
                 (numero_pedido, id_cliente, id_endereco, metodo_pagamento, forma_retirada, subtotal, frete, desconto, total, status, tempo_estimado_preparo)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );
            $stmt->bind_param(
                'siissddddsi',
                $numeroPedido,
                $clienteId,
                $idEndereco,
                $metodo,
                $formaRetirada,
                $subtotal,
                $frete,
                $desconto,
                $total,
                $status,
                $tempoEstimado
            );
            $stmt->execute();
            $idPedido = $conn->insert_id;

            $stmtItem = $conn->prepare(
                'INSERT INTO pedido_itens
                 (id_pedido, id_produto, nome_produto, quantidade, preco_unitario, subtotal)
                 VALUES (?, ?, ?, ?, ?, ?)'
            );
            $stmtEstoque = $conn->prepare(
                'UPDATE produtos SET estoque = estoque - ? WHERE id_produto = ?'
            );

            foreach ($itens as $item) {
                $idProduto = (int) $item['id_produto'];
                $nomeProduto = $item['nome'];
                $quantidade = (int) $item['quantidade'];
                $preco = (float) $item['preco_unitario'];
                $subtotalItem = $quantidade * $preco;

                $stmtItem->bind_param('iisidd', $idPedido, $idProduto, $nomeProduto, $quantidade, $preco, $subtotalItem);
                $stmtItem->execute();

                $stmtEstoque->bind_param('ii', $quantidade, $idProduto);
                $stmtEstoque->execute();
            }

            $stmt = $conn->prepare('DELETE FROM carrinho WHERE id_cliente = ?');
            $stmt->bind_param('i', $clienteId);
            $stmt->execute();

            $conn->commit();

            return array('ok' => true, 'numero_pedido' => $numeroPedido, 'id_pedido' => $idPedido);
        } catch (Throwable $erro) {
            $conn->rollback();
            return array('ok' => false, 'mensagem' => 'Não foi possível finalizar o pedido: ' . $erro->getMessage());
        }
    }

    public static function buscarPorNumero($numeroPedido, $clienteId = null)
    {
        self::garantirCamposRetirada();

        $sql = 'SELECT p.*, c.nome AS cliente_nome, c.email AS cliente_email,
                       e.nome_destinatario, e.telefone, e.cep, e.endereco, e.numero, e.complemento,
                       e.bairro, e.cidade, e.uf
                FROM pedidos p
                INNER JOIN clientes c ON c.id_cliente = p.id_cliente
                LEFT JOIN enderecos e ON e.id_endereco = p.id_endereco
                WHERE p.numero_pedido = ?';
        $types = 's';
        $params = array($numeroPedido);

        if ($clienteId !== null) {
            $sql .= ' AND p.id_cliente = ?';
            $types .= 'i';
            $params[] = (int) $clienteId;
        }

        $pedido = Conexao::fetchOne($sql . ' LIMIT 1', $types, $params);
        if (!$pedido) {
            return null;
        }

        $pedido['itens'] = Conexao::fetchAll(
            'SELECT * FROM pedido_itens WHERE id_pedido = ? ORDER BY id_item ASC',
            'i',
            array((int) $pedido['id_pedido'])
        );

        return $pedido;
    }

    public static function listarCliente($clienteId)
    {
        self::garantirCamposRetirada();

        return Conexao::fetchAll(
            'SELECT * FROM pedidos WHERE id_cliente = ? ORDER BY criado_em DESC',
            'i',
            array((int) $clienteId)
        );
    }

    public static function listarRecentes($limite = 12)
    {
        self::garantirCamposRetirada();

        $limite = max(1, min(50, (int) $limite));

        return Conexao::fetchAll(
            'SELECT p.*, c.nome AS cliente_nome
             FROM pedidos p
             INNER JOIN clientes c ON c.id_cliente = p.id_cliente
             ORDER BY p.criado_em DESC
             LIMIT ?',
            'i',
            array($limite)
        );
    }

    public static function atualizarStatus($idPedido, $status, $tempoEstimado = 40)
    {
        self::garantirCamposRetirada();

        $permitidos = array('Recebido', 'Em preparo', 'Saiu para entrega', 'Finalizado', 'Cancelado');

        if (!in_array($status, $permitidos, true)) {
            return array('ok' => false, 'mensagem' => 'Status inválido.');
        }

        $tempoEstimado = max(1, (int) $tempoEstimado);

        Conexao::preparar(
            'UPDATE pedidos SET status = ?, tempo_estimado_preparo = ? WHERE id_pedido = ?',
            'sii',
            array($status, $tempoEstimado, (int) $idPedido)
        );

        return array('ok' => true);
    }

    public static function metricas()
    {
        self::garantirCamposRetirada();

        return array(
            'clientes' => (int) ((Conexao::fetchOne('SELECT COUNT(*) AS total FROM clientes')['total']) ?? 0),
            'funcionarios' => (int) ((Conexao::fetchOne('SELECT COUNT(*) AS total FROM funcionarios')['total']) ?? 0),
            'produtos' => (int) ((Conexao::fetchOne('SELECT COUNT(*) AS total FROM produtos WHERE ativo = 1')['total']) ?? 0),
            'estoque_baixo' => (int) ((Conexao::fetchOne('SELECT COUNT(*) AS total FROM produtos WHERE ativo = 1 AND estoque <= 5')['total']) ?? 0),
            'pedidos' => (int) ((Conexao::fetchOne('SELECT COUNT(*) AS total FROM pedidos')['total']) ?? 0),
            'receita' => (float) ((Conexao::fetchOne("SELECT COALESCE(SUM(total), 0) AS total FROM pedidos WHERE status <> 'Cancelado'")['total']) ?? 0),
        );
    }
}
