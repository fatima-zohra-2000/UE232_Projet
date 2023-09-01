<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>

  <?php

$cnx->connection = require("connexion.php");

if(isset($_POST['signin'])){ //si le bouton 'se connecter' est cliqué


  //si les champs sont vides :
  function verify_existence() {
    if(empty($_POST['username'])&& empty($_POST['password'])){
      $_SESSION['retour']='Veuillez renseigner votre identifiant et mot de passe';
      header('Location: index.php');
      exit();
    }
    else if (empty($_POST['username'])){
      $_SESSION['retour'] = 'Veuillez renseigner votre identifiant';
      header('Location: index.php');
      exit();
    }
    else if(empty($_POST['password'])){
        $_SESSION['retour'] = 'Veuillez renseigner votre mot de passe';
        header('Location: index.php');
        exit();
    }//eof vérification des champs vides
  }

  function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
  return $data;
}

  $username= validate($_POST['username']);
  $password= validate($_POST['password']);

  if(count($_POST) && array_key_exists('username', $_POST) && array_key_exists('password', $_POST)){
      if(!empty($username)&& !empty($password)){

        $res="SELECT * FROM `utilisateurs` WHERE `code_etab`='".$username."' and `doti`='".$password."'";
        $requete=mysqli_query($cnx, $res);
        $data= mysqli_fetch_assoc($requete);

        $type_etab= validate($data['type_etab']);
        $_SESSION['type_etab']= $type_etab;

        if ((mysqli_num_rows($requete) > 0) && $data['user_type']== 'admin')
          { $_SESSION['username']=$username;
            $_SESSION['password']=$password;
            header('Location: home_admin.php');
          }
        else if ((mysqli_num_rows($requete) > 0) && $data['user_type']== 'utilisateur')
          { $_SESSION['username']=$username;
            $_SESSION['password']=$password;
            header('Location: courrier.php');
          }
        else
            {
            $_SESSION['retour'] = 'Impossible de trouver ce compte. Vérifiez votre identifiant et mot de passe';
            header('Location: index.php');
            }
      }
      else {
        verify_existence();
      }
  } else{ $_SESSION['retour'] = 'Identifiant ou mot de passe n\'existe pas'; }
}
?>
  </body>
  </html>
