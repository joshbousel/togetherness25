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
$firstName = $row[0];
$lastName = $row[1];
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
		<legend>Will we see you at the party on October 11?</legend>
		<div class="rsvp__container__fields">
			<div class="rsvp__container__fields__field">
				<input type="radio" id="rsvp-yes" name="rsvp" value="Yes"<?php if ($rsvp == "Yes"){ echo(" checked"); }?>> <label for="rsvp-yes">I'll be there</label>
			</div>
			<div class="rsvp__container__fields__field">
				<input type="radio" id="rsvp-no" name="rsvp" value="No"<?php if ($rsvp == "No"){ echo(" checked"); }?>> <label for="rsvp-no">Can't make it</label>
			</div>
		</div>
	</fieldset>
	<fieldset name="quantity">
		<legend>How many will be in your group? <span>Partners, dates, and children are all welcome.</span></legend>
		<div class="rsvp__container__fields">
			<div class="rsvp__container__fields__field">
				Adults
				<select id="adults" name="adults">
					<?php for ($x = 1; $x <= 5; $x++) { ?>
						<option value="<?php echo($x); ?>"<?php if ($adults == $x){ echo(" selected"); }?>><?php echo($x); ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="rsvp__container__fields__field">
				Children
				<select id="children" name="children">
					<?php for ($x = 0; $x <= 5; $x++) { ?>
						<option value="<?php echo($x); ?>"<?php if ($children == $x){ echo(" selected"); }?>><?php echo($x); ?></option>
					<?php } ?>
				</select>	
			</div>
		</div>
	</fieldset>
	<fieldset name="transportation">
		<legend>Would like to take the bus? <span>The bus will depart and return to the Aloft Downtown Durham.</span></legend>
		<div class="rsvp__container__fields">
			<div class="rsvp__container__fields__field">
				<input type="radio" id="bus" name="transportation" value="Bus"<?php if ($transportation == "Bus"){ echo(" checked"); }?>> <label for="bus">Yes, I'll take the bus</label>
			</div>
			<div class="rsvp__container__fields__field">
				<input type="radio" id="car" name="transportation" value="Car"<?php if ($transportation == "Car"){ echo(" checked"); }?>> <label for="car">No thanks</label>
			</div>
		</div>
	</fieldset>
	<fieldset name="carpool" class="hidden">
		<legend>If you plan on driving, would you be willing to give a lift to someone to or from the party?</legend>
		<div class="rsvp__container__fields">
			<div class="rsvp__container__fields__field">
				<input type="radio" id="carpool-yes" name="carpool" value="Yes"<?php if ($carpool == "Yes"){ echo(" checked"); }?>> <label for="carpool-yes">Sure</label>
			</div>
			<div class="rsvp__container__fields__field">
				<input type="radio" id="carpool-no" name="carpool" value="No"<?php if ($carpool == "No"){ echo(" checked"); }?>> <label for="carpool-no">Prefer not</label>
			</div>
			<div class="rsvp__container__fields__field">
				<input type="radio" id="carpool-na" name="carpool" value="N/A"<?php if ($carpool == "N/A"){ echo(" checked"); }?>> <label for="carpool-na">Doesn't Apply</label>
			</div>
		</div>
	</fieldset>
	<fieldset name="note">
		<legend>If you’d like to leave a note, this is your space<span>This will display to all guests</span></legend>
		<textarea name="note"><?php echo($note); ?></textarea>
	</fieldset>
	<fieldset>
		<div class="rsvp__container__fields">
			<div class="rsvp__container__fields__field">
				<a href="#" class="rsvp__container__rsvp-save btn">Submit</a>
			</div>
			<div class="rsvp__container__fields__field">
				<a href="#" class="rsvp__container__rsvp-cancel btn btn--secondary">Cancel</a>
			</div>
		</div>
	</fieldset>
<?php } else {
	if ($rsvp == "") { ?>
	<h2>Hiya <?php echo($firstName); ?></h2>
	<p>Will we see you at the party on October 11?</p>
	<div class="rsvp__container__fields">
		<div class="rsvp__container__fields__field">
			<a href="#" class="rsvp__container__attending btn" data-rsvp="Yes">I'll Be There</a>
		</div>
		<div class="rsvp__container__fields__field">
			<a href="#" class="rsvp__container__attending btn" data-rsvp="No">Can't Make It</a>
		</div>
	</div>
	<?php } else { 
		if ($rsvp == "Yes") {
			if ($adults == "") { ?>
				<h2>Awesome!</h2>
				<p>How many will be in your group?<br>Partners, dates, and children are all welcome.</p>
				<div class="rsvp__container__fields">
					<div class="rsvp__container__fields__field">
						Adults
						<select name="adults">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
					</div>
					<div class="rsvp__container__fields__field">
						Children
						<select name="children">
							<option value="0">0</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>	
					</div>
					<div class="rsvp__container__fields__field">
						<a href="#" class="rsvp__container__quanity btn">Next</a>
					</div>
				</div>
			<?php } else {
				if ($transportation == "") { ?>
					<h2>Let’s get you there</h2>
					<p>We’ll be offering a bus leaving from the Aloft Downtown Durham to and from the party for those without a car or would prefer not to drive. Are you interested in taking the bus?</p>
					<div class="rsvp__container__fields">
						<div class="rsvp__container__fields__field">
							<a href="#" class="rsvp__container__transportation btn" data-transportation="Bus">Yes, I'll take the bus</a>
						</div>
						<div class="rsvp__container__fields__field">
							<a href="#" class="rsvp__container__transportation btn" data-transportation="Car">No thanks</a>
						</div>
					</div>
				<?php } else {
					if ($transportation == "Car" && $carpool == "") { ?>
						<h2>C'mon and join our convoy</h2>
						<p>If you plan on driving, would you be willing to give a lift to someone to or from the party?</p>
						<div class="rsvp__container__fields">
							<div class="rsvp__container__fields__field">
								<a href="#" class="rsvp__container__carpool btn" data-carpool="Yes">Sure</a>
							</div>
							<div class="rsvp__container__fields__field">
								<a href="#" class="rsvp__container__carpool btn" data-carpool="No">Prefer Not</a>
							</div>
							<div class="rsvp__container__fields__field">
								<a href="#" class="rsvp__container__carpool btn" data-carpool="N/A">Doesn't Apply</a>
							</div>
						</div>
					<?php } else { 
						if ($note == "") { ?>
							<h2>One last thing...</h2>
							<p>If you’d like to leave a note, this is your space: (this will display to all guests)</p>
							<div class="rsvp__container__fields">
								<div class="rsvp__container__fields__field rsvp__container__fields__field--full">
									<textarea name="note"></textarea>
								</div>
								<div class="rsvp__container__fields__field">
									<a href="#" class="rsvp__container_note btn">Submit</a>
								</div>
								<div class="rsvp__container__fields__field">
									<a href="#" class="rsvp__container_note btn btn--secondary">Skip</a>
								</div>
							</div>
						<?php } else { ?>
							<h2>Thanks <?php echo($firstName); ?></h2>
							<p>We look forward to seeing you in October!</p>
							<p><a href="#" class="rsvp__container__edit btn">Edit your RSVP</a></p>
						<?php }
					}
				}
			}
		} else {
			if ($note == "") { ?>
				<h2>Just one more thing...</h2>
				<p>If you’d like to leave a note, this is your space: (this will display to all guests)</p>
				<div class="rsvp__container__fields">
					<div class="rsvp__container__fields__field rsvp__container__fields__field--full">
						<textarea name="note"></textarea>
					</div>
					<div class="rsvp__container__fields__field">
						<a href="#" class="rsvp__container_note btn">Submit</a>
					</div>
					<div class="rsvp__container__fields__field">
						<a href="#" class="rsvp__container_note btn btn--secondary">Skip</a>
					</div>
				</div>
			<?php } else { ?>
				<h2>Thanks <?php echo($firstName); ?></h3>
				<p><a href="#" class="rsvp__container__edit btn">Edit your RSVP</a></p>
			<?php }
		}	
	}
} ?>