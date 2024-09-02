<?php
session_start(); 
include 'conexao.php'; 

// Verifica se o usuário está logado como administrador
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'adm@gmail.com') {
    header('Location: login.php'); 
    exit();
}

if (isset($_GET['codBrinquedo'])) {
    $codBrinquedo = $_GET['codBrinquedo'];

    $query = "DELETE FROM brinquedos WHERE codBrinquedo = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $codBrinquedo);

    if ($stmt->execute()) {
        header("Location: admin.php"); 
        exit();
    } else {
        echo "Erro ao excluir brinquedo: " . htmlspecialchars($stmt->error);
    }
    $stmt->close();
} else {
    echo "Código do brinquedo não especificado.";
}

$conn->close();
?>
