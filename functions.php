<?php
require_once('conexao.php');
session_start();

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
                header("Location: pages/coletas.php");
                exit();
            }
        }
    }
    $_SESSION['erro_login'] = "Login inválido";
    header("Location: pages/index.php");
    exit();
}

if (isset($_POST['finalizarEntrega'])) {
    finalizarEntrega();
}

function finalizarEntrega()
{
    $banco = abrirBanco();
    $codigo_barras = $_POST['codigo_barras'];
    $id_motorista = $_SESSION['id_motorista'];

    // BUSCA A PLACA DO ÚLTIMO REGISTRO DE SAÍDA PARA ENTREGA DO MOTORISTA
    $sql = "SELECT id_placa FROM tracking WHERE id_motorista='$id_motorista' ORDER BY id DESC LIMIT 1";
    $result = $banco->query($sql);
    $row = $result->fetch_assoc();
    $id_placa = $row['id_placa'];

    // INSERE UM NOVO REGISTRO DE TRACKING E RECUPERA O ID
    $sql = "INSERT INTO tracking(id_placa, status, conferente, data_inicio, hora_inicio, data_fim, hora_fim, id_motorista) VALUES ('$id_placa', 5, '0', NOW(), NOW(), NOW(), NOW(), '$id_motorista')";
    $banco->query($sql);
    $id_tracking = $banco->insert_id;

    // SALVA ID_TRACKING EM ID_ENTREGA DO VOLUME
    $sql = "UPDATE tracking_mercadorias SET id_entrega='$id_tracking' WHERE codigo_barras='$codigo_barras'";
    $banco->query($sql);

    // BUSCA OS DADOS DO VOLUME
    $sql = "SELECT * FROM tracking_mercadorias WHERE codigo_barras = $codigo_barras";
    $result = $banco->query($sql);
    $row = $result->fetch_assoc();

    //Insere uma movimentação na tabela tracking_movimentacoes
    $movimentacao = "Entregue";
    $id_mercadoria = $row['id'];
    $sql = "INSERT INTO tracking_movimentacoes(id_tracking, id_mercadoria, status, movimentacao, data)VALUES('$id_tracking','$id_mercadoria','5', '$movimentacao', NOW())";
    $banco->query($sql);

    header("Location: pages/coletas.php");
    exit();
}
