<?php
session_start(); 
include 'conexao.php'; 

// Verifica se o usuário está logado como administrador
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'adm@gmail.com') {
    header('Location: login.php'); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeBrinquedo = $_POST['nomeBrinquedo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $valor = $_POST['valor'] ?? '';

    $query = "INSERT INTO brinquedos (nomeBrinquedo, descricao, valor) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('ssd', $nomeBrinquedo, $descricao, $valor);
    if ($stmt->execute()) {
        header("Location: admin.php"); 
        exit();
    } else {
        echo "Erro ao adicionar brinquedo: " . htmlspecialchars($stmt->error);
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Brinquedo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <img src="img/logotipo.png" alt="Logotipo Balão Mágico">
    </header>
    <nav>
        <ul>
            <li><a href="balaomagico.php">Início</a></li>
            <li><a href="agendamento.php">Agendar</a></li>
            <li><a href="sobre.php">Sobre</a></li>
            <li><a href="contato.php">Contato</a></li>
            <li><a href="index.php">Minha Conta</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
    </nav>
    <div class="container">
        <div class="box">
            <h2>Adicionar Brinquedo</h2>
            <form action="admin.php" method="POST">
                <label for="nomeBrinquedo">Nome do Brinquedo:</label>
                <input type="text" name="nomeBrinquedo" id="nomeBrinquedo" class="inputUser" required><br>
                
                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" class="inputUser" required></textarea><br>
                
                <label for="valor">Valor:</label>
                <input type="number" step="0.01" name="valor" id="valor" class="inputUser" required><br>
                
                <input type="submit" name="submit" id="submit" value="Adicionar Brinquedo">
            </form>
        </div>
    </div>
</body>
</html>
