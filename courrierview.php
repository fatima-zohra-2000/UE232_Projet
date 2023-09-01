<?php 
    session_start(); 
    //on se connecte à la bbd.
    $cnx->connection = require("connexion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage du courrier</title>
    <link rel="stylesheet" href="assets/css/style_commun.css">
    <link rel="stylesheet" href="assets/css/style_profile.css">
    <link rel="stylesheet" href="assets/css/style_courriers.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Stick+No+Bills:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/141a859c3f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script src="https://cdn.tiny.cloud/1/j159u6pvulu4apgz2iom2syart8jdojbzlk324qph9afsjj7/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body>
    <nav class="sidenav">
        <a href="courrier.php" class="sidenav-brand"><img src="assets/images/logo.png" alt="logo"></a>
        <a href="profile.php" class="sidenav-item"><i class=" fa fa-light fa-user sidenav-icon"></i>Mon Profil</a>
        <a href="gestioncourriers.php" class="sidenav-item active-item"><i class="fa fa-light fa-envelope sidenav-icon"></i>Courriers</a>
        <a href="#" class="sidenav-item"><i class="fa fa-light fa-circle-info sidenav-icon"></i>A propos de l'app</a>
        <a href="deconnexion.php" class="sidenav-item"><i class="fa fa-light fa-arrow-right-from-bracket sidenav-icon"></i>Se déconnecter</a>
    </nav>
    
    <section class="main">

        <article class="main-article">

            <div class="header">
                <h1 class="main-title underlined">Courrier</h1>
            </div>

            <div class="button-div">
                <a href="courrier.php" class="button">Retour</a>
                <!-- <input type="button" class="button" value="Voir le courrier" id="edit_button"> -->
            </div>

            <?php 
                
                $lu = $_SESSION['lu'];
                if (isset($_GET['show'])){
                    @$id2= $_GET['show'];
                    if($lu ==true){
                        $reqlu = $cnx -> query("UPDATE `courriers` SET `status`='lu' WHERE `id_courrier`=$id2");
                    }
                    // header("Location: courrier.php"); 
                    $_SESSION['message_show']= "Vous voyez maintenant le courrier !";
                }
            
                $courrier = $cnx->query("SELECT * FROM `courriers` WHERE `id_courrier` = $id2");
                $row = $courrier->fetch_assoc();
                $corp = $row['corp'];
                $corp = str_replace('"','\\"',$corp);
                $corp = str_replace(array("\r","\n"),"",$corp);
            ?>

            <!-- <div class="container-courrier"> -->
                <table class="table-affiche">
                    <tr class="table-affiche-row thead">
                        <td class="table-affiche-column column-first">
                            Objet :
                        </td>
                        <td class="table-affiche-column">
                            <h2 class="objet-affiche"><?php echo $row['objet'];?></h2>
                        </td>
                    </tr>

                    <tr class="table-affiche-row">
                        <td class="table-affiche-column">
                            Courrier :
                        </td>
                        <td class="table-affiche-column">
                            <p class="corp-affiche"><?php echo html_entity_decode($corp);?></p>
                        </td>
                    </tr>
                    
                </table>
            <!-- </div> -->
        </article>

        <footer class="footer-fix">
            <div>
                <p class="footer-text">© Tous Droit réservé</p>
                <p class="footer-text">BAKALI Fatima Zohra - UE232</p>
            </div>
        </footer>

    </section>
</body>
</html>