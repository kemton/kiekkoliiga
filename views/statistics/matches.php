<?php include_once (incDir."/statisticsbar.php"); ?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding">Ottelut</div>
		</div>
		<div class="content">
			<h4>Ottelut</h4>
			* = Ottelusta on kirjoitettuna raportti<br />
			(x) = Kommenttien määrä<br /><br />
			
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
					foreach (unserialize($_REQUEST["matches"]) as $match) {
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