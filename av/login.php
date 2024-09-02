<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se é um administrador
    $queryAdmin = "SELECT id FROM administradores WHERE email = ? AND senha = ?";
    if ($stmt = $conn->prepare($queryAdmin)) {
        $stmt->bind_param('ss', $email, $senha);
        $stmt->execute();
        $resultadoAdmin = $stmt->get_result();

        if ($resultadoAdmin && $resultadoAdmin->num_rows > 0) {
            $_SESSION['admin_id'] = $resultadoAdmin->fetch_assoc()['id'];
            $_SESSION['email'] = $email; // Armazena o e-mail na sessão
            $_SESSION['senha'] = $senha; // Armazena a senha na sessão
            header('Location: admin.php');
            exit;
        }

        $stmt->close();
    }

    // Verificar se é um cliente
    $queryCliente = "SELECT codCliente FROM cliente WHERE email = ? AND senha = ?";
    if ($stmt = $conn->prepare($queryCliente)) {
        $stmt->bind_param('ss', $email, $senha);
        $stmt->execute();
        $resultadoCliente = $stmt->get_result();

        if ($resultadoCliente && $resultadoCliente->num_rows > 0) {
            $_SESSION['codCliente'] = $resultadoCliente->fetch_assoc()['codCliente'];
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['login_error'] = 'Email ou senha inválido';
            header('Location: index.php');
            exit;
        }

        $stmt->close();
    } else {
        echo "Erro na preparação da consulta: " . $conn->error;
    }

    $conn->close();
}
?>
