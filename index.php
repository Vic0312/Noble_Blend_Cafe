<?php

$baseImg = 'img/';
$baseImg2 = '../img/';

$imagens = [
    'logo'       => $baseImg . 'logo.png',
    'hero'       => $baseImg2 . 'fundo-hero.png',
    'xicaraHero' => $baseImg . 'imagem_cafe_primeira_parte.png',
    'graosFooter'=> $baseImg . 'imagem_rodape.png',
    'pacoteCafe' => $baseImg . 'pacote_cafe.png',
];

$bebidas = [
    [
        'img' => $baseImg . 'cafe1.png',
        'alt' => 'Bebida gelada de café com chantilly'
    ],
    [
        'img' => $baseImg . 'cafe2.png',
        'alt' => 'Café cremoso servido em taça'
    ],
    [
        'img' => $baseImg . 'cafe3.png',
        'alt' => 'Frappé de café com calda de chocolate'
    ],
    [
        'img' => $baseImg . 'cafe4.png',
        'alt' => 'Cafés com arte latte'
    ],
    [
        'img' => $baseImg . 'cafe5.jfif',
        'alt' => 'Café especial da casa'
    ],
    [
        'img' => $baseImg . 'cafe6.png',
        'alt' => 'Bebida artesanal de café'
    ],
    [
        'img' => $baseImg . 'cafe7.png',
        'alt' => 'Bebida artesanal de café'
    ],
    [
        'img' => $baseImg . 'cafe8.jfif',
        'alt' => 'Bebida artesanal de café'
    ],

];

$pacotes = [
    [
        'titulo' => 'Espresso Clássico',
        'img'    => $baseImg . 'torra-clara-graos.png',
        'link'   => 'view/produto-torra-clara.php',
        'alt'    => 'Pacote de café Espresso Clássico'
    ],
    [
        'titulo' => 'Espresso Suave',
        'img'    => $baseImg . 'torra-clara-media-graos.png',
        'link'   => 'view/produto-medium.php',
        'alt'    => 'Pacote de café Espresso Suave'
    ],
    [
        'titulo' => 'Espresso Intenso',
        'img'    => $baseImg . 'torra-media-escura-graos.png',
        'link'   => 'view/produto-torra-media-escura.php',
        'alt'    => 'Pacote de café Espresso Intenso'
    ],
    [
        'titulo' => 'Espresso Premium',
        'img'    => $baseImg . 'torra-escura-graos.png',
        'link'   => 'view/produto-dark-cafe.php',
        'alt'    => 'Pacote de café Espresso Premium'
    ],
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noble Blend Café</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body id="topo">
    <header class="cabecalho">
        <nav class="navbar" aria-label="Navegação principal">
            <a href="index.php" class="navbar__logo" aria-label="Página inicial da Noble Blend Café">
                <img src="<?= $imagens['logo']; ?>" alt="Logo Noble Blend Café">
            </a>

            <div class="navbar__acoes">
                <a href="index.php?pagina=ajuda" class="navbar__icone" aria-label="Ajuda">
                    <img src="img/ponto-de-interrogacao.png">
                </a>
                <a href="index.php?pagina=perfil" class="navbar__perfil" aria-label="Perfil do usuário">
                    <img src="img/usuario_icone.png">
                </a>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero" aria-labelledby="titulo-hero" style="--hero-bg: url('<?= $imagens['hero']; ?>');">
            <div class="hero__overlay"></div>
            <img class="hero__fundo" src="<?= $imagens['hero']; ?>" alt="Ambiente interno aconchegante de cafeteria">

            <div class="hero__conteudo container">
                <div class="hero__texto">
                    <h1 id="titulo-hero">Noble Blend Café</h1>
                    <p>
                        Aqui, somos mais do que uma simples cafeteria; somos artesãos do sabor,
                        mestres na arte de despertar os sentidos e cultivadores de momentos inesquecíveis.
                    </p>
                    <a href="view/sobrenos.html" class="botao botao--principal">Sobre nós</a>
                </div>

                <img class="hero__xicara" src="<?= $imagens['xicaraHero']; ?>" alt="Xícara de café com arte latte">
            </div>
        </section>

        <section class="experiencia container" aria-labelledby="titulo-experiencia">
            <h2 id="titulo-experiencia">Experiência única</h2>

            <div class="experiencia__grid">
                <article class="experiencia__item">
                    <div class="experiencia__icone " aria-hidden="true"><img src="img/graos-de-cafe-icone.png"></div>
                    <p>
                        <i style="font-size:30px">No coração do Noble Blend Café </i><br>
                        está a paixão pela qualidade.
                        Nossos grãos de café, cultivados com cuidado e dedicação,
                        são a essência da nossa marca.
                    </p>
                </article>

                <article class="experiencia__item experiencia__item--meio">
                    <div class="experiencia__icone " aria-hidden="true"><img src="img/xicara-de-cafe-primeira-parte.png"></div>
                    <p>
                        <i style="font-size:30px">Cada xícara é uma celebração</i><br> do melhor que a natureza tem para oferecer,
                        refinado pela expertise de nossos baristas em criações que encantam paladares exigentes.
                    </p>
                </article>

                <article class="experiencia__item">
                    <div class="experiencia__icone" aria-hidden="true"><img src="img/menu-de-cafe-primeira-parte.png"></div>
                    <p>
                        <i style="font-size:30px">Nosso cardápio apresenta</i><br> uma variedade de cafés diferenciados,
                        cuidadosamente preparados para satisfazer os desejos mais refinados,
                        desde os clássicos expressos até as criações exclusivas da casa.
                    </p>
                </article>
            </div>
        </section>

        <section class="bebidas container" aria-labelledby="titulo-bebidas">
            <div class="carrossel" data-carousel>
                <div class="carrossel__trilho" data-carousel-track>
                    <?php foreach ($bebidas as $bebida): ?>
                        <figure class="carrossel__card">
                            <img src="<?= $bebida['img']; ?>" alt="<?= $bebida['alt']; ?>">
                        </figure>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="pacotes container" aria-labelledby="titulo-pacotes">

            <div class="pacotes__grid">
                <?php foreach ($pacotes as $pacote): ?>
                    <a class="pacote-card" href="<?= $pacote['link']; ?>" aria-label="Acessar <?= $pacote['titulo']; ?>">
                        <img class="pacote-card__fundo" src="<?= $pacote['img']; ?>" alt="<?= $pacote['alt']; ?>">
                        <img class="pacote-card__sacola" src="<?= $imagens['pacoteCafe']; ?>" alt="Pacote de café Noble Blend Café" aria-hidden="true">
                        <span><?= $pacote['titulo']; ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <a class="voltar-topo" href="#topo" aria-label="Voltar ao topo da página" title="Voltar ao topo">
        <span aria-hidden="true">↑</span>
    </a>

    <footer class="rodape">
        <div class="rodape__overlay"></div>
        <img class="rodape__fundo" src="<?= $imagens['graosFooter']; ?>" alt="Grãos de café ao fundo">

        <div class="rodape__conteudo container">
            <div class="rodape__marca">
                <img src="<?= $imagens['xicaraHero']; ?>" alt="Xícara de café">
                <div>
                    <strong>Noble Blend Café</strong>
                    <span>Cafeteria</span>
                </div>
            </div>

            <div class="rodape__contato">
                <img src="<?= $imagens['logo']; ?>" alt="Logo Noble Blend Café">
                <p>+55 (18) 99806-9565</p>

                <div class="rodape__redes" aria-label="Redes sociais">
                    <a href="#" aria-label="Telefone">☎</a>
                    <a href="#" aria-label="Instagram">◎</a>
                    <a href="#" aria-label="Facebook">f</a>
                    <a href="#" aria-label="X">𝕏</a>
                    <a href="mailto:contato@nobleblendcafe.com" aria-label="E-mail">✉</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/index.js"></script>
</body>
</html>
