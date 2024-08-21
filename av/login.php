<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Preparar e executar a consulta
    $query = "SELECT codCliente FROM cliente WHERE email = ? AND senha = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('ss', $email, $senha);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            $_SESSION['codCliente'] = $resultado->fetch_assoc()['codCliente'];
            header('Location: index.php');
        } else {
            $_SESSION['login_error'] = 'Email ou senha inválido';
            header('Location: index.php');
        }

        $stmt->close();
    } else {
        echo "Erro na preparação da consulta: " . $conn->error;
    }

    $conn->close();
}
?>
