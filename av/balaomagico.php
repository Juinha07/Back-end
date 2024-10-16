<?php
session_start();
include 'conexao.php';

$is_admin = isset($_SESSION['admin_id']);

$sql = "SELECT * FROM brinquedos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="./style/header.css">
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
            <?php if (!$is_admin): ?>
                <li><a href="index.php">Minha Conta</a></li>
            <?php endif; ?>
            <?php if ($is_admin): ?>
                <li><a href="admin.php">Admin</a></li>
                <li><a href="logout.php">Sair</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <main>
        <div class="quadrado-container">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="quadrado">';
                    echo '<img src="img/' . htmlspecialchars($row['imagem']) . '" alt="' . htmlspecialchars($row['nome']) . '">';
                    echo '<p><b>' . htmlspecialchars($row['nome']) . '</b></p><br>'; 
                    echo '<p2>Valor: <b>' . number_format($row['valor'], 2, ',', '.') . '</b></p2><br>';
                    
                    echo '<p2>' . nl2br(htmlspecialchars($row['descricao'])) . '</p2>';
                    echo '</div>';
                }
            } else {
                echo "<p>Nenhum brinquedo encontrado.</p>";
            }
            ?>
        </div>
    </main>
</body>
</html>
