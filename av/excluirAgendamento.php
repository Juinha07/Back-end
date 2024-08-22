<?php
session_start(); 
include 'conexao.php'; 

if (!isset($_SESSION['codCliente'])) {
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
        $query = "DELETE FROM agendamentos WHERE codAgendamento = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $codAgendamento);

        if ($stmt->execute()) {
            header("Location: index.php"); 
            exit();
        } else {
            echo "Erro ao excluir o agendamento: " . $conn->error;
        }
    } else {
        echo "Agendamento não encontrado.";
    }
} else {
    echo "Código do agendamento não especificado.";
}

if ($conn) {
    $conn->close();
}
?>
