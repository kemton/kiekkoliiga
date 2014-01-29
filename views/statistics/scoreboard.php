<?php include_once (incDir."/statisticsbar.php"); ?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding">Pistepörssi</div>
		</div>
		<div class="content">
			<div align="left">
				<table class="jeah" width="100%">
					<tr>
						<td width="4%">#</td>
						<td width="15%"><a href=""><b>pelaaja</b></a></td>
						<td width="26%"><a href=""><b>joukkue</b></a></td>
						<td width="9%"><a href=""><b>ottelut</b></a></td>
						<td width="9%"><a href=""><b>maalit</b></a></td>
						<td width="10%"><a href=""><b>syötöt</b></a></td>
						<td width="10%"><a href=""><b>pisteet</b></a></td>
						<td width="10%"><a href=""><b>pist/ott</b></a></td>
						<td width="7%" align="center"><a href=""><b>+/-</b></a></td>
					</tr>
					<?php
					$i = 1;
					$scoreboardList = unserialize($_REQUEST["scoreboard"]);
					foreach ($scoreboardList as $scoreboard) {
						$player = $scoreboard->__get('player');
						$team = $scoreboard->__get('team');
						if (strlen($team->__get('name')) >= 19) {
							$teamName = $team->__get('abbreviation');
						} else {
							$teamName = $team->__get('name');
						}
						
						if ($i%2) {
							echo '<tr class="odd">';
						} else {
							echo '<tr class="even">';
						}
						$logo = logosmall($team->__get('id'));
						echo "
						<td class=\"num\">{$i}.</td>
						<td><a href=\"/player/{$player->__get('name')}\">{$player->__get('name')}</a></td>
						<td>{$logo}<a href=\"/team/{$team->__get('name')}\">{$teamName}</a></td>
						<td>{$scoreboard->__get('matches')}</td>
						<td>{$scoreboard->__get('goals')}</td>
						<td>{$scoreboard->__get('assists')}</td>
						<td>{$scoreboard->__get('points')}</td>
						<td>{$scoreboard->__get('pointsPerMatch')}</td>";
						
						if ($scoreboard->__get('plusMinus') > 0) {
							echo "<td align=\"center\"><span class=\"green\">+{$scoreboard->__get('plusMinus')}</span></td>";
						} else if ($scoreboard->__get('plusMinus') == 0) {
							echo "<td align=\"center\"><span class=\"blue\">{$scoreboard->__get('plusMinus')}</span></td>";
						} else {
							echo "<td align=\"center\"><span class=\"red\">{$scoreboard->__get('plusMinus')}</span></td>";
						}
						
						echo '</tr>';
						$i++;
					}?>
				</table>
			</div>

		</div>
	</div>