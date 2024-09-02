<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'adm@gmail.com' || !isset($_SESSION['senha']) || $_SESSION['senha'] !== 'adm') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['codBrinquedo'])) {
    $codBrinquedo = $_GET['codBrinquedo'];

    $query = "SELECT * FROM brinquedos WHERE codBrinquedo = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $codBrinquedo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $brinquedo = $result->fetch_assoc();
    } else {
        echo "Brinquedo não encontrado.";
        exit();
    }
} else {
    echo "Código do brinquedo não especificado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $valor = $_POST['valor'] ?? '';

    $query = "UPDATE brinquedos SET nome = ?, descricao = ?, valor = ? WHERE codBrinquedo = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('ssdi', $nome, $descricao, $valor, $codBrinquedo);
    if ($stmt->execute()) {
        header("Location: admin.php"); 
        exit();
    } else {
        echo "Erro ao alterar brinquedo: " . htmlspecialchars($stmt->error);
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
    <title>Alterar Brinquedo</title>
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
            <li><a href="admin.php">Admin</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="box">
            <h2>Alterar Brinquedo</h2>
            <div class="alteracao">
                <form method="post" action="">
                <div class="inputBox">
                <label for="nome">Nome do Brinquedo:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($brinquedo['nome'] ?? ''); ?>" required>
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" required><?php echo htmlspecialchars($brinquedo['descricao'] ?? ''); ?></textarea>
                <label for="valor">Valor:</label>
                <input type="text" id="valor" name="valor" value="<?php echo htmlspecialchars($brinquedo['valor'] ?? ''); ?>" required>
                <input type="submit" value="Alterar Brinquedo">
            </div>
                </form>
        </div>
    </div>
</body>
</html>
