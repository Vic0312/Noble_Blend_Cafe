<?php

require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../model/Produto.php';

AuthController::requireFuncionario('../view/login_funcionario.php');

function uploadImagemProduto($campo)
{
    if (!isset($_FILES[$campo]) || $_FILES[$campo]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($_FILES[$campo]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $extensao = strtolower(pathinfo($_FILES[$campo]['name'], PATHINFO_EXTENSION));
    $permitidas = array('jpg', 'jpeg', 'png', 'gif', 'webp', 'jfif');

    if (!in_array($extensao, $permitidas, true)) {
        return null;
    }

    $pasta = __DIR__ . '/../img/produtos';
    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $nome = 'produto_' . date('YmdHis') . '_' . random_int(100, 999) . '.' . $extensao;
    $destino = $pasta . '/' . $nome;

    if (!move_uploaded_file($_FILES[$campo]['tmp_name'], $destino)) {
        return null;
    }

    return 'img/produtos/' . $nome;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/funcionario_produtos.php');
    exit;
}

$imagemUpload = uploadImagemProduto('imagem_upload');
$imagemAtual = trim($_POST['imagem_atual'] ?? '');
$imagemTexto = trim($_POST['imagem'] ?? '');

$dados = $_POST;
$dados['imagem'] = $imagemUpload ?: ($imagemTexto ?: $imagemAtual);
$dados['ativo'] = isset($_POST['ativo']) ? 1 : 0;

$resultado = Produto::salvar($dados);
flash_set($resultado['ok'] ? 'sucesso' : 'erro', $resultado['ok'] ? 'Produto salvo com sucesso.' : $resultado['mensagem']);

header('Location: ../view/funcionario_produtos.php');
exit;
