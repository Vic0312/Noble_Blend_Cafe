<?php
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/ViewHelper.php';
require_once __DIR__ . '/../model/Cliente.php';

AuthController::requireCliente();

$flash = flash_get();
$cliente = Cliente::buscarPorId(AuthController::clienteId());
$possuiClube = !empty($cliente['possui_clube']);

$imagens = [
    'marcaDagua' => asset('../img/marca_dagua.png'),
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Coffee Lovers | Noble Blend Café</title>
    <link rel="stylesheet" href="<?= asset('../css/cadastro_coffee_lovers.css'); ?>">
</head>
<body>
    <main class="cadastro-page">
        <section class="cadastro-conteudo" aria-labelledby="titulo-cadastro">
            <img class="marca-dagua marca-dagua--meio" src="<?= $imagens['marcaDagua']; ?>" alt="" aria-hidden="true">

            <div class="cadastro-apresentacao">
                <p class="cadastro-saudacao">Olá!</p>
                <h1 id="titulo-cadastro">
                    Para prosseguir com o cadastro de coffee lover, preencha seus dados abaixo
                </h1>
                <h2>Assinantes pagam o preço Coffee Lovers dos produtos</h2>
            </div>

            <div class="cadastro-progresso" aria-label="Etapas do cadastro">
                <div class="progresso-item progresso-item--ativo">
                    <span class="progresso-bolinha"></span>
                    <p>Dados pessoais</p>
                </div>
                <span class="progresso-linha"></span>
                <div class="progresso-item <?= $possuiClube ? 'progresso-item--ativo' : ''; ?>">
                    <span class="progresso-bolinha"></span>
                    <p>Confirmação do<br>cadastro</p>
                </div>
                <span class="progresso-linha"></span>
                <div class="progresso-item <?= $possuiClube ? 'progresso-item--ativo' : ''; ?>">
                    <span class="progresso-bolinha"></span>
                    <p>Conclusão do<br>cadastro</p>
                </div>
            </div>

            <?php if ($flash): ?>
                <div class="aviso-cadastro" role="alert">
                    <strong aria-hidden="true"><?= $flash['tipo'] === 'sucesso' ? '✓' : '!'; ?></strong>
                    <div>
                        <h3><?= $flash['tipo'] === 'sucesso' ? 'Pronto!' : 'Atenção!'; ?></h3>
                            <p><?= e($flash['mensagem']); ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="aviso-cadastro" role="alert">
                    <strong aria-hidden="true">!</strong>
                    <div>
                        <h3>Atenção!</h3>
                        <p>
                            Confirme seus dados para ativar o clube e pagar o valor Coffee Lovers em cada produto.
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <form class="form-cadastro" action="../processamento/coffee_lovers_salvar.php" method="POST">
                <p class="form-cadastro__texto">
                    Informe seu CPF e senha da conta para confirmar seu cadastro no clube Coffee Lovers.
                </p>

                <label class="campo-cadastro">
                    <span>Cpf</span>
                    <input type="text" name="cpf" placeholder="CPF" value="<?= e($cliente['cpf'] ?? ''); ?>" required>
                </label>

                <label class="campo-cadastro">
                    <span>Senha</span>
                    <input type="password" name="senha" placeholder="Senha" autocomplete="current-password" required>
                </label>

                <div class="separador-cadastro" aria-hidden="true">
                    <span></span>
                    <span></span>
                </div>

                <label class="checkbox-cadastro">
                    <input type="checkbox" name="marketing" value="1">
                    <span>Aceito receber comunicações de promoções e marketing.</span>
                </label>

                <p class="observacao-cadastro">
                    <span aria-hidden="true">ⓘ</span>
                    As informações coletadas no cadastro do cliente serão utilizadas para identificação das reservas, pedidos e execução de contrato entre o titular e a Noble Blend Café.
                </p>

                <button class="botao-continuar" type="submit">
                    <?= $possuiClube ? 'Atualizar cadastro' : 'Concluir cadastro'; ?>
                </button>

                <p class="observacao-cadastro">
                    <a href="logado_cliente.php">Voltar para o início</a>
                </p>
            </form>
        </section>
    </main>
</body>
</html>
