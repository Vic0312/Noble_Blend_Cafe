<?php
require_once __DIR__ . '/../controller/ViewHelper.php';
$flash = flash_get();

$imagens = array(
    'logo' => asset('../img/logo.png'),
    'marca' => asset('../img/marca_dagua.png'),
);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Cliente | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/app.css'); ?>">
</head>
<body class="app-body auth-body">
    <main class="auth-shell">
        <section class="auth-panel" aria-labelledby="titulo-cadastro-cliente">
            <img class="auth-watermark" src="<?= $imagens['marca']; ?>" alt="" aria-hidden="true">

            <div class="auth-brand auth-brand--logo-only">
                <img src="<?= $imagens['logo']; ?>" alt="Logo Noble Blend Café">
                <p>Cadastre-se para comprar pelo cardápio, acompanhar pedidos e montar seu carrinho.</p>
            </div>

            <form class="form-card" action="../processamento/cadastro_cliente.php" method="post">
                <header class="form-card__heading">
                    <p class="eyebrow">Coffee Lovers</p>
                    <h1 id="titulo-cadastro-cliente">Criar conta de cliente</h1>
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
                        <span>CPF</span>
                        <input type="text" name="cpf" placeholder="000.000.000-00">
                    </label>

                    <label class="field">
                        <span>Nascimento</span>
                        <input type="date" name="nascimento">
                    </label>

                    <label class="field">
                        <span>Senha</span>
                        <input type="password" name="senha" minlength="6" required>
                    </label>
                </div>

                <label class="check-line">
                    <input type="checkbox" required>
                    <span>Aceito criar minha conta para pedidos na Noble Blend Café.</span>
                </label>

                <div class="form-actions">
                    <a class="btn btn--ghost" href="login_cliente.php">Já tenho conta</a>
                    <button class="btn" type="submit">Continuar</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
