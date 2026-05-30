<?php
function asset(string $caminho): string
{
    $caminho = ltrim($caminho, '/');

    if (defined('BASE_URL')) {
        return rtrim(BASE_URL, '/') . '/' . $caminho;
    }

    $base = str_replace('\\\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $base = ($base === '/' || $base === '.' || $base === '\\') ? '' : rtrim($base, '/');

    return $base . '/' . $caminho;
}

$imagens = [
    'logo'  => asset('../img/logo.png'),
    'graos' => asset('../img/graos_cafe.png'),
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Funcionário | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/login_usuario.css'); ?>">
</head>
<body>
    <main class="pagina-login pagina-login--funcionario">
        <section class="login-card" aria-labelledby="titulo-login-funcionario">
            <header class="login-card__cabecalho">
                <span class="login-card__icone" aria-hidden="true">
                    <svg viewBox="0 0 64 64" role="img">
                        <path d="M32 8a11 11 0 1 1 0 22 11 11 0 0 1 0-22Z"/>
                        <path d="M18 35h28a7 7 0 0 1 7 7v13H11V42a7 7 0 0 1 7-7Z"/>
                        <path d="M25 38h14v17H25z" fill="#fff8ef" opacity=".95"/>
                        <path d="M29 41h6v5h-6zM28 49h8v4h-8z"/>
                        <path d="M24 35l8 7 8-7" fill="none" stroke="#000" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <p>Funcionário digite as informações solicitadas</p>
            </header>

            <img class="login-card__graos" src="<?= $imagens['graos']; ?>" alt="" aria-hidden="true">

            <div class="login-card__conteudo">
                <aside class="login-card__marca" aria-label="Noble Blend Café">
                    <img src="<?= $imagens['logo']; ?>" alt="Logo Noble Blend Café">
                </aside>

                <form class="login-form" action="#" method="post">
                    <h1 id="titulo-login-funcionario">Acesso ao sistema</h1>

                    <label class="campo-login">
                        <span>Digite seu Email:</span>
                        <input type="text" name="documento" placeholder="Email" autocomplete="username">
                    </label>

                    <label class="campo-login campo-login--senha">
                        <span>Digite sua senha:</span>
                        <div class="campo-login__senha">
                            <input type="password" name="senha" placeholder="Senha" autocomplete="current-password">
                            <button type="button" class="botao-senha" aria-label="Mostrar ou ocultar senha">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M2.3 12s3.5-6 9.7-6 9.7 6 9.7 6-3.5 6-9.7 6-9.7-6-9.7-6Zm9.7 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" fill="none" stroke="currentColor" stroke-width="1.8"/>
                                    <path d="M4 20 20 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                    </label>

                    <button class="botao-acessar" type="submit">Acessar</button>
                </form>
            </div>
        </section>

        <p class="direitos">© Noble Blend Café - Todos os direitos reservados</p>
    </main>
</body>
</html>
