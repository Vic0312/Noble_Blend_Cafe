<?php
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/ViewHelper.php';
require_once __DIR__ . '/../model/Produto.php';
require_once __DIR__ . '/../model/Cliente.php';

AuthController::requireCliente();

$flash = flash_get();
$cliente = Cliente::buscarPorId(AuthController::clienteId());
$possuiClube = !empty($cliente['possui_clube']);
$filtros = array(
    'busca' => $_GET['busca'] ?? '',
    'categoria' => $_GET['categoria'] ?? '',
    'preco_max' => $_GET['preco_max'] ?? '',
    'ordem' => $_GET['ordem'] ?? '',
    'em_estoque' => isset($_GET['em_estoque']),
);

$produtos = Produto::listar($filtros);
$categorias = Produto::categorias();
$redirectAtual = $_SERVER['REQUEST_URI'] ?? 'cardapio.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/app.css'); ?>">
</head>
<body class="app-body">
    <?php include __DIR__ . '/partials/nav_cliente.php'; ?>

    <main class="page-shell">
        <section class="section-heading section-heading--top">
            <div>
                <p class="eyebrow">Cardápio Noble Blend</p>
                <h1>Cardápio</h1>
            </div>
            <a class="btn btn--ghost" href="carrinho.php">Ver carrinho</a>
        </section>

        <?php if ($flash): ?>
            <div class="flash flash--<?= e($flash['tipo']); ?>"><?= e($flash['mensagem']); ?></div>
        <?php endif; ?>

        <section class="menu-layout" aria-label="Produtos do cardápio">
            <aside class="filters-panel">
                <form method="get" action="cardapio.php">
                    <h2>Filtrar por</h2>

                    <label class="field">
                        <span>Buscar</span>
                        <input type="search" name="busca" value="<?= e($filtros['busca']); ?>" placeholder="Latte, espresso...">
                    </label>

                    <label class="field">
                        <span>Categoria</span>
                        <select name="categoria">
                            <option value="">Todas</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= e($categoria['categoria']); ?>" <?= $filtros['categoria'] === $categoria['categoria'] ? 'selected' : ''; ?>>
                                    <?= e($categoria['categoria']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label class="field">
                        <span>Preço máximo</span>
                        <input type="number" name="preco_max" value="<?= e($filtros['preco_max']); ?>" min="0" step="0.01" placeholder="50.00">
                    </label>

                    <label class="field">
                        <span>Ordenar</span>
                        <select name="ordem">
                            <option value="">Nome A-Z</option>
                            <option value="nome_desc" <?= $filtros['ordem'] === 'nome_desc' ? 'selected' : ''; ?>>Nome Z-A</option>
                            <option value="preco_asc" <?= $filtros['ordem'] === 'preco_asc' ? 'selected' : ''; ?>>Menor preço</option>
                            <option value="preco_desc" <?= $filtros['ordem'] === 'preco_desc' ? 'selected' : ''; ?>>Maior preço</option>
                            <option value="recentes" <?= $filtros['ordem'] === 'recentes' ? 'selected' : ''; ?>>Mais recentes</option>
                        </select>
                    </label>

                    <label class="check-line">
                        <input type="checkbox" name="em_estoque" value="1" <?= $filtros['em_estoque'] ? 'checked' : ''; ?>>
                        <span>Mostrar apenas itens em estoque</span>
                    </label>

                    <div class="filter-actions">
                        <a class="btn btn--ghost" href="cardapio.php">Limpar</a>
                        <button class="btn" type="submit">Aplicar</button>
                    </div>
                </form>
            </aside>

            <section class="products-section">
                <div class="section-heading">
                    <div>
                        <p class="eyebrow">Resultado</p>
                        <h2><?= count($produtos); ?> item(ns) encontrados</h2>
                    </div>
                </div>

                <?php if (empty($produtos)): ?>
                    <div class="empty-state">
                        <h3>Nenhum produto encontrado</h3>
                        <p>Tente limpar os filtros ou cadastrar novos produtos na área de funcionário.</p>
                    </div>
                <?php else: ?>
                    <div class="product-grid">
                        <?php foreach ($produtos as $produto): ?>
                            <?php
                                $imagem = asset('../' . ltrim($produto['imagem'], '/'));
                                $semEstoque = (int) $produto['estoque'] <= 0;
                            ?>
                            <article class="menu-card">
                                <figure class="menu-card__image">
                                    <img src="<?= $imagem; ?>" alt="<?= e($produto['nome']); ?>">
                                </figure>

                                <div class="menu-card__content">
                                    <span class="pill"><?= e($produto['categoria']); ?></span>
                                    <h3><?= e($produto['nome']); ?></h3>
                                    <p><?= e($produto['descricao_curta']); ?></p>

                                    <div class="menu-card__meta">
                                        <strong><?= money($possuiClube ? $produto['preco_clube'] : $produto['preco']); ?></strong>
                                        <span class="<?= $semEstoque ? 'stock stock--empty' : 'stock'; ?>">
                                            <?= $semEstoque ? 'Sem estoque' : (int) $produto['estoque'] . ' em estoque'; ?>
                                        </span>
                                    </div>
                                    <div class="club-price-line">
                                        <span>Normal: <?= money($produto['preco']); ?></span>
                                        <span>Clube: <?= money($produto['preco_clube']); ?></span>
                                    </div>

                                    <form class="add-cart-form" action="../processamento/carrinho_adicionar.php" method="post">
                                        <input type="hidden" name="id_produto" value="<?= (int) $produto['id_produto']; ?>">
                                        <input type="hidden" name="redirect" value="<?= e($redirectAtual); ?>">
                                        <label>
                                            <span>Qtd.</span>
                                            <input type="number" name="quantidade" min="1" max="<?= (int) $produto['estoque']; ?>" value="1" <?= $semEstoque ? 'disabled' : ''; ?>>
                                        </label>
                                        <button class="btn" type="submit" <?= $semEstoque ? 'disabled' : ''; ?>>Adicionar</button>
                                    </form>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </section>
    </main>
</body>
</html>
