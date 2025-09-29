<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();
include 'conexao.php';

$email = $_POST['email'];
$senha_digitada = $_POST['senha'];

$filtro = ['email' => $email];
$usuario = $colecaoUsuarios->findOne($filtro);

if ($usuario && password_verify($senha_digitada, $usuario['senha'])) {
    $_SESSION['usuario_id'] = (string) $usuario['_id'];
    header("Location: dashboard.php");
    exit();
}

echo "Email ou senha inválidos. <a href='index.html'> Tente novamente </a>.";
?>