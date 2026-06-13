<?php
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/ViewHelper.php';
require_once __DIR__ . '/../model/Pedido.php';

AuthController::requireFuncionario();

$flash = flash_get();
$pedidos = Pedido::listarRecentes(50);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/app.css'); ?>">
</head>
<body class="staff-body">
    <?php include __DIR__ . '/partials/nav_funcionario.php'; ?>

    <main class="staff-shell">
        <?php if ($flash): ?>
            <div class="flash flash--<?= e($flash['tipo']); ?>"><?= e($flash['mensagem']); ?></div>
        <?php endif; ?>

        <section class="section-heading section-heading--top">
            <div>
                <p class="eyebrow">Vendas</p>
                <h1>Pedidos</h1>
                <p>Atualize o status dos pedidos e acompanhe as movimentações da cafeteria.</p>
            </div>
        </section>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Pedido</th>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Total</th>
                        <th>Forma</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?= e($pedido['numero_pedido']); ?></td>
                            <td><?= e($pedido['cliente_nome']); ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($pedido['criado_em'])); ?></td>
                            <td><?= money($pedido['total']); ?></td>
                            <td><?= ($pedido['forma_retirada'] ?? 'entrega') === 'retirada' ? 'Retirada' : 'Entrega'; ?></td>
                            <td>
                                <form class="inline-form" action="../processamento/pedido_status.php" method="post">
                                    <input type="hidden" name="id_pedido" value="<?= (int) $pedido['id_pedido']; ?>">
                                    <select name="status">
                                        <?php foreach (array('Recebido', 'Em preparo', 'Saiu para entrega', 'Finalizado', 'Cancelado') as $status): ?>
                                            <option value="<?= e($status); ?>" <?= $pedido['status'] === $status ? 'selected' : ''; ?>><?= e($status); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label class="inline-form__field">
                                        <span>Tempo</span>
                                        <input type="number" name="tempo_estimado_preparo" min="1" value="<?= (int) ($pedido['tempo_estimado_preparo'] ?? 40); ?>">
                                        <small>min</small>
                                    </label>
                                    <button class="btn btn--small" type="submit">Salvar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($pedidos)): ?>
                        <tr><td colspan="6">Nenhum pedido registrado ainda.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
