<?php
require_once __DIR__ . '/../controller/ViewHelper.php';
$flash = flash_get();

$imagens = array(
    'logo' => asset('../img/logo2.png'),
    'graos' => asset('../img/graos_cafe.png'),
);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Cliente | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/login_usuario.css'); ?>">
    <link rel="stylesheet" href="<?= asset('../css/app.css'); ?>">
</head>
<body>
    <main class="pagina-login pagina-login--cliente">
        <section class="login-card login-card--cliente" aria-labelledby="titulo-login-cliente">
            <header class="login-card__cabecalho login-card__cabecalho--cliente">
                <p>Faça login com seu email</p>
            </header>

            <img class="login-card__graos" src="<?= $imagens['graos']; ?>" alt="" aria-hidden="true">

            <div class="login-card__conteudo">
                <aside class="login-card__marca" aria-label="Noble Blend Café">
                    <img src="<?= $imagens['logo']; ?>" alt="Logo Noble Blend Café">
                </aside>

                <form class="login-form" action="../processamento/login_cliente.php" method="post">
                    <h1 id="titulo-login-cliente">Acesso do cliente</h1>

                    <?php if ($flash): ?>
                        <div class="flash flash--<?= e($flash['tipo']); ?>"><?= e($flash['mensagem']); ?></div>
                    <?php endif; ?>

                    <label class="campo-login">
                        <span>Digite seu email:</span>
                        <input type="email" name="email" placeholder="email@exemplo.com" autocomplete="username" required>
                    </label>

                    <label class="campo-login campo-login--senha">
                        <span>Digite sua senha:</span>
                        <div class="campo-login__senha">
                            <input type="password" name="senha" placeholder="Senha" autocomplete="current-password" required>
                            <button type="button" class="botao-senha" aria-label="Mostrar ou ocultar senha" data-toggle-password>
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M2.3 12s3.5-6 9.7-6 9.7 6 9.7 6-3.5 6-9.7 6-9.7-6-9.7-6Zm9.7 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" fill="none" stroke="currentColor" stroke-width="1.8"/>
                                    <path d="M4 20 20 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                    </label>

                    <div class="login-form__extras">
                        <label class="manter-conectado">
                            <input type="checkbox" name="manter_conectado">
                            <span>Manter conectado</span>
                        </label>

                        <a href="cadastro_cliente.php" class="esqueci-senha">Criar conta</a>
                    </div>

                    <button class="botao-acessar" type="submit">Acessar</button>
                </form>
            </div>
        </section>

        <p class="direitos">© Noble Blend Café - Todos os direitos reservados</p>
    </main>
    <script src="<?= asset('../js/app.js'); ?>"></script>
</body>
</html>
