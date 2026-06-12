<?php
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/ViewHelper.php';
require_once __DIR__ . '/../model/Carrinho.php';
require_once __DIR__ . '/../model/Cliente.php';

AuthController::requireCliente();

$flash = flash_get();
$clienteId = AuthController::clienteId();
$cliente = Cliente::buscarPorId($clienteId);
$itens = Carrinho::itens($clienteId);
$subtotal = Carrinho::subtotal($clienteId);
$frete = $subtotal >= 80 || $subtotal <= 0 ? 0.00 : 7.90;
$descontoPix = round($subtotal * 0.05, 2);
$totalPix = max(0, $subtotal + $frete - $descontoPix);
$totalCartao = max(0, $subtotal + $frete);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/app.css'); ?>">
</head>
<body class="app-body">
    <?php include __DIR__ . '/partials/nav_cliente.php'; ?>

    <main class="page-shell">
        <section class="section-heading section-heading--top">
            <div>
                <p class="eyebrow">Última etapa</p>
                <h1>Checkout</h1>
                <p>Informe entrega e forma de pagamento para confirmar seu pedido.</p>
            </div>
            <a class="btn btn--ghost" href="carrinho.php">Voltar ao carrinho</a>
        </section>

        <?php if ($flash): ?>
            <div class="flash flash--<?= e($flash['tipo']); ?>"><?= e($flash['mensagem']); ?></div>
        <?php endif; ?>

        <?php if (empty($itens)): ?>
            <section class="empty-state">
                <h2>Não há itens para finalizar</h2>
                <p>Adicione produtos ao carrinho antes de abrir o checkout.</p>
                <a class="btn" href="cardapio.php">Abrir cardápio</a>
            </section>
        <?php else: ?>
            <form class="checkout-layout" action="../processamento/checkout_finalizar.php" method="post">
                <section class="form-panel">
                    <h2>Entrega</h2>
                    <div class="form-grid">
                        <label class="field">
                            <span>Nome de quem recebe</span>
                            <input type="text" name="nome_destinatario" value="<?= e($cliente['nome'] ?? ''); ?>" required>
                        </label>

                        <label class="field">
                            <span>Telefone</span>
                            <input type="text" name="telefone" value="<?= e($cliente['telefone'] ?? ''); ?>" required>
                        </label>

                        <label class="field">
                            <span>CEP</span>
                            <input type="text" name="cep" placeholder="00000-000" required>
                        </label>

                        <label class="field">
                            <span>Rua</span>
                            <input type="text" name="endereco" required>
                        </label>

                        <label class="field">
                            <span>Número</span>
                            <input type="text" name="numero" required>
                        </label>

                        <label class="field">
                            <span>Complemento</span>
                            <input type="text" name="complemento">
                        </label>

                        <label class="field">
                            <span>Bairro</span>
                            <input type="text" name="bairro" required>
                        </label>

                        <label class="field">
                            <span>Cidade</span>
                            <input type="text" name="cidade" required>
                        </label>

                        <label class="field">
                            <span>UF</span>
                            <input type="text" name="uf" maxlength="2" required>
                        </label>
                    </div>

                    <h2>Pagamento</h2>
                    <div class="payment-options">
                        <label>
                            <input type="radio" name="metodo_pagamento" value="pix" checked>
                            <span>PIX <small>5% de desconto</small></span>
                        </label>
                        <label>
                            <input type="radio" name="metodo_pagamento" value="credito">
                            <span>Cartão de crédito <small>simulado</small></span>
                        </label>
                        <label>
                            <input type="radio" name="metodo_pagamento" value="debito">
                            <span>Cartão de débito <small>simulado</small></span>
                        </label>
                    </div>
                </section>

                <aside class="summary-panel">
                    <h2>Resumo do pedido</h2>

                    <?php foreach ($itens as $item): ?>
                        <div class="summary-product">
                            <span><?= (int) $item['quantidade']; ?>x <?= e($item['nome']); ?></span>
                            <strong><?= money($item['subtotal']); ?></strong>
                        </div>
                    <?php endforeach; ?>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <strong><?= money($subtotal); ?></strong>
                    </div>
                    <div class="summary-row">
                        <span>Frete</span>
                        <strong><?= $frete > 0 ? money($frete) : 'Grátis'; ?></strong>
                    </div>
                    <div class="summary-row">
                        <span>Desconto PIX</span>
                        <strong>-<?= money($descontoPix); ?></strong>
                    </div>
                    <div class="summary-row summary-row--total">
                        <span>Total no PIX</span>
                        <strong><?= money($totalPix); ?></strong>
                    </div>
                    <?php if (!empty($cliente['possui_clube'])): ?>
                        <p class="muted">Os itens deste pedido já estão usando o preço Coffee Lovers.</p>
                    <?php endif; ?>
                    <p class="muted">No cartão, o total fica <?= money($totalCartao); ?>.</p>
                    <button class="btn btn--block" type="submit">Confirmar pedido</button>
                </aside>
            </form>
        <?php endif; ?>
    </main>
</body>
</html>
