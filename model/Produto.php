<?php

require_once __DIR__ . '/Conexao.php';

class Produto
{
    private static function normalizarTexto($valor)
    {
        $texto = trim((string) $valor);

        if ($texto === '') {
            return '';
        }

        if (function_exists('mb_check_encoding') && !mb_check_encoding($texto, 'UTF-8')) {
            $convertido = mb_convert_encoding($texto, 'UTF-8', 'Windows-1252,ISO-8859-1');
            return is_string($convertido) ? $convertido : $texto;
        }

        if (!preg_match('//u', $texto)) {
            $convertido = @iconv('Windows-1252', 'UTF-8//IGNORE', $texto);
            return is_string($convertido) ? $convertido : $texto;
        }

        return $texto;
    }

    public static function listar($filtros = array())
    {
        $where = array();
        $params = array();
        $types = '';

        if (empty($filtros['incluir_inativos'])) {
            $where[] = 'ativo = 1';
        }

        if (!empty($filtros['busca'])) {
            $busca = '%' . trim($filtros['busca']) . '%';
            $where[] = '(nome LIKE ? OR descricao_curta LIKE ? OR descricao LIKE ?)';
            $params[] = $busca;
            $params[] = $busca;
            $params[] = $busca;
            $types .= 'sss';
        }

        if (!empty($filtros['categoria'])) {
            $where[] = 'categoria = ?';
            $params[] = $filtros['categoria'];
            $types .= 's';
        }

        if (isset($filtros['preco_max']) && $filtros['preco_max'] !== '') {
            $where[] = 'preco <= ?';
            $params[] = (float) $filtros['preco_max'];
            $types .= 'd';
        }

        if (!empty($filtros['em_estoque'])) {
            $where[] = 'estoque > 0';
        }

        $sql = 'SELECT * FROM produtos';
        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $ordens = array(
            'nome_desc' => 'nome DESC',
            'preco_asc' => 'preco ASC',
            'preco_desc' => 'preco DESC',
            'estoque_asc' => 'estoque ASC',
            'recentes' => 'criado_em DESC',
        );

        $ordem = isset($ordens[$filtros['ordem'] ?? '']) ? $ordens[$filtros['ordem']] : 'nome ASC';
        $sql .= ' ORDER BY ' . $ordem;

        return Conexao::fetchAll($sql, $types, $params);
    }

    public static function categorias()
    {
        return Conexao::fetchAll(
            'SELECT DISTINCT categoria FROM produtos WHERE ativo = 1 AND categoria <> "" ORDER BY categoria ASC'
        );
    }

    public static function buscar($id)
    {
        return Conexao::fetchOne(
            'SELECT * FROM produtos WHERE id_produto = ? LIMIT 1',
            'i',
            array((int) $id)
        );
    }

    public static function salvar($dados)
    {
        $id = (int) ($dados['id_produto'] ?? 0);
        $nome = self::normalizarTexto($dados['nome'] ?? '');
        $categoria = self::normalizarTexto($dados['categoria'] ?? '');
        $descricaoCurta = self::normalizarTexto($dados['descricao_curta'] ?? '');
        $descricao = self::normalizarTexto($dados['descricao'] ?? '');
        $preco = (float) str_replace(',', '.', (string) ($dados['preco'] ?? 0));
        $precoClubeBruto = $dados['preco_clube'] ?? '';
        $precoClube = $precoClubeBruto !== ''
            ? (float) str_replace(',', '.', (string) $precoClubeBruto)
            : $preco;
        $estoque = max(0, (int) ($dados['estoque'] ?? 0));
        $imagem = trim($dados['imagem'] ?? '');
        $ativo = isset($dados['ativo']) ? (int) $dados['ativo'] : 1;

        if ($nome === '' || $categoria === '' || $preco <= 0 || $precoClube <= 0) {
            return array('ok' => false, 'mensagem' => 'Informe nome, categoria e preços válidos.');
        }

        if ($imagem === '') {
            $imagem = 'img/pacote_cafe.png';
        }

        if ($id > 0) {
            Conexao::preparar(
                'UPDATE produtos
                 SET nome = ?, categoria = ?, descricao_curta = ?, descricao = ?, preco = ?, preco_clube = ?, estoque = ?, imagem = ?, ativo = ?
                 WHERE id_produto = ?',
                'ssssddisii',
                array($nome, $categoria, $descricaoCurta, $descricao, $preco, $precoClube, $estoque, $imagem, $ativo, $id)
            );

            return array('ok' => true, 'id' => $id);
        }

        Conexao::preparar(
            'INSERT INTO produtos (nome, categoria, descricao_curta, descricao, preco, preco_clube, estoque, imagem, ativo)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
            'ssssddisi',
            array($nome, $categoria, $descricaoCurta, $descricao, $preco, $precoClube, $estoque, $imagem, $ativo)
        );

        return array('ok' => true, 'id' => Conexao::conectar()->insert_id);
    }

    public static function desativar($id)
    {
        Conexao::preparar(
            'UPDATE produtos SET ativo = 0 WHERE id_produto = ?',
            'i',
            array((int) $id)
        );
    }

    public static function precoParaCliente($produto, $clienteId)
    {
        $cliente = Conexao::fetchOne(
            'SELECT possui_clube FROM clientes WHERE id_cliente = ? LIMIT 1',
            'i',
            array((int) $clienteId)
        );

        if (!empty($cliente['possui_clube']) && isset($produto['preco_clube'])) {
            return (float) $produto['preco_clube'];
        }

        return (float) $produto['preco'];
    }
}
