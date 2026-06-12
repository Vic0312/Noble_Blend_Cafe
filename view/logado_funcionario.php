<?php
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/ViewHelper.php';
require_once __DIR__ . '/../model/Pedido.php';
require_once __DIR__ . '/../model/Conexao.php';

AuthController::requireFuncionario();

$flash = flash_get();
$metricas = Pedido::metricas();
$pedidos = Pedido::listarRecentes(6);

$topProdutos = Conexao::fetchAll(
    'SELECT nome_produto, SUM(quantidade) AS quantidade, SUM(subtotal) AS receita
     FROM pedido_itens
     GROUP BY nome_produto
     ORDER BY quantidade DESC
     LIMIT 5'
);

$categorias = Conexao::fetchAll(
    'SELECT p.categoria, COALESCE(SUM(i.subtotal), 0) AS receita
     FROM produtos p
     LEFT JOIN pedido_itens i ON i.id_produto = p.id_produto
     GROUP BY p.categoria
     ORDER BY receita DESC, p.categoria ASC
     LIMIT 5'
);

$statusPedidos = Conexao::fetchAll(
    'SELECT status, COUNT(*) AS total
     FROM pedidos
     GROUP BY status
     ORDER BY total DESC'
);

$pagamentos = Conexao::fetchAll(
    'SELECT metodo_pagamento, COUNT(*) AS total, COALESCE(SUM(total), 0) AS receita
     FROM pedidos
     GROUP BY metodo_pagamento
     ORDER BY total DESC'
);

$receitaMax = 0;
foreach ($categorias as $categoria) {
    $receitaMax = max($receitaMax, (float) $categoria['receita']);
}

$quantidadeMax = 0;
foreach ($topProdutos as $top) {
    $quantidadeMax = max($quantidadeMax, (int) $top['quantidade']);
}

$statusMax = 0;
foreach ($statusPedidos as $statusRow) {
    $statusMax = max($statusMax, (int) $statusRow['total']);
}

$pagamentoMax = 0;
foreach ($pagamentos as $pagamento) {
    $pagamentoMax = max($pagamentoMax, (int) $pagamento['total']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Funcionário | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/app.css'); ?>">
</head>
<body class="staff-body">
    <?php include __DIR__ . '/partials/nav_funcionario.php'; ?>

    <main class="staff-shell">
        <?php if ($flash): ?>
            <div class="flash flash--<?= e($flash['tipo']); ?>"><?= e($flash['mensagem']); ?></div>
        <?php endif; ?>

        <section class="staff-hero staff-hero--dashboard">
            <div>
                <p class="eyebrow">Painel de controle</p>
                <h1>Visão geral</h1>
                <p>Resumo limpo do banco: vendas, clientes, produtos e alertas de estoque.</p>
            </div>
            <img src="<?= asset('../img/pacote_cafe.png'); ?>" alt="Pacote de café Noble Blend">
        </section>

        <section class="metric-grid metric-grid--dashboard" aria-label="Indicadores">
            <article class="metric"><span>Clientes</span><strong><?= (int) $metricas['clientes']; ?></strong></article>
            <article class="metric"><span>Funcionários</span><strong><?= (int) $metricas['funcionarios']; ?></strong></article>
            <article class="metric"><span>Produtos ativos</span><strong><?= (int) $metricas['produtos']; ?></strong></article>
            <article class="metric <?= $metricas['estoque_baixo'] > 0 ? 'metric--warn' : ''; ?>"><span>Estoque baixo</span><strong><?= (int) $metricas['estoque_baixo']; ?></strong></article>
            <article class="metric"><span>Pedidos</span><strong><?= (int) $metricas['pedidos']; ?></strong></article>
            <article class="metric"><span>Receita</span><strong><?= money($metricas['receita']); ?></strong></article>
        </section>

        <section class="dashboard-grid">
            <article class="chart-card">
                <div class="section-heading section-heading--inside">
                    <div>
                        <p class="eyebrow">Mais vendidos</p>
                        <h2>Produtos em destaque</h2>
                    </div>
                </div>

                <?php if (empty($topProdutos)): ?>
                    <p class="muted">Assim que houver pedidos, o ranking aparecerá aqui.</p>
                <?php else: ?>
                    <div class="bar-list">
                        <?php foreach ($topProdutos as $top): ?>
                            <?php $largura = $quantidadeMax > 0 ? ((int) $top['quantidade'] / $quantidadeMax) * 100 : 0; ?>
                            <div class="bar-row">
                                <div class="bar-row__label">
                                    <strong><?= e($top['nome_produto']); ?></strong>
                                    <span><?= (int) $top['quantidade']; ?> venda(s)</span>
                                </div>
                                <div class="bar-track"><span style="width: <?= (float) $largura; ?>%"></span></div>
                                <em><?= money($top['receita']); ?></em>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>

            <article class="chart-card">
                <div class="section-heading section-heading--inside">
                    <div>
                        <p class="eyebrow">Categorias</p>
                        <h2>Receita por categoria</h2>
                    </div>
                </div>

                <div class="bar-list">
                    <?php foreach ($categorias as $categoria): ?>
                        <?php $largura = $receitaMax > 0 ? ((float) $categoria['receita'] / $receitaMax) * 100 : 0; ?>
                        <div class="bar-row">
                            <div class="bar-row__label">
                                <strong><?= e($categoria['categoria']); ?></strong>
                                <span><?= money($categoria['receita']); ?></span>
                            </div>
                            <div class="bar-track"><span style="width: <?= (float) $largura; ?>%"></span></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </article>
        </section>

        <section class="dashboard-grid">
            <article class="chart-card">
                <div class="section-heading section-heading--inside">
                    <div>
                        <p class="eyebrow">Status</p>
                        <h2>Pedidos por status</h2>
                    </div>
                </div>

                <div class="bar-list">
                    <?php foreach ($statusPedidos as $statusRow): ?>
                        <?php $largura = $statusMax > 0 ? ((int) $statusRow['total'] / $statusMax) * 100 : 0; ?>
                        <div class="bar-row">
                            <div class="bar-row__label">
                                <strong><?= e($statusRow['status']); ?></strong>
                                <span><?= (int) $statusRow['total']; ?> pedido(s)</span>
                            </div>
                            <div class="bar-track"><span style="width: <?= (float) $largura; ?>%"></span></div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($statusPedidos)): ?>
                        <p class="muted">Nenhum pedido registrado ainda.</p>
                    <?php endif; ?>
                </div>
            </article>

            <article class="chart-card">
                <div class="section-heading section-heading--inside">
                    <div>
                        <p class="eyebrow">Pagamento</p>
                        <h2>Pedidos por pagamento</h2>
                    </div>
                </div>

                <div class="bar-list">
                    <?php foreach ($pagamentos as $pagamento): ?>
                        <?php $largura = $pagamentoMax > 0 ? ((int) $pagamento['total'] / $pagamentoMax) * 100 : 0; ?>
                        <div class="bar-row">
                            <div class="bar-row__label">
                                <strong><?= e(ucfirst($pagamento['metodo_pagamento'])); ?></strong>
                                <span><?= (int) $pagamento['total']; ?> pedido(s)</span>
                            </div>
                            <div class="bar-track"><span style="width: <?= (float) $largura; ?>%"></span></div>
                            <em><?= money($pagamento['receita']); ?></em>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($pagamentos)): ?>
                        <p class="muted">Nenhum pagamento registrado ainda.</p>
                    <?php endif; ?>
                </div>
            </article>
        </section>

        <section class="chart-card dashboard-orders">
            <div class="section-heading section-heading--inside">
                <div>
                    <p class="eyebrow">Pedidos</p>
                    <h2>Últimos registros do banco</h2>
                </div>
                <a class="btn btn--ghost" href="funcionario_pedidos.php">Ver pedidos</a>
            </div>

            <div class="table-wrap table-wrap--flat">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><?= e($pedido['numero_pedido']); ?></td>
                                <td><?= e($pedido['cliente_nome']); ?></td>
                                <td><span class="pill"><?= e($pedido['status']); ?></span></td>
                                <td><?= money($pedido['total']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($pedidos)): ?>
                            <tr><td colspan="4">Nenhum pedido registrado ainda.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
