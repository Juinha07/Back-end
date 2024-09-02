<?php
session_start();
include 'conexao.php';

// Verifica se o usuário está logado como administrador
if (isset($_SESSION['admin_id'])) {
    // O administrador está logado
    $is_admin = true;
} else {
    $is_admin = false;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="style/header.css">
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
    <div class="container">
        <div class="box">
            <h2>Balão Mágico</h2>
            <br>
            <p>O site do Balão Mágico é uma plataforma online dedicada ao agendamento e aluguel de brinquedos infláveis na cidade de Cascavel-PR. Com um design colorido e intuitivo, o site reflete a alegria e diversão que a empresa proporciona em festas e eventos.
            <br><br>
            A empresa também destaca seu compromisso com a segurança, detalhando as medidas de manutenção e higienização dos brinquedos, garantindo a tranquilidade dos pais e responsáveis.
            <br><br>
            Com informações de contato bem visíveis e um sistema de atendimento online, o site do Balão Mágico torna o processo de planejamento de eventos mais simples e eficiente, oferecendo uma experiência completa e segura para seus clientes em Cascavel-PR.
            </p>
        </div>
    </div>
</body>
</html>
