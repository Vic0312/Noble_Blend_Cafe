<?php

ini_set('default_charset', 'UTF-8');

if (PHP_SAPI !== 'cli' && !headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}

if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding('UTF-8');
}

if (!function_exists('asset')) {
    function asset($caminho)
    {
        $caminho = ltrim((string) $caminho, '/');

        if (preg_match('/^https?:\/\//', $caminho)) {
            return $caminho;
        }

        $base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        $base = ($base === '/' || $base === '.' || $base === '\\') ? '' : rtrim($base, '/');

        return $base . '/' . $caminho;
    }
}

if (!function_exists('e')) {
    function e($valor)
    {
        return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('money')) {
    function money($valor)
    {
        return 'R$ ' . number_format((float) $valor, 2, ',', '.');
    }
}

if (!function_exists('flash_get')) {
    function flash_get()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
        unset($_SESSION['flash']);

        return $flash;
    }
}

if (!function_exists('flash_set')) {
    function flash_set($tipo, $mensagem)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION['flash'] = array(
            'tipo' => $tipo,
            'mensagem' => $mensagem,
        );
    }
}
