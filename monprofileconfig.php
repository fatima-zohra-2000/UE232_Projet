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

            function validate($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
            return $data;
            }
            
            if(array_key_exists('password', $_POST) && array_key_exists('password_confirm', $_POST)){ //si le bouton changer mot de passe est cliqué et les champs sont dispo
                $password= validate($_POST['password']);
                $password_confirm = validate($_POST['password_confirm']);
                
                if($password === $password_confirm){

                    if(!empty($password)&&!empty($password_confirm)){
                        $utilisateur = $cnx->query("UPDATE `utilisateurs` SET `doti`='".$password."' WHERE `code_etab`='".$_SESSION['username']."'");
                        $_SESSION['retour'] = 'Vos modification sont bien retenues';
                        header('Location: monprofile.php');
                    
                    }else { //les champs de mdp sont disponibles mais vides
                        $_SESSION['retour'] = 'Remplir votre nouveau mot de passe';
                        header('Location: monprofile.php');
                    }
                }
                else{
                    $_SESSION['retour'] = 'La confirmation de votre mot de passe a échouée. Veuillez rééssayer';
                    header('Location: monprofile.php');
                }
            }
        }

        

     ?>
</body>
</html>