<?php
require_once __DIR__ . '/../../controller/AuthController.php';
require_once __DIR__ . '/../../controller/ViewHelper.php';

$funcionarioNomeNav = $_SESSION['funcionario_nome'] ?? 'Funcionário';
?>
<header class="staff-header">
    <nav class="staff-nav" aria-label="Navegação do funcionário">
        <a class="staff-brand" href="logado_funcionario.php">
            <img src="<?= asset('../img/logo2.png'); ?>" alt="Noble Blend Café">
            <span>Noble Blend Café</span>
        </a>

        <div class="staff-nav__links">
            <a href="logado_funcionario.php">Painel</a>
            <a href="funcionario_produtos.php">Produtos</a>
            <a href="funcionario_pedidos.php">Pedidos</a>
            <a href="funcionario_clientes.php">Clientes</a>
            <a href="funcionario_funcionarios.php">Funcionários</a>
            <a href="funcionario_perfil.php">Perfil</a>
        </div>

        <div class="staff-nav__user">
            <span><?= e($funcionarioNomeNav); ?></span>
            <a href="../processamento/logout.php">Sair</a>
        </div>
    </nav>
</header>
