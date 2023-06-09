<?php
require_once('../conexao.php');
session_start();

if (!isset($_POST['codigo_barras'])) {
    header('Location: coletas.php');
    exit();
}

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

$motorista = getMotoristaById($_SESSION['id_motorista']);
$codigo_barras = $_POST['codigo_barras'];
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
    <title>ontrack. || Motoristas</title>

</head>

<body>
    <nav>
        <div class="nav-content">
            <!-- <div class="initial-nav">
				<img src="../img/logo_vb.png" alt="">
				<p id="tag">Motoristas</p>
			</div> -->
            <div class="final-nav">
                <div class="dataDiv">
                    <img src="../img/user.png" alt="">
                    <h6>
                        <?= $motorista['nome'] ?><p>
                            <?= $motorista['cpf'] ?>
                        </p>
                    </h6>
                </div>

               <a href="../logoff.php"><button id="logout-btn">Sair <i class="fas fa-sign-out-alt"></i></button></a>

            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row mt-5">
            <div class="col-12 col-lg-8">
                <h1 style="font-size: 1.5rem !important; text-align: center;" class="display-4">Confirmação de Entrega</h1>
            </div>
            
            <div id="camera">
                <div class="label">
                </div>
                <hr class="redLine">
                <div class="label2">
                </div>
            </div>
             
            <form id="input-form" action="../functions.php" method="POST">
                <label for="">Inserir Código de Barras</label>
                <input id="resultado" oninput="verifyCode()" style="width: 85%; border-radius: 5px; border: 1px solid; margin-bottom: 10px; text-align: center; font-size: 20px; font-weight: bold;" name="codigo_barras" type="text" />
                <button style="background-color:#9F73FA;width: 85%; border: none; border-radius: 5px;" type="button" onclick="mostrarEsconderDiv()">
                    <img style="width: 28px;filter: hue-rotate(45deg);" src="../img/camera.png" alt="">
                </button>
                <button id="enviar_button" style=" border: none; background: transparent; margin-top: 1rem;" type="submit">
                    <img style="width: 45px;filter: hue-rotate(85deg)" src="../img/enviar.png" alt="">
                    <label style="font-size: 22px; font-weight: bold; color: #767676;" for="">enviar</label>
                </button>
                <a href="coletas.php" rel="noopener noreferrer"> <button style="    background-color: #b5b5b5;
                        width: auto;
                        border: none;
                        border-radius: 5px;
                        font-family: sans-serif;
                        margin-top: 3rem;
                        font-weight: bold;
                        color: #fff;" type="button" onclick="mostrarEsconderDiv()">
                        Voltar
                    </button>
                </a>
                <div style="width: 100%;width: 100%; display: block; margin-top: 1.5rem;" id="minhaDiv" class="esconder">
                    <h6 style="display: flex; width: 100%; justify-content:center;">
                        <p id="codigo_status" style="text-align: center;"></p>
                    </h6>
                </div>

                <input type="hidden" name="finalizarEntrega">
            </form>

            <style>
                .esconder {
                    display: none;
                }
            </style>

            <script>
                function mostrarDiv() {
                    var input = document.getElementById('resultado');
                    var div = document.getElementById('minhaDiv');

                    if (input.value !== '') {
                        div.style.display = 'block';
                    } else {
                        div.style.display = 'none';
                    }
                }
                
                setInterval(() => {
                    var userInput = document.getElementById('resultado').value;
                    var codigoBarras = "<?php echo $codigo_barras; ?>";
                    if (userInput === codigoBarras) {
                        $("#codigo_status").text('');
                        $("#enviar_button").prop("disabled", false);
                    } else {
                        $("#codigo_status").text("Código de barras não corresponde ao volume selecionado");
                        $("#enviar_button").prop("disabled", true);
                    }
                }, 500)
            </script>
            <div id="resultado"></div>

            <script src="../js/quagga.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <footer>
      <div class="text">
        powered by
        <div class="spanText">
          <img src="../img/logotrack.png" alt="">
        </div>
        <div class="sname">
        on <p>track.</p>
        </div>
      </div>
    </footer>
</body>

</html>