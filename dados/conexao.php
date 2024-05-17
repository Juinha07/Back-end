<?php
$dbhost ='localhost';
$user='aluno';
$senha='ceep';
$db='dados';

$con = new mysqli($dbhost, $user, $senha, $db);
if($con->connect_errno)
{
echo "erro" ;
}
else
{
echo"conexao OKAY";
}
?>
