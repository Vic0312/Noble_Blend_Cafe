<?php
require_once __DIR__ . '/../../controller/AuthController.php';
require_once __DIR__ . '/../../model/Carrinho.php';
require_once __DIR__ . '/../../controller/ViewHelper.php';

$totalCarrinhoNav = AuthController::clienteId() ? Carrinho::quantidadeTotal(AuthController::clienteId()) : 0;
?>
<header class="cabecalho-logado">
    <nav class="navbar-logado" aria-label="Navegação do cliente">
        <a href="logado_cliente.php" class="navbar-logado__logo" aria-label="Página inicial">
            <img src="<?= asset('../img/logo.png'); ?>" alt="Logo Noble Blend Café">
        </a>

        <div class="navbar-logado__links">
            <a href="logado_cliente.php">Início</a>
            <a href="sobrenos.html">Sobre nós</a>
            <a href="ajuda.php">Ajuda</a>
            <a href="cardapio.php">Cardápio</a>
            <a href="carrinho.php">Carrinho<?= $totalCarrinhoNav > 0 ? ' (' . (int) $totalCarrinhoNav . ')' : ''; ?></a>
            <a href="cliente_pedidos.php">Pedidos</a>
            <a href="perfil_cliente.php">Perfil</a>
        </div>

        <a href="cadastro_coffee_lovers.php" class="navbar-logado__icone" aria-label="Assinatura Coffee Lovers">
            <img src="<?= asset('../img/membro_cafe.png'); ?>" alt="Coffee Lovers">
        </a>
    </nav>
</header>
