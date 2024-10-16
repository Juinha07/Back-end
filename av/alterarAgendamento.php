<?php
session_start(); 
include 'conexao.php'; 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['codCliente'])) {
    header('Location: login.php'); 
    exit();
}

if (isset($_GET['codAgendamento'])) {
    $codAgendamento = $_GET['codAgendamento'];

    $query = "SELECT a.*, c.rua, c.numero, c.bairro, c.cidade 
              FROM agendamentos a 
              JOIN cliente c ON a.codCliente = c.codCliente 
              WHERE a.codAgendamento = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('i', $codAgendamento);
    if (!$stmt->execute()) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }
    
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaData = $_POST['dataAgendamento'] ?? '';
    $horaInicio = $_POST['horaInicio'] ?? '';
    $horaFinal = $_POST['horaFinal'] ?? '';
    $codBrinquedo = $_POST['codBrinquedo'] ?? '';
    $enderecoNovo = $_POST['enderecoNovo'] ?? '';

    if ($enderecoNovo === 'manter') {
        $rua = $agendamento['rua'] ?? '';
        $numero = $agendamento['numero'] ?? '';
        $bairro = $agendamento['bairro'] ?? '';
        $cidade = $agendamento['cidade'] ?? '';
    } else {
        $rua = $_POST['rua'] ?? '';
        $numero = $_POST['numero'] ?? '';
        $bairro = $_POST['bairro'] ?? '';
        $cidade = $_POST['cidade'] ?? '';
    }

    $query = "UPDATE agendamentos 
              SET dataAgendamento = ?, horaInicio = ?, horaFinal = ?, codBrinquedo = ? 
              WHERE codAgendamento = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('ssssi', $novaData, $horaInicio, $horaFinal, $codBrinquedo, $codAgendamento);
    if ($stmt->execute()) {
        if ($enderecoNovo === 'trocar') {
            $queryEndereco = "UPDATE cliente SET rua = ?, numero = ?, bairro = ?, cidade = ? WHERE codCliente = (SELECT codCliente FROM agendamentos WHERE codAgendamento = ?)";
            $stmtEndereco = $conn->prepare($queryEndereco);
            if ($stmtEndereco === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }
            $stmtEndereco->bind_param('ssssi', $rua, $numero, $bairro, $cidade, $codAgendamento);
            $stmtEndereco->execute();
            $stmtEndereco->close();
        }
        header("Location: index.php"); 
        exit();
    } else {
        echo "Erro ao alterar o agendamento: " . htmlspecialchars($stmt->error);
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
                <div class="inputBox">
                    <label for="codBrinquedo">Selecione o Brinquedo:</label>
                    <select name="codBrinquedo" id="codBrinquedo" class="inputUser" required>
                        <?php while ($row = $resultadoBrinquedos->fetch_assoc()): ?>
                            <option value="<?php echo $row['codBrinquedo']; ?>" <?php if ($row['codBrinquedo'] == $agendamento['codBrinquedo']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($row['nome']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select><br>

                    <label for="dataAgendamento">Data do Agendamento:</label>
                    <input type="date" name="dataAgendamento" id="dataAgendamento" class="inputUser" value="<?php echo htmlspecialchars($agendamento['dataAgendamento'] ?? ''); ?>" required><br>
                    
                    <label for="horaInicio">Hora de Início:</label>
                    <input type="time" name="horaInicio" id="horaInicio" class="inputUser" value="<?php echo htmlspecialchars($agendamento['horaInicio'] ?? ''); ?>" required><br>
                    
                    <label for="horaFinal">Hora de Término:</label>
                    <input type="time" name="horaFinal" id="horaFinal" class="inputUser" value="<?php echo htmlspecialchars($agendamento['horaFinal'] ?? ''); ?>" required><br>
                    
                    <label for="enderecoNovo">Manter o endereço atual?</label>
                    <input type="radio" name="enderecoNovo" value="manter" id="enderecoManter" checked>
                    <label for="enderecoManter">Manter</label>
                    <input type="radio" name="enderecoNovo" value="trocar" id="enderecoTrocar">
                    <label for="enderecoTrocar">Trocar</label><br>

                    <div id="enderecoFields" style="display: none;">
                        <label for="rua">Rua:</label>
                        <input type="text" name="rua" id="rua" class="inputUser" value="<?php echo htmlspecialchars($agendamento['rua'] ?? ''); ?>"><br>

                        <label for="numero">Número:</label>
                        <input type="text" name="numero" id="numero" class="inputUser" value="<?php echo htmlspecialchars($agendamento['numero'] ?? ''); ?>"><br>

                        <label for="bairro">Bairro:</label>
                        <input type="text" name="bairro" id="bairro" class="inputUser" value="<?php echo htmlspecialchars($agendamento['bairro'] ?? ''); ?>"><br>

                        <label for="cidade">Cidade:</label>
                        <input type="text" name="cidade" id="cidade" class="inputUser" value="<?php echo htmlspecialchars($agendamento['cidade'] ?? ''); ?>"><br>
                    </div>
                </div>
                <input type="submit" name="submit" id="submit" value="Alterar Agendamento">
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('input[name="enderecoNovo"]').forEach(function(elem) {
            elem.addEventListener('change', function() {
                var display = this.value === 'trocar' ? 'block' : 'none';
                document.getElementById('enderecoFields').style.display = display;
            });
        });
    </script>
</body>
</html>
