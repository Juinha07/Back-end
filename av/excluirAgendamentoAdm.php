<?php
session_start(); 
include 'conexao.php'; 

// Verifica se o usuário está logado como administrador
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'adm@gmail.com') {
    header('Location: login.php'); 
    exit();
}

if (isset($_GET['codAgendamento'])) {
    $codAgendamento = $_GET['codAgendamento'];

    $query = "DELETE FROM agendamentos WHERE codAgendamento = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $codAgendamento);

    if ($stmt->execute()) {
        header("Location: admin.php"); 
        exit();
    } else {
        echo "Erro ao excluir agendamento: " . htmlspecialchars($stmt->error);
    }
    $stmt->close();
} else {
    echo "Código do agendamento não especificado.";
}

$conn->close();
?>
