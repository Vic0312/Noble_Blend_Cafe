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
    'cafeLatte'  => asset('../img/cafe_latte.png'),
    'graosIcone' => asset('../img/graos-de-cafe-icone.png'),
];

$beneficios = [
    'Sabor Intenso: A torra média escura proporciona um perfil de sabor profundo, com notas de chocolate amargo, caramelo e nozes torradas.',
    'Aromas Marcantes: Desfrute de um aroma potente e convidativo, com toques de especiarias e cacau.',
    'Encorpado e Suave: Oferece uma textura densa e aveludada, com um final suave e prolongado.',
    'Baixa Acidez: Esta torra reduz a acidez natural do café, resultando em uma bebida mais suave e agradável ao paladar.',
    'Versatilidade: Ideal para métodos de preparo como espresso, prensa francesa e cafeteira italiana, adaptando-se bem a diversas receitas.',
];

$producao = [
    'Seleção dos Grãos: Selecionamos grãos que suportam bem torra mais intensa, preservando complexidade de sabor.',
    'Torrefação: Os grãos são torrados até um ponto médio escuro, destacando notas de chocolate amargo e caramelo queimado.',
    'Controle de Qualidade: Cada lote é degustado para garantir que atenda ao nosso padrão de sabor robusto e encorpado.',
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medium Dark Café | Noble Blend Café</title>
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
                    <h1 id="titulo-produto">Medium Dark<br>Café</h1>
                    <p>
                        Descubra a intensidade e profundidade do nosso Medium Dark Café. 
                    </p>
                    <p>
                        Esta torra é ideal para quem aprecia uma bebida robusta e encorpada,
                         com sabores acentuados e aromas marcantes.
                    </p>
                    <p>
                        A torra média escura realça as notas mais profundas dos grãos, 
                        resultando em uma xícara rica e satisfatória.
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
                    <h3>Café Latte</h3>

                    <div class="receita__bloco">
                        <h4>Ingredientes:</h4>
                        <ol>
                            <li>50ml de café espresso (torra média escura).<li>
                                200ml de leite.
                        </ol>
                    </div>

                    <div class="receita__bloco receita__bloco--preparo">
                        <h4>Modo de Preparo:</h4>
                        <p>
                            Prepare o espresso. Aqueça e vaporize o leite até formar uma espuma cremosa. 
                            Adicione o leite vaporizado ao espresso e sirva quente, decorado com uma leve camada de espuma.
                        </p>
                    </div>
                </div>

                <figure class="receita__imagem">
                    <img src="<?= $imagens['cafeLatte']; ?>" alt="Café mocha servido em xícara de vidro">
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
                    <strong>Descrição:</strong> Nosso Grão de Café de Torra Média Escura é perfeito para quem 
                    busca uma bebida encorpada e aromática. Com sabor 
                    profundo e notas de especiarias, é ideal para métodos como cafeteira italiana e prensa francesa.
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
