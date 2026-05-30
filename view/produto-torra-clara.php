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
    'ajuda'      => asset('../img/ponto-de-interrogacao.png'),
    'pacoteCafe' => asset('../img/pacote_cafe.png'),
    'cafeGelado'  => asset('../img/cafe_gelado.png'),
    'graosIcone' => asset('../img/graos-de-cafe-icone.png'),
];

$beneficios = [
    'Aromas Intensos: A torra clara mantém os aromas originais do café, proporcionando uma experiência olfativa rica e diversificada.',
    'Maior Acidez: Essa torra realça a acidez natural do café, oferecendo uma xícara mais brilhante e refrescante.',
    'Perfil de Sabor Complexo: Saboreie notas frutadas e florais, com nuances que variam conforme a origem do grão.',
    'Maior Teor de Cafeína: Com menor tempo de torrefação, a torra clara preserva mais cafeína, resultando em uma bebida mais estimulante.',
    'Antioxidantes Naturais: A torra clara conserva maior quantidade de antioxidantes, que auxiliam na proteção contra radicais livres.',
];

$producao = [
    'Seleção dos Grãos: Escolhemos os melhores grãos de café de fazendas sustentáveis ao redor do mundo.',
    'Torrefação: Os grãos são torrados em temperaturas mais baixas por um período mais curto, garantindo que suas características naturais sejam preservadas.',
    'Controle de Qualidade: Cada lote é rigorosamente testado para assegurar que mantém o perfil de sabor desejado.',
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Light Café | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/produto-medium2.css'); ?>">
</head>
<body id="topo">
    <a class="ajuda-flutuante" href="ajuda.php" aria-label="Ajuda">
        <img src="<?= $imagens['ajuda']; ?>" alt="">
    </a>

    <main>
        <section class="produto-hero" aria-labelledby="titulo-produto">
            <div class="produto-hero__painel">
                <div class="produto-hero__texto">
                    <h1 id="titulo-produto">Light<br>Café</h1>
                    <p>
                        Descubra a excelência do nosso Light café 350g, cuidadosamente 
                        selecionado para proporcionar uma experiência sensorial única.
                    </p>
                    <p>
                        A torra clara preserva as características naturais dos grãos, 
                        revelando notas complexas e sabores sutis.
                    </p>
                </div>
            </div>

            <div class="produto-hero__imagem">
                <img src="<?= $imagens['pacoteCafe']; ?>" alt="Pacote Medium Café 350g Noble Blend Café">
            </div>
        </section>

        <section class="beneficios secao-clara" aria-labelledby="titulo-beneficios">
            <img class="marca-dagua marca-dagua--beneficios" src="<?= $imagens['graosIcone']; ?>" alt="" aria-hidden="true">

            <div class="container container--estreito">
                <h2 id="titulo-beneficios">Benefícios da Torra Média</h2>

                <ol class="lista-beneficios">
                    <?php foreach ($beneficios as $beneficio): ?>
                        <li><?= $beneficio; ?></li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </section>

        <section class="receita" aria-labelledby="titulo-receita">
            <div class="container receita__conteudo">
                <div class="receita__texto">
                    <h2 id="titulo-receita">Receitas Sugeridas</h2>
                    <h3>Café Gelado com Leite de Amêndoas</h3>

                    <div class="receita__bloco">
                        <h4>Ingredientes:</h4>
                        <ol>
                            <li>50ml de café coado forte (torra clara); </li>
                            <li>200ml de leite de amêndoas;</li>
                            <li>gelo;</li>
                        </ol>
                    </div>

                    <div class="receita__bloco receita__bloco--preparo">
                        <h4>Modo de Preparo:</h4>
                        <p>
                            Encha um copo com gelo, adicione o café coado e complete com leite de amêndoas.
                             Misture bem e sirva imediatamente para uma bebida refrescante e deliciosa.
                        </p>
                    </div>
                </div>

                <figure class="receita__imagem">
                    <img src="<?= $imagens['cafeGelado']; ?>" alt="Café gelado servido em copo de vidro">
                </figure>
            </div>
        </section>

        <section class="producao secao-clara" aria-labelledby="titulo-producao">
            <img class="marca-dagua marca-dagua--producao" src="<?= $imagens['graosIcone']; ?>" alt="" aria-hidden="true">

            <div class="container container--texto">
                <h2 id="titulo-producao">Como os grãos são produzidos</h2>

                <ul class="lista-producao">
                    <?php foreach ($producao as $item): ?>
                        <li><?= $item; ?></li>
                    <?php endforeach; ?>
                </ul>

                <p class="descricao-final">
                    <strong>Descrição:</strong> Nosso Grão de Café de Torra Clara oferece uma experiência 
                    sensorial única, destacando notas frutadas e florais com uma acidez brilhante. 
                    Perfeito para métodos de preparo que realçam seu sabor delicado, como café coado
                     e cold brew.
                </p>
            </div>
        </section>
    </main>

    <a class="voltar-topo" href="#topo" aria-label="Voltar ao topo da página">
        <span aria-hidden="true">↑</span>
        Voltar ao topo
    </a>
</body>
</html>
