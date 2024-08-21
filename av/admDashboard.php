<?php
session_start();
include 'conexao.php';

// Verificar se o admin está logado
if (!isset($_SESSION['admLogged_in']) || !$_SESSION['admLogged_in']) {
    header("Location: admLogin.php");
    exit();
}

// Handle edit requests
if (isset($_POST['edit'])) {
    $codBrinquedo = $_POST['codBrinquedo'];
    $valor = $_POST['valor'];
    $descricao = $_POST['descricao'];

    $updateQuery = "UPDATE brinquedos SET valor = ?, descricao = ? WHERE codBrinquedo = ?";
    if ($stmt = $conn->prepare($updateQuery)) {
        $stmt->bind_param('ssi', $valor, $descricao, $codBrinquedo);
        $stmt->execute();
        $message = "Brinquedo atualizado com sucesso!";
        $stmt->close();
    } else {
        $message = "Erro na atualização do brinquedo: " . $conn->error;
    }
}

// Fetch all brinquedos
$query = "SELECT * FROM brinquedos";
if ($result = $conn->query($query)) {
    $brinquedos = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $error = "Erro ao buscar brinquedos: " . $conn->error;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Dashboard Admin</h1>
        <a href="admLogout.php">Sair</a>
    </header>
    <main>
        <?php if (isset($message)) { echo "<p class='success'>$message</p>"; } ?>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

        <h2>Editar Brinquedos</h2>
        <?php foreach ($brinquedos as $brinquedo) { ?>
            <form action="admDashboard.php" method="POST">
                <input type="hidden" name="codBrinquedo" value="<?php echo htmlspecialchars($brinquedo['codBrinquedo']); ?>">
                <div class="inputBox">
                    <label for="valor">Valor</label>
                    <input type="text" name="valor" value="<?php echo htmlspecialchars($brinquedo['valor']); ?>" required>
                </div>
                <div class="inputBox">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" required><?php echo htmlspecialchars($brinquedo['descricao']); ?></textarea>
                </div>
                <input type="submit" name="edit" value="Atualizar">
            </form>
        <?php } ?>
    </main>
</body>
</html>
