<?php
session_start();
header('Content-Type: application/json');


include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(403);
    echo json_encode(['erro' => 'Usuário não autenticado.']);
    exit();
}

$usuario_id_string = $_SESSION['usuario_id'];

try {
    // Agora o PHP sabe o que é 'ObjectId'
    $filtro = ['_id' => new MongoDB\BSON\ObjectId($usuario_id_string)];
    $opcoes = ['projection' => ['enderecos' => 1, '_id' => 0]];

    $usuario = $colecaoUsuarios->findOne($filtro, $opcoes);

    echo json_encode($usuario['enderecos'] ?? []);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao buscar endereços: ' . $e->getMessage()]);
}
?>