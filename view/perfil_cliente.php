<?php
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/ViewHelper.php';
require_once __DIR__ . '/../model/Cliente.php';

AuthController::requireCliente();

$flash = flash_get();
$cliente = Cliente::buscarPorId(AuthController::clienteId());
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/app.css'); ?>">
</head>
<body class="app-body">
    <?php include __DIR__ . '/partials/nav_cliente.php'; ?>

    <main class="page-shell">
        <section class="section-heading section-heading--top">
            <div>
                <p class="eyebrow">Minha conta</p>
                <h1>Editar perfil</h1>
                <p>Atualize seus dados de contato, CPF e senha.</p>
            </div>
            <a class="btn btn--ghost" href="logado_cliente.php">Voltar ao início</a>
        </section>

        <?php if ($flash): ?>
            <div class="flash flash--<?= e($flash['tipo']); ?>"><?= e($flash['mensagem']); ?></div>
        <?php endif; ?>

        <form class="form-panel" action="../processamento/perfil_cliente_salvar.php" method="post">
            <div class="form-grid">
                <label class="field">
                    <span>Nome</span>
                    <input type="text" name="nome" value="<?= e($cliente['nome'] ?? ''); ?>" required>
                </label>

                <label class="field">
                    <span>Email</span>
                    <input type="email" name="email" value="<?= e($cliente['email'] ?? ''); ?>" required>
                </label>

                <label class="field">
                    <span>Telefone</span>
                    <input type="text" name="telefone" value="<?= e($cliente['telefone'] ?? ''); ?>">
                </label>

                <label class="field">
                    <span>CPF</span>
                    <input type="text" name="cpf" value="<?= e($cliente['cpf'] ?? ''); ?>">
                </label>

                <label class="field">
                    <span>Nascimento</span>
                    <input type="date" name="nascimento" value="<?= e($cliente['nascimento'] ?? ''); ?>">
                </label>

                <label class="field">
                    <span>Nova senha</span>
                    <input type="password" name="senha" placeholder="Deixe vazio para manter">
                </label>
            </div>

            <div class="profile-status">
                <strong>Coffee Lovers:</strong>
                <span><?= !empty($cliente['possui_clube']) ? 'Clube ativo. Você paga o preço Coffee Lovers de cada produto.' : 'Ainda não ativado.'; ?></span>
                <a href="cadastro_coffee_lovers.php">Gerenciar assinatura</a>
            </div>

            <div class="form-actions">
                <button class="btn" type="submit">Salvar perfil</button>
            </div>
        </form>
    </main>
</body>
</html>
