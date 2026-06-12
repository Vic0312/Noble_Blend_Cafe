<?php
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/ViewHelper.php';
require_once __DIR__ . '/../model/Carrinho.php';

AuthController::requireCliente();

$baseImg = '../img/';
$totalCarrinho = Carrinho::quantidadeTotal(AuthController::clienteId());

$imagens = [
    'logo'        => asset($baseImg . 'logo.png'),
    'hero'        => asset($baseImg . 'fundo-hero.png'),
    'xicaraHero'  => asset($baseImg . 'imagem_cafe_primeira_parte.png'),
    'graosFooter' => asset($baseImg . 'imagem_rodape.png'),
    'pacoteCafe'  => asset($baseImg . 'pacote_cafe.png'),
    'mapaGraos'   => asset($baseImg . 'mapa_mundi_graos_escuros.png'),
    'xicaraNav'   => asset($baseImg . 'membro_cafe.png'),
];

$cardsCafe = [
    ['titulo' => 'Light café', 'icone' => asset($baseImg . 'icone1.png'), 'link' => 'produto-torra-clara.php'],
    ['titulo' => 'Medium café', 'icone' => asset($baseImg . 'icone2.png'), 'link' => 'produto-medium.php'],
    ['titulo' => 'Medium dark café', 'icone' => asset($baseImg . 'icone3.png'), 'link' => 'produto-torra-media-escura.php'],
    ['titulo' => 'Dark cafe', 'icone' => asset($baseImg . 'icone4.png'), 'link' => 'produto-dark-cafe.php'],
];

$bebidas = [
    ['img' => asset($baseImg . 'cafe1.png'), 'alt' => 'Bebida gelada de café com chantilly'],
    ['img' => asset($baseImg . 'cafe2.png'), 'alt' => 'Café cremoso servido com sorvete'],
    ['img' => asset($baseImg . 'cafe3.png'), 'alt' => 'Frappé de café com chocolate'],
    ['img' => asset($baseImg . 'cafe4.png'), 'alt' => 'Cafés com arte latte'],
    ['img' => asset($baseImg . 'cafe5.jfif'), 'alt' => 'Café especial da casa'],
    ['img' => asset($baseImg . 'cafe6.png'), 'alt' => 'Bebida artesanal de café'],
];

$pacotes = [
    ['titulo' => 'Espresso Clássico', 'img' => asset($baseImg . 'torra-clara-graos.png'), 'link' => 'produto-torra-clara.php', 'alt' => 'Grãos de café de torra clara'],
    ['titulo' => 'Espresso Suave', 'img' => asset($baseImg . 'torra-clara-media-graos.png'), 'link' => 'produto-medium.php', 'alt' => 'Grãos de café de torra média'],
    ['titulo' => 'Espresso Intenso', 'img' => asset($baseImg . 'torra-media-escura-graos.png'), 'link' => 'produto-torra-media-escura.php', 'alt' => 'Grãos de café de torra média escura'],
    ['titulo' => 'Espresso Premium', 'img' => asset($baseImg . 'torra-escura-graos.png'), 'link' => 'produto-dark-cafe.php', 'alt' => 'Grãos de café de torra escura'],
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/logado_cliente.css'); ?>">
</head>
<body id="topo">
    <?php include __DIR__ . '/partials/nav_cliente.php'; ?>

    <main>
        <section class="hero-logado" aria-labelledby="titulo-home-logado" style="--hero-bg: url('<?= $imagens['hero']; ?>');">
            <div class="hero-logado__overlay"></div>
            <div class="hero-logado__conteudo">
                <span class="linha-decorativa" aria-hidden="true"></span>
                <h1 id="titulo-home-logado">Noble Blend Café</h1>
                <span class="linha-decorativa" aria-hidden="true"></span>
            </div>
        </section>

        <section class="cards-cafe container" aria-label="Tipos de café">
            <?php foreach ($cardsCafe as $card): ?>
                <a href="<?= $card['link']; ?>" class="tipo-card">
                    <img src="<?= $card['icone']; ?>" alt="" aria-hidden="true">
                    <h2><?= $card['titulo']; ?></h2>
                    <ul>
                        <li>Benefícios da torra</li>
                        <li>Receitas sugeridas</li>
                    </ul>
                    <span>Saiba mais</span>
                </a>
            <?php endforeach; ?>
        </section>

        <section class="qualidade" aria-labelledby="titulo-qualidade">
            <div class="qualidade__conteudo container">
                <div class="qualidade__imagem">
                    <img src="<?= $imagens['pacoteCafe']; ?>" alt="Pacotes de café Noble Blend Café">
                    <img src="<?= $imagens['pacoteCafe']; ?>" alt="" aria-hidden="true" class="qualidade__imagem--atras">
                </div>

                <div class="qualidade__texto">
                    <h2 id="titulo-qualidade">Qualidade dos grãos:</h2>
                    <article class="qualidade__item">
                        <img src="<?= asset($baseImg . 'graos-de-cafe-icone.png'); ?>" alt="" aria-hidden="true">
                        <div>
                            <h3>Seleção cuidadosa:</h3>
                            <p>Selecionamos os grãos de fazendas renomadas, garantindo que apenas os melhores grãos de café arábica componham nossos blends.</p>
                        </div>
                    </article>
                    <article class="qualidade__item">
                        <img src="<?= asset($baseImg . 'cafeteira_icone.png'); ?>" alt="" aria-hidden="true">
                        <div>
                            <h3>Torrefação artesanal:</h3>
                            <p>Os grãos são torrados artesanalmente em pequenos lotes, permitindo controle preciso do perfil de sabor e da qualidade.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="mapa-graos" aria-label="Mapa mundi feito com grãos de café">
            <img src="<?= $imagens['mapaGraos']; ?>" alt="Mapa mundi formado por grãos de café">
        </section>

        <section class="destaques container" aria-labelledby="titulo-destaques">
            <h2 id="titulo-destaques">Destaques de pedidos:</h2>
            <div class="destaques__carrossel" data-carousel>
                <div class="destaques__trilho" data-carousel-track>
                    <?php foreach ($bebidas as $bebida): ?>
                        <figure class="destaque-card">
                            <img src="<?= $bebida['img']; ?>" alt="<?= $bebida['alt']; ?>">
                        </figure>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="pacotes-logado container" aria-label="Pacotes de café">
            <div class="pacotes-logado__grid">
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

    <a class="voltar-topo" href="#topo" aria-label="Voltar ao topo" title="Voltar ao topo"><span aria-hidden="true">↑</span></a>

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
                    <a href="tel:+5518998069565" aria-label="Telefone">☎</a>
                    <a href="#" aria-label="Instagram">◎</a>
                    <a href="#" aria-label="Facebook">f</a>
                    <a href="#" aria-label="X">𝕏</a>
                    <a href="mailto:contato@nobleblendcafe.com" aria-label="E-mail">✉</a>
                </div>
            </div>
        </div>
    </footer>
    <script src="<?= asset('../js/logado_cliente.js'); ?>"></script>
</body>
</html>
