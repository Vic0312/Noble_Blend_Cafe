<?php
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/ViewHelper.php';
require_once __DIR__ . '/../model/Funcionario.php';

AuthController::requireFuncionario();

$flash = flash_get();
$funcionario = Funcionario::buscarPorId(AuthController::funcionarioId());
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Funcionário | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/app.css'); ?>">
</head>
<body class="staff-body">
    <?php include __DIR__ . '/partials/nav_funcionario.php'; ?>

    <main class="staff-shell">
        <section class="section-heading section-heading--top">
            <div>
                <p class="eyebrow">Minha conta</p>
                <h1>Editar perfil</h1>
                <p>Atualize seus dados de funcionário e senha de acesso.</p>
            </div>
        </section>

        <?php if ($flash): ?>
            <div class="flash flash--<?= e($flash['tipo']); ?>"><?= e($flash['mensagem']); ?></div>
        <?php endif; ?>

        <form class="form-panel" action="../processamento/perfil_funcionario_salvar.php" method="post">
            <div class="form-grid">
                <label class="field">
                    <span>Nome</span>
                    <input type="text" name="nome" value="<?= e($funcionario['nome'] ?? ''); ?>" required>
                </label>

                <label class="field">
                    <span>Email</span>
                    <input type="email" name="email" value="<?= e($funcionario['email'] ?? ''); ?>" required>
                </label>

                <label class="field">
                    <span>Telefone</span>
                    <input type="text" name="telefone" value="<?= e($funcionario['telefone'] ?? ''); ?>">
                </label>

                <label class="field">
                    <span>Cargo</span>
                    <input type="text" name="cargo" value="<?= e($funcionario['cargo'] ?? 'Atendimento'); ?>" required>
                </label>

                <label class="field field--full">
                    <span>Nova senha</span>
                    <input type="password" name="senha" placeholder="Deixe vazio para manter">
                </label>
            </div>

            <div class="form-actions">
                <button class="btn" type="submit">Salvar perfil</button>
            </div>
        </form>
    </main>
</body>
</html>
