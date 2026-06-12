<?php
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/ViewHelper.php';
require_once __DIR__ . '/../model/Pedido.php';

AuthController::requireCliente();

$pedidos = Pedido::listarCliente(AuthController::clienteId());
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Pedidos | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/app.css'); ?>">
</head>
<body class="app-body">
    <?php include __DIR__ . '/partials/nav_cliente.php'; ?>

    <main class="page-shell">
        <section class="section-heading section-heading--top">
            <div>
                <p class="eyebrow">Histórico</p>
                <h1>Meus pedidos</h1>
                <p>Acompanhe status e valores dos pedidos feitos no Noble Blend Café.</p>
            </div>
            <a class="btn btn--ghost" href="cardapio.php">Novo pedido</a>
        </section>

        <?php if (empty($pedidos)): ?>
            <section class="empty-state">
                <h2>Você ainda não fez pedidos</h2>
                <p>Quando finalizar uma compra, ela aparecerá aqui.</p>
            </section>
        <?php else: ?>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><?= e($pedido['numero_pedido']); ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($pedido['criado_em'])); ?></td>
                                <td><span class="pill"><?= e($pedido['status']); ?></span></td>
                                <td><?= money($pedido['total']); ?></td>
                                <td><a class="link-button" href="confirmacao.php?pedido=<?= urlencode($pedido['numero_pedido']); ?>">Detalhes</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
