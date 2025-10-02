<?php
if (isset($_POST['login']) || isset($_POST['refresh'])) {	
	include_once('togetherness25.php');
}

$rsvpHTML = ["","",""];
$guest = "";
if (isset($_COOKIE["guest"])) {
	$guest = $_COOKIE["guest"];
}

if (isset($_POST['action'])) {
	include_once('togetherness25.php');
	
	if ($_POST['action'] == "save") {
		$event =  $_POST['event'];
		$rsvp =  $_POST['rsvp'];
		$update = "UPDATE guests SET $event = '$rsvp' WHERE uuid = '$guest'";
		dbQuery($update);	
	}
}

if ($guest != "") {
	$rsvpSelect = "SELECT karaoke, hike, picnic FROM guests WHERE uuid = '$guest'";
	$rsvpResult = dbQuery($rsvpSelect);
	$row = mysqli_fetch_array($rsvpResult);;
	$rsvpResponses = [$row[0],$row[1],$row[2]];
	$rsvpEvents = ['karaoke','hike','picnic'];
	
	for ($x = 0; $x < count($rsvpEvents); $x++) {
		$html = "<p class=\"rsvp-play\">";
		
		if ($rsvpResponses[$x] == "") {
			$html .= "<a href=\"#\" class=\"btn rsvp-play__action\" data-event=\"".$rsvpEvents[$x]."\" data-rsvp=\"Yes\">I'll be there!</a>";
		} elseif ($rsvpResponses[$x] == "Yes") {
			$html .= "<span class=\"rsvp-play__icon\">&#x2714;</span> <span class=\"rsvp-play__content\">Great, we'll see you there! <a href=\"#\" class=\"rsvp-play__action\" data-event=\"".$rsvpEvents[$x]."\" data-rsvp=\"No\">Sorry, can't make it anymore</a></span>";
		} else {
			$html .= "<span class=\"rsvp-play__icon\">&#x2718;</span> <span class=\"rsvp-play__content\">Sorry we'll miss you. <a href=\"#\" class=\"rsvp-play__action\" data-event=\"".$rsvpEvents[$x]."\" data-rsvp=\"Yes\">Actually, I can make it!</a></span>";
		}
		
		$html .= "</p>";
		$rsvpHTML[$x] = $html;
	}
} ?>
			<div class="page__icon">
				<a href="/"><img src="/images/star-playtime.png" alt="Star"></a>
			</div>
			<div class="page__content">
				<h1>Let's play</h1>
				<p>We’re so excited to see y’all and would love to spend time with everyone throughout the long weekend. We’re organizing a few meetups, but will also be down for ad hoc hangs Friday through Monday. If you think you may join for any of the below, please mark that you’ll be there (you must be logged in to see the RSVP button) so we can plan accordingly 😊 Can’t wait!</p>
				<hr>
				<h2>Patio Karaoke + Pizza</h2>
				<h3>Fri Oct 10 @ 5:00pm</h3>
				<p>If you want the truest Josh+Kris Durham experience, join us in our backyard <?php if ($guest != "") { echo('(that’s at <a href="https://maps.app.goo.gl/qFbCp7o1GJ7oA3vq6" target="_blank">1501 Southwood Dr</a>)'); } ?> for an evening of patio karaoke with pizza and snacks. Pizza should arrive around 5pm and we’ll get karaoke going a little after 6:30pm. We'll be out as long as people are up for hanging out, but we'll probably need to head inside or go into quiet mode around 10pm.</p>
				<?php echo($rsvpHTML[0]); ?>
				<hr>
				<h2>Morning River Walk on the Eno</h2>
				<h3>Sat Oct 11 @ 9:00am</h3>
				<p>Early risers unite for a hike along the Eno River. We'll start at the <a href="https://maps.app.goo.gl/F5gA6rBgsqRuU6Js6" target="_blank">main parking lot</a> at the <a href="https://www.ncparks.gov/state-parks/eno-river-state-park" target="_blank">Eno River State Park</a> (at the end of Cole Mill Road). From there it’s a short bit of downhill to the river and trail which is mostly an easy stroll, but does require you to walk on tree roots, rocks, and stairs at times. The full trail is just over 2 miles, but of course you’re free to go for as little or as long as you like—though some trails in the park are still closed due to recent storms, there’re many miles of open trails through the woods.</p>
				<?php echo($rsvpHTML[1]); ?>
				<hr>
				<h2>Picnic Brunch</h2>
				<h3>Sun Oct 12 @ 10:30am-12:30pm</h3>
				<p>Join us for Sunday morning hangs in the park! We’ve reserved the picnic pavilion at <a href="https://maps.app.goo.gl/NNgZR7HDkFd4iVrQ9" target="_blank">Whippoorwill Park</a> in N. Durham and will be providing some egg casseroles, biscuits, fruit, coffee, and OJ, but feel free to BYO brunch faves and other necessities.</p>
				<?php echo($rsvpHTML[2]); ?>
				<hr>
			</div>