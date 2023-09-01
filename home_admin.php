<?php 
    session_start(); 
    //on se connecte à la base.
    $cnx->connection = require("connexion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="assets/css/style_commun.css">
    <link rel="stylesheet" href="assets/css/style_home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Stick+No+Bills:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/141a859c3f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <nav class="sidenav">
        <a href="home_admin.php" class="sidenav-brand"><img src="assets/images/logo.png" alt="logo"></a>
        <a href="home_admin.php" class="sidenav-item active-item"><i class=" fa fa-light fa-gauge-high sidenav-icon"></i>Tableau de bord</a>
        <a href="profile.php" class="sidenav-item"><i class=" fa fa-light fa-user sidenav-icon"></i>Mon Profil</a>
        <a href="gestioncourriers.php" class="sidenav-item"><i class="fa fa-light fa-envelope sidenav-icon"></i>Gestion des courriers</a>
        <a href="gestionusers.php" class="sidenav-item"><i class="fa fa-thin fa-users-gear sidenav-icon"></i>Gestion des utilisateurs</a> 
        <a href="#" class="sidenav-item"><i class="fa-solid fa-compass sidenav-icon"></i>Gestion des directions</a> 
        <a href="#" class="sidenav-item"><i class="fa fa-light fa-circle-info sidenav-icon"></i>A propos de l'app</a>
        <a href="deconnexion.php" class="sidenav-item"><i class="fa fa-light fa-arrow-right-from-bracket sidenav-icon"></i>Se déconnecter</a>
    </nav>


    <section class="main">

        <article class="main-article">

            <div class="header">
                <h1 class="main-title underlined">Tableau de Bord</h1>
            </div>
            
            <div class="blocs parent">
                <?php 
                    $utilisateurs=$cnx->query('SELECT * FROM `utilisateurs`');
                    $email = $cnx->query("SELECT * FROM `courriers`");
                    $email_send=$cnx->query("SELECT * FROM `courriers` WHERE `envoyer_a`= 'administration'");
                    $email_received=$cnx->query("SELECT * FROM `courriers` WHERE `envoyer_a`!= 'administration'");
                    $directions = $cnx->query("SELECT * FROM `directions`");
                    
                    $num_direction = 0;
                    $num_email = 0;
                    $num_email_entrant = 0;
                    $num_email_sortant = 0;
                    $num_users=0;
                    $num_admin=0;
                    $num_simple=0;

                    if ($utilisateurs->num_rows > 0) {
                        // output data of each row
                        while($row = $utilisateurs->fetch_assoc()) {
                            $num_users++;
                            if ($row['user_type']=="utilisateur"){
                                $num_simple++;
                          } elseif ($row['user_type']=="admin"){
                              $num_admin++;
                          }
                        }
                      } else {
                        $num_users=0;
                      }
        
                    if ($email->num_rows > 0) {
                    // output data of each row
                        while($row = $email->fetch_assoc()) {
                            $num_email++;
                        }
                    } else {
                        $num_email=0;
                    }
    
                    if ($email_received->num_rows > 0) {
                    // output data of each row
                        while($row = $email_received->fetch_assoc()) {
                            $num_email_entrant++;
                        }
                    } else {
                        $num_email_entrant=0;
                    }
    
                    if ($email_send->num_rows > 0) {
                        // output data of each row
                        while($row = $email_send->fetch_assoc()) {
                            $num_email_sortant++;
                        }
                    } else {
                        $num_email_sortant=0;
                    }

                    if ($directions->num_rows > 0) {
                        // output data of each row
                        while($row = $directions->fetch_assoc()) {
                            $num_direction++;
                        }
                    } else {
                        $num_direction=0;
                    }
                ?>
                <div class="bloc-item first-bloc">
                    <p class="bloc-label1"><?php echo $num_email;?></p>
                    <p class="bloc-label">Courriers</p>
                </div>

                <div class="bloc-item second-bloc">
                    <p class="bloc-label1"><?php echo $num_direction;?></p>
                    <p class="bloc-label">Directions</p>
                </div>

                <div class="bloc-item third-bloc">
                    <p class="bloc-label1">2</p>
                    <p class="bloc-label">Types des utilisateurs</p>
                </div>

                <div class="bloc-item fourth-bloc">
                    <p class="bloc-label1"><?php echo $num_users;?></p>
                    <p class="bloc-label">Utilisateurs</p>
                </div>
            </div>

        </article>

        

        <article class="main-article">

            <div class="title-div">
                <h2 class="title">Statistiques regroupées</h2>
                <a href="home_admin.php" class="refresh-button"> Actualiser</a>
            </div>

            <div class="div-canvas parent2">
                <canvas id="canvas" width="400px" height="350px"></canvas>
                <div class="div-description">
                    <p class="label-description label-description1">Administrateur</p>
                    <p class="label-description label-description2">Utilisateur simple</p>
                </div>
                <canvas id="canvas2" width="400px" height="350px"></canvas>
                <div class="div-description">
                    <p class="label-description label-description4">Courriers envoyés à l'administration</p>
                    <p class="label-description label-description3">Courriers envoyés aux autres directions</p>
                </div>
            </div>
            <script>
                // function circle()
                // {
                // var canvas = document.getElementById("canvas"); 
                // var context = canvas.getContext("2d");
                // context.beginPath();
                // context.lineWidth="2";
                // context.arc(100, 100, 90, 0, 2 * Math.PI);
                // context.stroke();
                // }
                // circle();  

                function pie(ctx, w, h, datalist)
                {
                    var radius = h / 2 - 5;
                    var centerx = w / 2;
                    var centery = h / 2;
                    var total = 0;

                    var offset = Math.PI / 2;
                    var labelxy = new Array();

                    var fontSize = Math.floor(canvas.height / 13);
                    ctx.textAlign = 'center';
                    ctx.font = fontSize + "px Arial";
                    var total = 0;

                    for(x=0; x < datalist.length; x++) { total += datalist[x]; }; 
                    var lastend=0;
                    var offset = Math.PI / 2;

                    var dataname = new Array();

                    var num_admin = '<?php echo $num_admin; ?>';
                    var num_simple = '<?php echo $num_simple; ?>';
                    var num_users = '<?php echo $num_users; ?>';
                    var user_simple = num_simple * 100 / num_users;
                    var user_admin = num_admin * 100 / num_users;

                    // dataname[0] = num_simple+"\r\nUtilisateur simple";
                    // dataname[1] = num_admin+"\r\nAdministrateur";

                    dataname[0] = num_simple;
                    dataname[1] = num_admin;

                    for(x=0; x < datalist.length; x++)
                    {
                        var thispart = datalist[x]; 
                        ctx.beginPath();
                        ctx.fillStyle = colist[x];
                        ctx.moveTo(centerx,centery);
                        var arcsector = Math.PI * (2 * thispart / total);
                        ctx.arc(centerx, centery, radius, lastend - offset, lastend + arcsector - offset, false);
                        ctx.lineTo(centerx, centery);
                        ctx.fill();
                        ctx.closePath();
                        if(thispart > (total / 20))	
                            labelxy.push(lastend + arcsector / 2 + Math.PI + offset);
                        lastend += arcsector;	
                    }
                    var lradius = radius * 3 / 4; 
                    ctx.strokeStyle = "#ffffff";
                    ctx.fillStyle = "#ffffff";
                    for(i=0; i < labelxy.length; i++)
                    {	  
                        var langle = labelxy[i];
                        var dx = centerx + lradius * Math.cos(langle) /1.5;
                        var dy = centery + lradius * Math.sin(langle);	
                        ctx.fillText(dataname[i], dx, dy);
                            
                    }
                }

                var num_admin = '<?php echo $num_admin; ?>';
                var num_simple = '<?php echo $num_simple; ?>';
                var num_users = '<?php echo $num_users; ?>';
                var user_simple = num_simple * 100 / num_users;
                var user_admin = num_admin * 100 / num_users;

                var datalist= new Array(user_simple, user_admin); 
                var colist = new Array('#BF7F13', '#00BFB8 ', '#358fcd', '#711d72', 'gray', 'yellow');
                var canvas = document.getElementById("canvas"); 
                var ctx = canvas.getContext('2d');
                pie(ctx, canvas.width, canvas.height, datalist); 


                //canvas 2

                function pie2(ctx, w, h, datalist)
                {
                    var radius = h / 2 - 5;
                    var centerx = w / 2;
                    var centery = h / 2;
                    var total = 0;

                    var offset = Math.PI / 2;
                    var labelxy = new Array();

                    var fontSize = Math.floor(canvas.height / 13);
                    ctx.textAlign = 'center';
                    ctx.font = fontSize + "px Arial";
                    var total = 0;

                    for(x=0; x < datalist.length; x++) { total += datalist[x]; }; 
                    var lastend=0;
                    var offset = Math.PI / 2;

                    var dataname = new Array();

                    var num_email_entrant = '<?php echo $num_email_entrant; ?>';
                    var num_email_sortant = '<?php echo $num_email_sortant; ?>';
                    var num_email = '<?php echo $num_email; ?>';
                    var email_entrant = num_email_entrant * 100 / num_email;
                    var email_sortant = num_email_sortant * 100 / num_email;

                    // dataname[0] = num_email_entrant+"\r\nCourriers entrant";
                    // dataname[1] = num_email_sortant+"\r\nCourriers sortant";

                    dataname[0] = num_email_entrant;
                    dataname[1] = num_email_sortant;

                    for(x=0; x < datalist.length; x++)
                    {
                        var thispart = datalist[x]; 
                        ctx.beginPath();
                        ctx.fillStyle = colist[x];
                        ctx.moveTo(centerx,centery);
                        var arcsector = Math.PI * (2 * thispart / total);
                        ctx.arc(centerx, centery, radius, lastend - offset, lastend + arcsector - offset, false);
                        ctx.lineTo(centerx, centery);
                        ctx.fill();
                        ctx.closePath();
                        if(thispart > (total / 20))	
                            labelxy.push(lastend + arcsector / 2 + Math.PI + offset);
                        lastend += arcsector;	
                    }
                    var lradius = radius * 3 / 4; 
                    ctx.strokeStyle = "#ffffff";
                    ctx.fillStyle = "#ffffff";
                    for(i=0; i < labelxy.length; i++)
                    {	  
                        var langle = labelxy[i];
                        var dx = centerx + lradius * Math.cos(langle) /1.5;
                        var dy = centery + lradius * Math.sin(langle);	
                        ctx.fillText(dataname[i], dx, dy);
                            
                    }
                }

                var num_email_entrant = '<?php echo $num_email_entrant; ?>';
                var num_email_sortant = '<?php echo $num_email_sortant; ?>';
                var num_email = '<?php echo $num_email; ?>';
                var email_entrant = num_email_entrant * 100 / num_email;
                var email_sortant = num_email_sortant * 100 / num_email;

                var datalist= new Array(email_entrant, email_sortant); 
                var colist = new Array('#BF4300', '#09736F ', '#358fcd', '#711d72', 'gray', 'yellow');
                var canvas = document.getElementById("canvas2"); 
                var ctx = canvas.getContext('2d');
                pie2(ctx, canvas.width, canvas.height, datalist); 
                

                
            </script>

        </article>

        <footer class="footer">
            <div>
                <p class="footer-text">© Tous Droit réservé</p>
                <p class="footer-text">BAKALI Fatima Zohra - UE232</p>
            </div>
        </footer>

    </section>
    
    
</body>
</html>