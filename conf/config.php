<?php
$dbuser="steel";
$dbpass="3Td6yPpjLZCduMCA";
$dbhost="localhost";
$dbname="steel";

function myconnect(){
	global $dbuser, $dbpass, $dbhost, $dbname, $connect;
	$connect=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	if (!$connect) die ("Nem lehet csatlakozni az adatbázishoz!");
	return ($connect);
}

function myquery(){
	global $connect;
	$args=func_get_args();
	$tmp=explode("?", $args[0]);
	$query=$tmp[0];
	for ($i=1; $i<count($tmp); $i++){
		$query.=htmlspecialchars(mysqli_real_escape_string($connect, $args[$i]));
		$query.=$tmp[$i];

	}
	//print $query; //ellenőrzés
	$result=mysqli_query($connect, $query);
	if (mysqli_error($connect)){
		print mysqli_error($connect);
		return false;
	} else {
		$return = array();
		while ($line = mysqli_fetch_assoc($result)){
			$return[] = $line;
		}
		return $return;
	}

}

function myinsertid(){
	global $connect;
	return mysqli_insert_id($connect);
}

function myclose(){
	global $connect;
	mysqli_close($connect);

	}
?>