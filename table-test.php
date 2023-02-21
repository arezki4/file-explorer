<?php
include('header.php');
include('connexion.php');

$page = $_GET['page'];
$page = (!empty($_GET['page']) ? $_GET['page'] : 1);
$limite = 3;

$resultFoundRows = $db->query("select count(id) FROM Arbre");
/* On doit extraire le nombre du jeu de résultat */
$nombredElementsTotal = $resultFoundRows->fetchColumn();
$nombreDePages = ceil($nombredElementsTotal / $limite);

$debut = ($page - 1) * $limite;
$req = $db->prepare("select * from Arbre LIMIT :limite OFFSET :debut");

$req->bindValue(
    'limite',         // Le marqueur est nommé « limite »
     $limite,         // Il doit prendre la valeur de la variable $limite
     PDO::PARAM_INT   // Cette valeur est de type entier
);
$req->bindValue('debut', $debut, PDO::PARAM_INT);

$req->setFetchMode(PDO::FETCH_ASSOC);
$req->execute();
$tab = $req->fetchAll();
?>
<h1>Ceci est la solution de l\'exo 1 et 2</h1>
<div class='col-sm-12'>
  <table class='table table-striped'>
     <thead>
    	<tr>
	        <th>id</th>
	        <th>fichier</th>
	        <th>path</th>
	        <th>dossier</th>
	        <th>extension</th>
	        <th>taille</th>
    	</tr>
     </thead>
     <tbody>
     <!--Partie "Boucle"-->
	 <?php foreach($tab as $t): ?>
     <tr>
        	<td> <?= $t['id'];?> </td>
          	<td> <?= $t['fichier'];?> </td>
            <td> <?= $t['pathe'];?> </td>
            <td> <?= $t['dossier'];?> </td>
            <td> <?= $t['extension'];?> </td>
            <td> <?= $t['taille'];?> </td>
     </tr>
     <?php endforeach; ?>

	</tbody>
</table>

<!--Partie "Liens"-->
<?php if ($page > 1): ?>
	<a type ="button" class="btn btn-primary btn-sm" href="?page=<?php echo $page - 1; ?>">Page précédente</a>
<?php else : ?>
	<a type ="button" class="btn btn-primary btn-sm disabled" href="?page=<?php echo $page - 1; ?>">Page précédente</a>
<?php endif; ?>

<?php for($i = 1; $i <= $nombreDePages; $i++) :?>
			<?php if($i==1 || (($page-5)<$i && $i<($page+5)) || $i==$nombreDePages)
				{
					if($i==$nombreDePages && $page<($nombreDePages-5)) { echo '...|'; }
					if ($i == $page) { echo ' <b> '.$i.'</b> |'; }
					else { echo ' <a href="?page= '.$i.'" title="page '.$i.'">'.$i.'</a> |'; }
					if($i==1 && $page>4) { echo '...'; }
				}
			  ?>
<?php endfor; ?>

<?php if ($page < $nombreDePages): ?>
	<a type ="button" class="btn btn-primary btn-sm" href="?page=<?php echo $page + 1; ?>">Page suivante</a>
<?php else : ?>
	<a type ="button" class="btn btn-primary btn-sm disabled" href="?page=<?php echo $page + 1; ?>">Page suivante</a>
<?php endif; ?>


<form action="upload.php" method="POST" enctype="multipart/form-data">
	<h2>Upload Fichier</h2>
	<input type="file" name="fichier" size="30">
	<input type="submit" name="submit" value="Upload">
</form>

       <?php
    $dir = "/upload";
    // Ouvre un dossier bien connu, et liste tous les fichiers
    if (is_dir($dir)) { // si le dossier existe
        if ($dh = opendir($dir)) { // on ouvre le répertoire
            while (($file = readdir($dh)) !== false) { // tant qu'on peut lire
                echo "fichier : $file : type : " . filetype($dir . $file) . "\n"; // on affiche les fichiers
            }
            closedir($dh);
        }
    }
    ?>

   <p>
<?php
/*// le chemin du dossier à créer
$dir = "upload/test/";
 
// Verifier l'existence du dossier
if(!file_exists($dir)){
    // Tentative de création du répertoire
    if(mkdir($dir)){
        echo "Répertoire créé avec succès.";
    } else{
        echo "ERREUR : Le répertoire n'a pas pu être créé.";
    }
} else{
    echo "ERREUR : Le répertoire existe déjà.";
}*/
?>
</p>

<?= include('footer.php'); ?>