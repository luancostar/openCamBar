<?php 
session_start();

unset($_SESSION['id_motorista']);
header('Location: pages/index.php');
exit();
?>