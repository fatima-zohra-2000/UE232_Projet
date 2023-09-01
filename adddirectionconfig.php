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

        $direction= validate($_POST['direction']);

        //Vérification si la direction existe
        $direction_exist = $cnx->query("SELECT `direction` FROM `directions` WHERE `direction`='".$direction."'");
        if($direction_exist->num_rows > 0){
            $_SESSION['retour'] = 'Cette direction existe déjà';
            header('Location: adduser.php');
            exit();
        }

        if(count($_POST) && array_key_exists('direction', $_POST) ){

            if(!empty($direction)){
                

                $directionquery = $cnx->query("INSERT INTO `directions`(`id_direction`, `direction`) 
                                            VALUES (NULL,'$direction');") or die($cnx->error);

                $_SESSION['retour'] = 'Vous venez de créer une nouvelle direction';
                header('Location: gestiondirections.php');
            }else{ 
                $_SESSION['retour'] = 'Veuillez remplir tous les champs';
                header('Location: adddirection.php');
            }
        } else{
            $_SESSION['retour'] = 'Impossible d\'effectuer l\'ajout. Veuillez rééssayer.';
            header('Location: adddirection.php');
        }
    }


    if(isset($_POST['edit'])){ //si le bouton 'Modifier' est cliqué
        
        
        function validate($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $direction= validate($_POST['direction']);


        $direction_exist = $cnx->query("SELECT `direction` FROM `directions` WHERE `direction`='".$direction."'");
        $row_direction = $direction_exist->fetch_assoc();

        if($direction_exist->num_rows > 0 && $row_direction['direction'] != $_SESSION['direction_edit']){
            $_SESSION['retour'] = 'Cette direction existe déjà';
            header('Location: gestiondirections.php');
            exit();
        }

        if(count($_POST) && array_key_exists('direction', $_POST) ){

            if(!empty($direction)){
                $directionquery = $cnx->query("UPDATE `directions` SET `direction`='".$direction."' WHERE `id_direction`='".$_SESSION['direction_edit']."'");
                $_SESSION['retour'] = 'Vos modification sont bien retenues';
                header('Location: gestiondirections.php');
            }
            else{ 
                $_SESSION['retour'] = 'Veuillez remplir tous les champs';
                header('Location: gestiondirections.php');
            }
        } 
        else{
            $_SESSION['retour'] = 'Impossible d\'effectuer la modification. Veuillez rééssayer.';
            header('Location: gestiondirections.php');
        }
    }
    ?>
