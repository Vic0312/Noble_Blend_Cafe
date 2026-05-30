<?php
$baseImg = '../img/';

$imagens = [
    'logo'        => $baseImg . 'logo.png',
    'fundoAjuda'  => $baseImg . 'fundo-hero.png',
    'xicara'      => $baseImg . 'imagem_cafe_primeira_parte.png',
    'graosFooter' => $baseImg . 'imagem_rodape.png',
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajuda | Noble Blend Café</title>
    <link rel="stylesheet" href="../css/ajuda.css">
</head>
<body id="topo">
    <main class="ajuda-page">
        <section class="ajuda-hero" aria-labelledby="titulo-ajuda">
            <img class="ajuda-hero__fundo" src="<?= $imagens['fundoAjuda']; ?>" alt="Ambiente interno da cafeteria Noble Blend Café">
            <div class="ajuda-hero__overlay"></div>

            <div class="ajuda-hero__conteudo container">
                <section class="ajuda-info" aria-labelledby="titulo-marca">
                    <h1 id="titulo-marca">Noble Blend Café</h1>
                    <p class="ajuda-info__intro">
                        Para qualquer dúvida ou assistência,<br>
                        entre em contato com nosso suporte.<br>
                        Estamos aqui para ajudar!
                    </p>

                    <address class="contato-lista">
                        <p>
                            <span class="contato-lista__icone" aria-hidden="true">☎</span>
                            <a href="tel:+5518998069565">+55 (18) 99806-9565</a>
                        </p>
                        <p>
                            <span class="contato-lista__icone" aria-hidden="true">✉</span>
                            <a href="mailto:nobleblendcafe@gmail.com">nobleblendcafe@gmail.com</a>
                        </p>
                        <p>
                            <span class="contato-lista__icone" aria-hidden="true">⌖</span>
                            <span>Avenida Juscelino Kubitschek, 1909</span>
                        </p>
                    </address>
                </section>

                <section class="ajuda-formulario" aria-labelledby="titulo-formulario">
                    <h2 id="titulo-ajuda">Precisa de ajuda?</h2>

                    <form action="#" method="post" class="form-ajuda">
                        <label class="campo-formulario">
                            <span>Nome</span>
                            <input type="text" name="nome" placeholder="Digite seu nome aqui" autocomplete="name" required>
                        </label>

                        <label class="campo-formulario">
                            <span>Assunto</span>
                            <input type="text" name="assunto" placeholder="Assunto" required>
                        </label>

                        <label class="campo-formulario campo-formulario--mensagem">
                            <span>Mensagem</span>
                            <textarea name="mensagem" placeholder="Digite sua mensagem" rows="4"></textarea>
                        </label>

                        <button type="submit" class="botao-enviar">Enviar</button>
                    </form>
                </section>
            </div>
        </section>
    </main>

    <footer class="rodape">
        <div class="rodape__overlay"></div>
        <img class="rodape__fundo" src="<?= $imagens['graosFooter']; ?>" alt="Grãos de café ao fundo">

        <div class="rodape__conteudo container">
            <div class="rodape__marca">
                <img src="<?= $imagens['xicara']; ?>" alt="Xícara de café">
                <div>
                    <strong>Noble Blend Café</strong>
                    <span>Cafeteria</span>
                </div>
            </div>

            <div class="rodape__contato">
                <img src="<?= $imagens['logo']; ?>" alt="Logo Noble Blend Café">
                <p>+55 (18) 99806-9565</p>

                <div class="rodape__redes" aria-label="Redes sociais">
                    <a href="tel:+5518998069565" aria-label="Telefone">☎</a>
                    <a href="#" aria-label="Instagram">◎</a>
                    <a href="#" aria-label="Facebook">f</a>
                    <a href="#" aria-label="X">𝕏</a>
                    <a href="mailto:nobleblendcafe@gmail.com" aria-label="E-mail">✉</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
