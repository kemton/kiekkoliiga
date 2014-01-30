<div class="box">
	<div class="top">
		<div class="padding">Tilastot</div>
	</div>
	<div class="content">

<?php
$team = unserialize($_REQUEST["team"]);
$teamId = $team->__get("id");
if (!$teamId){
	die ("Joukkuetta ei löytynyt.");
}

$name = $team->__get("name");
$abbreviation = $team->__get("abbreviation");
$homeJersey = $team->__get("homeJersey");
$guestJersey = $team->__get("guestJersey");
$irc = $team->__get("ircChannel");

if($homeJersey == ""){ $homeJersey = "-"; }
if($guestJersey == ""){ $guestJersey = "-"; }
if($irc == ""){ $irc = "-"; }

$irc = strip_tags($irc);

echo "<h2>{$name}</h2>\n";

echo '<table width="100%" style="border: 1px solid #c0c7cc;">
<tr class="rivi">';

$filename =  $_SERVER['DOCUMENT_ROOT'] . "/images/logos/".$teamId.".gif";
if (file_exists($filename)) {
	$showlogo = "/images/logos/".$teamId.".gif";
}else $showlogo = false;

if($showlogo != false){
	echo '<td align="left" rowspan="5" width="120">';
	echo "<img src=\"{$showlogo}\" width=\"120\" height=\"120\" align=\"left\" hspace=\"20\" />";
	echo '</td>';
}

$players = $team->__get("players");

echo '<td width="1" style="padding-left: 5px;">';
echo 'Vastuuhenkilöt:</td><td>';
foreach($players as $player) {
	if($player->__get("isAdmin")) {
		$id = $player->__get("id");
		$name = $player->__get("name");
		echo("<a href=\"/player/{$name}\">{$name}</a> ");
	}
}

echo "</td></tr>";
echo "<tr><td style=\"padding-left: 5px;\">Muut pelaajat:</td><td>";
foreach($players as $player) {
	if($player->__get("isAdmin") == false) {
		$id = $player->__get("id");
		$name = $player->__get("name");
		echo("<a href=\"/player/{$name}\">{$name}</a> ");
	}
}

echo "</td></tr>";

echo "
<tr class='rivi'><td style=\"padding-left: 5px;\">Pelipaidat:</td><td>";
if($homeJersey == "-") echo "-"; else{

function zeropad($num){
   if(strlen($num) == 1) return "00000".$num;
   if(strlen($num) == 2) return "0000".$num;
   if(strlen($num) == 3) return "000".$num;
   if(strlen($num) == 4) return "00".$num;
   if(strlen($num) == 5) return "0".$num;
   if(strlen($num) == 6) return $num;
}

$erottele2 = explode("|", $homeJersey);
$malli = $erottele2[3] + 1;
echo('<div style="border: 1px solid black; margin-right: 4px; width: 12px; height: 12px; float: left; background-color: #'.zeropad(dechex(16777216 - $erottele2[0])).';"></div>');
echo('<div style="border: 1px solid black; margin-right: 4px; width: 12px; height: 12px; float: left; background-color: #'.zeropad(dechex(16777216 - $erottele2[1])).';"></div>');
echo('<div style="border: 1px solid black; margin-right: 4px; width: 12px; height: 12px; float: left; background-color: #'.zeropad(dechex(16777216 - $erottele2[2])).';"></div>');
echo('<div style="margin-right: 4px; width: 12px; height: 12px; float: left;">'.$malli.'</div>');
$erottele2 = explode("|", $guestJersey);
$malli = $erottele2[3] + 1;
echo('<div style="border: 1px solid black; margin-right: 4px; width: 12px; height: 12px; float: left; background-color: #'.zeropad(dechex(16777216 - $erottele2[0])).';"></div>');
echo('<div style="border: 1px solid black; margin-right: 4px; width: 12px; height: 12px; float: left; background-color: #'.zeropad(dechex(16777216 - $erottele2[1])).';"></div>');
echo('<div style="border: 1px solid black; margin-right: 4px; width: 12px; height: 12px; float: left; background-color: #'.zeropad(dechex(16777216 - $erottele2[2])).';"></div>');
echo('<div style="margin-right: 4px; width: 12px; height: 12px; float: left;">'.$malli.'</div>');

}

echo "</td></tr>
<tr><td style=\"padding-left: 5px;\">Lyhenne:</td><td>".$abbreviation."</td></tr>
<tr class='rivi'><td style=\"padding-left: 5px;\">IRC-kanava:</td><td>".$irc."</td></tr>";

echo "</table><br clear=\"left\"><br>";
			
			
?>





<div id="tabs">
	<ul>
	<li><a href="#tabs-1">Kausitilastot</a></li>
	<li><a href="#tabs-2">Historia</a></li>
	<li><a href="#tabs-3">Lehdistötiedotteet</a></li>
	</ul>
	<div id="tabs-1">
		<?php
		
		$teamSeasons = unserialize($_REQUEST["teamSeasons"]);

		foreach($teamSeasons as $row){
			global $mbcwf;
			$mbcwf = 0;

			$type = $row["type"];
			$competitionId = $row["competitionId"];
			$competitionName = $row["competitionName"];
			$stage = $row['stageName'];
			if ($type == 'pudotuspelit'){
				echo "<h5>{$competitionName} / ottelut:</h5>";
				printMatches($team, $competitionId, 'pp', $competitionName, $row['matches']);
			}
			else if ($type == 'ottelut'){
				echo "<h5>{$competitionName} / ottelut:</h5>";
				printMatches($team, $competitionId, 'rs', $competitionName, $row['matches']);
			}
			else if ($type == 'pisteporssi'){
				echo "<h5>{$competitionName} / tilastot:</h5>";
				printStatsPerCompetition($row['statsPlayers']);
			}
			else if ($type == 'cup2' || $type == 'yhdistetty'){
				echo "<h5>{$competitionName} ";
				if($stage != "Ottelut") {
				  echo(" - {$stage} ");
				}
				echo "/ ottelut:</h5>";
				printMatches($team, $competitionId, null, $competitionName, $row['matches']);
			}
		} 
		
		?>
	</div>
	<div id="tabs-2">
		<?php
			$history = unserialize($_REQUEST['teamHistory']);
			
			if($history['players']) {
			
				?>
				<h5>Joukkueessa pelanneet pelaajat: </h5>
				<?php
				foreach($history['players'] as $player) {
					echo("<a href='/player/{$player['name']}'>{$player['name']}</a> ");
				}
			}
			
			if($history['seasonPlacings']) {
				?>
				<h5>Sijoitukset kausittain</h5>
				<p>
				<?php
				foreach($history['seasonPlacings'] as $placing) {
					echo("{$placing['seasonName']} - {$placing['league']}n {$placing['placement']}.");
					if($placing['status']) {
						echo(" ({$placing['status']})");
					}
					echo("<br/>\n");
				}
				echo("</p>");
			}
			
			if($history['regularSeasonStatistics']) {
				?>
				<h5>Runkosarjatilastot</h5>
				<?php
				$column_options = array("", "", "", "", "", "", "", "", "", "", "");
				$first = true;
				$previous_league = "";

				foreach($history['regularSeasonStatistics'] as $season) {

					if($season["nimi"] != $previous_league and $first == false) {
						echo("</table>");
					}
					$first = false;
					
					if($season["nimi"] != $previous_league) {
						?>
						
						<table class="jeah" width="580">
						<tr>
							<th colspan="10" align="center"><?php echo($season["nimi"]); ?></th>
						</tr>
						<tr>
							<th width="12%">kausi</th>
							<th width="7%">ott</th>
							<th width="7%">v</th>
							<th width="7%">t</th>
							<th width="7%">h</th>
							<th width="10%">tm</th>
							<th width="10%">pm</th>
							<th width="8%">pist</th>
							<th width="13%">maaliero</th>
							<th width="10%">pist/ott</th>
							<th width="8%">rs. sija</th>
						</tr>
						
					<?php
					}
					$voitot = $season["voitot"];
					$tasapelit = $season["tasapelit"];
					$tappiot = $season["tappiot"]; // + $season["luovutukset"];
					$tehdyt = $season["tehdyt"];
					$paastetyt = $season["paastetyt"]; // + $season["luovutukset"]*5;
					
					$t_kausi = $season["kausi"];
					$t_ottelut = $voitot + $tasapelit + $tappiot;
					$t_pisteet = $season["pisteet"];
					
					if ($t_pisteet != 0 & $t_ottelut != 0){
						$pistott = $t_pisteet / $t_ottelut;
					}
					else {
						$pistott = 0;
					}
					
					$t_pistott = number_format($pistott, 2);
					
					$maaliero = $tehdyt - $paastetyt;
					
					if($season["sijoitus"] == "0"){ $season["sijoitus"] = "?"; }
					$t_sijoitus = $season["sijoitus"] . ".";
					
					if($maaliero > 0){ $t_maaliero = '<span class="green">+'.$maaliero.'</span>'; }
					if($maaliero < 0){ $t_maaliero = '<span class="red">'.$maaliero.'</span>'; }
					if($maaliero == 0){ $t_maaliero = '<span class="blue">'.$maaliero.'</span>'; }
				
				
				
				
					$columns = array($t_kausi, $t_ottelut, $voitot, $tasapelit, $tappiot, $tehdyt, $paastetyt, $t_pisteet, $t_maaliero, $t_pistott, $t_sijoitus);
					print_row_for_table($columns, $column_options);
					$previous_league = $season["nimi"];
				}
				echo("</table>");
			}
			
			
			if($history['playoffsSeasonStatistics']) {
			
				?>
				<h5>Playoffs- ja karsintatilastot</h5>
				<?php
				foreach($history['playoffsSeasonStatistics'] as $name => $playoffs) {
				?>
					<table class="jeah" width="400">
					<tr>
						<th colspan="10" align="center"><?php echo $name ?></th>
					</tr>
					<tr>
						<th width="24%">&nbsp;</th>
						<th width="10%">ott</th>
						<th width="9%">v</th>
						<th width="9%">t</th>
						<th width="9%">h</th>
						<th width="12%">tm</th>
						<th width="12%">pm</th>
						<th width="15%">maaliero</th>
					</tr>
					
					<?php
					
					$column_options = array("", "", "", "", "", "", "");
					$columns = array("yhteensä", $playoffs['matches'], $playoffs['wins'], $playoffs['ties'], $playoffs['loses'], $playoffs['scored'], $playoffs['againstScored'], $playoffs['goalDifference']);
					print_row_for_table($columns, $column_options);
					echo("</table>");
				}
				
			}
				
		?>
	</div>
	<div id="tabs-3">
		<?php
			echo "<table width=\"100%\" class=\"lehdisto\">";
			$pressReleases = unserialize($_REQUEST["teamPressReleases"]);
			if (!$pressReleases){
				echo "Joukkue ei ole jättänyt lehdistötiedotteita.<br><br>";
			}
			
			foreach($pressReleases as $pressRelease){
				$pressRelease = $pressRelease;
				$id = $pressRelease->__get("id");
				$timestamp = $pressRelease->__get("time");
				$header = str_replace(" ", "&nbsp;", $pressRelease->__get("header"));
				$text = $pressRelease->__get("text");
				
				echo "<tr><td width=\"85\">{$timestamp}</td>";
				echo "<td><a href=\"/board-info/{$id}\">{$header}</a></td></tr>";
				
				echo "<tr><td></td><td style=\"display: none;\">" . nl2br($text) . "</td></tr>";
			}

			echo "</table>";
		?>
	</div>
</div>

<?php
function printStatsPerCompetition($statsRows){
    
    if ($statsRows > 0){ ?>
		<table class="statistics" width="100%">
	     	<tr>
				<th width="5%" class="left">#</th>
				<th width="26%" class="left">pelaaja</th>
				<th width="10%">ottelut</th>
				<th width="10%">maalit</th>
				<th width="10%">syötöt</th>
				<th width="10%">pisteet</th>
				<th width="11%">pist/ott</th>
				<th width="10%">+/-</th>
	    	</tr>
	    	<?php
	    	$i = 1;
			foreach ($statsRows as $rivi){
				$pelaajaID = $rivi["pelaajaID"];
	        	$nimi = $rivi["nimi"];
				
				$t_pelaaja = "<a href=\"/player/{$nimi}\">$nimi</a>";
				
				$pperot = number_format($rivi["pperot"], 2, '.', '');
				
				$maalierot = $rivi["maaliero"];
				if($maalierot == "") $maalierot = '<span class="nostats"><a title="ei tilastoitu">-</a></span>';
				if($maalierot > 0) $maalierot = '<span class="green">+'.$maalierot.'</span>';
				if($maalierot == 0) $maalierot = '<span class="blue">'.$maalierot.'</span>';
				if($maalierot < 0) $maalierot = '<span class="red">'.$maalierot.'</span>';
				if($maalierot == ""){ $maalierot = ""; }

				$t_rivi = array($i.".", $t_pelaaja, $rivi["ot"], $rivi["ma"], $rivi["sy"], $rivi["pt"], $pperot, $maalierot);
				$t_optiot = array("", "", ' align="center"', ' align="center"', ' align="center"', ' align="center"', ' align="center"', ' align="center"');
				
				print_row_for_table($t_rivi, $t_optiot);

				$i++;
			}
			echo "</table>";
	}
	return 0;
}

function printMatches($team, $stID, $vaihe, $tulostusjuttu, $matches){ ?>
	<table class="statistics" width="100%">
		<tr>
		<?php if ($vaihe == 'rs') { ?>
			<th width="77" class="left">pvm</th>
			<th class="left">ottelu</th>
		<?php } else { ?>
			<th width="77">pvm</th>
			<th>ottelu</th>
		<?php } ?>
			<th width="13%">tulos</th>
			<th width="13%">&nbsp;</th>
		</tr>
	
	<?php
	foreach($matches as $match) {
		$tehdyt = 0;
		$paastetyt = 0;
		$kotiID = $match->__get("homeTeam")->__get("id");
		$vierasID = $match->__get("visitorTeam")->__get("id");
		$otteluID = $match->__get("id");
		
		if ($match->__get("walkover") == 'koti'){
			$match->__set("homeTeamGoals", 5);
			$match->__set("visitorTeamGoals", 0);
		}
		else if ($match->__get("walkover") == 'vieras'){
			$match->__set("homeTeamGoals", 0);
			$match->__set("visitorTeamGoals",5);
		}

		if ($kotiID == $team->__get('id')){
			$vastus = $match->__get("visitorTeam")->__get("name");
			$vastusID = $match->__get("visitorTeam")->__get("id");
			$tehdyt = $match->__get("homeTeamGoals");
			$paastetyt = $match->__get("visitorTeamGoals");
		}
		else {
			$vastus = $match->__get("homeTeam")->__get("name");
			$vastusID = $match->__get("homeTeam")->__get("id");
			$tehdyt = $match->__get("visitorTeamGoals");
			$paastetyt = $match->__get("homeTeamGoals");
		}

		$joukkueID = $team->__get("id");
		$joukkue = $team->__get("name");
		if($kotiID == $joukkueID) {
			$t_ottelu = "".logosmall($joukkueID)."{$joukkue} - ".logosmall($vastusID)."<a href=\"/team/{$vastus}\">{$vastus}</a>";
			if($tehdyt > $paastetyt) {
				$t_tulos = "<span class=\"green\">$tehdyt - $paastetyt</span>";	
			}
			elseif($tehdyt == $paastetyt) {
				$t_tulos = "<span class=\"blue\">$tehdyt - $paastetyt</span>";
			}
			else {
				$t_tulos = "<span class=\"red\">$tehdyt - $paastetyt</span>";
			}
		}
		else {
			$t_ottelu = "".logosmall($vastusID)."<a href=\"/team/{$vastus}\">$vastus</a> - ".logosmall($joukkueID)."$joukkue";
			if($tehdyt > $paastetyt) {
				$t_tulos = "<span class=\"green\">$paastetyt - $tehdyt</span>";	
			}
			elseif($tehdyt == $paastetyt) {
				$t_tulos = "<span class=\"blue\">$paastetyt - $tehdyt</span>";
			}
			else {
				$t_tulos = "<span class=\"red\">$paastetyt - $tehdyt</span>";
			}
		}

		$t_tilastot = "<a href=\"/statistics/ottelu/{$otteluID}\">tilastot</a>";
		$t_optiot = array("", "", " align=\"center\"", " align=\"center\"");
		$t_rivi = array($match->__get("date"), $t_ottelu, $t_tulos, $t_tilastot);
		print_row_for_table($t_rivi, $t_optiot);	
	}
	echo "</table><br /><br />\n";
} ?>

		</div>
	</div>