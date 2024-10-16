<?php
session_start(); 
include 'conexao.php'; 

if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'adm@gmail.com') {
    header('Location: login.php'); 
    exit();
}

if (isset($_GET['codCliente'])) {
    $codCliente = $_GET['codCliente'];

    $query = "SELECT * FROM cliente WHERE codCliente = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $codCliente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cliente = $result->fetch_assoc();
    } else {
        echo "Cliente não encontrado.";
        exit();
    }
} else {
    echo "Código do cliente não especificado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $rua = $_POST['rua'] ?? '';
    $numero = $_POST['numero'] ?? '';
    $bairro = $_POST['bairro'] ?? '';
    $cidade = $_POST['cidade'] ?? '';

    $query = "UPDATE cliente SET nome = ?, email = ?, telefone = ?, rua = ?, numero = ?, bairro = ?, cidade = ? WHERE codCliente = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('sssssssi', $nome, $email, $telefone, $rua, $numero, $bairro, $cidade, $codCliente);
    if ($stmt->execute()) {
        header("Location: admin.php"); 
        exit();
    } else {
        echo "Erro ao alterar cliente: " . htmlspecialchars($stmt->error);
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
    <title>Alterar Cliente</title>
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
            <h2>Alterar Cliente</h2>
            <form action="alterarCliente.php?codCliente=<?php echo $codCliente; ?>" method="POST">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" class="inputUser" value="<?php echo htmlspecialchars($cliente['nome'] ?? ''); ?>" required><br>
                
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="inputUser" value="<?php echo htmlspecialchars($cliente['email'] ?? ''); ?>" required><br>
                
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" id="telefone" class="inputUser" value="<?php echo htmlspecialchars($cliente['telefone'] ?? ''); ?>" required><br>
                
                <label for="rua">Rua:</label>
                <input type="text" name="rua" id="rua" class="inputUser" value="<?php echo htmlspecialchars($cliente['rua'] ?? ''); ?>" required><br>
                
                <label for="numero">Número:</label>
                <input type="text" name="numero" id="numero" class="inputUser" value="<?php echo htmlspecialchars($cliente['numero'] ?? ''); ?>" required><br>
                
                <label for="bairro">Bairro:</label>
                <input type="text" name="bairro" id="bairro" class="inputUser" value="<?php echo htmlspecialchars($cliente['bairro'] ?? ''); ?>" required><br>
                
                <label for="cidade">Cidade:</label>
                <input type="text" name="cidade" id="cidade" class="inputUser" value="<?php echo htmlspecialchars($cliente['cidade'] ?? ''); ?>" required><br>
                
                <input type="submit" name="submit" id="submit" value="Alterar Cliente">
            </form>
        </div>
    </div>
</body>
</html>
