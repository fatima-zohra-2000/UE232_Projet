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
        <a href="gestionusers.php" class="sidenav-item active-item"><i class="fa fa-thin fa-users-gear sidenav-icon"></i>Gestion des utilisateurs</a> 
        <a href="#" class="sidenav-item"><i class="fa-solid fa-compass sidenav-icon"></i>Gestion des directions</a> 
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
                    $_SESSION['user_edit'] = $id_edit;
                    $edit = $cnx->query("SELECT * FROM `utilisateurs` WHERE `code_etab`='".$id_edit."'");
                    $row = $edit->fetch_assoc();
                    $nom_etab= $row['nom_etab'];
                    $nom_responsable= $row['nom_responsable'];
                    $milieu= $row['milieu'];
                    $type_etab= $row['type_etab'];
                    $type_compte= $row['user_type'];
                }                
            ?>

            <div class="header">
                <h1 class="main-title underlined"><?php if($update == false){echo "Ajouter un utilisateur";}else{echo "Modifier l'utilisateur ".$_SESSION['user_edit'];} ?></h1>
            </div>

            <?php if(!empty($_SESSION['retour'])){
                        echo '<p class="msg-succes">'.$_SESSION['retour'].'</p>';
                        unset($_SESSION['retour']);//pour vider le msg
                      }
            ?>
            <?php
             if($update == false){
                $utilisateur = $cnx->query("SELECT * FROM `utilisateurs` WHERE `code_etab`='".$_SESSION['username']."'");
                $row = $utilisateur->fetch_assoc();
            } else {
                $utilisateur = $cnx->query("SELECT * FROM `utilisateurs` WHERE `code_etab`='".$_SESSION['user_edit']."'");
                $row = $utilisateur->fetch_assoc();
            }

            ?>
            <form action="adduserconfig.php" method="post" id="form" class="form">

                <div class="form-group">
                    <label for="pseudo">Identifiant :</label>
                    <input type="text" name="username" id="pseudo" value="<?php if($update){echo $row['code_etab'];} ?>" class="input field"></br>
                </div>

                <?php if(!$update){?>
                    <div class="form-group">
                        <label for="pseudo">Mot de passe :</label>
                        <input type="password" name="password" id="password" class="input field"/></br>
                    </div>

                    <div class="form-group">
                        <label for="pseudo">Confirmer le mot de passe :</label>
                        <input type="password" name="password_confirm" id="password_confirm" class="input field"/></br>
                    </div>
                <?php }?>

                <div class="form-group">
                    <label for="etab">Nom d'établissement :</label>
                    <input type="text" name="nom_etab" id="etab" value="<?php if($update){echo $row['nom_etab'];} ?>" class="input field"></br>
                </div>

                <div class="form-group">
                    <label for="nom_responsable">Nom du responsable :</label>
                    <input type="text" name="nom_responsable" id="nom_responsable" value="<?php if($update){echo $row['nom_responsable'];} ?>" class="input field"></br>
                </div>

                <div class="form-group">
                    <label for="milieu">Milieu d'établissement :</label>
                    <select name="milieu" id="milieu" class="input field" placeholder="<?php if($update){echo $row['milieu'];} ?>">
                        <?php if($update){ ?><option selected="selected" value="<?php echo $row['milieu']; ?>"><?php echo $row['milieu'];?></option><?php } ?>
                        <option value="urbain">urbain</option>
                        <option value="rural">rural</option>
                    </select>
                    </select>
                </div>

                <div class="form-group">
                    <label for="type_etab">Type d'établissement :</label>
                    <select name="type_etab" id="type_etab" class="input field" placeholder="<?php if($update){echo $row['type_etab'];} ?>">
                        <option selected="selected" value="<?php if($update){echo $row['type_etab']; ?>"><?php echo $row['type_etab'];} ?></option>
                        <option value="préscolaire">préscolaire</option>
                        <option value="primaire">primaire</option>
                        <option value="secondaire">secondaire</option>
                        <option value="terminal">terminal</option>
                        <option value="administration">administration</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="user_type">Type de compte :</label>
                    <select name="user_type" id="user_type" class="input field" placeholder="<?php if($update){echo $row['user_type'];} ?>">
                        <option selected="selected" value="<?php if($update){echo $row['user_type']; ?>"><?php echo $row['user_type'];} ?></option>
                        <option value="utilisateur">utilisateur</option>
                        <option value="admin">admin</option>
                    </select>
                </div>
                

                <div class="display-flex button-div">
                    <?php if($update==true){ ?>
                        <input type="submit" name="edit" id="save_courrier" class="button" value="Modifier"/>
                    <? } else { ?>
                        <input type="submit" name="save" id="save_courrier" class="button" value="Enregistrer"/>
                    <? } ?>
                        <a href="gestionusers.php" class="button-second annuler-button" id="annuler-courrier">Annuler</a>
                </div>

            </form>
        </article>
    </section>

</body>
</html>
