<?php
	// Connexion à la base de données
	try{
		$db = new PDO('mysql:host=localhost;dbname=Arbo4','root','');
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	}catch(Exception $e){
		echo "impossible de se connecter a la base de donnée";
		echo $e->getMessage();
		die();
	}
?>
