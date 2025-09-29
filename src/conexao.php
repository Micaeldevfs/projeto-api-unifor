<?php
require_once __DIR__ . '/../vendor/autoload.php';
//copie o link informado no pdf para essa variavel: entre as aspas:
$uri = "mongodb+srv://micael:GmVmrVlHtSGVqnYN@cluster0.cfzpz.mongodb.net/projeto_cep?retryWrites=true&w=majority";

try {
    $cliente = new MongoDB\Client($uri);
    $colecaoUsuarios = $cliente->projeto_cep->usuarios;
} catch (Exception $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['erro' => "Falha na conexão com o MongoDB: " . $e->getMessage()]);
    exit();
}
?>