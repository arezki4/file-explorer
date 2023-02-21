<?php

  # project: eBrigade
  # homepage: https://ebrigade.app
  # version: 5.6

  # Copyright (C) 2004, 2022 Nicolas MARCHE (eBrigade Technologies)
  # This program is free software; you can redistribute it and/or modify
  # it under the terms of the GNU General Public License as published by
  # the Free Software Foundation; either version 3 of the License, or
  # (at your option) any later version.
  #
  # This program is distributed in the hope that it will be useful,
  # but WITHOUT ANY WARRANTY; without even the implied warranty of
  # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  # GNU General Public License for more details.
  # You should have received a copy of the GNU General Public License
  # along with this program; If not, see https://www.gnu.org/licenses/.
  
  
include_once ("config.php");
check_all(18);
$nomenu=1;
writehead();
?>
<script>
function suppress(cat_old, child) {
    url_yes ="del_edit_categorie_vehicule.php?cat_old="+cat_old+"&child="+child;
    url_no ="parametrage.php?tab=1&child=3&ope=edit_cat";
    swalWarning("Êtes-vous sûr de vouloir supprimer cette catégorie?<br>Tous les éléments de cette catégorie seront <br>supprimés.",url_yes,url_no,'supprimer')
}
</script>
<?php
if (isset($_POST['TV_USAGE_PREV'])) $cat_old = secure_input($dbc,$_POST["TV_USAGE_PREV"]);
else $cat_old = '';
if (isset($_POST['TV_USAGE'])) $cat_value = secure_input($dbc, $_POST['TV_USAGE']);
else $cat_value = '';
if (isset($_POST['CV_DESCRIPTION'])) $cat_description = secure_input($dbc, $_POST['CV_DESCRIPTION']);
else $cat_description = '';
if (isset($_POST['logo'])) $logo = secure_input($dbc, $_POST['logo']);
else $logo = '';
if (isset($_POST['icon'])) $icone = secure_input($dbc, $_POST['icon']);
else $icone = '';
if (isset($_POST['Delete'])) $del = secure_input($dbc, $_POST['Delete']);
else $del = '';
if (isset($_POST['child'])) $child = $_POST['child'];
else if(isset($_GET['child'])) $child = secure_input($dbc, $_GET['child']);
else $child = 1;


$cat_old = STR_replace("\"","",$cat_old);
$cat_value = STR_replace("\"","",$cat_value);
$cat_description = STR_replace("\"","",$cat_description);
$logo = STR_replace("\"","",$logo);
$icone = STR_replace("\"","",$icone);

//=====================================================================
// New categorie
//=====================================================================

if (($cat_description == '' || $cat_value == '') && $del == '') {
    write_msgbox("erreur","","Veuillez remplir tous les champs avec un $asterisk <p align=center>
    <a href='javascript:history.back()'><input type='submit' class='btn btn-secondary' value='Retour'></a>",30,30);
    exit();
}

if ($cat_old === 'Nouvelle catégorie') {
    $query = "INSERT INTO categorie_vehicule(TV_USAGE, CV_DESCRIPTION, PICTURE, CV_ICON) VALUES (\"".$cat_value."\", \"".$cat_description."\", \"".$logo."\", \"".$icone."\")";
    $result = mysqli_query($dbc, $query);

    insert_log("UPDPARAM", 0, "Création catégorie véhicule");
}

//=====================================================================
// Rename categorie
//=====================================================================

if ($cat_old <> '' && $cat_value <> '') {
    if ($cat_old != $cat_value) {
        $query = "UPDATE type_vehicule SET TV_USAGE = \"".$cat_value."\" WHERE type_vehicule.TV_USAGE = \"".$cat_old."\""; 
        $result = mysqli_query($dbc, $query);
        $query = "UPDATE categorie_vehicule SET TV_USAGE = \"".$cat_value."\" WHERE categorie_vehicule.TV_USAGE = \"".$cat_old."\""; 
        $result = mysqli_query($dbc, $query);

        insert_log("UPDPARAM", 0, "Modification catégorie véhicule");
    }
}

//=====================================================================
// Rename description
//=====================================================================

if ($cat_old <> '' && $cat_value <> '') {
    if ($cat_old != $cat_value) {
        $cat_old = $cat_value;
    }
    $query = "UPDATE categorie_vehicule SET CV_DESCRIPTION = \"".$cat_description."\" WHERE categorie_vehicule.TV_USAGE = \"".$cat_old."\""; 
    $result = mysqli_query($dbc, $query);
}

//=====================================================================
// Update logo
//=====================================================================

if ($del == '') {
    $query = "UPDATE categorie_vehicule SET PICTURE = \"".$logo."\" WHERE categorie_vehicule.TV_USAGE = \"".$cat_old."\"";
    $result = mysqli_query($dbc, $query);
}

//=====================================================================
// Update icone
//=====================================================================

if ($del == '') {
    $query = "UPDATE categorie_vehicule SET CV_ICON = \"".$icone."\" WHERE categorie_vehicule.TV_USAGE = \"".$cat_old."\"";
    $result = mysqli_query($dbc, $query);
}

//=====================================================================
// Fichier
//=====================================================================

//deplacer le fichier
if(isset($_FILES['fileicon'])){

    //si ce dossier n'existe pas, on le créé
    if (!is_dir('./images/vehicules/iconespersos')) mkdir("./images/vehicules/iconespersos", 0755, true);

    //sauvegarder le meme nom en bdd (à la place du champs PICTURE)
    $iconeName=time();
    $res_file = move_uploaded_file($_FILES['fileicon']['tmp_name'], "./images/vehicules/iconespersos/".$iconeName.".png");
    if(!$res_file){
        write_msgbox("erreur","","Fichier non sauvegardé <p align=center>
        <a href='javascript:history.back()'><input type='submit' class='btn btn-secondary' value='Retour'></a>",30,30);
        exit();
    }  
}

//=====================================================================
// Redirect
//===================================================================== 
if ($del === 'Supprimer'){
    $cat_old = str_replace(' ','%20',$cat_old);
    //cas de l'apostrophe
    $cat_old = str_replace("'", '%27', $cat_old);
    echo "<body onload=suppress('".$cat_old."',$child)>";
}
else 
  header("Location: parametrage.php?tab=3&child=".$child."&ope=edit_cat");
exit();
?>