<?php
include('header.php');
try{
	$db = new PDO('mysql:host=localhost;dbname=Arborescence','root','@A1r2e4z5k0i6');
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}catch(Exception $e){
	echo "impossible de se connecter a la base de donnée";
	echo $e->getMessage();
	die();
} 
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
<nav aria-label="Page navigation">
  <ul class="pagination justify-content-end">

<?php if ($page > 1): ?>

<li class="page-item">
	<a type ="button" class="page-link" href="?page=<?php echo $page - 1; ?>"> 
	    <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
    </a>

<?php else : ?>

<li class="page-item disabled">
	<a type ="button" class="page-link">
	    <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
    </a>

<?php endif; ?>
</li>


<?php for($i = 1; $i <= $nombreDePages; $i++):?>

	    <li class="page-item"><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li> 

<?php endfor; ?>


<?php if ($page < $nombreDePages): ?>

<li class="page-item">
	<a type ="button" class="page-link" href="?page=<?php echo $page + 1; ?>">
	    <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
    </a>

<?php else : ?>

<li class="page-item disabled">
	<a type ="button" class="page-link">        
	    <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
    </a>

<?php endif; ?>
</li>

 
 </ul>
</nav>

<?= include('footer.php'); ?>