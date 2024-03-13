<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>arquivo php</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>



    <?php
  
    $valuemax = $_GET["valuemax"];
    $maluesmax = $_GET["valuesmax"];
    $value_arraymax = $_GET["value_arraymax"];


    echo "<p> o valor mínimo $value_arraymax é: " . max($valuemax, $valuesmax, $value_arraymax);
  

    ?>
</body>
</html>