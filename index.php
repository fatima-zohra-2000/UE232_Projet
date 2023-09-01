<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion</title>
    <link rel="stylesheet" href="assets/css/style_athentification.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Stick+No+Bills:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
  </head>
  <body>
    <section class="sign-in">
        <div class="container position-center">
            <div class="signin-content">
                

                <div class="signin-form">
                    <h2 class="form-title">Connexion</h2>
                    <form method="post" action="loginconfig.php" class="register-form" id="login-form">
                      <?php 
                      if(!empty($_SESSION['retour'])){
                        echo '<p class="msg-erreur">'.$_SESSION['retour'].'</p>';
                        unset($_SESSION['retour']);//pour vider le msg d'erreur
                      }
                      ?>
                      <div class="form-group">
                        <input type="text" name="username" id="your_name" placeholder="Identifiant"></br>
                      </div>

                      <div class="form-group">
                        <input type="password" name="password"id="your_pass" placeholder="Mot de passe"></br>
                      </div>

                      <div class="form-group form-button">
                        <input type="submit" name="signin" id="signin" class="form-submit" value="Se connecter"/>
                      </div>

                    </form>
                </div>

                <div class="signin-image">
                    <figure><img src="assets/images/gens-bureau.jpg" alt="sing up image"></figure>
                </div>

              </div>
          </div>
    </section>
  </body>
</html>
