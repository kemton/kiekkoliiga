<div id="right">
<!--	
<div class="box">
	<div class="top">
		<div class="padding">Otsake</div>
	</div>
	<div class="content">

	</div>
</div>
-->
<?php
foreach ($_REQUEST["standingsList"] as $value) {
	$teamList = unserialize($value);
	echo "<div class=\"box\">
			<div class=\"top\">
				<div class=\"padding\">Sarjan nimi</div>
			</div>\n
			<table class=\"sarjataulukko cellpadding_cellspacing  nopadding all\">
				<thead class=\"head\">
					<tr>
						<th></th>
						<th><div class=\"joukkue\">Nimi</div></th>
						<th><div class=\"ottelut\">O</div></th>
						<th><div class=\"maaliero\">+/-</div></th>
						<th><div class=\"pisteet\">P</div></th>
					</tr>
				</thead>
				<tbody>";
	$i=0;
	foreach ($teamList as $stand) {
		$team = unserialize($stand->__get('team'));
		
		if ($stand->__get('goalDifference') > 0) {
			$goalDifference = "<span class=\"green\">+{$stand->__get('goalDifference')}</span>";
		} else if ($stand->__get('goalDifference') == 0) {
			$goalDifference = "<span class=\"blue\">{$stand->__get('goalDifference')}</span>";
		} else {
			$goalDifference = "<span class=\"red\">{$stand->__get('goalDifference')}</span>";
		}
		
		$pointsWithoutPenalty = ($stand->__get('wins')*winPoints) + $stand->__get('draws');
		
		if ($pointsWithoutPenalty <> $stand->__get('points')) {
			$points = "<span class=\"red\">{$stand->__get('points')}</span>";
		} else {
			$points = $stand->__get('points');
		}
		
		echo "<tr class=\"team".($i%2 ? '2' : '')."\">";
		$logo = logosmall($team->__get('id'), 12, 1);
		echo "
		<td><div class=\"logo\">{$logo}</div></td>
		<td><div class=\"joukkue\"><a href=\"/team/{$team->__get('name')}\">{$team->__get('name')}</a></div></td>
		<td><div class=\"ottelut\">{$stand->__get('matches')}</div></td>
		<td><div class=\"maaliero center\">{$goalDifference}</div></td>
		<td><div class=\"pisteet\">{$points}</div></td>
	</tr>\n";
	$i++;
	}
	echo "</tbody>
		</table>
	</div>\n";
}


/*
	<div class="box">
		<div class="top">
			<div class="padding">Liiga</div>
		</div>
			<table class="sarjataulukko cellpadding_cellspacing  nopadding all">
				<thead class="head">
					<tr>
						<th></th>
						<th><div class="joukkue">Nimi</div></th>
						<th><div class="ottelut">O</div></th>
						<th><div class="maaliero">+/-</div></th>
						<th><div class="pisteet">P</div></th>
					</tr>
				</thead>
				<tbody>
				<?php
				$lastFour = count($_REQUEST["firstDivisionStandings"]) - 4;
				foreach($_REQUEST["leagueStandings"] as $key=>$value){
					$goalDifference = $value["tehdyt"] - $value["paastetyt"];
					if (strlen($value["nimi"]) >= 19) {
						$teamName = trim(substr($value["nimi"], 0, 15)).".";
					} else {
						$teamName = $value["nimi"];
					}
					if ($goalDifference > 0) {
						$goalDifference = '<span class="green">+'.$goalDifference.'</span>';
					} else if ($goalDifference == 0) {
						$goalDifference = '<span class="blue">'.$goalDifference.'</span>';
					} else {
						$goalDifference = '<span class="red">'.$goalDifference.'</span>';
					}
					$matches = $value["voitot"] + $value["tasapelit"] + $value["tappiot"];
					echo '<tr class="team'; if($key % 2 <> 0) echo '2';
					if($lastFour <= $key){
						echo ' team_red';
					}else if($key > 7){
						echo ' team_yellow';
					}
					echo '">
					<td><div class="logo">'.logosmall($value["joukkueID"]).'</div></td>
					<td><div class="joukkue">'.$teamName.'</div></td>
					<td><div class="ottelut">'.$matches.'</div></td>
					<td><div class="maaliero center">'.$goalDifference.'</div></td>
					<td><div class="pisteet">'.$value["pisteet"].'</div></td>
					</tr>';
				}
				?>
				</tbody>
			</table>
	</div>

	<div class="box">
		<div class="top">
			<div class="padding">1. Divari</div>
		</div>
			<table class="sarjataulukko cellpadding_cellspacing  nopadding all">
				<thead class="head">
					<tr>
						<th></th>
						<th><div class="joukkue">Nimi</div></th>
						<th><div class="ottelut">O</div></th>
						<th><div class="maaliero">+/-</div></th>
						<th><div class="pisteet">P</div></th>
					</tr>
				</thead>
				<tbody>
				<?php
				$lastFour = count($_REQUEST["firstDivisionStandings"]) - 4;
				foreach($_REQUEST["firstDivisionStandings"] as $key=>$value){
					$goalDifference = $value["tehdyt"] - $value["paastetyt"];
					if (strlen($value["nimi"]) >= 19) {
						$teamName = trim(substr($value["nimi"], 0, 15)).".";
					} else {
						$teamName = $value["nimi"];
					}
					if ($goalDifference > 0) {
						$goalDifference = '<span class="green">+'.$goalDifference.'</span>';
					} else if ($goalDifference == 0) {
						$goalDifference = '<span class="blue">'.$goalDifference.'</span>';
					} else {
						$goalDifference = '<span class="red">'.$goalDifference.'</span>';
					}
					$matches = $value["voitot"] + $value["tasapelit"] + $value["tappiot"];
					echo '<tr class="team'; if($key % 2 <> 0) echo '2';
					if($lastFour <= $key){
						echo ' team_red';
					}else if($key > 7){
						echo ' team_yellow';
					}
					echo '">
					<td><div class="logo">'.logosmall($value["joukkueID"]).'</div></td>
					<td><div class="joukkue">'.$teamName.'</div></td>
					<td><div class="ottelut">'.$matches.'</div></td>
					<td><div class="maaliero center">'.$goalDifference.'</div></td>
					<td><div class="pisteet">'.$value["pisteet"].'</div></td>
					</tr>';
				}
				?>
				</tbody>
			</table>
	</div>
	
	<div class="box">
		<div class="top">
			<div class="padding">2. Divari</div>
		</div>
			<table class="sarjataulukko cellpadding_cellspacing  nopadding all">
				<thead class="head">
					<tr>
						<th></th>
						<th><div class="joukkue">Nimi</div></th>
						<th><div class="ottelut">O</div></th>
						<th><div class="maaliero">+/-</div></th>
						<th><div class="pisteet">P</div></th>
					</tr>
				</thead>
				<tbody>
				<?php
				$lastFour = count($_REQUEST["secondDivisionStandings"]) - 4;
				foreach($_REQUEST["secondDivisionStandings"] as $key=>$value){
					$goalDifference = $value["tehdyt"] - $value["paastetyt"];
					if (strlen($value["nimi"]) >= 19) {
						$teamName = trim(substr($value["nimi"], 0, 15)).".";
					} else {
						$teamName = $value["nimi"];
					}
					if ($goalDifference > 0) {
						$goalDifference = '<span class="green">+'.$goalDifference.'</span>';
					} else if ($goalDifference == 0) {
						$goalDifference = '<span class="blue">'.$goalDifference.'</span>';
					} else {
						$goalDifference = '<span class="red">'.$goalDifference.'</span>';
					}
					$matches = $value["voitot"] + $value["tasapelit"] + $value["tappiot"];
					echo '<tr class="team'; if($key % 2 <> 0) echo '2';
					if($lastFour <= $key){
						echo ' team_red';
					}else if($key > 7){
						echo ' team_yellow';
					}
					echo '">
					<td><div class="logo">'.logosmall($value["joukkueID"]).'</div></td>
					<td><div class="joukkue">'.$teamName.'</div></td>
					<td><div class="ottelut">'.$matches.'</div></td>
					<td><div class="maaliero center">'.$goalDifference.'</div></td>
					<td><div class="pisteet">'.$value["pisteet"].'</div></td>
					</tr>';
				}
				?>
				</tbody>
			</table>
	</div>

*/
?>
</div>
