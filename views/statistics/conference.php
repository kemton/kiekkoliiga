<?php
include_once (incDir."/header.php");
include_once (incDir."/navigation.php");
include_once (incDir."/leftbar.php");
include_once (incDir."/statisticsbar.php");
?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding">Conference</div>
		</div>
		<div class="content">
			<table class="statistics" width="100%">
			<tr>
				<th width="3%" class="left">#</th>
				<th width="25%" class="left">joukkue</th>
				<th width="7%" class="left">ott</th>
				<th width="7%" class="left">v</th>
				<th width="7%" class="left">t</th>
				<th width="7%" class="left">h</th>
				<th width="9%" class="left">tm</th>
				<th width="9%" class="left">pm</th>
				<th width="8%" class="left">pist</th>
				<th width="9%" class="left">maaliero</th>
				<th width="9%" class="left">pist/ott</th>
			</tr>
			<?php
			$i=1;
			foreach (unserialize($_REQUEST["conferenceStanding"]) as $stand) {
				$team = $stand->__get('team');
				if ($i%2) {
					echo '<tr class="odd">';
				} else {
					echo '<tr class="even">';
				}
				if (strlen($team->__get('name')) >= 17) {
					$teamName = $team->__get('abbreviation');
				} else {
					$teamName = $team->__get('name');
				}
				$logo = logosmall($team->__get('id'));
				
				echo "
					<td>{$i}.</td>
					<td>{$logo}<a title=\"{$team->__get('name')}\" href=\"/team/{$team->__get('name')}\">{$teamName}</a></td>
					<td>{$stand->__get('matches')}</td>
					<td>{$stand->__get('wins')}</td>
					<td>{$stand->__get('draws')}</td>
					<td>{$stand->__get('losses')}</td>
					<td>{$stand->__get('goals')}</td>
					<td>{$stand->__get('goalsAgainst')}</td>
					<td>{$stand->__get('points')}</td>";
					
				if ($stand->__get('goalDifference') > 0) {
					echo "<td align=\"center\"><span class=\"green\">+{$stand->__get('goalDifference')}</span></td>";
				} else if ($stand->__get('goalDifference') == 0) {
					echo "<td align=\"center\"><span class=\"blue\">{$stand->__get('goalDifference')}</span></td>";
				} else {
					echo "<td align=\"center\"><span class=\"red\">{$stand->__get('goalDifference')}</span></td>";
				}
				
				echo "<td>{$stand->__get('scoresPerMatch')}</td>
				</tr>";
				
				$i++;
			}
			?>
			</table>
			<br />
			<table class="jeah">
				<thead>
					<tr>
						<td width="75"><a href=""><b>aika</b></td>
						<td width="29%"><a href=""><b>koti</b></td>
						<td width="29%"><a href=""><b>vieras</b></td>
						<td align="center" width="15%"><b>tulos</b></td>
						<td width="75">&nbsp;</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=1;
					foreach (unserialize($_REQUEST["conferenceMatches"]) as $match) {
						if ($i%2) {
							echo '<tr class="odd">';
						} else {
							echo '<tr class="even">';
						}
						if (($match->__get("report") != null) ? true : false) {
							$isReport = '*';
						} else {
							$isReport = '';
						}
						
						$homeTeam = $match->__get("homeTeam");
						$visitorTeam = $match->__get("visitorTeam");
						$homeLogo = logosmall($homeTeam->__get("id"));
						$visitorLogo = logosmall($visitorTeam->__get("id"));
						
						echo "
							<td>{$match->__get("date")}</td>
							<td>{$homeLogo}<a href=\"/team/{$homeTeam->__get("name")}\">{$homeTeam->__get("name")}</a></td>
							<td>{$visitorLogo}<a href=\"/team/{$visitorTeam->__get("name")}\">{$visitorTeam->__get("name")}</a></td>
							<td align=\"center\">{$match->__get("homeTeamGoals")} - {$match->__get("visitorTeamGoals")}</td>
							<td><a href=\"/statistics/ottelu/{$match->__get("id")}\">tilastot</a>({$match->__get("comments")}){$isReport}</td>
						</tr>";
						$i++;
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
<?php
include_once (incDir."/footer.php");
?>