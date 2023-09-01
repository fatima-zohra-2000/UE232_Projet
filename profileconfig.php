<?php 
    session_start(); 
    //on se connecte à la bbd.
    $cnx->connection = require("connexion.php");
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <?php

        if(isset($_POST['save'])){ //si le bouton 'se connecter' est cliqué


        //si les champs sont vides :
        function verify_existence() {
            if(empty($_POST['username']) || empty($_POST['nom_etab']) || empty($_POST['milieu']) || empty($_POST['type_etab']) || empty($_POST['user_type'])){
                
                $_SESSION['retour']='Veuillez renseigner tous les champs';
                header('Location: profile.php');
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
          $nom_etab= validate($_POST['nom_etab']);
          $nom_responsable= validate($_POST['nom_responsable']);
          $milieu= validate($_POST['milieu']);
          $type_etab= validate($_POST['type_etab']);
          $user_type= validate($_POST['user_type']);

          

          //Vérification si le nouveau pseudo est déjà pris
          $pseudo_exist = $cnx->query("SELECT `code_etab` FROM `utilisateurs` WHERE `code_etab`='".$username."'");
          $row_username = $pseudo_exist->fetch_assoc();

          if($pseudo_exist->num_rows > 0 && $row_username['code_etab'] != $_SESSION['username']){
              $_SESSION['retour'] = 'Cet identifiant est déjà pris. Choisissez un autre identifiant';
              header('Location: profile.php');
              exit();
          }



          if(count($_POST) && array_key_exists('nom_etab', $_POST) && array_key_exists('nom_responsable', $_POST) && array_key_exists('milieu', $_POST) && array_key_exists('type_etab', $_POST) && array_key_exists('user_type', $_POST)){
            
            if(!empty($nom_etab) && !empty($nom_responsable) && !empty($milieu) && !empty($type_etab) && !empty($user_type)){
                

              if(array_key_exists('password', $_POST) && array_key_exists('password_confirm', $_POST)){ //si le bouton changer mot de passe est cliqué et les champs sont dispo

                $password= validate($_POST['password']);
                $password_confirm = validate($_POST['password_confirm']);
    
                if(!empty($password)&&!empty($password_confirm)){
                  $utilisateur = $cnx->query("UPDATE `utilisateurs` SET `code_etab`='".$username."', `doti`='".$password."', `nom_etab`='".$nom_etab."',`nom_responsable`='".$nom_responsable."',`milieu`='".$milieu."',`type_etab`='".$type_etab."',`user_type`='".$user_type."' WHERE `code_etab`='".$_SESSION['username']."'");
                  $_SESSION['retour'] = 'Vos modification sont bien retenues';
                  header('Location: profile.php');
                  
                }else { //les champs de mdp sont disponibles mais vides
                  $_SESSION['retour'] = 'Remplir votre nouveau mot de passe';
                  header('Location: profile.php');
                }

              }else{ // le bouton changer mdp n'est pas cliqué. Les champs sont diasabled
                $utilisateur = $cnx->query("UPDATE `utilisateurs` SET `code_etab`='".$username."', `nom_etab`='".$nom_etab."',`nom_responsable`='".$nom_responsable."',`milieu`='".$milieu."',`type_etab`='".$type_etab."',`user_type`='".$user_type."' WHERE `code_etab`='".$_SESSION['username']."'");
                $_SESSION['retour'] = 'Vos modification sont bien retenues';
                $_SESSION['username']=$username;
                header('Location: profile.php');
                }
             }
          } else{
            $_SESSION['retour'] = 'Vos modifications ne sont pas retenues ! Veuillez rééssayer.';
          }
        }

        

     ?>
</body>
</html>