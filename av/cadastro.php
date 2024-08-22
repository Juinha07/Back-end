<?php
if (isset($_POST['submit'])) {
    include_once('conexao.php');

    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $dataNascimento = $_POST['dataNascimento'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];

    $stmt = $conn->prepare("INSERT INTO cliente (cpf, nome, email, senha, telefone, dataNascimento, rua, numero, bairro, cidade) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param('ssssssssss', $cpf, $nome, $email, $senha, $telefone, $dataNascimento, $rua, $numero, $bairro, $cidade);

    if ($stmt->execute()) {
        header("location: index.php");
    } else {
        echo 'Erro: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
