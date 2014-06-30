<?php

// Stored some of the static stats/team information into a file to refrence, assuming this info wont change 
// http://worldcup.kimonolabs.com/api/teams?apikey=1c8265af34f7d6e618888652d32b20b6&sort=name&fields=name,logo,website,foundedYear,address,homeStadium,stadiumCapacity,group,id
$cachedTeams = plugin_dir_path( __FILE__ ) . 'api/teams.json';
$response = file_get_contents($cachedTeams);
$teams = json_decode($response, TRUE);

$themes = array(
		'Default',
		'Dark'
	);

	//Instance variables
	$selectedTeam	= ($instance['selected_team']) ?: '0';
	$theme			= ($instance['theme']) ?: 0; 
	$show_matches	= ($instance['show_matches']) ?: 0; 

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
	<div class="favorite-team-pick">
		<div class="team">
			<label for="<?php echo $this->get_field_name('selected_team'); ?>">Select Team:</label>
			<select id="<?php echo $this->get_field_id('selected_team'); ?>" name="<?php echo $this->get_field_name('selected_team'); ?>">
			<?php foreach($teams as $key => $team) { ?>
				<?php $selected = ($instance['selected_team'] == $key) ? 'selected' : ''; ?>
				<option <?php echo $selected; ?> data-logo="<?php echo $team['logo'];?>" value="<?php echo $key; ?>" data-id="<?php echo $team['id'];?>"><?php echo $team['name']; ?></option>
			<?php } ?>
			</select>
		</div>
	</div>
	<div class="show-matches">
		<label for="<?php echo $this->get_field_name('show_matches'); ?>">Show All Matches:</label>
		<input id="<?php echo $this->get_field_id('show_matches'); ?>" name="<?php echo $this->get_field_name('show_matches'); ?>" type="checkbox" value="1"<?php if($show_matches) { echo " checked"; };?>>
	</div>
</div>