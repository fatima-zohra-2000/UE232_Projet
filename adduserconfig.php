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



    if(isset($_POST['save'])){ //si le bouton 'Enregistrer' est cliqué

        function validate($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $username= validate($_POST['username']);
        $password= validate($_POST['password']);
        $password_confirm = validate($_POST['password_confirm']);
        $nom_etab= validate($_POST['nom_etab']);
        $nom_responsable= validate($_POST['nom_responsable']);
        $milieu= validate($_POST['milieu']);
        $type_etab= validate($_POST['type_etab']);
        $user_type= validate($_POST['user_type']);

        $pseudo_exist = $cnx->query("SELECT `code_etab` FROM `utilisateurs` WHERE `code_etab`='".$username."'");

        if($pseudo_exist->num_rows > 0){
            $_SESSION['retour'] = 'Cet identifiant est déjà pris. Choisissez un autre identifiant';
            header('Location: adduser.php');
            exit();
        }

        if(count($_POST) && array_key_exists('nom_etab', $_POST) && array_key_exists('nom_responsable', $_POST) && array_key_exists('milieu', $_POST) && array_key_exists('type_etab', $_POST) && array_key_exists('user_type', $_POST)){
            if($password === $password_confirm){

                if(!empty($nom_etab) && !empty($nom_responsable) && !empty($milieu) && !empty($type_etab) && !empty($user_type)){
                    

                    $utilisateur = $cnx->query("INSERT INTO `utilisateurs`(`code_etab`, `doti`, `nom_etab`, `nom_responsable`, `milieu`, `type_etab`, `user_type`) 
                                                VALUES ('$username','$password','$nom_etab','$nom_responsable','$milieu','$type_etab','$user_type');");

                    $_SESSION['retour'] = 'Vous venez de créer un nouveau compte';
                    header('Location: gestionusers.php');
                }else{ 
                    $_SESSION['retour'] = 'Veuillez remplir tous les champs';
                    header('Location: adduser.php');
                }
            } else{
                $_SESSION['retour'] = 'La confirmation de votre mot de passe a échouée. Veuillez rééssayer';
                header('Location: adduser.php');
            }
        } else{
            $_SESSION['retour'] = 'Vos modification ne sont pas retenues ! Veuillez rééssayer.';
            header('Location: adduser.php');
        }
    }

    if(isset($_POST['edit'])){ //si le bouton 'Modifier' est cliqué
        
        
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

        $pseudo_exist = $cnx->query("SELECT `code_etab` FROM `utilisateurs` WHERE `code_etab`='".$username."'");
        $row_username = $pseudo_exist->fetch_assoc();

        if($pseudo_exist->num_rows > 0 && $row_username['code_etab'] != $_SESSION['user_edit']){
            $_SESSION['retour'] = 'Cet identifiant est déjà pris. Choisissez un autre identifiant';
            header('Location: gestionusers.php');
            exit();
        }

        if(count($_POST) && array_key_exists('nom_etab', $_POST) && array_key_exists('nom_responsable', $_POST) && array_key_exists('milieu', $_POST) && array_key_exists('type_etab', $_POST) && array_key_exists('user_type', $_POST)){
        
        if(!empty($nom_etab) && !empty($nom_responsable) && !empty($milieu) && !empty($type_etab) && !empty($user_type)){
            

            // $utilisateur = $cnx->query("SELECT * FROM `utilisateurs` WHERE `code_etab`='".$_SESSION['username']."'");
            $utilisateur = $cnx->query("UPDATE `utilisateurs` SET `code_etab`='".$username."', `nom_etab`='".$nom_etab."',`nom_responsable`='".$nom_responsable."',`milieu`='".$milieu."',`type_etab`='".$type_etab."',`user_type`='".$user_type."' WHERE `code_etab`='".$_SESSION['user_edit']."'");
            $_SESSION['retour'] = 'Vos modification sont bien retenues';
            header('Location: gestionusers.php');
        }
        } else{
        $_SESSION['retour'] = 'Vos modifications ne sont pas retenues ! Veuillez rééssayer.';
        }
    }?>
