<?php
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/ViewHelper.php';
require_once __DIR__ . '/../model/Carrinho.php';

AuthController::requireCliente();

$flash = flash_get();
$clienteId = AuthController::clienteId();
$itens = Carrinho::itens($clienteId);
$subtotal = Carrinho::subtotal($clienteId);
$freteEstimado = $subtotal >= 80 || $subtotal <= 0 ? 0.00 : 7.90;
$totalEstimado = $subtotal + $freteEstimado;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/app.css'); ?>">
</head>
<body class="app-body">
    <?php include __DIR__ . '/partials/nav_cliente.php'; ?>

    <main class="page-shell">
        <section class="section-heading section-heading--top">
            <div>
                <p class="eyebrow">Seu pedido</p>
                <h1>Carrinho</h1>
                <p>Revise quantidades, remova itens e siga para finalizar a compra.</p>
            </div>
            <a class="btn btn--ghost" href="cardapio.php">Continuar comprando</a>
        </section>

        <?php if ($flash): ?>
            <div class="flash flash--<?= e($flash['tipo']); ?>"><?= e($flash['mensagem']); ?></div>
        <?php endif; ?>

        <?php if (empty($itens)): ?>
            <section class="empty-state">
                <h2>Seu carrinho está vazio</h2>
                <p>O cardápio já está pronto para receber seu primeiro café.</p>
                <a class="btn" href="cardapio.php">Abrir cardápio</a>
            </section>
        <?php else: ?>
            <section class="cart-layout">
                <div class="cart-items">
                    <?php foreach ($itens as $item): ?>
                        <article class="cart-item">
                            <img src="<?= asset('../' . ltrim($item['imagem'], '/')); ?>" alt="<?= e($item['nome']); ?>">

                            <div class="cart-item__info">
                                <span class="pill"><?= e($item['categoria']); ?></span>
                                <h2><?= e($item['nome']); ?></h2>
                                <p><?= money($item['preco_unitario']); ?> por unidade</p>
                                <p class="muted">Normal: <?= money($item['preco']); ?> | Clube: <?= money($item['preco_clube']); ?></p>
                            </div>

                            <form class="cart-item__qty" action="../processamento/carrinho_atualizar.php" method="post">
                                <input type="hidden" name="id_produto" value="<?= (int) $item['id_produto']; ?>">
                                <label>
                                    <span>Qtd.</span>
                                    <input type="number" name="quantidade" min="1" max="<?= (int) $item['estoque']; ?>" value="<?= (int) $item['quantidade']; ?>">
                                </label>
                                <button class="btn btn--small" type="submit">Atualizar</button>
                            </form>

                            <div class="cart-item__subtotal">
                                <span>Subtotal</span>
                                <strong><?= money($item['subtotal']); ?></strong>
                                <form action="../processamento/carrinho_remover.php" method="post">
                                    <input type="hidden" name="id_produto" value="<?= (int) $item['id_produto']; ?>">
                                    <button class="link-button" type="submit">Remover</button>
                                </form>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <aside class="summary-panel">
                    <h2>Resumo</h2>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <strong><?= money($subtotal); ?></strong>
                    </div>
                    <div class="summary-row">
                        <span>Frete estimado</span>
                        <strong><?= $freteEstimado > 0 ? money($freteEstimado) : 'Grátis'; ?></strong>
                    </div>
                    <p class="muted">Frete grátis em pedidos a partir de R$ 80,00.</p>
                    <div class="summary-row summary-row--total">
                        <span>Total estimado</span>
                        <strong><?= money($totalEstimado); ?></strong>
                    </div>
                    <a class="btn btn--block" href="checkout.php">Finalizar compra</a>
                </aside>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
