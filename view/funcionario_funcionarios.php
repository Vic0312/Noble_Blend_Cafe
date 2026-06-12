<?php
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/ViewHelper.php';
require_once __DIR__ . '/../model/Funcionario.php';

AuthController::requireFuncionario();

$funcionarios = Funcionario::listarTodos();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionários | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/app.css'); ?>">
</head>
<body class="staff-body">
    <?php include __DIR__ . '/partials/nav_funcionario.php'; ?>

    <main class="staff-shell">
        <section class="section-heading section-heading--top">
            <div>
                <p class="eyebrow">Equipe</p>
                <h1>Funcionários</h1>
                <p>Todos têm o mesmo tipo de acesso, sem distinção entre administrador e funcionário comum.</p>
            </div>
            <a class="btn btn--ghost" href="cadastro_funcionario.php">Cadastrar funcionário</a>
        </section>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Cargo</th>
                        <th>Cadastro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($funcionarios as $funcionario): ?>
                        <tr>
                            <td><?= e($funcionario['nome']); ?></td>
                            <td><?= e($funcionario['email']); ?></td>
                            <td><?= e($funcionario['telefone']); ?></td>
                            <td><?= e($funcionario['cargo']); ?></td>
                            <td><?= date('d/m/Y', strtotime($funcionario['criado_em'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
