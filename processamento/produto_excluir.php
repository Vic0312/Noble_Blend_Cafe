<?php

require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../model/Produto.php';

AuthController::requireFuncionario('../view/login_funcionario.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Produto::desativar((int) ($_POST['id_produto'] ?? 0));
    flash_set('sucesso', 'Produto removido do cardápio.');
}

header('Location: ../view/funcionario_produtos.php');
exit;
