<?php
include('connexion.php');
include('table-test.php');
// Vérifier si le formulaire a été soumis
if( isset($_POST) )
{
    // Vérifie si le fichier a été uploadé sans erreur.
    if(isset($_FILES["fichier"]) && $_FILES["fichier"]["error"] == 0)
     {
          //$id = $_POST['id'];
          $name = $_FILES["fichier"]["name"];
          $size = $_FILES['fichier']['size'];
          $dossier = 'upload/';
          $temp_name = $_FILES['fichier']['tmp_name'];

          if (!is_uploaded_file($temp_name)) {
               exit("le fichier est introuvable");
          }

          if($size >= 1000000){
               exit("Erreur, le fichier est trop volumineux");
          }

          $infosfichier = pathinfo($_FILES['fichier']['name']);
          $extension_upload = $infosfichier['extension'];

          $extension_upload = strtolower($extension_upload);
          $extension_autorisees = array('pdf','jpeg','jpg','png','gif','docx','php');

          if (!in_array($extension_upload, $extension_autorisees)) {
               exit("Erreur, Mauvaise extension");
          }

          $nom_file=$name;
          $pathe = $dossier.$nom_file;

          if (!move_uploaded_file($temp_name, $pathe)) {
               exit("Probléme dans le téléchargement de l'image, Ressayez");
          }

          var_dump($nom_file);
          $req1 = $db->prepare("INSERT INTO Arbre (fichier, pathe, dossier, extension, taille) VALUES ('$nom_file', '$pathe', '$dossier', '$extension_upload', $size);");
          echo("requete passé");
          $req1->execute();
          echo("requete executé");
    }

    else{

     $nom_file="inserez un fichier";
     echo "je suis la !!!";

    }

    echo"fichier uploadé avec succée";

}
?>