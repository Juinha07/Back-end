<?php
if(isset($_POST['submit']))
{
include_once('conexao.php');

$email =$_POST['email'];
$senha =$_POST['senha'];

$result = mysqli_query($con,"INSERT INTO cliente(email, senha) values 
('$email','$senha')");

echo('login com sucesso: ');
}?>