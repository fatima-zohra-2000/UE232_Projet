<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<?php
			$host="localhost";
			$user="bakali1";
			$pass="Fatimita2000";
			$bdd="ue232projet";

			// try{
			// 	$cnx = new PDO("mysql:host=$host;dbname=$bdd",$user,$pass);
			// 	//On définit le mode d'erreur de PDO sur Exception
            //     $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //     echo 'Connexion réussie';
			// }
			// catch(PDOException $e){
			// 	echo "Erreur : " . $e->getMessage();
			//   }
			// if(!$cnx){
			// 	echo"cannot connect to the server"."</br>";
			// 	exit();
			// }

			

			$cnx=mysqli_connect($host,$user,$pass);
			if(!$cnx){
				echo"cannot connect to the server"."</br>";
				exit();
			}
			if (mysqli_select_db($cnx,$bdd)==false){
				echo"Cannot find the data base"."</br>";
				exit();
			}
		?>
	</body>
</html>