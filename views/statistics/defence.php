<div class="box">
	<div class="top">
		<div class="padding">Puolustustilastot</div>
	</div>
	<div class="content">
		<table class="st" width="100%">
			<thead>
				<tr>
					<th width="3%">#</th>
					<th width="25%">team</th>
					<th width="10%">saves</th>
					<th width="10%">goals against</th>
					<th width="10%">saves/game</th>
					<th width="10%">goals against/game</th>
					<th width="10%">saves%</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=1;
				$defenceStatsList = unserialize($_REQUEST["defenceStats"]);
				foreach ($defenceStatsList as $defenceStats) {
					$team = $defenceStats->__get('team');
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
						<td>{$logo}<a title=\"{$team->__get('name')}\" href=\"/team/{$team->__get('name')}\">{$teamName}</a></td>
						<td>{$defenceStats->__get('saves')}</td>
						<td>{$defenceStats->__get('goalsAgainst')}</td>
						<td>{$defenceStats->__get('savesPerMatch')}</td>
						<td>{$defenceStats->__get('goalsAgainstPerMatch')}</td>
						<td>{$defenceStats->__get('savesPercent')}%</td>
					</tr>";
					$i++;
				}
				?>
			</tbody>
		</table>
	</div>
</div>