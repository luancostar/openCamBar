<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>VB - Motoristas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">

</head>

<body>
  <!-- partial:index.partial.html -->
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;display=swap" rel="stylesheet">
  </head>

  <body>
    <section>
      <div class="imgBx">
        <img src="img/wallpaper.png">
      </div>
      <div class="contentBx">
        <div class="formBx">
          <div class="headbox">
            <img src="img/logo_vb.png" alt="">
            <p>Motoristas</p>
          </div>
          <h2>Login</h2>
          <form method="POST" action="functions.php">
            <div class="inputBx">
              <span>CPF do Motorista</span>
              <input type="number" name="cpf">
            </div>
            <div class="inputBx">
              <span>Senha</span>
              <input type="password" name="senha">
            </div>
            <div class="remember">
              <label><input type="checkbox">Lembrar de mim</label>
            </div>
            <div class="inputBx">
              <input type="hidden" name="login" value="login">
              <input type="submit" value="Logar">
              <?php if (isset($_SESSION['erro_login'])) {
                echo '<p style="color: red">' . $_SESSION['erro_login'] . '</p>';
              }
              ?>

            </div>
            <div class="inputBx">
              <p> Não consegue logar ? <a href="">Clique aqui</a></p>
            </div>
          </form>
          <footer>
      <div class="text">
        powered by
        <div class="spanText">
          <img src="img/logotrack.png" alt="">
        </div>
        <div class="sname">
        on <p>track.</p>
        </div>
      </div>
    </footer>
        </div>
        
      </div>
    
    </section>
    
  </body>

  </html>
  <!-- partial -->

</body>

</html>