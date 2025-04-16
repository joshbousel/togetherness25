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

			<div class="page__icon">
				<img src="/images/heart-full.png" alt="Heart">
			</div>
			<div class="page__content">
				<h1>RSVP</h1>
				<?php if ($guest == "") { ?>
					<h1>Not Logged In</h1>
				<?php } else { ?>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					<div class="rsvp__container">
						<?php include('rsvp-actions.php'); ?>
					</div>
					<?php if ($yesRSVP != "") { ?>
						<h2>Party Posse</h2>
						<ul>
							<?php echo($yesRSVP); ?>
						</ul>
					<?php }
					if ($noRSVP != "") { ?>
						<h2>Regrets</h2>
						<ul>
							<?php echo($noRSVP); ?>
						</ul>
					<?php }
					if ($emptyRSVP != "") { ?>
						<h2>Waiting Room</h2>
						<ul>
							<?php echo($emptyRSVP); ?>
						</ul>
					<?php } 
				}?>
			</div>