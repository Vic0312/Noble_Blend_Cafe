<?php

require_once __DIR__ . '/../controller/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/login_funcionario.php');
    exit;
}

$email = trim($_POST['email'] ?? $_POST['documento'] ?? '');
$senha = (string) ($_POST['senha'] ?? '');

$resultado = AuthController::loginFuncionario($email, $senha);

if ($resultado['ok']) {
    header('Location: ../view/logado_funcionario.php');
    exit;
}

flash_set('erro', $resultado['mensagem']);
header('Location: ../view/login_funcionario.php');
exit;
