<?php

class Conexao
{
    private static $conn = null;

    public static function conectar()
    {
        if (self::$conn instanceof mysqli) {
            return self::$conn;
        }

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $host = getenv('DB_HOST') ?: 'localhost';
        $usuario = getenv('DB_USER') ?: 'root';
        $senha = getenv('DB_PASS') ?: '';
        $banco = getenv('DB_NAME') ?: 'noble_blend_cafe';

        self::$conn = new mysqli($host, $usuario, $senha, $banco);
        self::$conn->set_charset('utf8mb4');

        return self::$conn;
    }

    public static function preparar($sql, $types = '', $params = array())
    {
        $stmt = self::conectar()->prepare($sql);

        if ($types !== '' && !empty($params)) {
            $refs = array($types);
            foreach ($params as $key => $value) {
                $refs[] = &$params[$key];
            }
            call_user_func_array(array($stmt, 'bind_param'), $refs);
        }

        $stmt->execute();
        return $stmt;
    }

    public static function fetchOne($sql, $types = '', $params = array())
    {
        $stmt = self::preparar($sql, $types, $params);
        $result = $stmt->get_result();

        return $result ? $result->fetch_assoc() : null;
    }

    public static function fetchAll($sql, $types = '', $params = array())
    {
        $stmt = self::preparar($sql, $types, $params);
        $result = $stmt->get_result();

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : array();
    }
}
