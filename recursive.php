<link href="css/recursive.css" rel="stylesheet">

<?php
include("header.php");
include("connexion_Arbo4.php");

function delete(){
	global $db;

  // sql to delete a record
  $sql = "TRUNCATE TABLE files";
  $sql2 = "TRUNCATE TABLE folders";

  // use exec() because no results are returned
  $db->exec($sql);
  $db->exec($sql2);
  echo "Record deleted successfully";
}

// Fonction récursive qui parcourt récursivement le répertoire et qui ajoute les fichiers et dossiers dans la base de données
function scanDirectory($directory, $parentId) {
  global $db;

  // Récupération de la liste des fichiers et dossiers dans le répertoire
  $items = scandir($directory);

  // Parcours de la liste des fichiers et dossiers
  foreach ($items as $item) {
    // On ignore les fichiers "." et ".."
    if ($item == "." || $item == "..") continue;

    // Chemin complet du fichier ou dossier
    $path = $directory . '/' . $item;

    // Si c'est un dossier, on insère un enregistrement dans la table des dossiers et on appelle récursivement la fonction scanDirectory
    if (is_dir($path)) {
      $stmt = $db->prepare('INSERT INTO folders (name, parent_id) VALUES (?, ?)');
      $stmt->execute([$item, $parentId]);
      $folderId = $db->lastInsertId();
      scanDirectory($path, $folderId);
    }
    // Si c'est un fichier, on insère un enregistrement dans la table des fichiers
    else {
    	$size = filesize($path);
      	$stmt = $db->prepare('INSERT INTO files (name, size, parent_id) VALUES (?, ?, ?)');
      	$stmt->execute([$item, $size, $parentId]);
      var_dump($size);
    }
  }
}

// On commence par le répertoire racine, avec un parent_id à 0
//delete();
//scanDirectory('docs/', 0);

// Fonction récursive pour afficher les dossiers et fichiers dans la base de données
function displayDirectory($parentId, $level = 0) {
  global $db;

  // Récupération de la liste des dossiers enfants du dossier courant
  $stmt = $db->prepare('SELECT * FROM folders WHERE parent_id = ?');
  $stmt->execute([$parentId]);
  $folders = $stmt->fetchAll();

  // Si il y a des dossiers, on les affiche
  if (count($folders) > 0) {
    // Encapsulation des dossiers dans une div
    echo '<div class="folders">';
    foreach ($folders as $folder) {
      // Ajout de la marge en fonction du niveau de profondeur
      echo '<div style="margin-left: ' . ($level * 20) . 'px">';
      // Affichage du nom du dossier
      echo '<div style="display: flex; align-items: center;">
      <img src="/icons/folder.gif"></img> 
      <a style="height: 10px;margin-left:7px" href="?dir=' . $folder['id_folder'] . '">' . $folder['name'] . '</a>
      </div>';
  
      // Appel récursif pour afficher les dossiers enfants
      displayDirectory($folder['id_folder'], $level + 1);
      echo '</div>';
    }
    echo '</div>';
  }
}

function displayFiles($parentId, $page) {
  global $db;

  // Nombre de fichiers à afficher par page
  $filesPerPage = 9;

  // Récupération du nombre total de fichiers du dossier courant
  $stmt = $db->prepare('SELECT COUNT(*) FROM files WHERE parent_id = ?');
  $stmt->execute([$parentId]);
  $totalFiles = $stmt->fetchColumn();
  //print_r($totalFiles);
  // Calcul du nombre de pages nécessaires
  $totalPages = ceil($totalFiles / $filesPerPage);

  // Vérification que la page demandée existe
  if ($page < 1 || $page > $totalPages) {
    $page = 1;
  }

  // Calcul de l'offset pour la clause LIMIT de la requête SQL
  $offset = ($page - 1) * $filesPerPage;

  // Si aucun nom de fichier n'est spécifié, afficher tous les fichiers du dossier courant
  if (!isset($_GET['search'])) {
  // Récupération de la liste des fichiers du dossier courant pour la page demandée
  $stmt = $db->prepare('SELECT * FROM files WHERE parent_id = '.$parentId.' LIMIT '.$filesPerPage.' OFFSET '.$offset.'');
  $stmt->execute();
  //var_dump($stmt);
  $files = $stmt->fetchAll();
 //echo"je suis laaaaaaaaaaaaaa";
  //var_dump($files);
  //print_r($files);

  }elseif (empty($_GET['search'])) {
  	echo "Veuillez inserer le nom.ext du fichiers que vous vous Rechercher";
  }else {
    // Recherche de fichiers par nom
    //$stmt = $db->prepare('SELECT * FROM files WHERE parent_id = '.$parentId.' AND name LIKE '. $_GET['search'] .' ? LIMIT '.$filesPerPage.' OFFSET '.$offset.'');
    $stmt = $db->prepare('SELECT * FROM files WHERE parent_id = ? AND name LIKE ? LIMIT ? OFFSET ?');
	$stmt->bindValue(1, $parentId, PDO::PARAM_INT);
	$stmt->bindValue(2, '%' . $_GET['search'] . '%', PDO::PARAM_STR);
	$stmt->bindValue(3, $filesPerPage, PDO::PARAM_INT);
	$stmt->bindValue(4, $offset, PDO::PARAM_INT);
	$stmt->execute();
	$files = $stmt->fetchAll();
    //var_dump($parentId);
    //print_r($files);
  }

  // Si il y a des fichiers, on les affiche
  if (count($files) > 0) {
  	//echo '<ul class="files">'; // Encapsulation de la liste de fichiers dans une ul
  	echo"<div class='col-sm-12'>
  		<table class='table table-striped'>
     		<thead>
     			<tr>
	        		<th>name</th>
	        		<th>Taille</th>
	    		</tr>
     		</thead>";
     echo'<tbody>';
    foreach ($files as $file) {
    	echo'<tr>';
      echo '<td><img style="height: 20px;" src="/icons/text.gif"></img>' . $file['name'] . '</td>
     		<td> '. $file['size'] .' </td>
            </tr>';
    }
    echo'</tbody></table>';
    echo '</div>';
  } else {
  echo "Aucun fichier trouvé pour le nom '" . htmlspecialchars($_GET['search']) . "'";
}

  // Affichage de la pagination

echo'<nav aria-label="Page navigation" style="width:50%;">
  <ul class="pagination justify-content-end" style="margin-left:40px">';

if ($page > 1){ 

echo'<li class="page-item">
	<a type ="button" class="page-link" href="?dir=' . $parentId . '&page=' . $page - 1 . '"> 
	    <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
    </a>';
}

else{

	echo'<li class="page-item disabled">
		<a type ="button" class="page-link">
		    <span aria-hidden="true">&laquo;</span>
	        <span class="sr-only">Previous</span>
	    </a>';
	}

echo'</li>';


for($i = 1; $i <= $totalPages; $i++):

	//echo'<li class="page-item"><a href="?dir=' . $parentId . '&page=' . $i . '"> '.$i.' </a></li>';
	echo '<li class="page-item"><a href="?' . http_build_query(['dir' => $parentId, 'page' => $i, 'search' => $_GET['search']]) . '">' . $i . '</a></li>'; 

endfor;


if ($page < $totalPages){

	echo'<li class="page-item">
		<a type ="button" class="page-link" href="?dir=' . $parentId . '&page=' . $page + 1 . '">
		    <span aria-hidden="true">&raquo;</span>
	        <span class="sr-only">Next</span>
	    </a>';
	}

else{

	echo'<li class="page-item disabled">
		<a type ="button" class="page-link">        
		    <span aria-hidden="true">&raquo;</span>
	        <span class="sr-only">Next</span>
	    </a>';

	}
	echo'</ul>
	</nav>';
}
///////////Ajout de fichiers///////////////////
function addFile($fileName,$size,$parentId) {
  global $db;

  // Préparation de la requête d'insertion
  $stmt = $db->prepare('INSERT INTO files (name, size, parent_id) VALUES (?, ?, ?)');
  // Exécution de la requête avec les valeurs fournies en paramètres
  $stmt->execute([$fileName,$size,$parentId]);
  var_dump($stmt);
}

///////////Ajout de dossiers///////////////////
function addFolder($name, $parentId) {
  global $db;

  // Préparation de la requête d'insertion
  $stmt = $db->prepare('INSERT INTO folders (name, parent_id) VALUES (?, ?)');
  // Exécution de la requête avec les valeurs fournies en entrée
  $stmt->execute([$name, $parentId]);
}

///////////s'assurer qu'un dossier existe avant de lui en ajouter un autre//////////////
function folderExists($folderId) {
  global $db;
  // Préparation de la requête de sélection
  $stmt = $db->prepare('SELECT COUNT(*) FROM folders WHERE id_folder = ?');
  // Exécution de la requête avec l'ID du dossier en paramètre
  $stmt->execute([$folderId]);
  // Récupération du résultat
  $count = $stmt->fetchColumn();
  // Si le compte est supérieur à 0, le dossier existe
  return $count > 0;
}

// Récupération de l'ID du dossier courant (si fourni)
$currentDirId = isset($_GET['dir']) ? (int)$_GET['dir'] : 0;

// Récupération de la page demandée (si fournie)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;





echo '<div class="left-side">';
echo'<h2>Mes dossiers</h2>';
// Ajout d'un bouton pour revenir au dossier racine
echo '<a href="?dir=0">Retour au dossier racine</a>';
// On affiche le contenu du dossier courant
displayDirectory(0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Récupération du nom et de l'ID du dossier parent à partir du formulaire
  $name = $_POST['name'];
  $parentId = $_POST['parentId'];

  // Vérification du nom du dossier
  if (empty($name)) {
    echo "Vous n'avez pas mis de nom, Veuillez entrer un nom de dossier valide.";
  }
  // Vérification de l'ID du dossier parent
  else if (!folderExists($parentId)) {
    echo "Le dossier parent n'existe pas.";
  }
  // Si les valeurs sont valides, ajout du nouveau dossier
  else {
    addFolder($name, $parentId);
    header('Location: ' . $_SERVER['REQUEST_URI']);
  }
}

echo'<form action="" method="POST">
  
  <label for="name">Nom du dossier :</label>
  <input type="text" name="name" id="name">
  
  <label for="parentId">ID du dossier parent :</label>
  <input type="number" name="parentId" id="parentId">
  <!-- Bouton de soumission du formulaire -->
  <button type="submit">Ajouter le dossier</button>
</form>';

echo '</div>';




echo '<div class="right-side">';
echo'<h2 style="margin-left:20px">Mes fichiers</h2>';

// Si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Vérification que le fichier a bien été sélectionné
  if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
    // Récupération du nom du fichier envoyé
    $fileName = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    //$doc = dirname($_FILES['file']['size']);
    var_dump($pathe);
    // Ajout du fichier à la base de données
    addFile($fileName,$size, $currentDirId);
    // Redirection vers la page courante (pour éviter qu'un fichier soit ajouté plusieurs fois lors de l'actualisation de la page)
    header('Location: ' . $_SERVER['REQUEST_URI']);
    //exit;
    //$_POST['file'] = "";
  } else {
    // Si aucun fichier n'a été sélectionné, afficher un message d'erreur
    echo 'Veuillez sélectionner un fichier à ajouter';
  }
}

echo'<form class="form-inline" style="margin-left:20px;width:30%" method="GET">
<div class="form-group mx-sm-3 mb-2">
  <input type="hidden" name="dir" value="'. htmlspecialchars($currentDirId) .'">
  <label for="exampleInputEmail1">Rechercher :</label>
  <input class="form-control" type="text" name="search" id="search">
  </div>
  <button class="btn btn-primary mb-2" type="submit" style="margin-bottom:-6%;">Rechercher</button>
</form>';

echo'
<form style="margin-left:20px" method="post" enctype="multipart/form-data">
	<div class="form-group">
	  <input type="file" name="file"/>
	  <input type="submit" value="Ajouter le fichier"/>
  	</div>
</form>';
// On affiche les fichiers du dossier courant
displayFiles($currentDirId, $page);
echo '</div>';

include("footer.php");
?>