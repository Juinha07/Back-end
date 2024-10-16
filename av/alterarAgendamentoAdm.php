<?php
session_start(); 
include 'conexao.php'; 

if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'adm@gmail.com') {
    header('Location: login.php'); 
    exit();
}

if (isset($_GET['codAgendamento'])) {
    $codAgendamento = $_GET['codAgendamento'];

    $query = "SELECT * FROM agendamentos WHERE codAgendamento = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $codAgendamento);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $agendamento = $result->fetch_assoc();
    } else {
        echo "Agendamento não encontrado.";
        exit();
    }
} else {
    echo "Código do agendamento não especificado.";
    exit();
}

$queryBrinquedos = "SELECT codBrinquedo, nome FROM brinquedos";
$resultadoBrinquedos = $conn->query($queryBrinquedos);

$queryClientes = "SELECT codCliente, nome FROM cliente";
$resultadoClientes = $conn->query($queryClientes);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataAgendamento = $_POST['dataAgendamento'] ?? '';
    $horaInicio = $_POST['horaInicio'] ?? '';
    $horaFinal = $_POST['horaFinal'] ?? '';
    $codBrinquedo = $_POST['codBrinquedo'] ?? '';
    $codCliente = $_POST['codCliente'] ?? '';

    $query = "UPDATE agendamentos SET dataAgendamento = ?, horaInicio = ?, horaFinal = ?, codBrinquedo = ?, codCliente = ? WHERE codAgendamento = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('sssssi', $dataAgendamento, $horaInicio, $horaFinal, $codBrinquedo, $codCliente, $codAgendamento);
    if ($stmt->execute()) {
        header("Location: admin.php"); 
        exit();
    } else {
        echo "Erro ao alterar agendamento: " . htmlspecialchars($stmt->error);
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
    <title>Alterar Agendamento</title>
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
            <h2>Alterar Agendamento</h2>
            <form action="" method="POST">
                <label for="dataAgendamento">Data do Agendamento:</label>
                <input type="date" name="dataAgendamento" id="dataAgendamento" class="inputUser" value="<?php echo htmlspecialchars($agendamento['dataAgendamento'] ?? ''); ?>" required><br>

                <label for="horaInicio">Hora de Início:</label>
                <input type="time" name="horaInicio" id="horaInicio" class="inputUser" value="<?php echo htmlspecialchars($agendamento['horaInicio'] ?? ''); ?>" required><br>

                <label for="horaFinal">Hora de Término:</label>
                <input type="time" name="horaFinal" id="horaFinal" class="inputUser" value="<?php echo htmlspecialchars($agendamento['horaFinal'] ?? ''); ?>" required><br>

                <label for="codBrinquedo">Selecione o Brinquedo:</label>
                <select name="codBrinquedo" id="codBrinquedo" class="inputUser" required>
                    <?php while ($row = $resultadoBrinquedos->fetch_assoc()): ?>
                        <option value="<?php echo $row['codBrinquedo']; ?>" <?php echo ($row['codBrinquedo'] == $agendamento['codBrinquedo']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($row['nome']); ?>
                        </option>
                    <?php endwhile; ?>
                </select><br>

                <label for="codCliente">Selecione o Cliente:</label>
                <select name="codCliente" id="codCliente" class="inputUser" required>
                    <?php while ($row = $resultadoClientes->fetch_assoc()): ?>
                        <option value="<?php echo $row['codCliente']; ?>" <?php echo ($row['codCliente'] == $agendamento['codCliente']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($row['nome']) . ' (Código: ' . $row['codCliente'] . ')'; ?>
                        </option>
                    <?php endwhile; ?>
                </select><br>

                <input type="submit" name="submit" id="submit" value="Alterar Agendamento">
            </form>
        </div>
    </div>
</body>
</html>
