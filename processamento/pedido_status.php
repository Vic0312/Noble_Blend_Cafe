<?php

require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../model/Pedido.php';

AuthController::requireFuncionario('../view/login_funcionario.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = Pedido::atualizarStatus((int) ($_POST['id_pedido'] ?? 0), $_POST['status'] ?? '');
    flash_set($resultado['ok'] ? 'sucesso' : 'erro', $resultado['ok'] ? 'Status do pedido atualizado.' : $resultado['mensagem']);
}

header('Location: ../view/funcionario_pedidos.php');
exit;
