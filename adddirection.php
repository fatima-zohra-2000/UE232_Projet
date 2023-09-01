<?php 
    session_start(); 
    //on se connecte à la bbd.
    $cnx->connection = require("connexion.php");
    $update = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="assets/css/style_commun.css">
    <link rel="stylesheet" href="assets/css/style_profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Stick+No+Bills:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/141a859c3f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>

<body>
    <nav class="sidenav">
        <a href="home_admin.php" class="sidenav-brand"><img src="assets/images/logo.png" alt="logo"></a>
        <a href="home_admin.php" class="sidenav-item"><i class=" fa fa-light fa-gauge-high sidenav-icon"></i>Tableau de bord</a>
        <a href="profile.php" class="sidenav-item"><i class=" fa fa-light fa-user sidenav-icon"></i>Mon Profil</a>
        <a href="gestioncourriers.php" class="sidenav-item"><i class="fa fa-light fa-envelope sidenav-icon"></i>Gestion des courriers</a>
        <a href="gestionusers.php" class="sidenav-item"><i class="fa fa-thin fa-users-gear sidenav-icon"></i>Gestion des utilisateurs</a> 
        <a href="gestiondirections.php" class="sidenav-item active-item"><i class="fa-solid fa-compass sidenav-icon"></i>Gestion des directions</a> 
        <a href="#" class="sidenav-item"><i class="fa fa-light fa-circle-info sidenav-icon"></i>A propos de l'app</a>
        <a href="deconnexion.php" class="sidenav-item"><i class="fa fa-light fa-arrow-right-from-bracket sidenav-icon"></i>Se déconnecter</a>
    </nav>
    
    <section class="main">

        <article class="main-article">

            <?php

                // echo $_SESSION['courrier_edit'];
                if(isset($_GET['edit']) && !empty($_GET['edit'])){
                    $update = true;
                    $id_edit = $_GET['edit'];
                    $_SESSION['direction_edit'] = $id_edit;
                    $edit = $cnx->query("SELECT * FROM `directions` WHERE `id_direction`='".$id_edit."'");
                    $row = $edit->fetch_assoc();
                    $direction= $row['direction'];
                    // $nom_responsable= $row['nom_responsable'];
                    // $milieu= $row['milieu'];
                    // $type_etab= $row['type_etab'];
                    // $type_compte= $row['user_type'];
                }                
            ?>

            <div class="header">
                <h1 class="main-title underlined"><?php if($update == false){echo "Ajouter une direction";}else{echo "Modifier la direction ";} ?></h1>
            </div>

            <!-- <div class="button-div">
                <input type="button" class="button" value="Changer le mot de passe" id=""> -->
                <!-- <a href="#" class="button">Changer le mot de passe</a> -->
                <!-- <input type="button" class="button" value="Editer" id="edit_button">
            </div> -->

            <?php if(!empty($_SESSION['retour'])){
                        echo '<p class="msg-succes">'.$_SESSION['retour'].'</p>';
                        unset($_SESSION['retour']);//pour vider le msg
                      }
            ?>
            <?php
             if($update){
                $directionquery = $cnx->query("SELECT * FROM `directions` WHERE `id_direction`='".$id_edit."'") or die($cnx->error);
                $row_direction = $directionquery->fetch_assoc();
             }

            ?>
            <form action="adddirectionconfig.php" method="post" id="form" class="form">

                <div class="form-group">
                    <label for="direction">Nom de la direction :</label>
                    <input type="text" name="direction" id="direction" value="<?php if($update){echo $row_direction['direction'];} ?>" class="input field"></br>
                </div>

                <div class="display-flex button-div">
                    <?php if($update==true){ ?>
                        <input type="submit" name="edit" id="save_courrier" class="button" value="Modifier"/>
                    <? } else { ?>
                        <input type="submit" name="save" id="save_courrier" class="button" value="Enregistrer"/>
                    <? } ?>
                        <a href="gestiondirections.php" class="button-second annuler-button" id="annuler-courrier">Annuler</a>
                </div>

            </form>