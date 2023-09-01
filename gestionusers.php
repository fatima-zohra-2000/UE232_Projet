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
    <title>Tableau de bord</title>
    <!-- Latest compiled and minified CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Latest compiled JavaScript -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->
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
        <a href="home_admin.php" class="sidenav-brand"><img src="assets/images/logo.png" alt="logo"></a>
        <a href="home_admin.php" class="sidenav-item"><i class=" fa fa-light fa-gauge-high sidenav-icon"></i>Tableau de bord</a>
        <a href="profile.php" class="sidenav-item"><i class=" fa fa-light fa-user sidenav-icon"></i>Mon Profil</a>
        <a href="gestioncourriers.php" class="sidenav-item"><i class="fa fa-light fa-envelope sidenav-icon"></i>Gestion des courriers</a>
        <a href="gestionusers.php" class="sidenav-item active-item"><i class="fa fa-thin fa-users-gear sidenav-icon"></i>Gestion des utilisateurs</a> 
        <a href="gestiondirections.php" class="sidenav-item"><i class="fa-solid fa-compass sidenav-icon"></i>Gestion des directions</a> 
        <a href="#" class="sidenav-item"><i class="fa fa-light fa-circle-info sidenav-icon"></i>A propos de l'app</a>
        <a href="deconnexion.php" class="sidenav-item"><i class="fa fa-light fa-arrow-right-from-bracket sidenav-icon"></i>Se déconnecter</a>
    </nav>
    
    <section class="main">

        <article class="main-article">

            <div class="header">
                <h1 class="main-title underlined">Gestion des Utilisateurs</h1>
            </div>

            <?php if(!empty($_SESSION['retour'])){
                        echo '<p class="msg-succes">'.$_SESSION['retour'].'</p>';
                        unset($_SESSION['retour']);//pour vider le msg
                      }
            ?>
            
            <div class="button-div">
                <a href="adduser.php" class="button">Nouveau utilisateur</a>
                <a href="gestionusers.php" class="button-second">Actualiser</a>
                <!-- <input type="button" class="button" value="Voir le courrier" id="edit_button"> -->
            </div>

            <table class="table">
                <tr class="table-tr table-tr-header">
                    <td class="table-td table-td-header">id</td>
                    <td class="table-td table-td-header">Identifiant</td>
                    <td class="table-td table-td-header">Nom d'établissement</td>
                    <td class="table-td table-td-header">Nom du responsable</td>
                    <td class="table-td table-td-header">Milieu de l'établissement</td>
                    <td class="table-td table-td-header">Type d'établissement</td>
                    <td class="table-td table-td-header">Type du compte</td>
                    <td class="table-td table-td-header">Modifier</td>
                    <td class="table-td table-td-header">Supprimer</td>
                </tr>
                <?php 
                    $compteur_id = 0;

                    // $users = $cnx->query("SELECT * FROM `utilisateurs` WHERE `code_etab`='".$_SESSION['username']."' OR `envoyer_a`='".$_SESSION['type_etab']."'");
                    $users = $cnx->query("SELECT * FROM `utilisateurs`");

                    if ($users->num_rows > 0) {
                        // output data of each row
                        while($row = $users->fetch_assoc()) {
                            $compteur_id++;
                            ?>
                        <tr class="table-tr">
                            <td class="table-td"><?php echo $compteur_id; ?></td>
                            <td class="table-td"><?php echo $row['code_etab']; ?></td>
                            <td class="table-td"><?php echo $row['nom_etab']; ?></td>
                            <td class="table-td"><?php echo $row['nom_responsable']; ?></td>
                            <td class="table-td"><?php echo $row['milieu']; ?></td>
                            <td class="table-td"><?php echo $row['type_etab']; ?></td>
                            <td class="table-td"><?php echo $row['user_type']; ?></td>
                            <td class="table-td">
                                <a href="adduser.php?edit=<?php echo $row['code_etab'];?>">
                                    <i class="fa fa-duotone fa-pen-to-square"></i>
                                </a>
                            </td>
                            <td class="table-td">
                                <a onclick="return(confirm('Etes-vous sûr de vouloir supprimer?'));" href="gestionusers.php?delete=<?php echo $row['code_etab'];?>">
                                    <i class="fa fa-duotone fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                <?php } } ?>

                <?php 
                if (isset($_GET['delete']) && !empty($_GET['delete'])){
                    @$id_edit= $_GET['delete'];
                    $delete = $cnx->query("DELETE FROM `utilisateurs` WHERE `code_etab`='".$id_edit."'");
                    header("Location: gestionusers.php"); 
                    $_SESSION['message']= "Utilisateur bien supprimé !";
                }
                 ?>

            </table>