<?php
session_start(); 
include 'conexao.php'; 

// Verifica se o usuário está logado como administrador
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'adm@gmail.com') {
    header('Location: login.php'); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataAgendamento = $_POST['dataAgendamento'] ?? '';
    $horaInicio = $_POST['horaInicio'] ?? '';
    $horaFinal = $_POST['horaFinal'] ?? '';
    $codBrinquedo = $_POST['codBrinquedo'] ?? '';
    $codCliente = $_POST['codCliente'] ?? '';

    $query = "INSERT INTO agendamentos (dataAgendamento, horaInicio, horaFinal, codBrinquedo, codCliente) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('ssssi', $dataAgendamento, $horaInicio, $horaFinal, $codBrinquedo, $codCliente);
    if ($stmt->execute()) {
        header("Location: admin.php"); 
        exit();
    } else {
        echo "Erro ao adicionar agendamento: " . htmlspecialchars($stmt->error);
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
    <title>Adicionar Agendamento</title>
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
            <h2>Adicionar Agendamento</h2>
            <form action="admin.php" method="POST">
                <label for="dataAgendamento">Data do Agendamento:</label>
                <input type="date" name="dataAgendamento" id="dataAgendamento" class="inputUser" required><br>
                
                <label for="horaInicio">Hora de Início:</label>
                <input type="time" name="horaInicio" id="horaInicio" class="inputUser" required><br>
                
                <label for="horaFinal">Hora de Término:</label>
                <input type="time" name="horaFinal" id="horaFinal" class="inputUser" required><br>
                
                <label for="codBrinquedo">Código do Brinquedo:</label>
                <input type="text" name="codBrinquedo" id="codBrinquedo" class="inputUser" required><br>
                
                <label for="codCliente">Código do Cliente:</label>
                <input type="text" name="codCliente" id="codCliente" class="inputUser" required><br>
                
                <input type="submit" name="submit" id="submit" value="Adicionar Agendamento">
            </form>
        </div>
    </div>
</body>
</html>
