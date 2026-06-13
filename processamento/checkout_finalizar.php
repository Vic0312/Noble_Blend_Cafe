<?php

require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../model/Pedido.php';

AuthController::requireCliente('../view/login_cliente.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/checkout.php');
    exit;
}

$formaRetirada = ($_POST['forma_retirada'] ?? 'entrega') === 'retirada' ? 'retirada' : 'entrega';
$obrigatorios = array('metodo_pagamento');

if ($formaRetirada === 'entrega') {
    $obrigatorios = array_merge($obrigatorios, array('nome_destinatario', 'telefone', 'cep', 'endereco', 'numero', 'bairro', 'cidade', 'uf'));
}

foreach ($obrigatorios as $campo) {
    if (trim($_POST[$campo] ?? '') === '') {
        flash_set('erro', 'Preencha todos os dados necessários para finalizar o pedido.');
        header('Location: ../view/checkout.php');
        exit;
    }
}

$entrega = array(
    'forma_retirada' => $formaRetirada,
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
