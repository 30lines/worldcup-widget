<?php


//Instance variables
$selectedGroup	= ($instance['selected_group']) ?: '0';
$theme			= ($instance['theme']) ?: 0; 


$groupStats = $this->worldcup_api_call('teams', '&sort=groupRank&group=' . $selectedGroup);

?>

<div class="group-standings <?php echo 'theme-' . strtolower($theme);  if($selectedTeam > -1) { echo ' ' .strtolower($teams[$selectedTeam]['name']); } ?>">
	<h2>Group <?php echo $selectedGroup; ?>: Standings</h2>
	
	<div class="teamslist">
		<?php
		foreach($groupStats as $team) { ?> 
			
			<div class="team">
				<p class="group-rank"><?php echo $team['groupRank']; ?></p>

				<p class="country">
					<img class="flag" src="<?php echo plugins_url() . '/worldcup-widget/flags/' . $team['name'] . '.png';?>">

				<?php echo $team['name']; ?>
				</p>
				<p class="record">
				<span class="totals"><?php echo $team['wins'];?>-<?php echo $team['losses']; ?>-<?php echo $team['draws']; ?>
				</span>
				Goals Scored: <?php echo $team['goalsFor']; ?>
				<br>
				Goals Differential: <?php echo $team['goalsDiff']; ?>
				<br>
				Group Points: <?php echo $team['groupPoints']; ?>
				</p>

		
			</div>
		<?php 
		} ?>
	</div>
</div>