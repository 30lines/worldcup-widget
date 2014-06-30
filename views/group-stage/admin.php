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
	$selectedGroup	= ($instance['selected_group']) ?: '0';
	$theme			= ($instance['theme']) ?: 0; 

?>
<div class="worldcup-admin">

	<div class="theme">
		<label for="<?php echo $this->get_field_name('theme'); ?>">Theme:</label>
		<select id="<?php echo $this->get_field_id('theme'); ?>" name="<?php echo $this->get_field_name('theme'); ?>">
			<?php foreach($themes as $possible) { ?>
				<option <?php if($possible == $theme) { echo 'selected'; } ?> value="<?php echo $possible; ?>"><?php echo $possible;?></option>
			<?php } ?>
		</select>
	</div>
	<div class="groupstage-pick">
		<div class="group">
			<label for="<?php echo $this->get_field_name('selected_group'); ?>">Select Group:</label>
			<select id="<?php echo $this->get_field_id('selected_group'); ?>" name="<?php echo $this->get_field_name('selected_group'); ?>">
				<option value="A" <?php if($selectedGroup == 'A') { echo 'selected'; } ?>>Group A</option>
				<option value="0" disabled>Brazil</option>
				<option value="0" disabled>Cameroon</option>
				<option value="0" disabled>Croatia</option>
				<option value="0" disabled>Mexico</option>
				<option value="B" <?php if($selectedGroup == 'B') { echo 'selected'; } ?>>Group B</option>
				<option value="0" disabled>Austrailia</option>
				<option value="0" disabled>Chile</option>
				<option value="0" disabled>Netherlands</option>
				<option value="0" disabled>Spain</option>
				<option value="C" <?php if($selectedGroup == 'C') { echo 'selected'; } ?>>Group C</option>
				<option value="0" disabled>Colombia</option>
				<option value="0" disabled>Côte d'Ivoire</option>
				<option value="0" disabled>Greece</option>
				<option value="0" disabled>Japan</option>
				<option value="D" <?php if($selectedGroup == 'D') { echo 'selected'; } ?>>Group D</option>
				<option value="0" disabled>Costa Rica</option>
				<option value="0" disabled>England</option>
				<option value="0" disabled>Italy</option>
				<option value="0" disabled>Uruguay</option>
				<option value="E" <?php if($selectedGroup == 'E') { echo 'selected'; } ?>>Group E</option>
				<option value="0" disabled>Ecuador</option>
				<option value="0" disabled>France</option>
				<option value="0" disabled>Honduras</option>
				<option value="0" disabled>Switzerland</option>
				<option value="F" <?php if($selectedGroup == 'F') { echo 'selected'; } ?>>Group F</option>
				<option value="0" disabled>Argentina</option>
				<option value="0" disabled>Bosnia and Herzegovina</option>
				<option value="0" disabled>Iran</option>
				<option value="0" disabled>Nigeria</option>
				<option value="G" <?php if($selectedGroup == 'G') { echo 'selected'; } ?>>Group G</option>
				<option value="0" disabled>Germany</option>
				<option value="0" disabled>Ghana</option>
				<option value="0" disabled>Portugal</option>
				<option value="0" disabled>United States</option>
				<option value="H" <?php if($selectedGroup == 'H') { echo 'selected'; } ?>>Group H</option>
				<option value="0" disabled>Algeria</option>
				<option value="0" disabled>Belgium</option>
				<option value="0" disabled>Korea Republic</option>
				<option value="0" disabled>Russia</option>
			</select>
		</div>
	</div>
</div>