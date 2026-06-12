<?php
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/ViewHelper.php';
require_once __DIR__ . '/../model/Produto.php';

AuthController::requireFuncionario();

$flash = flash_get();
$produtos = Produto::listar(array('incluir_inativos' => true, 'ordem' => 'recentes'));
$produtoEditar = isset($_GET['editar']) ? Produto::buscar((int) $_GET['editar']) : null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/app.css'); ?>">
</head>
<body class="staff-body">
    <?php include __DIR__ . '/partials/nav_funcionario.php'; ?>

    <main class="staff-shell">
        <?php if ($flash): ?>
            <div class="flash flash--<?= e($flash['tipo']); ?>"><?= e($flash['mensagem']); ?></div>
        <?php endif; ?>

        <section class="section-heading section-heading--top">
            <div>
                <p class="eyebrow">Cardápio</p>
                <h1><?= $produtoEditar ? 'Editar produto' : 'Cadastrar produto'; ?></h1>
                <p>Gerencie os itens que aparecem no cardápio do cliente.</p>
            </div>
            <?php if ($produtoEditar): ?>
                <a class="btn btn--ghost" href="funcionario_produtos.php">Novo produto</a>
            <?php endif; ?>
        </section>

        <form class="form-panel product-editor" action="../processamento/produto_salvar.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_produto" value="<?= (int) ($produtoEditar['id_produto'] ?? 0); ?>">
            <input type="hidden" name="imagem_atual" value="<?= e($produtoEditar['imagem'] ?? ''); ?>">

            <div class="form-grid">
                <label class="field">
                    <span>Nome</span>
                    <input type="text" name="nome" value="<?= e($produtoEditar['nome'] ?? ''); ?>" required>
                </label>

                <label class="field">
                    <span>Categoria</span>
                    <input type="text" name="categoria" value="<?= e($produtoEditar['categoria'] ?? 'Bebidas'); ?>" required>
                </label>

                <label class="field">
                    <span>Preço</span>
                    <input type="number" name="preco" min="0" step="0.01" value="<?= e($produtoEditar['preco'] ?? ''); ?>" required>
                </label>

                <label class="field">
                    <span>Preço Coffee Lovers</span>
                    <input type="number" name="preco_clube" min="0" step="0.01" value="<?= e($produtoEditar['preco_clube'] ?? ''); ?>" required>
                </label>

                <label class="field">
                    <span>Estoque</span>
                    <input type="number" name="estoque" min="0" value="<?= e($produtoEditar['estoque'] ?? 0); ?>" required>
                </label>

                <label class="field">
                    <span>Imagem existente ou caminho</span>
                    <input type="text" name="imagem" value="<?= e($produtoEditar['imagem'] ?? 'img/pacote_cafe.png'); ?>">
                </label>

                <label class="field">
                    <span>Enviar imagem</span>
                    <input type="file" name="imagem_upload" accept=".jpg,.jpeg,.png,.gif,.webp,.jfif">
                </label>

                <label class="field field--full">
                    <span>Descrição curta</span>
                    <input type="text" name="descricao_curta" value="<?= e($produtoEditar['descricao_curta'] ?? ''); ?>">
                </label>

                <label class="field field--full">
                    <span>Descrição completa</span>
                    <textarea name="descricao" rows="4"><?= e($produtoEditar['descricao'] ?? ''); ?></textarea>
                </label>
            </div>

            <label class="check-line">
                <input type="checkbox" name="ativo" value="1" <?= !isset($produtoEditar['ativo']) || (int) $produtoEditar['ativo'] === 1 ? 'checked' : ''; ?>>
                <span>Produto ativo no cardápio</span>
            </label>

            <div class="form-actions">
                <button class="btn" type="submit">Salvar produto</button>
            </div>
        </form>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Categoria</th>
                <th>Preço</th>
                <th>Preço clube</th>
                <th>Estoque</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td>
                                <div class="table-product">
                                    <img src="<?= asset('../' . ltrim($produto['imagem'], '/')); ?>" alt="">
                                    <span><?= e($produto['nome']); ?></span>
                                </div>
                            </td>
                            <td><?= e($produto['categoria']); ?></td>
                            <td><?= money($produto['preco']); ?></td>
                            <td><?= money($produto['preco_clube']); ?></td>
                            <td><?= (int) $produto['estoque']; ?></td>
                            <td><span class="pill"><?= (int) $produto['ativo'] === 1 ? 'Ativo' : 'Inativo'; ?></span></td>
                            <td class="table-actions">
                                <a class="link-button" href="funcionario_produtos.php?editar=<?= (int) $produto['id_produto']; ?>">Editar</a>
                                <?php if ((int) $produto['ativo'] === 1): ?>
                                    <form action="../processamento/produto_excluir.php" method="post">
                                        <input type="hidden" name="id_produto" value="<?= (int) $produto['id_produto']; ?>">
                                        <button class="link-button" type="submit">Remover</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
