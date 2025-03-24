<?php
if (isset($_POST['login']) || isset($_POST['refresh'])) {	
	include_once('togetherness25.php');
}

$guest = "";
if (isset($_COOKIE["guest"])) {
	$guest = $_COOKIE["guest"];
}

$repliesSelect = "SELECT first_name, last_name, rsvp, note FROM guests ORDER BY first_name ASC";
$repliesResult = dbQuery($repliesSelect);
$yesRSVP = "";
$noRSVP = "";
$emptyRSVP = "";

while($row = mysqli_fetch_array($repliesResult)) {
	$name = $row[0].' '.substr($row[1],0,1);
	$rsvp = $row[2];
	$note = $row[3];
	$html = "<li>".$name;
	
	if ($note != "" && $note != "None") {
		$html .= ": ".$note;
	}
	
	$html .= "</li>";
	
	if ($note != null) {
		$note = stripslashes(nl2br($note));
	}
	
	if ($rsvp == "Yes") {
		$yesRSVP .= $html;
	} elseif ($rsvp == "No") {
		$noRSVP .= $html;
	} else {
		$emptyRSVP .= $html;
	}
} ?>

<?php if ($guest == "") { ?>
	<h1>Not Logged In</h1>
<?php } else { ?>
	<h1>RSVP</h1>
	<div class="rsvp__container">
		<?php include('rsvp-actions.php'); ?>
	</div>
	<?php if ($yesRSVP != "") { ?>
		<h2>Yes RSVP</h2>
		<ul>
			<?php echo($yesRSVP); ?>
		</ul>
	<?php }
	if ($noRSVP != "") { ?>
		<h2>No RSVP</h2>
		<ul>
			<?php echo($noRSVP); ?>
		</ul>
	<?php }
	if ($emptyRSVP != "") { ?>
		<h2>Empty RSVP</h2>
		<ul>
			<?php echo($emptyRSVP); ?>
		</ul>
	<?php } 
}?>