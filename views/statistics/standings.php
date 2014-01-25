<?php
include_once (incDir."/header.php");
include_once (incDir."/navigation.php");
include_once (incDir."/leftbar.php");
include_once (incDir."/statisticsbar.php");
?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding">Sarjataulukko</div>
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
				$standObj = unserialize($_REQUEST["standings"]);
				foreach ($standObj as $stand) {
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
		</div>
	</div>
<?php
include_once (incDir."/footer.php");
?>