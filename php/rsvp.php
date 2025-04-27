<?php
if (isset($_POST['login']) || isset($_POST['refresh'])) {	
	include_once('togetherness25.php');
}

$rsvpContainerClass = "";
if (isset($_POST['refresh'])) {
	$rsvpContainerClass = "rsvp__container--enter";
}

$guest = "";
if (isset($_COOKIE["guest"])) {
	$guest = $_COOKIE["guest"];
}

$repliesSelect = "SELECT first_name, last_name, rsvp, note, adults, children FROM guests ORDER BY first_name ASC";
$repliesResult = dbQuery($repliesSelect);
$yesRSVP = "";
$noRSVP = "";
$emptyRSVP = "";

while($row = mysqli_fetch_array($repliesResult)) {
	$name = $row[0].' '.substr($row[1],0,1);
	$rsvp = $row[2];
	$note = $row[3];
	$guestCount = $row[4]+$row[5];
	
	if ($note != null) {
		$note = stripslashes(nl2br($note));
	}
	
	$html = "<li><strong>".$name."</strong>";
	
	if ($rsvp == "Yes" && $guestCount != 0) {
		$html .= " ($guestCount)";
	}
	
	if ($note != "" && $note != "None") {
		$html .= "<span class=\"rsvp-list__note\">".$note."</span>";
	}
	
	$html .= "</li>";
	
	if ($rsvp == "Yes") {
		$yesRSVP .= $html;
	} elseif ($rsvp == "No") {
		$noRSVP .= $html;
	} else {
		$emptyRSVP .= $html;
	}
} ?>

			<div class="page__icon">
				<a href="/"><img src="/images/stars-rsvp.png" alt="Stars"></a>
			</div>
			<div class="page__content">
				<h1>RSVP</h1>
				<?php if ($guest == "") { ?>
					<p>Please use the RSVP link sent to you via email to RSVP and view the guest list. Contact Josh or Kris if you did not receive a RSVP email or need the link again.</p>
				<?php } else { ?>
					<p>Kindly RSVP by July 31. You'll be able to edit your RSVP after submitting if needed. We're looking forward to seeing many of you this October!</p>
					<div class="rsvp">
						<div class="rsvp__container<?php if ($rsvpContainerClass != "") { echo(" $rsvpContainerClass"); } ?>"">
							<?php include('rsvp-actions.php'); ?>
						</div>
					</div>
					<?php if ($yesRSVP != "") { ?>
						<h2>Party Posse</h2>
						<ul class="rsvp-list">
							<?php echo($yesRSVP); ?>
						</ul>
						<hr>
					<?php }
					if ($noRSVP != "") { ?>
						<h2>Regrets</h2>
						<ul class="rsvp-list">
							<?php echo($noRSVP); ?>
						</ul>
						<hr>
					<?php }
					if ($emptyRSVP != "") { ?>
						<h2>Waiting Room</h2>
						<ul class="rsvp-list rsvp-list--waiting">
							<?php echo($emptyRSVP); ?>
						</ul>
					<?php } 
				}?>
			</div>