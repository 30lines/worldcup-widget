<?php

// Stored some of the static stats/team information into a file to refrence, assuming this info wont change 
// http://worldcup.kimonolabs.com/api/teams?apikey=1c8265af34f7d6e618888652d32b20b6&sort=name&fields=name,logo,website,foundedYear,address,homeStadium,stadiumCapacity,group,id
$cachedTeams = $this->get_widget_path() . 'views/api/teams.json';
$response = file_get_contents($cachedTeams);
$teams = json_decode($response, TRUE);

$themes = array(
		'Default',
		'Dark'
	);

	//Instance variables
	$selectedTeam	= ($instance['selected_team']) ?: '0';
	$theme			= ($instance['theme']) ?: 0; 
	$playercount	= ($instance['playercount']) ?: 0; 
	$show_emblem	= ($instance['show_emblem']) ?: 0; 

?>
<div class="worldcup-admin">

	<img src="<?php echo $teams[$selectedTeam]['logo']; ?>" />
	<div class="theme">
		<label for="<?php echo $this->get_field_name('theme'); ?>">Theme:</label>
		<select id="<?php echo $this->get_field_id('theme'); ?>" name="<?php echo $this->get_field_name('theme'); ?>">
			<?php foreach($themes as $possible) { ?>
				<option <?php if($possible == $theme) { echo 'selected'; } ?> value="<?php echo $possible; ?>"><?php echo $possible;?></option>
			<?php } ?>
		</select>
	</div>
	<div class="show-emblem">
		<label for="<?php echo $this->get_field_name('show_emblem'); ?>">Show Emblem:</label>
		<input id="<?php echo $this->get_field_id('show_emblem'); ?>" name="<?php echo $this->get_field_name('show_emblem'); ?>" type="checkbox" value="1"<?php if($show_emblem) { echo " checked"; };?>>
	</div>
	<div class="favorite-team-pick">
		<div class="team">
			<label for="<?php echo $this->get_field_name('selected_team'); ?>">Select Team:</label>
			<select id="<?php echo $this->get_field_id('selected_team'); ?>" name="<?php echo $this->get_field_name('selected_team'); ?>">
				<option data-logo="" value="-1" data-id="-1">All</option>
			<?php foreach($teams as $key => $team) { ?>
				<?php $selected = ($instance['selected_team'] == $key) ? 'selected' : ''; ?>
				<option <?php echo $selected; ?> data-logo="<?php echo $team['logo'];?>" value="<?php echo $key; ?>" data-id="<?php echo $team['id'];?>"><?php echo $team['name']; ?></option>
			<?php } ?>
			</select>
		</div>
	</div>
	<div class="playercount">
		<label for="<?php echo $this->get_field_name('playercount'); ?>">Number of Scorers:</label>
		<select id="<?php echo $this->get_field_id('playercount'); ?>" name="<?php echo $this->get_field_name('playercount'); ?>">
			<?php
			$i = 1;
			while ($i <= 10) {
				?>
				<option value="<?php echo $i;?>" <?php if($playercount == $i) { echo 'selected'; } ?>><?php echo $i;?></option>
				<?php
			    $i++;
			}
			?>
		</select>
	</div>
</div>