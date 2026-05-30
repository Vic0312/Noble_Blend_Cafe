<?php
function asset(string $caminho): string
{
    $caminho = ltrim($caminho, '/');

    if (defined('BASE_URL')) {
        return rtrim(BASE_URL, '/') . '/' . $caminho;
    }

    $base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $base = ($base === '/' || $base === '.' || $base === '\\') ? '' : rtrim($base, '/');

    return $base . '/' . $caminho;
}

$imagens = [
    'logo'  => asset('../img/logo.png'),
    'folha' => asset('../img/pe_cafe.png'),
    'graos' => asset('../img/graos_cafe.png'),
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecionar Usuário | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/selecionar_usuario.css'); ?>">
</head>
<body>
    <main class="pagina-selecao">
        <section class="selecao-card" aria-labelledby="titulo-selecao">
            <img class="decoracao decoracao--folha" src="<?= $imagens['folha']; ?>" alt="" aria-hidden="true">
            <img class="decoracao decoracao--graos" src="<?= $imagens['graos']; ?>" alt="" aria-hidden="true">

            <div class="selecao-card__topo">
                <span class="linha linha--esquerda" aria-hidden="true"></span>

                <div class="marca">
                    <img src="<?= $imagens['logo']; ?>" alt="Logo Noble Blend Café">
                    <h1 id="titulo-selecao">Quem é você?</h1>
                </div>

                <span class="linha linha--direita" aria-hidden="true"></span>
            </div>

            <div class="opcoes-usuario" aria-label="Escolha o tipo de usuário">
                <a class="opcao-card" href="login_funcionario.php" aria-label="Entrar como funcionário">
                    <span class="opcao-card__icone" aria-hidden="true">
                        <svg viewBox="0 0 64 64" role="img">
                            <path d="M32 8a11 11 0 1 1 0 22 11 11 0 0 1 0-22Z"/>
                            <path d="M18 35h28a7 7 0 0 1 7 7v13H11V42a7 7 0 0 1 7-7Z"/>
                            <path d="M25 38h14v17H25z" fill="#fff8ef" opacity=".95"/>
                            <path d="M29 41h6v5h-6zM28 49h8v4h-8z"/>
                            <path d="M24 35l8 7 8-7" fill="none" stroke="#000" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span>Funcionário</span>
                </a>

                <a class="opcao-card" href="login_cliente.php" aria-label="Entrar como cliente">
                    <span class="opcao-card__icone" aria-hidden="true">
                        <svg viewBox="0 0 64 64" role="img">
                            <path d="M32 10a12 12 0 1 1 0 24 12 12 0 0 1 0-24Z"/>
                            <path d="M15 41c3.5-6.5 10-10 17-10s13.5 3.5 17 10v12H15V41Z"/>
                        </svg>
                    </span>
                    <span>Cliente</span>
                </a>
            </div>
        </section>

        <p class="direitos">© Noble Blend Café - Todos os direitos reservados</p>
    </main>
</body>
</html>
