<?php

require_once __DIR__ . '/../model/Cliente.php';
require_once __DIR__ . '/../model/Funcionario.php';
require_once __DIR__ . '/ViewHelper.php';

class AuthController
{
    public static function iniciarSessao()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function loginCliente($email, $senha)
    {
        self::iniciarSessao();

        $cliente = Cliente::buscarPorEmail($email);
        if (!$cliente || !password_verify($senha, $cliente['senha_hash'])) {
            return array('ok' => false, 'mensagem' => 'Email ou senha incorretos.');
        }

        unset($_SESSION['funcionario_id'], $_SESSION['funcionario_nome']);
        $_SESSION['tipo_usuario'] = 'cliente';
        $_SESSION['cliente_id'] = (int) $cliente['id_cliente'];
        $_SESSION['cliente_nome'] = $cliente['nome'];
        $_SESSION['cliente_email'] = $cliente['email'];

        return array('ok' => true);
    }

    public static function loginFuncionario($email, $senha)
    {
        self::iniciarSessao();

        $funcionario = Funcionario::buscarPorEmail($email);
        if (!$funcionario || !password_verify($senha, $funcionario['senha_hash'])) {
            return array('ok' => false, 'mensagem' => 'Email ou senha incorretos.');
        }

        unset($_SESSION['cliente_id'], $_SESSION['cliente_nome']);
        $_SESSION['tipo_usuario'] = 'funcionario';
        $_SESSION['funcionario_id'] = (int) $funcionario['id_funcionario'];
        $_SESSION['funcionario_nome'] = $funcionario['nome'];
        $_SESSION['funcionario_email'] = $funcionario['email'];

        return array('ok' => true);
    }

    public static function requireCliente($redirect = 'login_cliente.php')
    {
        self::iniciarSessao();

        if (!isset($_SESSION['cliente_id']) || ($_SESSION['tipo_usuario'] ?? '') !== 'cliente') {
            header('Location: ' . $redirect);
            exit;
        }
    }

    public static function requireFuncionario($redirect = 'login_funcionario.php')
    {
        self::iniciarSessao();

        if (!isset($_SESSION['funcionario_id']) || ($_SESSION['tipo_usuario'] ?? '') !== 'funcionario') {
            header('Location: ' . $redirect);
            exit;
        }
    }

    public static function clienteId()
    {
        self::iniciarSessao();
        return isset($_SESSION['cliente_id']) ? (int) $_SESSION['cliente_id'] : null;
    }

    public static function funcionarioId()
    {
        self::iniciarSessao();
        return isset($_SESSION['funcionario_id']) ? (int) $_SESSION['funcionario_id'] : null;
    }

    public static function logout()
    {
        self::iniciarSessao();
        $_SESSION = array();
        session_destroy();
    }
}
