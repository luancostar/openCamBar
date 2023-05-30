<?php
require_once('../conexao.php');
session_start();

if (!isset($_SESSION['id_motorista'])) {
    header('Location: index.php');
    exit();
}

function getMotoristaById($id)
{
    $sql = "SELECT * FROM cadastro_motoristas WHERE id='$id'";
    $result = abrirBanco()->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $motorista = $row;
        return $motorista;
    }
    return [];
}

$motorista = getMotoristaById($_SESSION['id_motorista'])
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/7a8d54eabc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/coletas.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>VB - Motoristas</title>
</head>

<body>
    <nav>
        <div class="nav-content">
            <div class="initial-nav">
                <img src="../img/logo_vb.png" alt="">
                <p id="tag">Motoristas</p>
            </div>
            <div class="final-nav">
                <h6><?= $motorista['nome'] ?> <p>
                        <?= $motorista['cpf'] ?>
                    </p>
                </h6>

                <img src="../img/user.png" alt="">
                <a href=""> <i class="fas fa-sign-out-alt">Sair</i> </a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row mt-5">
            <div class="col-12 col-lg-8">
                <h1 style="font-size: 1.5rem !important; text-align: center;" class="display-4">Confirmação de Entrega
                </h1>
            </div>
          
            <div id="camera">
            <div class="label">
                
                </div>
            </div>
           
            <form id="input-form" action="">
                <label for="">Inserir Código de Barras</label>
                <input id="resultado" value="" style="    width: 85%;
           border-radius: 5px;
           border: 1px solid;
           margin-bottom: 10px;
           text-align: center;
           font-size: 20px;
           font-weight: bold;" type="text" />
                <button style="background-color: #0070ff;
            width: 85%;
            border: none;
            border-radius: 5px;" type="button" onclick="mostrarEsconderDiv()"><img style="width: 28px;" src="../img/camera.png" alt=""></button>


            </form>

            <div id="resultado"></div>
            <script src="../js/quagga.min.js"></script>

            <script>
                Quagga.init({
                    inputStream: {
                        name: "Live",
                        type: "LiveStream",
                        target: document.querySelector('#camera') // Or '#yourElement' (optional)
                    },
                    decoder: {
                        readers: ["codabar_reader"]
                    }
                }, function(err) {
                    if (err) {
                        console.log(err);
                        return
                    }
                    console.log("Initialization finished. Ready to start");
                    Quagga.start();
                });

                Quagga.onDetected(function(data) {

                    console.log(trimmedCode);

                    var code = data.codeResult.code;
                    var trimmedCode = code.substring(1, code.length - 1);
                    document.getElementById('resultado').value = trimmedCode;
                    // document.getElementById('resultado').value = data.codeResult.code;

                });
            </script>
            <script>
                function mostrarEsconderDiv() {
                    var minhaDiv = document.getElementById("camera");
                    if (minhaDiv.style.display === "none") {
                        minhaDiv.style.display = "block";
                    } else {
                        minhaDiv.style.display = "none";
                    }
                }
            </script>
            <style>
                #camera {
                    display: none;
                }
            </style>
</body>

</html>