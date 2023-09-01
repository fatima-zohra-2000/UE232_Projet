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

    $objet= validate($_POST['objet']);
    $objet= addslashes($objet);
    $corp= validate($_POST['corp']);
    $type_etab= validate($_POST['type_etab']);


    date_default_timezone_set('Europe/Madrid');
    $current_date = date('Y-m-d');

    $utilisateur = $cnx->query("SELECT * FROM `utilisateurs` WHERE `code_etab` = '".$_SESSION['username']."'");
    $row_user = $utilisateur->fetch_assoc();

    $insertcourrier = $cnx->query("INSERT INTO `courriers` (`id_courrier`, `nom_envoyeur`, `code_etab`, `date_courrier`, `origine`, `objet`, `corp`, `status`, `modifier_par`, `envoyer_a`) 
    VALUES (NULL, '".$row_user['nom_responsable']."', '".$row_user['code_etab']."', '".$current_date."', '".$row_user['type_etab']."', '".$objet."', '".$corp."', 'non lu', '".$row_user['nom_responsable']."', '".$type_etab."')") or die($cnx->error);

    if ($insertcourrier){   
        $_SESSION['retour'] = 'Votre courrier est bien envoyé';
        header('Location: gestioncourriers.php');
    } else {
        header('Location: gestioncourriers.php');
        $_SESSION['retour'] = 'Requete non valide';

    }
}

if(isset($_POST['edit'])){ //si le bouton 'Modifier' est cliqué
    
    
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $objet= validate($_POST['objet']);
    $corp= validate($_POST['corp']);
    $type_etab= validate($_POST['type_etab']);


    date_default_timezone_set('Europe/Madrid');
    $current_date = date('Y-m-d');

    $utilisateur = $cnx->query("SELECT * FROM `utilisateurs` WHERE `code_etab` = '".$_SESSION['username']."'");
    $row_user = $utilisateur->fetch_assoc();

    $updatecourrier = $cnx->query("UPDATE `courriers` SET `date_courrier`='".$current_date."' , `objet`='".$objet."' ,`corp`='".$corp."' , `status`='non lu', `modifier_par`= '".$row_user['nom_responsable']."' , `envoyer_a`='".$type_etab."'  WHERE `id_courrier`='".$_SESSION['courrier_edit']."' ");

    if ($updatecourrier){   
        $_SESSION['retour'] = 'Votre courrier est bien modifié';
        header('Location: gestioncourriers.php');
    } else {
        header('Location: gestioncourriers.php');
        $_SESSION['retour'] = 'La modification n\'a pas pu se faire';

    }
}?>
