<?php
require_once('conexao.php');
$conn = abrirBanco();

$codigo_barras = $_POST['codigo_barras'];

$sql = "SELECT destinatario FROM tracking_etiquetas WHERE codigo_barras = '$codigo_barras'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $destinatario = $row['destinatario'];
    echo $destinatario;
} else {
    echo "not_found";
}
?>