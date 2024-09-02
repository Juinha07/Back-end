<?php
include 'conexao.php';

$email = 'adm@gmail.com'; 
$senha = 'adm'; 

$hash = password_hash($senha, PASSWORD_BCRYPT);

$query = "UPDATE cliente SET senha = ? WHERE email = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('ss', $hash, $email);
    $stmt->execute();
    echo "Senha atualizada com sucesso.";
    $stmt->close();
} else {
    echo "Erro na preparação da consulta: " . $conn->error;
}

$conn->close();
?>
