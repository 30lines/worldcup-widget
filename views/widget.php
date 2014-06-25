<?php

$selectedTeam = ($instance['selected_team']) ?: '0'; 
$theme = ($instance['theme']) ?: 0; 
$show_matches = ($instance['show_matches']) ?: 0; 


// Stored some of the static stats/team information into a file to refrence, assuming this info wont change 
// http://worldcup.kimonolabs.com/api/teams?apikey=1c8265af34f7d6e618888652d32b20b6&sort=name&fields=name,logo,website,foundedYear,address,homeStadium,stadiumCapacity,group,id
$cachedTeams = plugin_dir_path( __FILE__ ) . 'api/teams.json';
$response = file_get_contents($cachedTeams);

$teams = json_decode($response, TRUE);

$displayTeam = $teams[$selectedTeam];



$matches = $this->worldcup_api_call('matches', '&sort=startTime&limit=400');

$live = $this->worldcup_api_call('teams', '&id=' . $teams[$selectedTeam]['id']);


$team_matches = array();



?>
<div class="favorite-team <?php echo 'theme-' . strtolower($theme); ?>">
	<!-- <h1 class="widget-title">WorldCup 2014</h1> -->
	<h2><?php echo $displayTeam['name']; ?></h2>
	<?php

	?>
	<img src="<?php echo $displayTeam['logo']; ?>" />
	
	<div class="group">
		<strong>Group: <?php echo $displayTeam['group']; ?>, Rank: <?php echo $live[0]['groupRank'];?></strong>
		<div class="record">
			Record: <?php echo $live[0]['wins']; ?>-<?php echo $live[0]['losses'];?>-<?php echo $live[0]['draws'];?>
		</div>
	</div>

<?php

		//This section needs cleaning up quite abit.
		//
if($show_matches) {
?>
	<h4>Matches</h4>
	<?php foreach ($matches as $match) {
		if($match['awayTeamId'] == $displayTeam['id'] || $match['homeTeamId'] == $displayTeam['id']) {
			array_push($team_matches, $match);
		}
	}
	foreach ($team_matches as $match) {
		
		$matchTime = DateTime::createFromFormat(
		    'U',
		    strtotime( $match['startTime'] ),
		    new DateTimeZone('UTC')
		);

		$wordpressTimezone = ( get_option('timezone_string') ) ?: 'UTC';

		$matchTime->setTimeZone(new DateTimeZone($wordpressTimezone));


		$awayTeam = $this->getTeamByIdentifier($match['awayTeamId'], $teams);
		$homeTeam = $this->getTeamByIdentifier($match['homeTeamId'], $teams);

		$winner = ($match['homeScore'] > $match['awayScore']) ? $homeTeam : 0;
		$winner = ($match['homeScore'] < $match['awayScore']) ? $awayTeam : $winner;

		$loser = ($match['homeScore'] > $match['awayScore']) ? $awayTeam : 0;
		$loser = ($match['homeScore'] < $match['awayScore']) ? $homeTeam : $loser;
			
		?>
		<div class="match<?php 
	
			if($match['status'] == 'Final') { echo ' completed'; } 
			if($winner == $selectedTeam) { echo ' winner'; } 
			if($loser == $selectedTeam) { echo ' loser'; } 
			?>" data-match-id="<?php echo $match['id']; ?>">
			<img src="<?php echo plugins_url() . '/worldcup-widget/flags/' . $teams[$homeTeam]['name'] . '.png';?>" alt="<?php echo $teams[$homeTeam]['name'];?>"> VS. 
			<img src="<?php echo plugins_url() . '/worldcup-widget/flags/' . $teams[$awayTeam]['name'] . '.png';?>" alt="<?php echo $teams[$awayTeam]['name'];?>">
			<?php if($match['status'] != 'Pre-game') { ?>
				<p class="score"><?php echo $match['homeScore'];?> - <?php echo $match['awayScore'];?></p>
				<?php if($match['currentGameMinute']) {  ?>
					<p>After <?php echo $match['currentGameMinute']; ?> minutes of play.</p>
				<?php } else { ?>
					<p><?php echo $matchTime->format('M j, Y @ g:i A'); ?></p>
				<?php } ?>
			<?php } else { ?>
				<p><?php echo $matchTime->format('M j, Y @ g:i A'); ?></p>
			<?php } ?>
		</div>
		<?php

	} 
} ?>
</div>