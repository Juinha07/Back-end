<?php
include 'conexao.php';

$senhaHash = password_hash('admin123', PASSWORD_DEFAULT);

$query = "INSERT INTO administradores (email, senha) VALUES ('admin@admin.com', ?)";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('s', $senhaHash);
    $stmt->execute();
    echo "Administrador inserido com sucesso!";
    $stmt->close();
} else {
    echo "Erro na inserção do administrador: " . $conn->error;
}
$conn->close();
?>
