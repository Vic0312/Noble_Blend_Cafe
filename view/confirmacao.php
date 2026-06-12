<?php
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/ViewHelper.php';
require_once __DIR__ . '/../model/Pedido.php';

AuthController::requireCliente();

$numero = $_GET['pedido'] ?? '';
$pedido = $numero ? Pedido::buscarPorNumero($numero, AuthController::clienteId()) : null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/app.css'); ?>">
</head>
<body class="app-body">
    <?php include __DIR__ . '/partials/nav_cliente.php'; ?>

    <main class="page-shell">
        <?php if (!$pedido): ?>
            <section class="empty-state">
                <h1>Pedido não encontrado</h1>
                <p>Confira seus pedidos ou volte ao cardápio.</p>
                <a class="btn" href="cliente_pedidos.php">Meus pedidos</a>
            </section>
        <?php else: ?>
            <section class="confirmation-hero">
                <p class="eyebrow">Pedido confirmado</p>
                <h1><?= e($pedido['numero_pedido']); ?></h1>
                <p>Recebemos seu pedido e a equipe já pode acompanhar o preparo na área de funcionário.</p>
            </section>

            <section class="checkout-layout">
                <div class="form-panel">
                    <h2>Entrega</h2>
                    <p><strong><?= e($pedido['nome_destinatario']); ?></strong></p>
                    <p><?= e($pedido['endereco']); ?>, <?= e($pedido['numero']); ?> <?= e($pedido['complemento']); ?></p>
                    <p><?= e($pedido['bairro']); ?> - <?= e($pedido['cidade']); ?>/<?= e($pedido['uf']); ?>, <?= e($pedido['cep']); ?></p>
                    <p>Status atual: <strong><?= e($pedido['status']); ?></strong></p>

                    <h2>Itens</h2>
                    <div class="table-wrap">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Qtd.</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pedido['itens'] as $item): ?>
                                    <tr>
                                        <td><?= e($item['nome_produto']); ?></td>
                                        <td><?= (int) $item['quantidade']; ?></td>
                                        <td><?= money($item['subtotal']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <aside class="summary-panel">
                    <h2>Total</h2>
                    <div class="summary-row"><span>Subtotal</span><strong><?= money($pedido['subtotal']); ?></strong></div>
                    <div class="summary-row"><span>Frete</span><strong><?= money($pedido['frete']); ?></strong></div>
                    <div class="summary-row"><span>Desconto</span><strong>-<?= money($pedido['desconto']); ?></strong></div>
                    <div class="summary-row summary-row--total"><span>Total pago</span><strong><?= money($pedido['total']); ?></strong></div>
                    <a class="btn btn--block" href="cardapio.php">Comprar novamente</a>
                </aside>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
