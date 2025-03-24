<?php

if (isset($_POST['guest'])) {
	require('togetherness25.php');
}

$guest = $_POST['guest'];
	
if (isset($_COOKIE["guest"])) {
	$uuid = $_COOKIE["guest"];
}
else {
	$uuid = "";
}

if ($uuid != $guest) {
	$select = "SELECT * FROM guests WHERE uuid = '$guest'";
	$result = dbQuery($select);

	if (mysqli_num_rows($result) != 0) {
		setcookie("guest","",time()-3600,"/");
		setcookie("guest", $guest,time()+15552000,"/");
	}
	else {
		setcookie("guest","",time()-3600,"/");
		$uuid = "";
	}
}

?>