<?php
include_once (incDir."/header.php");
include_once (incDir."/navigation.php");
include_once (incDir."/leftbar.php");
include_once (incDir."/statisticsbar.php");
?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding">Hyökkäystilastot</div>
		</div>
		<div class="content">
			<table class="st" width="100%">
				<thead>
					<tr>
						<th width="3%">#</th>
						<th width="25%">team</th>
						<th width="10%">shots</th>
						<th width="10%">goals</th>
						<th width="10%">shots/game</th>
						<th width="10%">goals/game</th>
						<th width="10%">scoring%</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=1;
					$attackStatsList = unserialize($_REQUEST["attackStats"]);
					foreach ($attackStatsList as $attackStats) {
						$team = $attackStats->__get('team');
						if (strlen($team->__get('name')) >= 19) {
							$teamName = $team->__get('abbreviation');
						} else {
							$teamName = $team->__get('name');
						}
						
						if ($i%2) {
							echo '<tr class="rivi2">';
						} else {
							echo '<tr class="rivi">';
						}
						$logo = logosmall($team->__get('id'));
						echo "
							<td>{$i}.</td>
							<td>{$logo}<a title=\"{$team->__get('name')}\" href=\"/team/'.{$team->__get('name')}\">{$teamName}</a></td>
							<td>{$attackStats->__get('shots')}</td>
							<td>{$attackStats->__get('goals')}</td>
							<td>{$attackStats->__get('shotsPerMatch')}</td>
							<td>{$attackStats->__get('goalsPerMatch')}</td>
							<td>{$attackStats->__get('scoringPercent')}%</td>
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