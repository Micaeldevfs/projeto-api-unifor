<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(403);
    echo json_encode(['erro' => 'Usuário não autenticado.']);
    exit();
}

$dados = json_decode(file_get_contents('php://input'), true);
$usuario_id_string = $_SESSION['usuario_id'];

$novoEndereco = [
    'cep' => $dados['cep'] ?? null,
    'logradouro' => $dados['logradouro'] ?? null,
    'bairro' => $dados['bairro'] ?? null,
    'cidade' => $dados['cidade'] ?? null,
    'uf' => $dados['uf'] ?? null
];

$filtro = ['_id' => new MongoDB\BSON\ObjectId($usuario_id_string)];
$atualizacao = ['$push' => ['enderecos' => $novoEndereco]];

$resultado = $colecaoUsuarios->updateOne($filtro, $atualizacao);

if ($resultado->getModifiedCount() > 0) {
    http_response_code(200);
    echo json_encode(['sucesso' => 'Endereço Salvo!']);
} else {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha ao salvar endereço.']);
}
?>