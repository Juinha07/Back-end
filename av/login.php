<?php
session_start(); 

include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['senha']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "SELECT codCliente FROM cliente WHERE email = '$email' AND senha = '$senha'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['codCliente'] = $row['codCliente'];
            header("location: index.php"); 
            exit();
        } else {
            echo "Email ou senha inválido";
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}

if ($conn) {
    $conn->close();
}
?>
