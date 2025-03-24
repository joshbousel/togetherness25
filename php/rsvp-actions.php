<?php
$action = "";

if (isset($_POST['action'])) {
	include_once('togetherness25.php');
		
	$guest = "";
	if (isset($_COOKIE["guest"])) {
		$guest = $_COOKIE["guest"];
	}
	
	if ($_POST['action'] == "save") {
		if (isset($_POST['rsvp'])) {
			$rsvp = $_POST['rsvp'];
			$set = "rsvp = '$rsvp'";
		} elseif (isset($_POST['adults'])) {
			$adults = $_POST['adults'];
			$children = $_POST['children'];
			$set = "adults = '$adults', children = '$children'";
		} elseif (isset($_POST['transportation'])) {
			$transportation = $_POST['transportation'];
			$set = "transportation = '$transportation'";
		} elseif (isset($_POST['carpool'])) {
			$carpool = $_POST['carpool'];
			$set = "carpool = '$carpool'";
		} elseif (isset($_POST['note'])) {
			$note = $_POST['note'];
			
			if ($note == "") {
				$note = "None";
			} else {
				$note = addslashes($note);
			}
			
			$set = "note = '$note'";
		}
		
		$update = "UPDATE guests SET $set WHERE uuid = '$guest'";
		dbQuery($update);	
	} elseif ($_POST['action'] == "edit") {
		$action = "edit";
	} elseif ($_POST['action'] == "update") {
		$rsvp = $_POST['rsvp'];
		$adults = $_POST['adults'];
		$children = $_POST['children'];
		$transportation = $_POST['transportation'];
		$carpool = $_POST['carpool'];
		$note = $_POST['note'];
		
		if ($rsvp == "No") {
			$adults = null;
			$children = null;
			$transportation = null;
			$carpool = null;
		} else {
			if ($transportation == "Bus") {
				$carpool = "N/A";
			} elseif ($carpool == "") {
				$carpool = "N/A";
			}	
		}
		
		if ($note == "") {
			$note = "None";
		} else {
			$note = addslashes($note);
		}
		
		$update = "UPDATE guests SET rsvp = '$rsvp', adults = '$adults', children = '$children', transportation = '$transportation', carpool = '$carpool', note = '$note' WHERE uuid = '$guest'";
		dbQuery($update);
	}
}

$rsvpSelect = "SELECT first_name, last_name, rsvp, adults, children, transportation, carpool, note FROM guests WHERE uuid = '$guest'";
$rsvpResult = dbQuery($rsvpSelect);
$row = mysqli_fetch_array($rsvpResult);
$name = $row[0]." ".$row[1];
$rsvp = $row[2];
$adults = $row[3];
$children = $row[4];
$transportation = $row[5];
$carpool = $row[6];
$note = $row[7];

if ($note == "None") {
	$note = "";
} elseif ($note != "") {
	$note = stripslashes($note);
} ?>

<?php if ($action == "edit") { ?>
	<h2>Edit RSVP</h2>
	<fieldset>
		<legend>Will you be attending?</legend>
		<input type="radio" id="rsvp-yes" name="rsvp" value="Yes"<?php if ($rsvp == "Yes"){ echo(" checked"); }?>> <label for="rsvp-yes">Yes</label>
		<input type="radio" id="rsvp-no" name="rsvp" value="No"<?php if ($rsvp == "No"){ echo(" checked"); }?>> <label for="rsvp-no">No</label>
	</fieldset>
	<fieldset name="quantity">
		<legend>How many in your group?</legend>
		<label for="adults">Adults:</label>
		<select id="adults" name="adults">
			<?php for ($x = 1; $x <= 5; $x++) { ?>
				<option value="<?php echo($x); ?>"<?php if ($adults == $x){ echo(" selected"); }?>><?php echo($x); ?></option>
			<?php } ?>
		</select>
		<label for="children">Children:</label>
		<select id="children" name="children">
			<?php for ($x = 0; $x <= 5; $x++) { ?>
				<option value="<?php echo($x); ?>"<?php if ($children == $x){ echo(" selected"); }?>><?php echo($x); ?></option>
			<?php } ?>
		</select>
	</fieldset>
	<fieldset name="transportation">
		<legend>How do plan to travel to the party?</legend>
		<input type="radio" id="bus" name="transportation" value="Bus"<?php if ($transportation == "Bus"){ echo(" checked"); }?>> <label for="bus">Take the bus</label>
		<input type="radio" id="car" name="transportation" value="Car"<?php if ($transportation == "Car"){ echo(" checked"); }?>> <label for="car">Drive/Rideshare</label>
	</fieldset>
	<fieldset name="carpool" class="hidden">
		<legend>If you plan on driving, would you be willing to carpool?</legend>
		<input type="radio" id="carpool-yes" name="carpool" value="Yes"<?php if ($carpool == "Yes"){ echo(" checked"); }?>> <label for="carpool-yes">Yes</label>
		<input type="radio" id="carpool-no" name="carpool" value="No"<?php if ($carpool == "No"){ echo(" checked"); }?>> <label for="carpool-no">No</label>
		<input type="radio" id="carpool-na" name="carpool" value="N/A"<?php if ($carpool == "N/A"){ echo(" checked"); }?>> <label for="carpool-na">N/A</label>
	</fieldset>
	<fieldset name="note">
		<legend>Leave a public note if you feel like it</legend>
		<textarea name="note"><?php echo($note); ?></textarea>
	</fieldset>
	<p><a href="#" class="rsvp__container__rsvp-save">Submit</a> <a href="#" class="rsvp__container__rsvp-cancel">Cancel</a></p>
<?php } else {
	if ($rsvp == "") { ?>
	<h2>Hi <?php echo($name); ?></h2>
	<h3>Will you be attending?</h3>
	<a href="#" class="rsvp__container__attending" data-rsvp="Yes">Yes</a>
	<a href="#" class="rsvp__container__attending" data-rsvp="No">No</a>
	<?php } else { 
		if ($rsvp == "Yes") {
			if ($adults == "") { ?>
				<h3>How many in your group?</h3>
				<p><strong>Adults:</strong></p>
				<select name="adults">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<p><strong>Children:</strong></p>
				<select name="children">
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>	
				<a href="#" class="rsvp__container__quanity">Next</a>
			<?php } else {
				if ($transportation == "") { ?>
					<h3>How do plan to travel to the party?</h3>
					<a href="#" class="rsvp__container__transportation" data-transportation="Bus">Take the bus</a>
					<a href="#" class="rsvp__container__transportation" data-transportation="Car">Drive/Rideshare</a>
				<?php } else {
					if ($transportation == "Car" && $carpool == "") { ?>
						<h3>If you plan on driving, would you be willing to carpool?</h3>
						<a href="#" class="rsvp__container__carpool" data-carpool="Yes">Yes</a>
						<a href="#" class="rsvp__container__carpool" data-carpool="No">No</a>
						<a href="#" class="rsvp__container__carpool" data-carpool="N/A">N/A</a>
					<?php } else { 
						if ($note == "") { ?>
							<h3>Leave a public note if you feel like it</h3>
							<textarea name="note"></textarea><br>
							<a href="#" class="rsvp__container_note">Submit</a>
							<a href="#" class="rsvp__container_note">No Thanks</a>
						<?php } else { ?>
							<h3>Thanks for your RSVP <?php echo($name); ?></h3>
							<p>We look forward to seeing you in October!</p>
							<p><a href="#" class="rsvp__container__edit">Change your RSVP</a></p>
						<?php }
					}
				}
			}
		} else {
			if ($note == "") { ?>
				<h3>Leave a public note if you feel like it</h3>
				<textarea name="note"></textarea><br>
				<a href="#" class="rsvp__container_note">Submit</a>
				<a href="#" class="rsvp__container_note">No Thanks</a>
			<?php } else { ?>
				<h3>Thanks for your RSVP <?php echo($name); ?></h3>
				<p><a href="#" class="rsvp__container__edit">Change your RSVP</a></p>
			<?php }
		}	
	}
} ?>