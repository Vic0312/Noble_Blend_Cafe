<?php

require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../model/Cliente.php';

AuthController::requireCliente('../view/login_cliente.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/cadastro_coffee_lovers.php');
    exit;
}

$resultado = Cliente::ativarCoffeeLover(
    AuthController::clienteId(),
    $_POST['cpf'] ?? '',
    $_POST['senha'] ?? '',
    isset($_POST['marketing']) ? 1 : 0
);

flash_set(
    $resultado['ok'] ? 'sucesso' : 'erro',
    $resultado['ok'] ? 'Cadastro concluido com sucesso' : $resultado['mensagem']
);

header('Location: ../view/cadastro_coffee_lovers.php');
exit;
