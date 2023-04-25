<?php
require_once('conexao.php');

if (isset($_POST['login'])) {
    autenticarUsuario();
}

function autenticarUsuario()
{
    session_start();
    // Verifica se o CPF é válido
    $cpf = $_POST['cpf'];

    if (preg_match("/^[0-9]{11}$/", $cpf)) {
        $sql = "SELECT * FROM cadastro_motoristas WHERE cpf = '$cpf'";
        $result = abrirBanco()->query($sql);
        //Verifica se o CPF existe no banco
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_pass = md5($_POST['senha']);
            $database_pass = $row['senha'];
            if ($user_pass == $database_pass) {
                $_SESSION['erro_login'] = '';
                $_SESSION['id_motorista'] = $row['id'];
                header("Location: coletas.php");
                exit();
            }
        }
    }
    $_SESSION['erro_login'] = "Login inválido";
    header("Location: index.php");
    exit();
}
