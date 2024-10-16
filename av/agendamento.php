<?php
session_start();
include 'conexao.php';

$is_admin = isset($_SESSION['admin_id']);

$queryBrinquedos = "SELECT codBrinquedo, nome FROM brinquedos";
$resultadoBrinquedos = $conn->query($queryBrinquedos);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento</title>
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
                            <label for="codBrinquedo">Selecione o Brinquedo:</label>
                            <select name="codBrinquedo" id="codBrinquedo" class="inputUser" required>
                                <?php while ($row = $resultadoBrinquedos->fetch_assoc()): ?>
                                    <option value="<?php echo $row['codBrinquedo']; ?>">
                                        <?php echo htmlspecialchars($row['nome']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select><br>
                            
                            <label for="dataAgendamento" class="labelInput">Data do Agendamento:</label>
                            <input type="date" name="dataAgendamento" id="dataAgendamento" class="inputUser" required><br>
                            
                            <label for="horaInicio" class="labelInput">Hora de Início:</label>
                            <input type="time" name="horaInicio" id="horaInicio" class="inputUser" required><br>
                            
                            <label for="horaFinal" class="labelInput">Hora de Término:</label>
                            <input type="time" name="horaFinal" id="horaFinal" class="inputUser" required><br>

                            <?php if ($is_admin): ?>
                                <label for="codCliente" class="labelInput">Código do Cliente:</label>
                                <input type="text" name="codCliente" id="codCliente" class="inputUser" placeholder="Código do Cliente" required><br>
                            <?php endif; ?>
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

<?php
$conn->close();
?>
