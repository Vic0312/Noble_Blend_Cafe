<?php

require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../model/Cliente.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/cadastro_cliente.php');
    exit;
}

$resultado = Cliente::criar($_POST);

if (!$resultado['ok']) {
    flash_set('erro', $resultado['mensagem']);
    header('Location: ../view/cadastro_cliente.php');
    exit;
}

AuthController::loginCliente($_POST['email'] ?? '', $_POST['senha'] ?? '');
flash_set('sucesso', 'Cadastro realizado com sucesso. Bem-vindo ao Noble Blend Café!');
header('Location: ../view/logado_cliente.php');
exit;
