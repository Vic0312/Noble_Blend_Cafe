<?php

require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../model/Carrinho.php';

AuthController::requireCliente('../view/login_cliente.php');

$produtoId = (int) ($_POST['id_produto'] ?? 0);
Carrinho::remover(AuthController::clienteId(), $produtoId);
flash_set('sucesso', 'Item removido do carrinho.');

header('Location: ../view/carrinho.php');
exit;
