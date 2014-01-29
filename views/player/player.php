<?php
$player = unserialize($_REQUEST["playerStats"]);
$team = $player->__get("team");
?>
<div class="box">
	<div class="top">
		<div class="padding">Tilastot</div>
	</div>
	<div class="content">
<?php if ($team->__get("id") <> 0) { ?>
<div width="40%" style="border: 1px solid #c0c7cc; float:right;">
	<div class="rivi">
		<div align="left" rowspan="5" width="120"><img src="/images/logos/<?php echo $team->__get("id"); ?>.gif" width="120" height="120" align="left" hspace="20" /></div>
		<div align="center"><?php echo "<a href=\"/team/{$team->__get("name")}\">{$team->__get("name")}</a>"; ?></div>
	</div>
</div>
<?php
}
echo("<h2>{$player->__get("name")}</h2>");
$previousNames = $player->__get("previousNames");
if ($previousNames) {
	echo "Entiset nickit: {$previousNames}<br />";
}
echo "<a href=\"/player/{$player->__get("name")}/achievements\">Saavutukset</a>";

/**** Achievements ****/
$achievements = $player->__get('achievements');
if ($achievements <> NULL) {
	echo "<h4>Saavutukset:</h4>";
	foreach ($achievements as $ach) {
		$season = $ach->__get('season');
		echo "{$season->__get('name')} - {$ach->__get('name')} joukkueessa {$ach->__get('team')}<br />";
	}
}
/**** Achievements end ****/
?>

<?php
/**** Rangaistukset ****/
$user = unserialize($_SESSION["user"]);
if (!empty($_REQUEST["playerSuspensions"]) && $user->isAdmin()) {
	echo "<h4>Rangaistukset:</h4>";
	foreach ($_REQUEST["playerSuspensions"] as $value) {
		echo "<span class=\"red\">".date('m/Y', strtotime($value["aika"])).": ".$value["kielto"]." - ".$value["pituus"]." ".$value["tapa"]."</span><br />";
	}
}
/**** Rangaistukset loppuu ****/
?>

<!-- StatsPerSeason -->
<h4>Tilastot</h4>
<table class="jeah" width="100%">
	<thead>
		<tr>
			<th>kausi</th><th>joukkue</th><th>ottelut</th><th>maalit</th><th>syötöt</th><th>pisteet</th><th>+/-</th>
		</tr>
	</thead>
	<tbody>
<?php
$i=0;
$playerStatsPerSeason = $player->__get('statsPerSeason');
foreach ($playerStatsPerSeason as $stats) {
	$season = $stats->__get('season');
	$team = $stats->__get('team');
	
	if ($i%2 == 1) {
		echo "<tr class=\"even\">";
	} else {
		echo "<tr class=\"odd\">";
	}
	
	$logo = logosmall($team->__get('id'));
	echo "
		<td>{$season->__get('name')} {$stats->__get('leagueLevel')}</td>
		<td>{$logo}<a href=\"/team/{$team->__get('name')}\">{$team->__get('name')}</a></td>
		<td style=\"text-align:center\">{$stats->__get('matches')}</td>
		<td style=\"text-align:center\">{$stats->__get('goals')}</td>
		<td style=\"text-align:center\">{$stats->__get('assists')}</td>
		<td style=\"text-align:center\">{$stats->__get('points')}</td>";
	if ($stats->__get('plusMinus') == NULL) {
		echo "<td>-</td>";
	} elseif ($stats->__get('plusMinus') == 0) {
		echo "<td><span class=\"blue\">0</span></td>";
	} elseif ($stats->__get('plusMinus') > 0) {
			echo"<td><span class=\"green\">+{$stats->__get('plusMinus')}</span></td>";
	} else {
		echo"<td><span class=\"red\">{$stats->__get('plusMinus')}</span></td>";
	}
	echo "</tr>";
	$i++;
}

?>
	</tbody>
</table>
<!-- StatsPerSeason end -->

<!-- Yhteistilastot -->
<h4>Yhteistilastot:</h4>
<table class="jeah" width="70%">
	<thead>
		<tr>
			<th>sarja</th><th>ottelut</th><th>maalit</th><th>+</th><th>syötöt</th><th>=</th><th>pisteet</th>
		</tr>
	</thead>
	<tbody>
<?php
$totalMatches = 0;
$totalGoals = 0;
$totalPasses = 0;
$totalPoints = 0;
$i=0;
$totalStats = $player->__get('leagueTotalStats');
foreach ($totalStats as $stats) {
	if ($i%2 == 1) {
		echo "<tr class=\"even\">";
	} else {
		echo "<tr class=\"odd\">";
	}
	echo "
		<td>yht. {$stats->__get('league')}</td>
		<td>{$stats->__get('matches')}</td>
		<td>{$stats->__get('goals')}</td>
		<td>+</td>
		<td>{$stats->__get('assists')}</td>
		<td>=</td>
		<td>{$stats->__get('points')}</td>";
	echo "</tr>";
	$totalMatches += $stats->__get('matches');
	$totalGoals += $stats->__get('goals');
	$totalPasses += $stats->__get('assists');
	$totalPoints += $stats->__get('points');
	$i++;
}

echo "<tr>
		<td>(yhteensä)</td><td>{$totalMatches}</td><td>{$totalGoals}</td><td>+</td><td>{$totalPasses}</td><td>=</td><td>{$totalPoints}</td>
	</tr>";
?>
	</tbody>
</table>
<!-- Yhteistilastot loppuu -->

<!-- Viimesimmät ottelut -->
<h4>Viimeisimmät ottelut:</h4>
<table class="jeah" width="100%">
	<thead>
		<tr>
			<th>pvm</th><th>ottelut</th><th>tulos</th><th>tehot</th><th>+/-</th>
		</tr>
	</thead>
	<tbody>
<?php
$i=0;
$lastMatches = $player->__get('lastMatches');
foreach ($lastMatches as $match) {
	
	if ($i%2 == 1) {
		echo "<tr class=\"even\">";
	} else {
		echo "<tr class=\"odd\">";
	}
	
	$homeTeam = $match->__get('homeTeam');
	$homeTeamLogo = logosmall($homeTeam->__get('id'));
	
	$visitorTeam = $match->__get('visitorTeam');
	$visitorTeamLogo = logosmall($visitorTeam->__get('id'));
	
	// Haetaan kumpi joukkueista on pelaajan
	$homeTeamPlayersList = $homeTeam->__get('players');
	foreach ($homeTeamPlayersList as $homeTeamPlayer) {
		if ($homeTeamPlayer->__get('id') == $player->__get("id")) {
			$matchPlayerTeamId = $homeTeam->__get('id');
		}
	}
	if ($matchPlayerTeamId == '') {
		$matchPlayerTeamId = $visitorTeam->__get('id');
	}
	
	
	
	
	// Haetaan pelaajan tilastot
	// EI TOIMI VIELÄ!!!!! Koska saa väärän joukkueID:n vanhan jengin otteluista!
	$playerGoals=0;
	$playerAssists=0;
	$playerPlusMinus=0;
	$playerTeam=0;
	$check = true;
	$homeTeamMatchPlayersList = $match->__get('homeTeamMatchPlayers');
	foreach ($homeTeamMatchPlayersList as $homeTeamMatchPlayer) {
		$homeTeamPlayer = $homeTeamMatchPlayer->__get('player');
		
		if ($homeTeamPlayer->__get('id') == $player->__get('id')) {
			$playerGoals = $homeTeamMatchPlayer->__get('goals');
			$playerAssists = $homeTeamMatchPlayer->__get('assists');
			$playerPlusMinus = $homeTeamMatchPlayer->__get('plusminus');
			$playerTeam = $homeTeamPlayer->__get('id');
			$check = false;
			break;
		}
	}
	if ($check == true) {
		$visitorTeamMatchPlayersList = $match->__get('visitorTeamMatchPlayers');
		foreach ($visitorTeamMatchPlayersList as $visitorTeamMatchPlayer) {
			$visitorTeamMatchPlayer = $visitorTeamMatchPlayer;
			$visitorTeamPlayer = $visitorTeamMatchPlayer->__get('player');
			
			if ($visitorTeamPlayer->__get('id') == $player->__get('id')) {
				$playerGoals = $visitorTeamMatchPlayer->__get('goals');
				$playerAssists = $visitorTeamMatchPlayer->__get('assists');
				$playerPlusMinus = $visitorTeamMatchPlayer->__get('plusminus');
				$playerTeam = $visitorTeamPlayer->__get('id');
				break;
			}
		}
	}
	// EI TOIMI YLÄPUOLELLA !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	
	
	
	
	
	
	echo "
		<td>{$match->__get('date')}</td>
		<td>{$homeTeamLogo}<a href=\"/team/{$homeTeam->__get('name')}\">{$homeTeam->__get('name')}</a> - 
		{$visitorTeamLogo}<a href=\"/team/{$visitorTeam->__get('name')}\">{$visitorTeam->__get('name')}</a></td>";
		
	// Haetaan maalit ja jos oma joukkue voitti näytetään se vihreällä, tappiot punasella ja tasapelit sinisenä
	echo "<td><a href=\"/statistics/ottelu/{$match->__get('id')}\">";
	if ($homeTeam->__get('id') == $matchPlayerTeamId) {
		if ($match->__get('homeTeamGoals') > $match->__get('visitorTeamGoals')) {
			echo "<span class=\"green\">{$match->__get('homeTeamGoals')} - {$match->__get('visitorTeamGoals')}</span>";
		} elseif ($match->__get('homeTeamGoals') == $match->__get('visitorTeamGoals')) {
			echo "<span class=\"blue\"><span class=\"blue\">{$match->__get('homeTeamGoals')} - {$match->__get('visitorTeamGoals')}</span>";
		} else {
			echo "<span class=\"red\">{$match->__get('homeTeamGoals')} - {$match->__get('visitorTeamGoals')}</span>";
		}
	} else {
		if ($match->__get('homeTeamGoals') > $match->__get('visitorTeamGoals')) {
			echo "<span class=\"red\">{$match->__get('homeTeamGoals')} - {$match->__get('visitorTeamGoals')}</span>";
		} elseif ($match->__get('homeTeamGoals') == $match->__get('visitorTeamGoals')) {
			echo "<span class=\"blue\">{$match->__get('homeTeamGoals')} - {$match->__get('visitorTeamGoals')}</span>";
		} else {
			echo "<span class=\"green\">{$match->__get('homeTeamGoals')} - {$match->__get('visitorTeamGoals')}</span>";
		}
	}
	echo "</a></td>";
	
	echo "<td>{$playerGoals}+{$playerAssists}</td>";
	
	if ($playerPlusMinus == NULL) {
		echo "<td>-</td>";
	} elseif ($playerPlusMinus == 0) {
		echo "<td><span class=\"blue\">0</span></td>";
	} else {
		if($playerPlusMinus > 0) {
			echo"<td><span class=\"green\">+{$playerPlusMinus}</span></td>";
		} else {
			echo"<td><span class=\"red\">{$playerPlusMinus}</span></td>";
		}
	}
	echo "</tr>";
	$i++;
}
?>
	</tbody>
</table>

<?php
$kiekkoPlayer = $player->__get('kiekkoPlayer');
if (!$kiekkoPlayer->__get('hideStats')) {
?>
<!-- Kiekkotilastot -->
<h4>Kiekko.tk tilastot:</h4>
<table class="jeah" width="70%">
	<thead>
		<tr>
			<th>joukkue</th><th>maalit</th><th></th><th>syötöt</th><th></th><th>yhteensä</th><th>+/-</th>
		</tr>
	</thead>
	<tbody>
<?php
$i=0;
$totalGoals=0;
$totalAssists=0;
$totalPoints=0;
$totalPlusminus=0;
foreach ($kiekkoPlayer->__get('kiekkoPlayerStats') as $stats) {
	if ($i%2 == 1) {
		echo "<tr class=\"even\">";
	} else {
		echo "<tr class=\"odd\">";
	}
	
	echo "
		<td>{$stats->getTeamName($stats->__get('team'))}</td>
		<td>{$stats->__get('goals')}</td>
		<td>+</td>
		<td>{$stats->__get('assists')}</td>
		<td>=</td>
		<td>{$stats->__get('points')}</td>
		<td>{$stats->__get('plusminus')}</td>";
	echo "</tr>";
	$totalGoals += $stats->__get('goals');
	$totalAssists += $stats->__get('assists');
	$totalPoints += $stats->__get('points');
	$totalPlusminus += $stats->__get('plusminus');
	$i++;
}

echo "<tr>
		<td>(yhteensä)</td><td>{$totalGoals}</td><td>+</td><td>{$totalAssists}</td><td>=</td><td>{$totalPoints}</td><td>{$totalPlusminus}</td>
	</tr>";
?>
	</tbody>
</table>
<!-- Kiekkotilastot loppuu -->

<?php } ?>
		</div>
	</div>