<?php
session_start();
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifique se o email e a senha correspondem ao admin
    $query = "SELECT * FROM administradores WHERE email = ? AND senha = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('ss', $email, $senha);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            $_SESSION['adminLogged_in'] = true;
            header("Location: adminDashboard.php");
            exit();
        } else {
            $error = "Email ou senha inválidos";
        }

        $stmt->close();
    } else {
        $error = "Erro na preparação da consulta: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Login Admin</h1>
    </header>
    <main>
        <form action="admLogin.php" method="POST">
            <div class="inputBox">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" required>
            </div>
            <div class="inputBox" style="position: relative;">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" required>
                <span class="show-password" onclick="togglePassword()">👁️</span>
            </div>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            <input type="submit" value="Login">
        </form>
    </main>

    <script>
        function togglePassword() {
            const senhaInput = document.getElementById('senha');
            const passwordType = senhaInput.type === 'password' ? 'text' : 'password';
            senhaInput.type = passwordType;
        }
    </script>
</body>
</html>
