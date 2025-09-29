<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.html");
    exit();
}
$id_do_usuario_logado = $_SESSION['usuario_id'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard de Endereços</title>
    <!-- Vamos conectar o mesmo arquivo de estilo, mas depois adicionaremos regras específicas -->
    <link rel="stylesheet" href="/public/estilo.css">
</head>
<body>

    <div class="container-dashboard">
        <div class="header-dashboard">
            <h1>Busque e Salve Endereços</h1>
            <a href="logout.php">Sair</a>
        </div>

        <!-- Seção de Busca de CEP -->
        <div class="busca-cep-container">
            <input type="text" id="cep-input" placeholder="Digite um CEP (apenas números)">
            <button id="buscar-btn">Buscar Endereço</button>
        </div>
        
        <div id="resultado-busca" class="card-resultado" style="display:none;">
            <h3>Endereço Encontrado:</h3>
            <p><strong>CEP:</strong> <span id="res-cep"></span></p>
            <p><strong>Rua:</strong> <span id="res-logradouro"></span></p>
            <p><strong>Bairro:</strong> <span id="res-bairro"></span></p>
            <p><strong>Cidade/UF:</strong> <span id="res-cidade-uf"></span></p>
            <button id="salvar-btn">Salvar este Endereço</button>
        </div>

        <hr>

        <h2>Meus Endereços Salvos</h2>

        <div id="enderecos-salvos" class="grid-cards">

            <p id="loading-message">Carregando endereços...</p>
        </div>
    </div>

    <script src="/public/script.js"></script>
</body>
</html>