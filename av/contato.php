<?php
session_start();
include 'conexao.php';
$is_admin = isset($_SESSION['admin_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="style/header.css">
</head>
<body>
    <header>
        <img src="img/logotipo.png">
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
    <div class="container">
        <div class="box">
        <h2>Quer entrar em contato com a gente?</h2>
        <br></br><p>Nosso telefone é: <b>(45) 998415-2373</b>
        <br></br>Nosso email é: <b>ajuliarodriguess.07@gmail.com</b>
        <br></br>Nosso instagram é: <b>@julia_x7z</b>
        </p>
        </div>
    </div>
</body>
</html>