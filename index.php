<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/loginScript.js" defer></script>
  <title>ontrack. || Motoristas</title>
</head>

<body>
  <main>
    <section class="login">
      <div class="wrapper">
        <img src="img/ontrack-nobg.gif" class="login__logo">
        <div class="content-name-small">
          <div class="nametag-small"><p class="firstTag-small">on</p><p>track.</p><p class="text-position">
          motoristas</p></div>
        </div>
        <form action="functions.php" method="post" class="sign-in-form">
        <h1 class="login__title">Fazer login</h1>
        <label class="login__label">
          <span>cpf do motorista</span>
          <input required="" name="cpf" type="number" class="input">
        </label>
  
        <label class="login__label">
          <span>senha</span>
          <input required="" name="senha" type="password" class="input">
        </label>

         <input type="hidden" name="login" value="login">
         <button name="btn-entrar" type="submit" value="Logar" class="loginBtn">Logar</button>

         <?php
        if (!empty($erros)) :
          foreach ($erros as $erro) :
            echo $erro;
          endforeach;
        endif;
        ?>

      <div class="sup-btn">
        <a href="#" class="login__link">Esqueci minha senha</a><br>
        <a href="#" class="login__link">Contatar Suporte</a>
      </div>
      </form>
      </div>

    </section>

    <section class="wallpaper">
      <img src="img/ontrack.gif" alt="">
      <div class="content-name">
      <div class="nametag"><p class="firstTag">on</p><p>track.</p></div>
      </div>
    </section>
  </main>
  
</body>
</html>