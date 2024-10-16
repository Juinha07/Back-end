<?php
session_start(); 
include 'conexao.php'; 

if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'adm@gmail.com') {
    header('Location: login.php'); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codBrinquedo = $_POST['codBrinquedo'] ?? '';
    $nomeBrinquedo = $_POST['nomeBrinquedo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $valor = $_POST['valor'] ?? '';
    $imagem = $_FILES['imagem'] ?? null;

    if (empty($codBrinquedo) || empty($nomeBrinquedo) || empty($descricao) || empty($valor) || !$imagem) {
        echo "Todos os campos devem ser preenchidos.";
    } else {
        if ($imagem && $imagem['error'] === UPLOAD_ERR_OK) {
            $tipoArquivo = mime_content_type($imagem['tmp_name']);
            if (strpos($tipoArquivo, 'image/') === 0) {
                $diretorioImagens = 'av/img/';
                if (!is_dir($diretorioImagens)) {
                    mkdir($diretorioImagens, 0777, true);
                }

                $nomeImagem = preg_replace("/[^a-zA-Z0-9.]/", "_", basename($imagem['name']));
                $caminhoImagem = $diretorioImagens . $nomeImagem;

                if (move_uploaded_file($imagem['tmp_name'], $caminhoImagem)) {
                    $query = "INSERT INTO brinquedos (codBrinquedo, nome, descricao, valor, imagem) VALUES ('$codBrinquedo', '$nomeBrinquedo', '$descricao', '$valor', '$nomeImagem')";
                    if ($conn->query($query) === TRUE) {
                        header("Location: admin.php"); 
                        exit();
                    } else {
                        echo "Erro ao adicionar brinquedo: " . htmlspecialchars($conn->error);
                    }
                } else {
                    echo "Erro ao mover o arquivo de imagem.";
                }
            } else {
                echo "O arquivo enviado não é uma imagem válida.";
            }
        } else {
            echo "Erro no upload da imagem: " . htmlspecialchars($imagem['error']);
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Brinquedo</title>
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
            <h2>Adicionar Brinquedo</h2>
            <form action="adicionarBrinquedo.php" method="POST" enctype="multipart/form-data">
                <label for="codBrinquedo">Código do Brinquedo:</label>
                <input type="text" name="codBrinquedo" id="codBrinquedo" class="inputUser" required maxlength="2"><br>

                <label for="nomeBrinquedo">Nome do Brinquedo:</label>
                <input type="text" name="nomeBrinquedo" id="nomeBrinquedo" class="inputUser" required><br>
                
                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" class="inputUser" required></textarea><br>
                
                <label for="valor">Valor:</label>
                <input type="number" step="0.01" name="valor" id="valor" class="inputUser" required><br>
                
                <label for="imagem">Imagem:</label>
                <input type="file" name="imagem" id="imagem" accept="image/*" class="inputUser" required><br>
                
                <input type="submit" name="submit" id="submit" value="Adicionar Brinquedo">
            </form>
        </div>
    </div>
</body>
</html>
