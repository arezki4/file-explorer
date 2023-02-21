<?php
function executeQueryFile($filesql) {
	$query = file_get_contents($filesql);
	$array = explode(";\n", $query);
	$b = true;
	for ($i=0; $i < count($array) ; $i++) {
		$str = $array[$i];
	if ($str != '') {
		$str .= ';';
		$b &= mysql_query($str);
	}

	return $b;
	}
}
//executeQueryFile('sql/Arbo4.sql');
//executeQueryFile('sql/Arborescence3.sql');

include("recursive.php");
?>