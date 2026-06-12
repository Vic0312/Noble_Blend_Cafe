<?php

require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../model/Funcionario.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/cadastro_funcionario.php');
    exit;
}

$resultado = Funcionario::criar($_POST);

if (!$resultado['ok']) {
    flash_set('erro', $resultado['mensagem']);
    header('Location: ../view/cadastro_funcionario.php');
    exit;
}

AuthController::loginFuncionario($_POST['email'] ?? '', $_POST['senha'] ?? '');
flash_set('sucesso', 'Funcionário cadastrado com sucesso.');
header('Location: ../view/logado_funcionario.php');
exit;
