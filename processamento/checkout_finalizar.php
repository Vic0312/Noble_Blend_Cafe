<?php

require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../model/Pedido.php';

AuthController::requireCliente('../view/login_cliente.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/checkout.php');
    exit;
}

$obrigatorios = array('nome_destinatario', 'telefone', 'cep', 'endereco', 'numero', 'bairro', 'cidade', 'uf', 'metodo_pagamento');
foreach ($obrigatorios as $campo) {
    if (trim($_POST[$campo] ?? '') === '') {
        flash_set('erro', 'Preencha todos os dados de entrega e pagamento.');
        header('Location: ../view/checkout.php');
        exit;
    }
}

$entrega = array(
    'nome_destinatario' => $_POST['nome_destinatario'] ?? '',
    'telefone' => $_POST['telefone'] ?? '',
    'cep' => $_POST['cep'] ?? '',
    'endereco' => $_POST['endereco'] ?? '',
    'numero' => $_POST['numero'] ?? '',
    'complemento' => $_POST['complemento'] ?? '',
    'bairro' => $_POST['bairro'] ?? '',
    'cidade' => $_POST['cidade'] ?? '',
    'uf' => $_POST['uf'] ?? '',
);

$pagamento = array(
    'metodo_pagamento' => $_POST['metodo_pagamento'] ?? 'pix',
);

$resultado = Pedido::criar(AuthController::clienteId(), $entrega, $pagamento);

if (!$resultado['ok']) {
    flash_set('erro', $resultado['mensagem']);
    header('Location: ../view/checkout.php');
    exit;
}

header('Location: ../view/confirmacao.php?pedido=' . rawurlencode($resultado['numero_pedido']));
exit;
