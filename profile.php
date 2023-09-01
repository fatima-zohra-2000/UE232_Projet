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
    <link rel="stylesheet" href="assets/css/style_profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Stick+No+Bills:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/141a859c3f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>

<body>

    <script type="text/javascript">

        function masquer_div(id)
        {
        if (document.getElementById(id).style.display == 'none')
        {
            document.getElementById(id).style.display = 'block';
        }
        else
        {
            document.getElementById(id).style.display = 'none';
        }
        }
    </script>

    <nav class="sidenav">
        <a href="home_admin.php" class="sidenav-brand"><img src="assets/images/logo.png" alt="logo"></a>
        <a href="home_admin.php" class="sidenav-item"><i class=" fa fa-light fa-gauge-high sidenav-icon"></i>Tableau de bord</a>
        <a href="profile.php" class="sidenav-item active-item"><i class=" fa fa-light fa-user sidenav-icon"></i>Mon Profil</a>
        <a href="gestioncourriers.php" class="sidenav-item"><i class="fa fa-light fa-envelope sidenav-icon"></i>Gestion des courriers</a>
        <a href="gestionusers.php" class="sidenav-item"><i class="fa fa-thin fa-users-gear sidenav-icon"></i>Gestion des utilisateurs</a> 
        <a href="#" class="sidenav-item"><i class="fa-solid fa-compass sidenav-icon"></i>Gestion des directions</a> 
        <a href="#" class="sidenav-item"><i class="fa fa-light fa-circle-info sidenav-icon"></i>A propos de l'app</a>
        <a href="deconnexion.php" class="sidenav-item"><i class="fa fa-light fa-arrow-right-from-bracket sidenav-icon"></i>Se déconnecter</a>
    </nav>
    
    <section class="main">

        <article class="main-article">

            <div class="header">
                <h1 class="main-title underlined">Profil de <?php echo $_SESSION['username'];?></h1>
            </div>

            <div class="button-div">
                <input type="button" class="button" value="Changer le mot de passe" id="change_pw">
                <!-- <a href="#" class="button">Changer le mot de passe</a> -->
                <input type="button" class="button-second" value="Editer les informations" id="edit_button">
            </div>

            <?php if(!empty($_SESSION['retour'])){
                        echo '<p class="msg-succes">'.$_SESSION['retour'].'</p>';
                        unset($_SESSION['retour']);//pour vider le msg
                      }
            ?>
            <?php
            
                $utilisateur = $cnx->query("SELECT * FROM `utilisateurs` WHERE `code_etab`='".$_SESSION['username']."'");
                $row = $utilisateur->fetch_assoc();
            ?>
            <form action="profileconfig.php" method="post" id="form" class="form">

                <div class="form-group">
                    <label for="pseudo">Identifiant :</label>
                    <input type="text" name="username" id="pseudo" value="<?php echo $row['code_etab']; ?>" class="input field" disabled></br>
                </div>

                <div class="form-group">
                    <label for="etab">Nom d'établissement :</label>
                    <input type="text" name="nom_etab" id="etab" value="<?php echo $row['nom_etab']; ?>" class="input field" disabled></br>
                </div>

                <div class="form-group">
                    <label for="nom_responsable">Nom du responsable :</label>
                    <input type="text" name="nom_responsable" id="nom_responsable" value="<?php echo $row['nom_responsable']; ?>" class="input field" disabled></br>
                </div>

                <div class="form-group">
                    <label for="milieu">Milieu d'établissement :</label>
                    <select name="milieu" id="milieu" class="input field" placeholder="<?php echo $row['milieu']; ?>" disabled>
                        <option selected="selected" value="<?php echo $row['milieu']; ?>"><?php echo $row['milieu']; ?></option>
                        <option value="urbain">urbain</option>
                        <option value="rural">rural</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="type_etab">Type d'établissement :</label>
                    <select name="type_etab" id="type_etab" class="input field" placeholder="<?php echo $row['type_etab']; ?>" disabled>
                        <option selected="selected" value="<?php echo $row['type_etab']; ?>"><?php echo $row['type_etab']; ?></option>
                        <option value="préscolaire">préscolaire</option>
                        <option value="primaire">primaire</option>
                        <option value="secondaire">secondaire</option>
                        <option value="terminal">terminal</option>
                        <option value="administration">administration</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="user_type">Type de compte :</label>
                    <select name="user_type" id="user_type" class="input field" placeholder="<?php echo $row['user_type']; ?>" disabled>
                        <option selected="selected" value="<?php echo $row['user_type']; ?>"><?php echo $row['user_type']; ?></option>
                        <option value="utilisateur">utilisateur</option>
                        <option value="admin">admin</option>
                    </select>
                </div>

                <div id="masquer" style="display:none;">
                    <div class="form-group">
                        <label for="pseudo">Mot de passe :</label>
                        <input type="password" name="password" id="masquer" class="input field2" disabled/></br>
                    </div>

                    <div class="form-group">
                        <label for="pseudo">Confirmer le mot de passe :</label>
                        <input type="password" name="password_confirm" id="masquer" class="input field2" disabled/></br>
                    </div>
                </div>
                
                <input type="hidden" name="save" id="save" class="button field" value="Enregistrer" disabled/>

            </form>

        </article>
        <footer class="footer-incomplet">
            <div>
                <p class="footer-text">© Tous Droit réservé</p>
                <p class="footer-text">BAKALI Fatima Zohra - UE232</p>
            </div>
        </footer>
    </section>
    
    <script>

        // function remove_disabled(){
        //     var ele = document.getElementsByClassName('input');
        //     for(var i =0; i<ele.length; i++){
        //         ele[i].removeAttribute("disabled");
        //     }
        //     var edit_button = document.getElementById('edit_button');
        //     // edit_button.setAttribute("value", "Annuler");
        //     edit_button.value = "Annuler"
        // }

        //Old method that do not allow to go back and forwered in button value


        var btn = document.getElementById('edit_button');
        var savebtn = document.getElementById('save');

        btn.addEventListener("click", ()=>{

            if(btn.value == "Editer les informations"){

                btn.value = "Annuler";
                var ele = document.getElementsByClassName('field');
                for(var i =0; i<ele.length; i++){
                    ele[i].removeAttribute("disabled");
                }
                savebtn.setAttribute("type","submit");
            
            } else {
                location.reload();
            }
        })

        var change_pw = document.getElementById('change_pw');
        var divmasquer = document.getElementById('masquer');
        change_pw.addEventListener("click", ()=>{

            if(change_pw.value == "Changer le mot de passe"){
                change_pw.value = "Terminer"
                divmasquer.style.display = 'block';
                var ele = document.getElementsByClassName('field2');
                for(var i =0; i<ele.length; i++){
                    ele[i].removeAttribute("disabled");
                }
            }
            else
            {
                change_pw.value = "Changer le mot de passe"
                divmasquer.style.display = 'none';
                var ele = document.getElementsByClassName('field2');
                for(var i =0; i<ele.length; i++){
                    ele[i].setAttribute("disabled","");
                }
            }
        })

    </script>

</body>
</html>