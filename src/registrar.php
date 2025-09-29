<?php
require_once __DIR__ . '/../vendor/autoload.php';
include 'conexao.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha_pura = $_POST['senha'];
$senha_hash = password_hash($senha_pura, PASSWORD_DEFAULT);

$documentoUsuario = [
    'nome' => $nome,
    'email' => $email,
    'senha' => $senha_hash,
    'data_criacao' => new MongoDB\BSON\UTCDateTime(),
    'enderecos' => []
];

try {
    $resultado = $colecaoUsuarios->insertOne($documentoUsuario);
    echo "Usuário cadastrado com sucesso! Você já pode fazer o login.";
} catch (Exception $e) {
    echo "Erro ao cadastrar: " . $e->getMessage();
}
?>