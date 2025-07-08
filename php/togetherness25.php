<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if ($_SERVER['HTTP_HOST'] == 'dev.togetherness25.com') {	
	require ('/var/www/vhosts/bousel.com/dev.togetherness25.com/php/vars-dev.php');
} else {
	require ('/var/www/vhosts/bousel.com/togetherness25.com/php/vars-prod.php');
}

function debug_to_console($data) {
	$output = $data;
	if (is_array($output))
		$output = implode(',', $output);

	echo '<script>console.log("Debug Objects: ' . $output . '");</script>';
}

/////////////////////////////////
// Database functions          //
/////////////////////////////////

function dbQuery($statement) {
	global $DB_SERVER, $DB_LOGIN, $DB_PASSWORD, $DB;
	
	$link = mysqli_connect($DB_SERVER,$DB_LOGIN,$DB_PASSWORD,$DB);
	
	if (!$link) {
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
		
	$result = mysqli_query($link,$statement);
	mysqli_close($link);
	return $result;
}

/////////////////////////////////
// Page Building Functions     //
/////////////////////////////////

function buildPage($path) {
	global $base_url;
	
	$path = explode('/',$path);
	$page = $path[0];
	$bodyClass = "";
	
	if ($page == '') {
		$bodyClass = "home";
	}
	
	// Build the page
	include('header.php');
	
	if ($page == '') {
		include('php/home.php');
	} elseif ($page == 'explore') {
		include('php/explore.php');
	} elseif ($page == 'faqs') {
		include('php/faqs.php');
	} elseif ($page == 'partytime') {
		include('php/partytime.php');
	} elseif ($page == 'play') {
		echo('<main class="page">');
		include('php/play.php');
		echo('</main>');
	} elseif ($page == 'rsvp') {
		echo('<main class="page">');
		include('php/rsvp.php');
		echo('</main>');
	} elseif ($page == 'stay') {
		include('php/stay.php');
	}
	
	include('php/nav.php');
	include('php/footer.php');
}

?>