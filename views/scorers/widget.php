<?php

$selectedTeam = ($instance['selected_team']) ?: '0'; 
$theme = ($instance['theme']) ?: 0; 
$playercount = ($instance['playercount']) ?: 0; 
$show_emblem = ($instance['show_emblem']) ?: 0; 



$cachedTeams = $this->get_widget_path() . '/views/api/teams.json';
$response = file_get_contents($cachedTeams);

$teams = json_decode($response, TRUE);

$displayTeam = $teams[$selectedTeam];

if($selectedTeam == -1) {
	$topScorers = $this->worldcup_api_call('players', '&fields=firstName,lastName,nickname,goals,penaltyGoals,assists,position,age,nationality,image&limit=' . $playercount . '&sort=goals,-1');
} else {
	$topScorers = $this->worldcup_api_call('players', '&fields=firstName,lastName,nickname,goals,penaltyGoals,assists,position,age,nationality,image&nationality=' . urlencode($displayTeam['name']) .'&limit=' . $playercount . '&sort=goals,-1');
}
?>

<div class="top-scorers <?php echo 'theme-' . strtolower($theme);  if($selectedTeam > -1) { echo ' ' .strtolower($teams[$selectedTeam]['name']); } ?>">
	<h2>Top Scorers<?php if($selectedTeam > -1) { echo ' for ' . $displayTeam['name']; } else { echo ' in World Cup 2014';} ?> </h2>
	<?php if($selectedTeam > -1 && $show_emblem) { ?>
		<img src="<?php echo $displayTeam['logo']; ?>" />
	<?php } elseif( $selectedTeam == -1 && $show_emblem) { ?>
		<img src="<?php echo plugins_url() . '/worldcup-widget/flags/golden-boot.png'; ?>" />
	<?php } ?>
	<div class="playerlist">
		<?php
		if($playercount > 1) {
		foreach($topScorers as $player) { ?> 
			<?php if($player['goals']) { ?>
			<div class="player">
				<a href="#">
					<img class="profile" src="<?php echo $player['image']; ?>">
					<span class="nickname"><?php echo $player['nickname']; ?></span> <span class="goal-count"><?php echo $player['goals']; ?></span>
					<img class="flag" src="<?php echo plugins_url() . '/worldcup-widget/flags/' . $player['nationality'] . '.png';?>">
					<span class="nationality"><?php echo $player['nationality'];?></span>
				</a>
				<div class="extra-stats">
					<h3><?php echo $player['firstName']; ?> <?php echo $player['lastName']; ?></h3>
					<p>Age: <?php echo $player['age']; ?></p>
					<p>Assists: <?php echo $player['assists']; ?></p>
					<p>Penalty Goals: <?php echo $player['penaltyGoals']; ?></p>
					<p>Position: <?php echo $player['position']; ?></p>
				</div>
			</div>
			<?php } ?>
		<?php 
		}
		} else { 
			$player = $topScorers; ?>
			<div class="player">
				<img class="profile" src="<?php echo $player['image']; ?>">
				<span class="nickname"><?php echo $player['nickname']; ?></span> - <span class="goal-count"><?php echo $player['goals']; ?></span>
				<img class="flag" src="<?php echo plugins_url() . '/worldcup-widget/flags/' . $player['nationality'] . '.png';?>">
			</div>
			<?php
		} ?>
	</div>

</div>