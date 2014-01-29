<div class="box">
	<div class="top">
		<div class="padding">Sarjataulukko</div>
	</div>
	<div class="content">
		<?php
		$standObj = unserialize($_REQUEST["playoffsStanding"]);
		foreach ($standObj as $stand) {
			echo "<div style=\"padding-bottom:30px;\">";
			$team1 = $stand->__get('team1');
			$team2 = $stand->__get('team2');
			$matches = $stand->__get('matches');
			
			$team1logo = logolarge($team1->__get('id'));
			$team2logo = logolarge($team2->__get('id'));
			
			
			echo "<div width=\"10%\" height=\"10%\" style=\"border: 1px solid #c0c7cc; float:left; margin-left:13%;\">
				<div class=\"rivi\">
				<div align=\"center\" rowspan=\"5\" width=\"120\">{$team1logo}</div>
				<div align=\"center\"><a title=\"{$team1->__get('name')}\" href=\"/team/{$team1->__get('name')}\">{$team1->__get('name')}</a></div>
				</div></div>";
			
			echo "<div style=\"float:left; margin: 55px 0px 0px 38px; font-size:250%;\">{$stand->__get('team1Wins')} - {$stand->__get('team2Wins')}</div>";
			
			echo "<div width=\"10%\" height=\"10%\" style=\"border: 1px solid #c0c7cc; float:right; margin-right:13%;\">
				<div class=\"rivi\">
				<div align=\"center\" rowspan=\"5\" width=\"120\">{$team2logo}</div>
				<div align=\"center\"><a title=\"{$team2->__get('name')}\" href=\"/team/{$team2->__get('name')}\">{$team2->__get('name')}</a></div>
				</div></div><br />";
			
			?>
			<table class="statistics" width="100%">
				<thead>
					<tr>
						<th class="left">date</th>
						<th class="left">team</th>
						<th class="left">result</th>
					</tr>
				</thead>
				<tbody>
			<?php
			$i=0;			
			foreach ($matches as $match) {
				if ($i%2) {
					echo '<tr class="odd">';
				} else {
					echo '<tr class="even">';
				}
				$homeTeam = $match->__get('homeTeam');
				$visitorTeam = $match->__get('visitorTeam');
				$homeTeamlogo = logosmall($homeTeam->__get('id'));
				$visitorTeamlogo = logosmall($visitorTeam->__get('id'));
			
				echo "<td>{$match->__get('date')}</td>
				<td><a href=\"{$homeTeam->__get('name')}\">{$homeTeamlogo}{$homeTeam->__get('name')}</a> - <a href=\"{$visitorTeam->__get('name')}\">{$visitorTeamlogo}{$visitorTeam->__get('name')}</a></td>
				<td><a href=\"/statistics/ottelu/{$match->__get('id')}\">{$match->__get('homeTeamGoals')} - {$match->__get('visitorTeamGoals')}</a></td>";
				
				echo "</tr>";
				$i++;
			}
		?>
		</tbody>
		</table>
		</div>
		<?php
		}
		?>
	</div>
</div>