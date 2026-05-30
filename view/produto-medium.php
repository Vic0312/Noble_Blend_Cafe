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
    'cafeMocha'  => asset('../img/cafe_mocha.png'),
    'graosIcone' => asset('../img/graos-de-cafe-icone.png'),
];

$beneficios = [
    'Equilíbrio de Sabor: A torra média oferece um equilíbrio harmonioso entre acidez, doçura e amargor, resultando em uma xícara de café bem balanceada.',
    'Aromas Profundos: Desfrute de aromas mais robustos e complexos, com notas de caramelo, nozes e chocolate.',
    'Sabor Encorpado: O perfil de sabor é mais completo, com uma textura aveludada que preenche o paladar.',
    'Versatilidade: Ideal para diversos métodos de preparo, desde o tradicional café coado até espressos intensos.',
    'Benefícios à Saúde: A torra média mantém uma boa quantidade de antioxidantes e compostos benéficos, auxiliando na saúde geral e no bem-estar.',
];

$producao = [
    'Seleção dos Grãos: Grãos premium são selecionados para um perfil de sabor equilibrado.',
    'Torrefação: Os grãos passam por um processo de torra moderada, que equilibra a acidez e o amargor, resultando em um sabor harmonioso.',
    'Controle de Qualidade: Garantimos consistência em cada lote através de rigorosos testes de sabor.',
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medium Café | Noble Blend Café</title>
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
                    <h1 id="titulo-produto">Medium<br>Café</h1>
                    <p>
                        Conheça nosso Medium Café 350g, especialmente selecionado para oferecer
                        um equilíbrio perfeito entre sabor, aroma e intensidade.
                    </p>
                    <p>
                        A torra média realça as características intrínsecas dos grãos,
                        proporcionando uma xícara rica e encorpada que agrada tanto aos
                        paladares exigentes quanto aos apreciadores casuais.
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
                <h2 id="titulo-beneficios">Benefícios da Torra Média Clara</h2>

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
                            <li>50ml de café espresso (torra média)</li>
                            <li>150ml de leite</li>
                            <li>2 colheres de sopa de calda de chocolate.</li>
                        </ol>
                    </div>

                    <div class="receita__bloco receita__bloco--preparo">
                        <h4>Modo de Preparo:</h4>
                        <p>
                            Misture o café com a calda de chocolate. Aqueça o leite e vaporize até obter espuma.
                            Adicione o leite vaporizado ao café com chocolate e sirva com chantilly, se desejar.
                        </p>
                    </div>
                </div>

                <figure class="receita__imagem">
                    <img src="<?= $imagens['cafeMocha']; ?>" alt="Café mocha servido em xícara de vidro">
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
                    <strong>Descrição:</strong> O Grão de Café de Torra Média proporciona uma bebida equilibrada,
                    com notas de caramelo, nozes e um leve toque de chocolate. Ideal para métodos como
                    espresso e prensa francesa, oferecendo uma xícara bem balanceada.
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
