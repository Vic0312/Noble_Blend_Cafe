<?php

require_once __DIR__ . '/Conexao.php';
require_once __DIR__ . '/Produto.php';

class Carrinho
{
    public static function itens($clienteId)
    {
        return Conexao::fetchAll(
            'SELECT c.id_carrinho, c.id_produto, c.quantidade, c.preco_unitario,
                    (c.quantidade * c.preco_unitario) AS subtotal,
                    p.nome, p.imagem, p.categoria, p.estoque, p.preco, p.preco_clube
             FROM carrinho c
             INNER JOIN produtos p ON p.id_produto = c.id_produto
             WHERE c.id_cliente = ?
             ORDER BY c.atualizado_em DESC',
            'i',
            array((int) $clienteId)
        );
    }

    public static function subtotal($clienteId)
    {
        $row = Conexao::fetchOne(
            'SELECT COALESCE(SUM(quantidade * preco_unitario), 0) AS total
             FROM carrinho
             WHERE id_cliente = ?',
            'i',
            array((int) $clienteId)
        );

        return (float) ($row['total'] ?? 0);
    }

    public static function quantidadeTotal($clienteId)
    {
        $row = Conexao::fetchOne(
            'SELECT COALESCE(SUM(quantidade), 0) AS total
             FROM carrinho
             WHERE id_cliente = ?',
            'i',
            array((int) $clienteId)
        );

        return (int) ($row['total'] ?? 0);
    }

    public static function adicionar($clienteId, $produtoId, $quantidade)
    {
        $clienteId = (int) $clienteId;
        $produtoId = (int) $produtoId;
        $quantidade = max(1, (int) $quantidade);

        $produto = Produto::buscar($produtoId);
        if (!$produto || (int) $produto['ativo'] !== 1) {
            return array('ok' => false, 'mensagem' => 'Produto não encontrado.');
        }

        if ((int) $produto['estoque'] <= 0) {
            return array('ok' => false, 'mensagem' => 'Produto sem estoque no momento.');
        }

        $item = Conexao::fetchOne(
            'SELECT quantidade FROM carrinho WHERE id_cliente = ? AND id_produto = ? LIMIT 1',
            'ii',
            array($clienteId, $produtoId)
        );

        $quantidadeAtual = $item ? (int) $item['quantidade'] : 0;
        $novaQuantidade = $quantidadeAtual + $quantidade;

        if ($novaQuantidade > (int) $produto['estoque']) {
            return array('ok' => false, 'mensagem' => 'A quantidade escolhida passa do estoque disponível.');
        }

        $precoCliente = Produto::precoParaCliente($produto, $clienteId);

        if ($item) {
            Conexao::preparar(
                'UPDATE carrinho
                 SET quantidade = ?, preco_unitario = ?, atualizado_em = NOW()
                 WHERE id_cliente = ? AND id_produto = ?',
                'idii',
                array($novaQuantidade, $precoCliente, $clienteId, $produtoId)
            );
        } else {
            Conexao::preparar(
                'INSERT INTO carrinho (id_cliente, id_produto, quantidade, preco_unitario)
                 VALUES (?, ?, ?, ?)',
                'iiid',
                array($clienteId, $produtoId, $quantidade, $precoCliente)
            );
        }

        return array('ok' => true, 'mensagem' => 'Produto adicionado ao carrinho.');
    }

    public static function atualizar($clienteId, $produtoId, $quantidade)
    {
        $clienteId = (int) $clienteId;
        $produtoId = (int) $produtoId;
        $quantidade = (int) $quantidade;

        if ($quantidade <= 0) {
            self::remover($clienteId, $produtoId);
            return array('ok' => true, 'mensagem' => 'Item removido.');
        }

        $produto = Produto::buscar($produtoId);
        if (!$produto) {
            return array('ok' => false, 'mensagem' => 'Produto não encontrado.');
        }

        if ($quantidade > (int) $produto['estoque']) {
            return array('ok' => false, 'mensagem' => 'Quantidade maior que o estoque disponível.');
        }

        $precoCliente = Produto::precoParaCliente($produto, $clienteId);

        Conexao::preparar(
            'UPDATE carrinho
             SET quantidade = ?, preco_unitario = ?, atualizado_em = NOW()
             WHERE id_cliente = ? AND id_produto = ?',
            'idii',
            array($quantidade, $precoCliente, $clienteId, $produtoId)
        );

        return array('ok' => true, 'mensagem' => 'Carrinho atualizado.');
    }

    public static function remover($clienteId, $produtoId)
    {
        Conexao::preparar(
            'DELETE FROM carrinho WHERE id_cliente = ? AND id_produto = ?',
            'ii',
            array((int) $clienteId, (int) $produtoId)
        );
    }

    public static function limpar($clienteId)
    {
        Conexao::preparar(
            'DELETE FROM carrinho WHERE id_cliente = ?',
            'i',
            array((int) $clienteId)
        );
    }
}
