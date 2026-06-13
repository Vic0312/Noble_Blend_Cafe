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
$freteEntrega = $subtotal >= 80 || $subtotal <= 0 ? 0.00 : 7.90;
$freteRetirada = 0.00;
$descontoPix = round($subtotal * 0.05, 2);
$totalPixEntrega = max(0, $subtotal + $freteEntrega - $descontoPix);
$totalCartaoEntrega = max(0, $subtotal + $freteEntrega);
$totalPixRetirada = max(0, $subtotal + $freteRetirada - $descontoPix);
$totalCartaoRetirada = max(0, $subtotal + $freteRetirada);
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
                <p>Escolha retirada ou entrega e informe a forma de pagamento para confirmar seu pedido.</p>
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
                    <h2>Forma de retirada</h2>
                    <div class="payment-options fulfillment-options">
                        <label>
                            <input type="radio" name="forma_retirada" value="entrega" checked>
                            <span>Entrega <small>Receba no endereço informado</small></span>
                        </label>
                        <label>
                            <input type="radio" name="forma_retirada" value="retirada">
                            <span>Retirar na loja <small>Sem cobrança de frete</small></span>
                        </label>
                    </div>

                    <div class="pickup-note" id="pickup-note" hidden>
                        Seu pedido ficará disponível para retirada na loja.
                    </div>

                    <div id="delivery-fields">
                        <h2>Entrega</h2>
                        <div class="form-grid">
                        <label class="field">
                            <span>Nome de quem recebe</span>
                            <input type="text" name="nome_destinatario" value="<?= e($cliente['nome'] ?? ''); ?>" required data-delivery-field>
                        </label>

                        <label class="field">
                            <span>Telefone</span>
                            <input type="text" name="telefone" value="<?= e($cliente['telefone'] ?? ''); ?>" required data-delivery-field>
                        </label>

                        <label class="field">
                            <span>CEP</span>
                            <input type="text" name="cep" id="cep" placeholder="00000-000" inputmode="numeric" required data-delivery-field>
                            <small class="field-hint" id="cep-status">Digite o CEP para buscar o endereço.</small>
                        </label>

                        <label class="field">
                            <span>Rua</span>
                            <input type="text" name="endereco" id="endereco" required data-delivery-field>
                        </label>

                        <label class="field">
                            <span>Número</span>
                            <input type="text" name="numero" required data-delivery-field>
                        </label>

                        <label class="field">
                            <span>Complemento</span>
                            <input type="text" name="complemento">
                        </label>

                        <label class="field">
                            <span>Bairro</span>
                            <input type="text" name="bairro" id="bairro" required data-delivery-field>
                        </label>

                        <label class="field">
                            <span>Cidade</span>
                            <input type="text" name="cidade" id="cidade" required data-delivery-field>
                        </label>

                        <label class="field">
                            <span>UF</span>
                            <input type="text" name="uf" id="uf" maxlength="2" required data-delivery-field>
                        </label>
                        </div>
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
                        <strong id="summary-frete"
                            data-entrega="<?= e($freteEntrega > 0 ? money($freteEntrega) : 'Grátis'); ?>"
                            data-retirada="<?= e($freteRetirada > 0 ? money($freteRetirada) : 'Grátis'); ?>">
                            <?= $freteEntrega > 0 ? money($freteEntrega) : 'Grátis'; ?>
                        </strong>
                    </div>
                    <div class="summary-row">
                        <span>Desconto PIX</span>
                        <strong>-<?= money($descontoPix); ?></strong>
                    </div>
                    <div class="summary-row summary-row--total">
                        <span>Total no PIX</span>
                        <strong id="summary-total-pix"
                            data-entrega="<?= e(money($totalPixEntrega)); ?>"
                            data-retirada="<?= e(money($totalPixRetirada)); ?>">
                            <?= money($totalPixEntrega); ?>
                        </strong>
                    </div>
                    <?php if (!empty($cliente['possui_clube'])): ?>
                        <p class="muted">Os itens deste pedido já estão usando o preço Coffee Lovers.</p>
                    <?php endif; ?>
                    <p class="muted" id="summary-card"
                        data-entrega="No cartão, o total fica <?= e(money($totalCartaoEntrega)); ?>."
                        data-retirada="No cartão, o total fica <?= e(money($totalCartaoRetirada)); ?>.">
                        No cartão, o total fica <?= money($totalCartaoEntrega); ?>.
                    </p>
                    <button class="btn btn--block" type="submit">Confirmar pedido</button>
                </aside>
            </form>
        <?php endif; ?>
    </main>
    <script src="<?= asset('../js/checkout.js'); ?>"></script>
</body>
</html>
