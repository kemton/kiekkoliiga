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
	/*foreach ($_REQUEST["leagueStandings"] as $key => $value) {
		echo "<strong>Johto</strong> - ".$value["pvm"]."<br />";
		echo '<a href="?action='.$value["tiedoteID"].'"><i>'.$value["otsikko"].'</i></a><br /><br />';
	}*/
?>							
	<div class="box">
		<div class="top">
			<div class="padding">Liiga</div>
		</div>
		<div class="content">
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
				foreach($_REQUEST["leagueStandings"] as $key=>$value){
					$matches = $value["voitot"] + $value["tasapelit"] + $value["tappiot"];
					$plusminus = $value["tehdyt"] - $value["paastetyt"];
					echo '<tr class="team'; if($key % 2 <> 0) echo '2'; echo '">
					<td><div class="logo"></div></td>
					<td><div class="joukkue">'.$value["nimi"].'</div></td>
					<td><div class="ottelut">'.$matches.'</div></td>
					<td><div class="maaliero center">'.$plusminus.'</div></td>
					<td><div class="pisteet">'.$value["pisteet"].'</div></td>
					</tr>';
				}
				?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="box">
		<div class="top">
			<div class="padding">1. Divari</div>
		</div>
		<div class="content">
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
				foreach($_REQUEST["firstDivisionStandings"] as $key=>$value){
					$matches = $value["voitot"] + $value["tasapelit"] + $value["tappiot"];
					$plusminus = $value["tehdyt"] - $value["paastetyt"];
					echo '<tr class="team'; if($key % 2 <> 0) echo '2'; echo '">
					<td><div class="logo"></div></td>
					<td><div class="joukkue">'.$value["nimi"].'</div></td>
					<td><div class="ottelut">'.$matches.'</div></td>
					<td><div class="maaliero center">'.$plusminus.'</div></td>
					<td><div class="pisteet">'.$value["pisteet"].'</div></td>
					</tr>';
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="box">
		<div class="top">
			<div class="padding">2. Divari</div>
		</div>
		<div class="content">
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
				foreach($_REQUEST["secondDivisionStandings"] as $key=>$value){
					$matches = $value["voitot"] + $value["tasapelit"] + $value["tappiot"];
					$plusminus = $value["tehdyt"] - $value["paastetyt"];
					echo '<tr class="team'; if($key % 2 <> 0) echo '2'; echo '">
					<td><div class="logo"></div></td>
					<td><div class="joukkue">'.$value["nimi"].'</div></td>
					<td><div class="ottelut">'.$matches.'</div></td>
					<td><div class="maaliero center">'.$plusminus.'</div></td>
					<td><div class="pisteet">'.$value["pisteet"].'</div></td>
					</tr>';
				}
				?>
				</tbody>
			</table>
		</div>
	</div>

</div>
