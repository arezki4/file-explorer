<?php
// Vérifier si le formulaire a été soumis
if( isset($_POST) )
{
    // Vérifie si le fichier a été uploadé sans erreur.
    if(isset($_FILES["fichier"]) && $_FILES["fichier"]["error"] == 0)
	{
        $ok = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
        echo $name = $_FILES["fichier"]["name"], "<br/>";
        echo $type = $_FILES["fichier"]["type"], "<br/>";
        echo $size = $_FILES["fichier"]["size"], "<br/>";

        // Vérifie l'extension du fichier
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        if(!array_key_exists($extension, $ok)) die("Erreur : format de fichier  non autorisé !");

        // Vérifie la taille du fichier - 5Mo maximum
        $sizemax = 8 * 1024 * 1024;
        if($size > $sizemax) die("Erreur: La taille du fichier ne doit pas dépassée $sizemax !");

        // Vérifie le type MIME du fichier
        if(in_array($type, $ok))
		{
            // Vérifie si le fichier existe avant de le télécharger.
            if(file_exists("upload/" . $_FILES["fichier"]["name"]))
			{
                echo "Ce ", $_FILES["fichier"]["name"] . " existe déjà !";
            } 
			else
			{
                move_uploaded_file($_FILES["fichier"]["tmp_name"], "upload/" . $_FILES["fichier"]["name"]);
                echo "Le  fichier a été téléchargé avec succès !";
				
				// Requete sql
				$SQL = "INSERT INTO images VALUES ('$nom', $size, '$type')";
				
				//excuter sql
				
	
            } 
        } 
		else
		{
            echo "Erreur: Problème de téléchargement du fichier !"; 
        }
    } 
	else
	{
        echo "Erreur: " . $_FILES["fichier"]["error"];
    }
}
?>