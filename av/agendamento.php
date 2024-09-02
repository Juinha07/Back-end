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
    <title>Agendamento</title>
    <link rel="stylesheet" href="balaomagico.html">
    <link rel="stylesheet" href="styles.css">

   
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
    <main>
        <div class="container">
            <div class="box">
        <h2>Agendar Brinquedo</h2><br>
        <div class="agendamento">
            <form action="agendar.php" method="post">
                <div class="inputBox">
                    <label for="codBrinquedo" class="labelInput">Código do Brinquedo:</label>
                    <input type="text" name="codBrinquedo" id="codBrinquedo" class="inputUser" placeholder="Código do Brinquedo" required><br>
                    
                    <br>
                    <label for="dataAgendamento" class="labelInput">Data do Agendamento:</label>
                    <input type="date" name="dataAgendamento" id="dataAgendamento" class="inputUser" placeholder="Data" required><br>
                    
                    <br>
                    <label for="horaInicio" class="labelInput">Hora de Início:</label>
                    <input type="time" name="horaInicio" id="horaInicio" class="inputUser" placeholder="Hora de Início" required><br>
                    
                    <br>
                    <label for="horaFinal" class="labelInput">Hora de Término:</label>
                    <input type="time" name="horaFinal" id="horaFinal" class="inputUser" placeholder="Hora de Término" required><br>
                </div>
                <input type="submit" name="submit" id="submit" value="Agendar">
            </form>
        </div>
            </div>
        </div>
        <section id="calendario">
        </section>
    </main>
</body>
</html>