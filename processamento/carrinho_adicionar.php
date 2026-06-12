<?php

require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../model/Carrinho.php';

AuthController::requireCliente('../view/login_cliente.php');

$redirect = $_POST['redirect'] ?? '../view/cardapio.php';
if (preg_match('/^https?:\/\//', $redirect)) {
    $redirect = '../view/cardapio.php';
}

$produtoId = (int) ($_POST['id_produto'] ?? 0);
$quantidade = (int) ($_POST['quantidade'] ?? 1);

$resultado = Carrinho::adicionar(AuthController::clienteId(), $produtoId, $quantidade);
flash_set($resultado['ok'] ? 'sucesso' : 'erro', $resultado['mensagem']);

header('Location: ' . $redirect);
exit;
