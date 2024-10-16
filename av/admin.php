<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$queryBrinquedos = "SELECT * FROM brinquedos";
$resultadoBrinquedos = $conn->query($queryBrinquedos);

$queryClientes = "SELECT * FROM cliente";
$resultadoClientes = $conn->query($queryClientes);

$queryAgendamentos = "
    SELECT a.codAgendamento, a.dataAgendamento, a.horaInicio, a.horaFinal, b.nome AS brinquedo_nome, c.nome AS cliente_nome, 
           c.rua, c.numero, c.bairro, c.cidade
    FROM agendamentos a
    JOIN brinquedos b ON a.codBrinquedo = b.codBrinquedo
    JOIN cliente c ON a.codCliente = c.codCliente
    ORDER BY a.dataAgendamento DESC
";
$resultadoAgendamentos = $conn->query($queryAgendamentos);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
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
            <li><a href="admin.php">Admin</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="box">
            <h2>Brinquedos Cadastrados</h2><br>
            <ul>
                <?php while ($row = $resultadoBrinquedos->fetch_assoc()): ?>
                    <li>
                        <?php echo $row['nome'] . " - R$ " . $row['valor'] . " - " . $row['descricao']; ?>
                        <div class='actions'>
                            <a href='alterarBrinquedo.php?codBrinquedo=<?php echo htmlspecialchars($row['codBrinquedo']); ?>' class='alterar-btn'>Alterar</a>
                            <a href='excluirBrinquedo.php?codBrinquedo=<?php echo htmlspecialchars($row['codBrinquedo']); ?>' class='excluir-btn' onclick='return confirm("Tem certeza que deseja excluir este brinquedo?")'>Excluir</a>
                        </div>
                    </li>
                    <br>
                <?php endwhile; ?>
            </ul>
            <div class='actions'>
                <a href='adicionarBrinquedo.php' class='adicionar-btn'>Adicionar Brinquedo</a>
            </div><br>

            <h2>Clientes</h2><br>
            <ul>
                <?php while ($row = $resultadoClientes->fetch_assoc()): ?>
                    <li>
                        <?php echo $row['nome'] . " - " . $row['email'] . " - " . $row['telefone']; ?>
                        <div class='actions'>
                            <a href='alterarCliente.php?codCliente=<?php echo htmlspecialchars($row['codCliente']); ?>' class='alterar-btn'>Alterar</a>
                            <a href='excluirCliente.php?codCliente=<?php echo htmlspecialchars($row['codCliente']); ?>' class='excluir-btn' onclick='return confirm("Tem certeza que deseja excluir este cliente?")'>Excluir</a>
                        </div>
                    </li>
                    <br>
                <?php endwhile; ?>
            </ul>
            
            <div class='actions'>
                <a href='adicionarCliente.php' class='adicionar-btn'>Adicionar Cliente</a>
            </div><br>

            <h2>Agendamentos</h2><br>
            <ul>
                <?php while ($row = $resultadoAgendamentos->fetch_assoc()): ?>
                    <li>
                        Cliente: <?php echo $row['cliente_nome']; ?> - Brinquedo: <?php echo $row['brinquedo_nome']; ?><br>
                        Data: <?php echo $row['dataAgendamento']; ?> - Horário: <?php echo $row['horaInicio'] . " às " . $row['horaFinal']; ?><br>
                        Endereço: 
                        <?php 
                        echo (!empty($row['rua']) ? $row['rua'] : 'Rua não informada') . ", " . 
                             (!empty($row['numero']) ? $row['numero'] : 'Nº não informado') . " - " . 
                             (!empty($row['bairro']) ? $row['bairro'] : 'Bairro não informado') . ", " . 
                             (!empty($row['cidade']) ? $row['cidade'] : 'Cidade não informada'); 
                        ?>
                        <div class='actions'>
                            <a href='alterarAgendamentoAdm.php?codAgendamento=<?php echo htmlspecialchars($row['codAgendamento']); ?>' class='alterar-btn'>Alterar</a>
                            <a href='excluirAgendamentoAdm.php?codAgendamento=<?php echo htmlspecialchars($row['codAgendamento']); ?>' class='excluir-btn' onclick='return confirm("Tem certeza que deseja excluir este agendamento?")'>Excluir</a>
                        </div>
                    </li>
                    <br>
                <?php endwhile; ?>
            </ul>
            <div class='actions'>
                <a href='adicionarAgendamento.php' class='adicionar-btn'>Adicionar Agendamento</a>
            </div><br>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
