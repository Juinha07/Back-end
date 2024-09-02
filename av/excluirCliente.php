<?php
session_start(); 
include 'conexao.php'; 

// Verifica se o usuário está logado como administrador
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'adm@gmail.com') {
    header('Location: login.php'); 
    exit();
}

if (isset($_GET['codCliente'])) {
    $codCliente = $_GET['codCliente'];

    $query = "DELETE FROM cliente WHERE codCliente = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $codCliente);

    if ($stmt->execute()) {
        header("Location: admin.php"); 
        exit();
    } else {
        echo "Erro ao excluir cliente: " . htmlspecialchars($stmt->error);
    }
    $stmt->close();
} else {
    echo "Código do cliente não especificado.";
}

$conn->close();
?>
