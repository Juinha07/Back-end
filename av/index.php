<?php
session_start(); 
include 'conexao.php'; 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Conta</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <img src="img/logotipo.png" alt="Logotipo Balão Mágico">
    </header>
    <nav>
        <ul>
            <li><a href="balaomagico.html">Início</a></li>
            <li><a href="agendamento.html">Agendar</a></li>
            <li><a href="sobre.html">Sobre</a></li>
            <li><a href="contato.html">Contato</a></li>
            <li><a href="index.php">Minha Conta</a></li>
            <?php
                if (isset($_SESSION['codCliente'])) {
                    echo '<li><a href="logout.php">Sair</a></li>';
                }
            ?>
        </ul>
    </nav>
    <div class="container">
        <div class="box">
            <?php
            if (isset($_SESSION['codCliente'])) {
                $codCliente = $_SESSION['codCliente'];

                $query = "
                    SELECT a.codAgendamento, a.dataAgendamento, a.horaInicio, a.horaFinal, a.codBrinquedo, b.valor, 
                           c.rua, c.numero, c.bairro, c.cidade 
                    FROM agendamentos a
                    JOIN brinquedos b ON a.codBrinquedo = b.codBrinquedo
                    JOIN cliente c ON a.codCliente = c.codCliente
                    WHERE a.codCliente = ? 
                    ORDER BY a.dataAgendamento DESC LIMIT 1
                ";

                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param('i', $codCliente);
                    $stmt->execute();
                    $resultado = $stmt->get_result();

                    if ($resultado && $resultado->num_rows > 0) {
                        $agendamento = $resultado->fetch_assoc();
                        echo "<h2>Seu Agendamento</h2>";
                        echo "<p>Data do Agendamento: " . htmlspecialchars($agendamento['dataAgendamento']) . "</p>";
                        echo "<p>Hora de Início: " . htmlspecialchars($agendamento['horaInicio']) . "</p>";
                        echo "<p>Hora de Término: " . htmlspecialchars($agendamento['horaFinal']) . "</p>";
                        echo "<p>Valor do Brinquedo: R$ " . htmlspecialchars($agendamento['valor']) . "</p>";
                        echo "<p>Endereço: " . htmlspecialchars($agendamento['rua']) . ", " . htmlspecialchars($agendamento['numero']) . " - " . htmlspecialchars($agendamento['bairro']) . ", " . htmlspecialchars($agendamento['cidade']) . "</p>";

                        if (isset($agendamento['codAgendamento'])) {
                            echo "<div class='agendamento-box'>";
                            echo "<div class='agendamento-actions'>";
                            echo "<br>";
                            echo "<a href='alterarAgendamento.php?codAgendamento=" . htmlspecialchars($agendamento['codAgendamento']) . "' class='alterar-btn'>Alterar</a>";
                            echo "<br>";
                            echo "<br>";
                            echo "<a href='excluirAgendamento.php?codAgendamento=" . htmlspecialchars($agendamento['codAgendamento']) . "' class='excluir-btn' onclick='return confirm(\"Tem certeza que deseja excluir este agendamento?\")'>Excluir</a>";
                            echo "</div>";
                            echo "</div>";
                        } else {
                            echo "<p>Não foi possível encontrar o código do agendamento.</p>";
                        }
                    } else {
                        echo "<h2>Nenhum agendamento encontrado.</h2>";
                    }

                    $stmt->close();
                } else {
                    echo "Erro na preparação da consulta: " . $conn->error;
                }
            } else {
                echo '
                <form action="login.php" method="POST">
                    <fieldset>
                        <div class="inputBox">
                            <label for="email" class="labelInput">Email</label>
                            <input type="text" name="email" id="email" class="inputUser" required>
                        </div>
                        <div class="inputBox">
                            <label for="senha" class="labelInput">Senha</label>
                            <input type="password" name="senha" id="senha" class="inputUser" required>
                        </div>
                        <p class="signup">Você não tem uma conta?
                            <a href="cadastro.html">Crie já</a>
                        </p>
                        <br>
                        <input type="submit" name="submit" id="submit" value="Login">
                    </fieldset>
                </form>';
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
