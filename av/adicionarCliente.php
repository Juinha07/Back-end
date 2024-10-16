<?php
session_start(); 
include 'conexao.php'; 

if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'adm@gmail.com') {
    header('Location: login.php'); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = $_POST['cpf'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $dataNascimento = $_POST['dataNascimento'] ?? '';
    $rua = $_POST['rua'] ?? '';
    $numero = $_POST['numero'] ?? '';
    $bairro = $_POST['bairro'] ?? '';
    $cidade = $_POST['cidade'] ?? '';

    $query = "INSERT INTO cliente (cpf, nome, email, senha, telefone, dataNascimento, rua, numero, bairro, cidade) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('ssssssssss', $cpf, $nome, $email, $senha, $telefone, $dataNascimento, $rua, $numero, $bairro, $cidade);

    if ($stmt->execute()) {
        header("Location: admin.php"); 
        exit();
    } else {
        echo "Erro ao adicionar cliente: " . htmlspecialchars($stmt->error);
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
    <title>Adicionar Cliente</title>
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
            <h2>Adicionar Cliente</h2>
            <form action="adicionarCliente.php" method="POST">
                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" id="cpf" class="inputUser" required><br>
                
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" class="inputUser" required><br>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="inputUser" required><br>

                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" class="inputUser" required><br>
                
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" id="telefone" class="inputUser" required><br>

                <label for="dataNascimento">Data de Nascimento:</label>
                <input type="date" name="dataNascimento" id="dataNascimento" class="inputUser" required><br>

                <label for="rua">Rua:</label>
                <input type="text" name="rua" id="rua" class="inputUser" required><br>

                <label for="numero">Número:</label>
                <input type="text" name="numero" id="numero" class="inputUser" required><br>

                <label for="bairro">Bairro:</label>
                <input type="text" name="bairro" id="bairro" class="inputUser" required><br>

                <label for="cidade">Cidade:</label>
                <input type="text" name="cidade" id="cidade" class="inputUser" required><br>

                <input type="submit" name="submit" id="submit" value="Adicionar Cliente">
            </form>
        </div>
    </div>
</body>
</html>
