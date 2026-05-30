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

$baseImg = '../img/';

$imagens = [
    'marcaDagua' => asset($baseImg . 'marca_dagua.png'),
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Coffee Lovers | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/cadastro_coffee_lovers.css'); ?>">
</head>
<body>
    <main class="cadastro-page">
        <section class="cadastro-conteudo" aria-labelledby="titulo-cadastro">
            <img class="marca-dagua marca-dagua--meio" src="<?= $imagens['marcaDagua']; ?>" alt="" aria-hidden="true">
    
            <div class="cadastro-apresentacao">
                <p class="cadastro-saudacao">Olá!</p>
                <h1 id="titulo-cadastro">
                    Para prosseguir com o cadastro de coffee lover, preencha seus dados abaixo
                </h1>
                <h2>Preencha os dados do seu contato</h2>
            </div>

            <div class="cadastro-progresso" aria-label="Etapas do cadastro">
                <div class="progresso-item progresso-item--ativo">
                    <span class="progresso-bolinha"></span>
                    <p>Dados pessoais</p>
                </div>
                <span class="progresso-linha"></span>
                <div class="progresso-item">
                    <span class="progresso-bolinha"></span>
                    <p>Confirmação do<br>cadastro</p>
                </div>
                <span class="progresso-linha"></span>
                <div class="progresso-item">
                    <span class="progresso-bolinha"></span>
                    <p>Conclusão do<br>cadastro</p>
                </div>
            </div>

            <div class="aviso-cadastro" role="alert">
                <strong aria-hidden="true">!</strong>
                <div>
                    <h3>Atenção!</h3>
                    <p>
                        Lembre-se de revisar os dados preenchidos, serão importantes<br>
                        para concluir o seu cadastro e realizar a sua reserva.
                    </p>
                </div>
            </div>

            <form class="form-cadastro" action="#" method="POST">
                <p class="form-cadastro__texto">
                    Não se preocupe. Informe o seu cpf, um código será enviado para o email cadastrado
                </p>

                <label class="campo-cadastro">
                    <span>Cpf</span>
                    <input type="email" name="cpf" placeholder="CPF" autocomplete="CPF" required>
                </label>

                <label class="campo-cadastro">
                    <span>Senha</span>
                    <input type="password" name="senha" placeholder="Senha" autocomplete="new-password" required>
                </label>

                <div class="separador-cadastro" aria-hidden="true">
                    <span></span>
                    <span></span>
                </div>

                <label class="checkbox-cadastro">
                    <input type="checkbox" name="marketing" value="1">
                    <span>Aceito receber comunicações de promoções e marketing.</span>
                </label>

                <p class="observacao-cadastro">
                    <span aria-hidden="true">ⓘ</span>
                    As informações coletadas no cadastro do cliente serão utilizadas para identificação das reservas e execução de contrato entre o titular e a Noble Blend Café.
                </p>

                <button class="botao-continuar" type="submit">Continuar</button>
            </form>
        </section>
    </main>
</body>
</html>
