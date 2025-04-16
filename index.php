<?php 

require("php/togetherness25.php");

if (isset($_GET['path'])) {
	$path = $_GET['path'];
} else {
	$path = "/";
}

buildPage($path);

?>