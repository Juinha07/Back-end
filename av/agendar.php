<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['codCliente'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codBrinquedo = $_POST['codBrinquedo'];
    $dataAgendamento = $_POST['dataAgendamento'];
    $horaInicio = $_POST['horaInicio'];
    $horaFinal = $_POST['horaFinal'];
    $codCliente = $_SESSION['codCliente'];

    $queryVerificarConflito = "
        SELECT * FROM agendamentos 
        WHERE codBrinquedo = ? 
        AND dataAgendamento = ?
        AND ((horaInicio <= ? AND horaFinal > ?) OR (horaInicio < ? AND horaFinal >= ?))";

    $stmtVerificar = $conn->prepare($queryVerificarConflito);
    if ($stmtVerificar === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmtVerificar->bind_param('isssss', $codBrinquedo, $dataAgendamento, $horaFinal, $horaInicio, $horaInicio, $horaFinal);
    $stmtVerificar->execute();
    $resultVerificar = $stmtVerificar->get_result();

    if ($resultVerificar->num_rows > 0) {
        echo "Já existe um agendamento para este brinquedo no horário selecionado. Por favor, escolha outro horário.";
        exit();
    }

    $stmtVerificar->close();

    $query = "INSERT INTO agendamentos (codBrinquedo, dataAgendamento, horaInicio, horaFinal, codCliente) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('ssssi', $codBrinquedo, $dataAgendamento, $horaInicio, $horaFinal, $codCliente);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao agendar: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
}

$conn->close();
?>
