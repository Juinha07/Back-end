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
  
    $numsin = $_GET["numsin"];
   


    echo "<p> O valor seno $numsin é: " . sin(float $numsin);
  

    ?>
</body>
</html>