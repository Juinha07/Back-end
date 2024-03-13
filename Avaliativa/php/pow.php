<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>arquivo php</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>



    <?php
  
    $basepow = $_GET["basepow"];
    $expoente = $_GET["expoente"];


    echo "<p> O valor $basepow elevado à potência de $expoente é: " . pow(mixed $basepow, mixed $expoente);
  

    ?>
</body>
</html>