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
    <title>Courrier</title>
    <link rel="stylesheet" href="assets/css/style_commun.css">
    <link rel="stylesheet" href="assets/css/style_courriers.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Stick+No+Bills:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/141a859c3f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>

<body>
    <nav class="sidenav">
        <a href="courrier.php" class="sidenav-brand"><img src="assets/images/logo.png" alt="logo"></a>
        <a href="monprofile.php" class="sidenav-item"><i class=" fa fa-light fa-user sidenav-icon"></i>Mon Profil</a>
        <a href="courrier.php" class="sidenav-item active-item"><i class="fa fa-light fa-envelope sidenav-icon"></i>Courriers</a>
        <a href="#" class="sidenav-item"><i class="fa fa-light fa-circle-info sidenav-icon"></i>A propos de l'app</a>
        <a href="deconnexion.php" class="sidenav-item"><i class="fa fa-light fa-arrow-right-from-bracket sidenav-icon"></i>Se déconnecter</a>
    </nav>
    
    <section class="main">

        <article class="main-article">

            <div class="header">
                <h1 class="main-title underlined">Liste des courriers reçus</h1>
            </div>

            <div class="button-div">
                <a href="courrier.php" class="button">Actualiser</a>
            </div>

            <?php if(!empty($_SESSION['retour'])){
                        echo '<p class="msg-succes">'.$_SESSION['retour'].'</p>';
                        unset($_SESSION['retour']);//pour vider le msg
                      }
            ?>
            
            <?php
                $users = $cnx->query("SELECT * FROM `utilisateurs` WHERE `code_etab` = '".$_SESSION['username']."'");
                $users_row = $users->fetch_assoc();
                $compteur_id = 0;
     
                $_SESSION['type_etab'] = $users_row['type_etab'];

                $courriers = $cnx->query("SELECT * FROM `courriers` WHERE `envoyer_a`='".$_SESSION['type_etab']."'");

                if ($courriers->num_rows > 0) {

                    //On affiche le tableau des courriers si et seulement s'il existe des courriers envoyés à l'utilsateur
                    $_SESSION['lu'] = false; ?> 

                <table class="table">
                    <tr class="table-tr table-tr-header">
                        <td class="table-td-header">id</td>
                        <td class="table-td-header">Nom d'envoyeur</td>
                        <td class="table-td-header">Date d'envoie</td>
                        <td class="table-td-header">Origine</td>
                        <td class="table-td-header">Objet du courrier</td>
                        <td class="table-td-header">Modifié par</td>
                        <td class="table-td-header">Envoyé à</td>
                        <td class="table-td-header">Visionner</td>
                    </tr>
                    <?php 
                        
                            // output data of each row
                            while($row = $courriers->fetch_assoc()) {
                                $compteur_id++;
                                ?>
                            <tr class="table-tr">
                                <td class="table-td"><?php echo $compteur_id; ?></td>
                                <td class="table-td"><?php echo $row['nom_envoyeur']; ?></td>
                                <td class="table-td"><?php echo $row['date_courrier']; ?></td>
                                <td class="table-td"><?php echo $row['origine']; ?></td>
                                <td class="table-td"><?php echo $row['objet']; ?></td>
                                <td class="table-td"><?php echo $row['modifier_par']; ?></td>
                                <td class="table-td"><?php echo $row['envoyer_a']; ?></td>
                                <td class="table-td table-icone">
                                    <a href="courrierview.php?show=<?php echo $row['id_courrier']; $_SESSION['lu'] = true; ?>">
                                        <i class="fa fa-duotone fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                    <?php } ?>

                </table>
            <?php }else{ ?>

                <div class="div-pas-de-courrier">
                    <p class="p-pas-de-courrier">Vous n'avez aucun courrier jusqu'à le moment</p>
                </div>
            <?php } ?>
        </article>
        <!-- <footer class="footer-fix">
            <div>
                <p class="footer-text">© Tous Droit réservé</p>
                <p class="footer-text">BAKALI Fatima Zohra - UE232</p>
            </div>
        </footer> -->

    </section>

</body>
</html>