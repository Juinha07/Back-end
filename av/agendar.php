<?php
session_start();  

include 'conexao.php';

if (isset($_SESSION['codCliente'])) {
    $codCliente = $_SESSION['codCliente'];

    if (isset($_POST['codBrinquedo'], $_POST['dataAgendamento'], $_POST['horaInicio'], $_POST['horaFinal'])) {
        $codBrinquedo = $_POST['codBrinquedo'];
        $dataAgendamento = $_POST['dataAgendamento'];
        $horaInicio = $_POST['horaInicio'];
        $horaFinal = $_POST['horaFinal'];

        $sqlVerificacao = "SELECT * FROM agendamentos 
                           WHERE codBrinquedo = '$codBrinquedo' 
                           AND dataAgendamento = '$dataAgendamento' 
                           AND ('$horaInicio' < horaFinal AND '$horaFinal' > horaInicio)";

        $result = $conn->query($sqlVerificacao);

        if ($result->num_rows > 0) {
            echo "O brinquedo já está reservado para este período. Por favor, escolha outra data ou horário.";
        } else {
            $sqlInserir = "INSERT INTO agendamentos (codCliente, codBrinquedo, dataAgendamento, horaInicio, horaFinal) 
                           VALUES ('$codCliente', '$codBrinquedo', '$dataAgendamento', '$horaInicio', '$horaFinal')";

            if ($conn->query($sqlInserir) === TRUE) {
                echo "Agendamento realizado com sucesso!";
                header("Location: index.php");
                exit;
            } else {
                echo "Erro ao realizar o agendamento: " . $conn->error;
            }
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
} else {
    header("Location: index.php");
}

$conn->close();
?>
