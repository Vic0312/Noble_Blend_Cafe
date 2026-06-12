<?php

require_once __DIR__ . '/Conexao.php';

class Funcionario
{
    public static function buscarPorEmail($email)
    {
        return Conexao::fetchOne(
            'SELECT * FROM funcionarios WHERE email = ? LIMIT 1',
            's',
            array(trim($email))
        );
    }

    public static function buscarPorId($id)
    {
        return Conexao::fetchOne(
            'SELECT id_funcionario, nome, email, telefone, cargo, criado_em FROM funcionarios WHERE id_funcionario = ? LIMIT 1',
            'i',
            array((int) $id)
        );
    }

    public static function listarTodos()
    {
        return Conexao::fetchAll(
            'SELECT id_funcionario, nome, email, telefone, cargo, criado_em
             FROM funcionarios
             ORDER BY criado_em DESC'
        );
    }

    public static function criar($dados)
    {
        $nome = trim($dados['nome'] ?? '');
        $email = trim($dados['email'] ?? '');
        $senha = (string) ($dados['senha'] ?? '');
        $telefone = trim($dados['telefone'] ?? '');
        $cargo = trim($dados['cargo'] ?? 'Atendimento');

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
            return array('ok' => false, 'mensagem' => 'Este email já está cadastrado como funcionário.');
        }

        $hash = password_hash($senha, PASSWORD_DEFAULT);

        Conexao::preparar(
            'INSERT INTO funcionarios (nome, email, senha_hash, telefone, cargo)
             VALUES (?, ?, ?, ?, ?)',
            'sssss',
            array($nome, $email, $hash, $telefone, $cargo)
        );

        return array('ok' => true, 'id' => Conexao::conectar()->insert_id);
    }

    public static function atualizarPerfil($id, $dados)
    {
        $id = (int) $id;
        $nome = trim($dados['nome'] ?? '');
        $email = trim($dados['email'] ?? '');
        $telefone = trim($dados['telefone'] ?? '');
        $cargo = trim($dados['cargo'] ?? '');
        $senha = (string) ($dados['senha'] ?? '');

        if ($nome === '' || $email === '' || $cargo === '') {
            return array('ok' => false, 'mensagem' => 'Preencha nome, email e cargo.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return array('ok' => false, 'mensagem' => 'Informe um email válido.');
        }

        $existente = Conexao::fetchOne(
            'SELECT id_funcionario FROM funcionarios WHERE email = ? AND id_funcionario <> ? LIMIT 1',
            'si',
            array($email, $id)
        );

        if ($existente) {
            return array('ok' => false, 'mensagem' => 'Este email já está em uso.');
        }

        if ($senha !== '') {
            if (strlen($senha) < 6) {
                return array('ok' => false, 'mensagem' => 'A nova senha precisa ter pelo menos 6 caracteres.');
            }

            $hash = password_hash($senha, PASSWORD_DEFAULT);
            Conexao::preparar(
                'UPDATE funcionarios
                 SET nome = ?, email = ?, telefone = ?, cargo = ?, senha_hash = ?
                 WHERE id_funcionario = ?',
                'sssssi',
                array($nome, $email, $telefone, $cargo, $hash, $id)
            );
        } else {
            Conexao::preparar(
                'UPDATE funcionarios
                 SET nome = ?, email = ?, telefone = ?, cargo = ?
                 WHERE id_funcionario = ?',
                'ssssi',
                array($nome, $email, $telefone, $cargo, $id)
            );
        }

        return array('ok' => true);
    }
}
