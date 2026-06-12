<?php
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/ViewHelper.php';
require_once __DIR__ . '/../model/Cliente.php';

AuthController::requireFuncionario();

$clientes = Cliente::listarTodos();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/app.css'); ?>">
</head>
<body class="staff-body">
    <?php include __DIR__ . '/partials/nav_funcionario.php'; ?>

    <main class="staff-shell">
        <section class="section-heading section-heading--top">
            <div>
                <p class="eyebrow">Público</p>
                <h1>Clientes</h1>
                <p>Lista de clientes cadastrados e situação da assinatura Coffee Lovers.</p>
            </div>
        </section>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Coffee Lovers</th>
                        <th>Cadastro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?= e($cliente['nome']); ?></td>
                            <td><?= e($cliente['email']); ?></td>
                            <td><?= e($cliente['telefone']); ?></td>
                            <td><span class="pill"><?= !empty($cliente['possui_clube']) ? 'Ativo' : 'Não assina'; ?></span></td>
                            <td><?= date('d/m/Y', strtotime($cliente['criado_em'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
