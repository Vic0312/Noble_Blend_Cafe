<?php
require_once __DIR__ . '/../controller/ViewHelper.php';
$flash = flash_get();

$imagens = array(
    'logo' => asset('../img/logo2.png'),
    'marca' => asset('../img/marca_dagua.png'),
);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Funcionário | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/app.css'); ?>">
</head>
<body class="app-body auth-body">
    <main class="auth-shell">
        <section class="auth-panel auth-panel--staff" aria-labelledby="titulo-cadastro-funcionario">
            <img class="auth-watermark" src="<?= $imagens['marca']; ?>" alt="" aria-hidden="true">

            <div class="auth-brand auth-brand--logo-only">
                <img src="<?= $imagens['logo']; ?>" alt="Logo Noble Blend Café">
                <h1 id="titulo-cadastro-funcionario">Cadastro de funcionário</h1>
                <p>Use esta tela para criar acessos da equipe. Não há separação entre administrador e funcionário comum.</p>
            </div>

            <form class="form-card" action="../processamento/cadastro_funcionario.php" method="post">
                <header class="form-card__heading">
                    <p class="eyebrow">Equipe Noble Blend</p>
                    <h2>Cadastro de funcionario</h2>
                </header>

                <?php if ($flash): ?>
                    <div class="flash flash--<?= e($flash['tipo']); ?>"><?= e($flash['mensagem']); ?></div>
                <?php endif; ?>

                <div class="form-grid">
                    <label class="field">
                        <span>Nome completo</span>
                        <input type="text" name="nome" required>
                    </label>

                    <label class="field">
                        <span>Email</span>
                        <input type="email" name="email" required>
                    </label>

                    <label class="field">
                        <span>Telefone</span>
                        <input type="text" name="telefone" placeholder="(00) 00000-0000">
                    </label>

                    <label class="field">
                        <span>Cargo</span>
                        <input type="text" name="cargo" value="Atendimento" required>
                    </label>

                    <label class="field field--full">
                        <span>Senha</span>
                        <input type="password" name="senha" minlength="6" required>
                    </label>
                </div>

                <div class="form-actions">
                    <a class="btn btn--ghost" href="login_funcionario.php">Voltar ao login</a>
                    <button class="btn" type="submit">Cadastrar funcionário</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
