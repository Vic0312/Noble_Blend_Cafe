<?php

require_once __DIR__ . '/Conexao.php';

class Cliente
{
    public static function buscarPorEmail($email)
    {
        return Conexao::fetchOne(
            'SELECT * FROM clientes WHERE email = ? LIMIT 1',
            's',
            array(trim($email))
        );
    }

    public static function buscarPorId($id)
    {
        return Conexao::fetchOne(
            'SELECT id_cliente, nome, email, telefone, cpf, nascimento, possui_clube, criado_em FROM clientes WHERE id_cliente = ? LIMIT 1',
            'i',
            array((int) $id)
        );
    }

    public static function listarTodos()
    {
        return Conexao::fetchAll(
            'SELECT id_cliente, nome, email, telefone, cpf, nascimento, possui_clube, criado_em
             FROM clientes
             ORDER BY criado_em DESC'
        );
    }

    public static function criar($dados)
    {
        $nome = trim($dados['nome'] ?? '');
        $email = trim($dados['email'] ?? '');
        $senha = (string) ($dados['senha'] ?? '');
        $telefone = trim($dados['telefone'] ?? '');
        $cpf = trim($dados['cpf'] ?? '');
        $nascimento = trim($dados['nascimento'] ?? '');

        if ($nome === '' || $email === '' || $senha === '') {
            return array('ok' => false, 'mensagem' => 'Preencha nome, email e senha.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return array('ok' => false, 'mensagem' => 'Informe um email válido.');
        }

        if (strlen($senha) < 6) {
            return array('ok' => false, 'mensagem' => 'A senha precisa ter pelo menos 6 caracteres.');
        }

        if (self::buscarPorEmail($email)) {
            return array('ok' => false, 'mensagem' => 'Este email já está cadastrado como cliente.');
        }

        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $cpf = $cpf !== '' ? $cpf : null;
        $nascimento = $nascimento !== '' ? $nascimento : null;

        Conexao::preparar(
            'INSERT INTO clientes (nome, email, senha_hash, telefone, cpf, nascimento)
             VALUES (?, ?, ?, ?, ?, ?)',
            'ssssss',
            array($nome, $email, $hash, $telefone, $cpf, $nascimento)
        );

        return array('ok' => true, 'id' => Conexao::conectar()->insert_id);
    }

    public static function atualizarPerfil($id, $dados)
    {
        $id = (int) $id;
        $nome = trim($dados['nome'] ?? '');
        $email = trim($dados['email'] ?? '');
        $telefone = trim($dados['telefone'] ?? '');
        $cpf = trim($dados['cpf'] ?? '');
        $nascimento = trim($dados['nascimento'] ?? '');
        $senha = (string) ($dados['senha'] ?? '');

        if ($nome === '' || $email === '') {
            return array('ok' => false, 'mensagem' => 'Preencha nome e email.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return array('ok' => false, 'mensagem' => 'Informe um email válido.');
        }

        $existente = Conexao::fetchOne(
            'SELECT id_cliente FROM clientes WHERE email = ? AND id_cliente <> ? LIMIT 1',
            'si',
            array($email, $id)
        );

        if ($existente) {
            return array('ok' => false, 'mensagem' => 'Este email já está em uso.');
        }

        $cpf = $cpf !== '' ? $cpf : null;
        $nascimento = $nascimento !== '' ? $nascimento : null;

        if ($senha !== '') {
            if (strlen($senha) < 6) {
                return array('ok' => false, 'mensagem' => 'A nova senha precisa ter pelo menos 6 caracteres.');
            }

            $hash = password_hash($senha, PASSWORD_DEFAULT);
            Conexao::preparar(
                'UPDATE clientes
                 SET nome = ?, email = ?, telefone = ?, cpf = ?, nascimento = ?, senha_hash = ?
                 WHERE id_cliente = ?',
                'ssssssi',
                array($nome, $email, $telefone, $cpf, $nascimento, $hash, $id)
            );
        } else {
            Conexao::preparar(
                'UPDATE clientes
                 SET nome = ?, email = ?, telefone = ?, cpf = ?, nascimento = ?
                 WHERE id_cliente = ?',
                'sssssi',
                array($nome, $email, $telefone, $cpf, $nascimento, $id)
            );
        }

        return array('ok' => true);
    }

    public static function ativarCoffeeLover($id, $cpf, $senha, $marketing)
    {
        $cliente = Conexao::fetchOne(
            'SELECT id_cliente, senha_hash FROM clientes WHERE id_cliente = ? LIMIT 1',
            'i',
            array((int) $id)
        );

        if (!$cliente || !password_verify((string) $senha, $cliente['senha_hash'])) {
            return array('ok' => false, 'mensagem' => 'Senha incorreta. Confira seus dados para ativar a assinatura.');
        }

        Conexao::preparar(
            'UPDATE clientes
             SET cpf = COALESCE(NULLIF(?, ""), cpf),
                 possui_clube = 1,
                 coffee_lover = 1,
                 coffee_lover_marketing = ?
             WHERE id_cliente = ?',
            'sii',
            array(trim($cpf), (int) $marketing, (int) $id)
        );

        Conexao::preparar(
            'UPDATE carrinho c
             INNER JOIN produtos p ON p.id_produto = c.id_produto
             SET c.preco_unitario = p.preco_clube
             WHERE c.id_cliente = ?',
            'i',
            array((int) $id)
        );

        return array('ok' => true);
    }
}
