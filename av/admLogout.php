<?php
session_start();
session_unset();
session_destroy();
header("Location: admlogin.php");
exit();
?>
