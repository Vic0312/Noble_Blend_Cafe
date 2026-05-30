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
    'cafeDark'  => asset('../img/cafedark.png'),
    'graosIcone' => asset('../img/graos-de-cafe-icone.png'),
];

$beneficios = [
    'Sabor Robusto: A torra escura desenvolve um perfil de sabor profundo, com notas de chocolate amargo, caramelo queimado e nozes tostadas.',
    'Aromas Intensos: Desfrute de um aroma forte e marcante, com nuances de especiarias e tabaco.',
    'Encorpado e Aveludado: Oferece uma textura densa e cremosa, com um final suave e persistente.',
    'Baixa Acidez: A torra escura reduz significativamente a acidez natural do café, resultando em uma bebida mais suave e encorpada.',
    'Versatilidade: Ideal para métodos de preparo como espresso, cafeteira italiana e café turco, adaptando-se bem a diversas receitas e preparos.',
];

$producao = [
    'Seleção dos Grãos: Grãos selecionados para proporcionar um perfil de sabor intenso.',
    'Torrefação: Torrados até um ponto escuro, os grãos desenvolvem notas fortes de chocolate, caramelo e especiarias, com baixa acidez.',
    'Controle de Qualidade: Realizamos testes rigorosos para garantir que cada lote tenha a intensidade e o sabor desejados.',
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Café | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/produto-medium.css'); ?>">
</head>
<body id="topo">
    <a class="ajuda-flutuante" href="ajuda.php" aria-label="Ajuda">
        <img src="<?= $imagens['ajuda']; ?>" alt="">
    </a>

    <main>
        <section class="produto-hero" aria-labelledby="titulo-produto">
            <div class="produto-hero__painel">
                <div class="produto-hero__texto">
                    <h1 id="titulo-produto">Dark<br>Café</h1>
                    <p>
                        Experimente a intensidade máxima do nosso Dark Café.
                    </p>
                    <p>
                         Esta torra é perfeita para quem prefere um café forte e marcante, 
                         com um sabor robusto e encorpado que proporciona uma experiência sensorial inesquecível.
                    </p>
                    <p>
                         A torra escura realça os sabores mais profundos e complexos dos grãos, resultando em uma bebida rica e satisfatória.
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
                <h2 id="titulo-beneficios">Benefícios da Torra Escura</h2>

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
                    <h3>Café Mocha</h3>

                    <div class="receita__bloco">
                        <h4>Ingredientes:</h4>
                        <ol>
                            <li>50ml de café espresso (torra escura);</li>
                            <li>150ml de água quente.</li>
                        </ol>
                    </div>

                    <div class="receita__bloco receita__bloco--preparo">
                        <h4>Modo de Preparo:</h4>
                        <p>
                            Prepare o espresso e adicione água quente para diluir, 
                            criando uma bebida suave, mas com o sabor robusto característico da torra escura.
                        </p>
                    </div>
                </div>

                <figure class="receita__imagem">
                    <img src="<?= $imagens['cafeDark']; ?>" alt="Café dark servido em xícara de vidro">
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
                    <strong>Descrição:</strong> O Grão de Café de Torra Escura oferece uma experiência robusta e intensa, perfeita para amantes de café forte. Ideal para métodos como espresso 
                    e café turco, sua baixa acidez e textura aveludada garantem uma xícara rica e satisfatória.
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
