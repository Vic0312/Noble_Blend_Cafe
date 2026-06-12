<?php

require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../model/Funcionario.php';

AuthController::requireFuncionario('../view/login_funcionario.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/funcionario_perfil.php');
    exit;
}

$resultado = Funcionario::atualizarPerfil(AuthController::funcionarioId(), $_POST);

if ($resultado['ok']) {
    $_SESSION['funcionario_nome'] = trim($_POST['nome'] ?? $_SESSION['funcionario_nome']);
    $_SESSION['funcionario_email'] = trim($_POST['email'] ?? $_SESSION['funcionario_email']);
}

flash_set($resultado['ok'] ? 'sucesso' : 'erro', $resultado['ok'] ? 'Perfil atualizado com sucesso.' : $resultado['mensagem']);
header('Location: ../view/funcionario_perfil.php');
exit;
