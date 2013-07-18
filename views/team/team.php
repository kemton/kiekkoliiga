<?php
include_once (incDir."/header.php");
include_once (incDir."/navigation.php");
include_once (incDir."/leftbar.php");
include_once (incDir."/statisticsbar.php");
?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding">Tilastot</div>
		</div>
		<div class="content">
			<pre>
			<?php
			/*$team = unserialize($_REQUEST["team"]);
			
			echo "<h3>" . $team->getName() . "</h3><br >";
			echo "Vastuuhenkilöt:<br />";
			foreach ($team->getPlayers() as $value) {
				if ($value->isAdmin()) echo $value->getName()."<br />";
			}
			echo "<br />";
			echo "Pelaajat:<br />";
			foreach ($team->getPlayers() as $value) {
				if (!$value->isAdmin()) echo $value->getName()."<br />";
			}
			
			print_r($_REQUEST["teamSeasons"]);*/
			
			
			
			
			
			$team = unserialize($_REQUEST["team"]);
			$id = $team->__get("id");
			if (!$id){
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

$filename =  $_SERVER['DOCUMENT_ROOT'] . "/images/logos/".$id.".gif";
if (file_exists($filename)) {
	$showlogo = "/images/logos/".$id.".gif";
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

	$player = unserialize($player);
	if($player->__get("isAdmin")) {
		$id = $player->__get("id");
		$name = $player->__get("name");
		echo("<a href=\"/pelaaja/{$id}\">{$name}</a> ");
	}
}

echo "</td></tr>";
echo "<tr><td style=\"padding-left: 5px;\">Muut pelaajat:</td><td>";
foreach($players as $player) {
	$player = unserialize($player);
	if($player->__get("isAdmin") == false) {
		$id = $player->__get("id");
		$name = $player->__get("name");
		echo("<a href=\"/pelaaja/{$id}\">{$name}</a> ");
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

$a = array('jlnk2', 'jlnk2', 'jlnk2', 'jlnk2');

if ($tilasto == 'joukkue'){
	$a[0] = 'jlnk';
} else if ($tilasto == 'historia'){
	$a[1] = 'jlnk';
} else if ($tilasto == 'lehdisto'){
	$a[2] = 'jlnk';
} else if ($tilasto == 'alltime'){
	$a[2] = 'jlnk';
}

echo "<a class=\"" . $a[0] . "\" href=\"/tilastot/?tilasto=joukkue&id=$id&kausi=$kausi\">Kausitilastot</a> - ";
echo "<a class=\"" . $a[1] . "\" href=\"/tilastot/?tilasto=historia&id=$id&kausi=$kausi\">Joukkueen historia</a> - ";
echo "<a class=\"" . $a[2] . "\" href=\"/tilastot/?tilasto=lehdisto&id=$id&kausi=$kausi\">Lehdistötiedotteet</a>";
			
			
?>
<div id="tabs">
	<ul>
	<li><a href="#tabs-1">Kausitilastot</a></li>
	<li><a href="#tabs-2">historia</a></li>
	<li><a href="#tabs-3">Lehdistötiedotteet</a></li>
	</ul>
	<div id="tabs-1">
		
	</div>
	<div id="tabs-2">
		
	</div>
	<div id="tabs-3">
		<?php
			echo "<table width=\"100%\" class=\"lehdisto\">";
			$pressReleases = $_REQUEST["teamPressReleases"];
			if (!$pressReleases){
				echo "Joukkue ei ole jättänyt lehdistötiedotteita.<br><br>";
			}
			
			foreach($pressReleases as $pressRelease){
				$pressRelease = unserialize($pressRelease);
				print_r($pressRelease);
				$id = $pressRelease->__get("id");
				$timestamp = $pressRelase->__get("time");
				$header = str_replace(" ", "&nbsp;", $pressRelease->__get("header"));
				$text = $pressRelease->__get("text");
				
				echo "<tr><td width=\"85\">{$timestamp}</td>";
				echo "<td>TÄHÄN Javascript-aukaisu<a href=\"/board-info/{$id}\">{$header}</a></td></tr>";
				
				echo "<tr><td></td><td>" . nl2br($text) . "</td></tr>";
			}

			echo "</table>";
		?>
	</div>
</div>
			
<?php
			
			
			
			print_r($_REQUEST["teamSeasons"]);
			$haku = sql ("SELECT sarjatilasto.sarjatilastoID, sarjatilasto.tyyppi, sarja.nimi
              FROM joukkuesivu, sarjatilasto, sarja
              WHERE joukkueID = $id
              AND joukkuesivu.sarjatilastoID = sarjatilasto.sarjatilastoID
              AND sarjatilasto.sarjaID = sarja.sarjaID
              AND kausiID = $kausi
              AND primaari = 1
              ORDER BY sarjatilasto.sarjaID DESC, sarjatilasto.tyyppi");

while ($rivi = mysql_fetch_assoc($haku)){
	global $mbcwf;
	$mbcwf = 0;
	
	$tyyppi = $rivi["tyyppi"];
	$tilastoID = $rivi["sarjatilastoID"];
	$tulostus = $rivi["nimi"];
	
	if ($tyyppi == 'pudotuspelit'){
		echo "<h5>$tulostus / ottelut:</h5>";
		tulostaOttelut($id, $nimi, $tilastoID, 'pp', $kausi, $sortby, $tulostus);
	}
	else if ($tyyppi == 'ottelut' || $tyyppi == 'yhdistetty'){
		echo "<h5>$tulostus / ottelut:</h5>";
		tulostaOttelut($id, $nimi, $tilastoID, 'rs', $kausi, $sortby, $tulostus);
	}
	else if ($tyyppi == 'pisteporssi'){
		echo "<h5>$tulostus / tilastot:</h5>";
		tulostaPorssi($id, $tilastoID, $kausi);
	}
  else if ($tyyppi == 'cup'){
		echo "<h5>$tulostus / ottelut:</h5>";
		tulostaOttelut($id, $tilastoID, $kausi);
	}
}

function tulostaPorssi($joukkueID, $stID, $kau){
	$t_optiot = array("", "", " align=\"center\"", " align=\"center\"", " align=\"center\"", " align=\"center\"", " align=\"center\""," align=\"center\"");

    $porssi = sql("SELECT pelaaja.nimi AS nimi, pelaaja.pelaajaID, 
                      SUM(ottelut) AS ot, SUM(maalit) AS ma, SUM(syotot) AS sy, SUM(maalit)+SUM(syotot) AS pt,
                      (SUM(maalit)+SUM(syotot))/SUM(ottelut) AS pperot, maaliero                         
               FROM pelaaja, tehotilasto
               WHERE pelaaja.pelaajaID = tehotilasto.pelaajaID
               AND tehotilasto.joukkueID = $joukkueID
               AND sarjatilastoID = $stID
               GROUP BY pelaaja.pelaajaID
               ORDER BY pt DESC, ma DESC, ot, nimi");
    
    if (mysql_num_rows($porssi) > 0){
    	?>
		<table class="statistics" width="100%">
     	<tr>
		<th width="5%" class="left">#</a></th>
     	<th width="26%" class="left">pelaaja</a></th>
     	<th width="10%">ottelut</a></th>
     	<th width="10%">maalit</a></th>
     	<th width="10%">syötöt</a></th>
     	<th width="10%">pisteet</a></th>
     	<th width="11%">pist/ott</a></th>
		<th width="10%">+/-</a></th>
    	</tr>
    	<?php
		$i = 1;
		while ($rivi = mysql_fetch_assoc($porssi)){
			$pelaajaID = $rivi["pelaajaID"];
        	$nimi = $rivi["nimi"];
		
		$t_pelaaja = "<a href=\"/tilastot/?tilasto=pelaaja&id=$pelaajaID&kausi=$kau\">$nimi</a>";
		
		$pperot = number_format($rivi["pperot"], 2, '.', '');
		
		$maalierot = $rivi["maaliero"];
		if($maalierot == "") $maalierot = '<span class="nostats"><a title="ei tilastoitu">-</a></span>';
		if($maalierot > 0) $maalierot = '<span class="green">+'.$maalierot.'</span>';
		if($maalierot == 0) $maalierot = '<span class="blue">'.$maalierot.'</span>';
		if($maalierot < 0) $maalierot = '<span class="red">'.$maalierot.'</span>';
		if($maalierot == ""){ $maalierot = ""; }

		
		

		$t_rivi = array($i.".", $t_pelaaja, $rivi["ot"], $rivi["ma"], $rivi["sy"], $rivi["pt"], $pperot, $maalierot);
		
		taulukkorivi($t_rivi, 8, $t_optiot);

		$i++;
		}
		echo "</table>";
	}
	return 0;
}

function tulostaOttelut($joukkueID, $joukkue, $stID, $vaihe, $kau, $sb, $tulostusjuttu){
global $id;

	$t_optiot = array("", "", " align=\"center\"", " align=\"center\"");
	
	?>
	<table class="statistics" width="100%">
     <tr>
    <?php
    if ($vaihe == 'rs'){
    	?>
		<th width="77" class="left">pvm</th>
 		<th class="left">ottelu</th>
 		<?php
	}
	else {
		?>
        <th width="77">pvm</th>
        <th>ottelu</th>
        <?php
    }
    ?>
      <th width="13%">tulos</th>
      <th width="13%">&nbsp;</th>
     </tr>
	
	<?php
	if ($sb == "0" || $vaihe == 'pp'){
		$ottelut = sql("SELECT otteluID, kotiID, vierasID, kotimaalit, vierasmaalit, pvm, 
		                       DATE_FORMAT(pvm,'%d.%m.%Y') AS pvm2, luovutusvoitto
                        FROM ottelu
                        WHERE (kotiID = $joukkueID OR vierasID = $joukkueID)
                        AND ottelu.sarjatilastoID = $stID
                        ORDER BY pvm DESC, aika DESC, otteluID DESC");
	}
	else {
		$ottelut = sql("SELECT otteluID, kotiID, vierasID, kotiID+vierasID AS ot, kotimaalit,
	                           vierasmaalit, pvm, DATE_FORMAT(pvm,'%d.%m.%Y') AS pvm2, luovutusvoitto
                        FROM ottelu
                        WHERE (kotiID = $joukkueID OR vierasID = $joukkueID)
                        AND ottelu.sarjatilastoID = $stID
                        ORDER BY ot, pvm DESC, aika DESC, otteluID DESC");
	}
                         
	while ($rivi = mysql_fetch_assoc($ottelut)){
		$tehdyt = 0;
		$paastetyt = 0;
		$kotiID = $rivi["kotiID"];
		$vierasID = $rivi["vierasID"];
		$otteluID = $rivi["otteluID"];
		
		if ($rivi["luovutusvoitto"] == 'koti'){
			$rivi["kotimaalit"] = 5;
			$rivi["vierasmaalit"] = 0;
		}
		if ($rivi["luovutusvoitto"] == 'vieras'){
			$rivi["kotimaalit"] = 0;
			$rivi["vierasmaalit"] = 5;
		}

		if ($kotiID == $joukkueID){
			$vhaku = sql("SELECT nimi, joukkueID FROM joukkue WHERE joukkueID = $vierasID");
			$tehdyt = $rivi["kotimaalit"];
			$paastetyt = $rivi["vierasmaalit"];
		}
		else {
			$vhaku = sql("SELECT nimi, joukkueID FROM joukkue WHERE joukkueID = $kotiID");
			$tehdyt = $rivi["vierasmaalit"];
			$paastetyt = $rivi["kotimaalit"];
		}
	
		$vastus = mysql_result($vhaku, 0, 0);
		$vastusID = mysql_result($vhaku, 0, 1);

		if($kotiID == $joukkueID) {
			$t_ottelu = "".logosmall($joukkueID)."$joukkue - ".logosmall($vastusID)."<a href=\"/tilastot/?tilasto=joukkue&id=$vastusID&kausi=$kau\">$vastus</a>";
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
			$t_ottelu = "".logosmall($vastusID)."<a href=\"/tilastot/?tilasto=joukkue&id=$vastusID&kausi=$kau\">$vastus</a> - ".logosmall($joukkueID)."$joukkue";
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

		$t_tilastot = "<a href=\"/tilastot/?tilasto=ottelu&id=$otteluID&kausi=$kau\">tilastot</a>";

		$t_rivi = array($rivi["pvm2"], $t_ottelu, $t_tulos, $t_tilastot);
		
		taulukkorivi($t_rivi, 4, $t_optiot);	
	}
	echo "<!--</table><br><br>\n-->";
	
if($tulostusjuttu == "Liiga" or $tulostusjuttu == "1. Divari" or $tulostusjuttu == "2. Divari" or $tulostusjuttu == "5vs5-liiga"){

	$t_optiot = array("", "", " align=\"center\"", " align=\"center\"");
	
?>
<!--	<table class="jeah" width="450">
     <tr>
        <td width="21%"><b>pvm</b></td>
        <td width="49%"><b>ottelu</b></td>
      <td align="center" width="13%"><b>tulos</b></td>
      <td width="12%">&nbsp;</td>
     </tr>-->
<?php

$joukkue2 = $joukkueID;
$joukkuenimi = $joukkue;
$ottelutilasto = $stID;

if($tulostusjuttu == "5vs5-liiga"){
$ehtojuttu = "";
}else{
$ehtojuttu = "AND sarjatilastoID <> 685";
}

$qq = mysql_query("SELECT *
FROM `rstilasto`
WHERE `joukkueID` =$joukkueID
$ehtojuttu
ORDER BY `rstilasto`.`sarjatilastoID` DESC
LIMIT 1") or die(mysql_error());		
while ($rr = mysql_fetch_assoc($qq)){
$sarjatilasto = $rr["sarjatilastoID"];
$lohko = $rr["lohko"];
}


if($lohko <> 0){
$lohkoehto = " AND lohko='".$lohko."' ";
}

$q = mysql_query("SELECT * FROM rstilasto WHERE sarjatilastoID='".$sarjatilasto."' AND `joukkueID` NOT LIKE '".$joukkue2."' ".$lohkoehto."");		
while ($r = mysql_fetch_assoc($q)){

	$q2 = mysql_query("SELECT * FROM joukkue WHERE joukkueID='".$r["joukkueID"]."' LIMIT 1");		
	while ($r2 = mysql_fetch_assoc($q2)){
		$q3 = mysql_query("SELECT kotiID,vierasID,sarjatilastoID FROM ottelu WHERE sarjatilastoID='".$ottelutilasto."' AND kotiID='".$joukkue2."' AND vierasID='".$r2["joukkueID"]."' LIMIT 1") or die("Virhe!");
		$tulos = mysql_num_rows($q3);

	if($tulos == 0){
	$ottelujuttu = ''.logosmall($id).''.$joukkuenimi.' - '.logosmall($r2["joukkueID"]).'<a href="/tilastot/?tilasto=joukkue&id='.$r2["joukkueID"].'&kausi='.$kau.'">'.$r2["nimi"].'</a>';

			$t_rivi = array("-", $ottelujuttu, "-", "ei pelattu");
		$t_optiot = array("", "", " align=\"center\"", " align=\"center\"");
			taulukkorivi($t_rivi, 4, $t_optiot);
	}

	}
	
}

//

$q = mysql_query("SELECT * FROM rstilasto WHERE sarjatilastoID='".$sarjatilasto."' AND `joukkueID` NOT LIKE '".$joukkue2."' ".$lohkoehto."");		
while ($r = mysql_fetch_assoc($q)){

$q2 = mysql_query("SELECT * FROM joukkue WHERE joukkueID='".$r["joukkueID"]."' LIMIT 1");		
while ($r2 = mysql_fetch_assoc($q2)){

	$q3 = mysql_query("SELECT kotiID,vierasID,sarjatilastoID FROM ottelu WHERE sarjatilastoID='".$ottelutilasto."' AND kotiID='".$r2["joukkueID"]."' AND vierasID='".$joukkue2."' LIMIT 1") or die("Virhe!");
	$tulos = mysql_num_rows($q3);

if($tulos == 0){
//echo ''.$r2["nimi"].' vs. '.$joukkuenimi.'<br />';

$ottelujuttu = ''.logosmall($r2["joukkueID"]).'<a href="/tilastot/?tilasto=joukkue&id='.$r2["joukkueID"].'&kausi='.$kau.'">'.$r2["nimi"].'</a> - '.logosmall($id).''.$joukkuenimi.'';

		$t_rivi = array("-", $ottelujuttu, "-", "ei pelattu");
		
		taulukkorivi($t_rivi, 4, $t_optiot);
}

}
	
}$haku = sql ("SELECT sarjatilasto.sarjatilastoID, sarjatilasto.tyyppi, sarja.nimi
              FROM joukkuesivu, sarjatilasto, sarja
              WHERE joukkueID = $id
              AND joukkuesivu.sarjatilastoID = sarjatilasto.sarjatilastoID
              AND sarjatilasto.sarjaID = sarja.sarjaID
              AND kausiID = $kausi
              AND primaari = 1
              ORDER BY sarjatilasto.sarjaID DESC, sarjatilasto.tyyppi");

while ($rivi = mysql_fetch_assoc($haku)){
	global $mbcwf;
	$mbcwf = 0;
	
	$tyyppi = $rivi["tyyppi"];
	$tilastoID = $rivi["sarjatilastoID"];
	$tulostus = $rivi["nimi"];
	
	if ($tyyppi == 'pudotuspelit'){
		echo "<h5>$tulostus / ottelut:</h5>";
		tulostaOttelut($id, $nimi, $tilastoID, 'pp', $kausi, $sortby, $tulostus);
	}
	else if ($tyyppi == 'ottelut' || $tyyppi == 'yhdistetty'){
		echo "<h5>$tulostus / ottelut:</h5>";
		tulostaOttelut($id, $nimi, $tilastoID, 'rs', $kausi, $sortby, $tulostus);
	}
	else if ($tyyppi == 'pisteporssi'){
		echo "<h5>$tulostus / tilastot:</h5>";
		tulostaPorssi($id, $tilastoID, $kausi);
	}
       	else if ($tyyppi == 'cup'){
		echo "<h5>$tulostus / ottelut:</h5>";
		tulostaOttelut($id, $tilastoID, $kausi);
	}
}

function tulostaPorssi($joukkueID, $stID, $kau){
	$t_optiot = array("", "", " align=\"center\"", " align=\"center\"", " align=\"center\"", " align=\"center\"", " align=\"center\""," align=\"center\"");

    $porssi = sql("SELECT pelaaja.nimi AS nimi, pelaaja.pelaajaID, 
                      SUM(ottelut) AS ot, SUM(maalit) AS ma, SUM(syotot) AS sy, SUM(maalit)+SUM(syotot) AS pt,
                      (SUM(maalit)+SUM(syotot))/SUM(ottelut) AS pperot, maaliero                         
               FROM pelaaja, tehotilasto
               WHERE pelaaja.pelaajaID = tehotilasto.pelaajaID
               AND tehotilasto.joukkueID = $joukkueID
               AND sarjatilastoID = $stID
               GROUP BY pelaaja.pelaajaID
               ORDER BY pt DESC, ma DESC, ot, nimi");
    
    if (mysql_num_rows($porssi) > 0){
    	?>
		<table class="statistics" width="100%">
     	<tr>
		<th width="5%" class="left">#</a></th>
     	<th width="26%" class="left">pelaaja</a></th>
     	<th width="10%">ottelut</a></th>
     	<th width="10%">maalit</a></th>
     	<th width="10%">syötöt</a></th>
     	<th width="10%">pisteet</a></th>
     	<th width="11%">pist/ott</a></th>
		<th width="10%">+/-</a></th>
    	</tr>
<?php
		$i = 1;
		while ($rivi = mysql_fetch_assoc($porssi)){
			$pelaajaID = $rivi["pelaajaID"];
        	$nimi = $rivi["nimi"];
		
		$t_pelaaja = "<a href=\"/tilastot/?tilasto=pelaaja&id=$pelaajaID&kausi=$kau\">$nimi</a>";
		
		$pperot = number_format($rivi["pperot"], 2, '.', '');
		
		$maalierot = $rivi["maaliero"];
		if($maalierot == "") $maalierot = '<span class="nostats"><a title="ei tilastoitu">-</a></span>';
		if($maalierot > 0) $maalierot = '<span class="green">+'.$maalierot.'</span>';
		if($maalierot == 0) $maalierot = '<span class="blue">'.$maalierot.'</span>';
		if($maalierot < 0) $maalierot = '<span class="red">'.$maalierot.'</span>';
		if($maalierot == ""){ $maalierot = ""; }

		
		

		$t_rivi = array($i.".", $t_pelaaja, $rivi["ot"], $rivi["ma"], $rivi["sy"], $rivi["pt"], $pperot, $maalierot);
		
		taulukkorivi($t_rivi, 8, $t_optiot);

		$i++;
		}
		echo "</table>";
	}
	return 0;
}

function tulostaOttelut($joukkueID, $joukkue, $stID, $vaihe, $kau, $sb, $tulostusjuttu){
global $id;

	$t_optiot = array("", "", " align=\"center\"", " align=\"center\"");
	
	?>
	<table class="statistics" width="100%">
     <tr>
    <?php
    if ($vaihe == 'rs'){
    	?>
		<th width="77" class="left">pvm</th>
 		<th class="left">ottelu</th>
 		<?php
	}
	else {
		?>
        <th width="77">pvm</th>
        <th>ottelu</th>
        <?php
    }
    ?>
      <th width="13%">tulos</th>
      <th width="13%">&nbsp;</th>
     </tr>
	
	<?php
	if ($sb == "0" || $vaihe == 'pp'){
		$ottelut = sql("SELECT otteluID, kotiID, vierasID, kotimaalit, vierasmaalit, pvm, 
		                       DATE_FORMAT(pvm,'%d.%m.%Y') AS pvm2, luovutusvoitto
                        FROM ottelu
                        WHERE (kotiID = $joukkueID OR vierasID = $joukkueID)
                        AND ottelu.sarjatilastoID = $stID
                        ORDER BY pvm DESC, aika DESC, otteluID DESC");
	}
	else {
		$ottelut = sql("SELECT otteluID, kotiID, vierasID, kotiID+vierasID AS ot, kotimaalit,
	                           vierasmaalit, pvm, DATE_FORMAT(pvm,'%d.%m.%Y') AS pvm2, luovutusvoitto
                        FROM ottelu
                        WHERE (kotiID = $joukkueID OR vierasID = $joukkueID)
                        AND ottelu.sarjatilastoID = $stID
                        ORDER BY ot, pvm DESC, aika DESC, otteluID DESC");
	}
                         
	while ($rivi = mysql_fetch_assoc($ottelut)){
		$tehdyt = 0;
		$paastetyt = 0;
		$kotiID = $rivi["kotiID"];
		$vierasID = $rivi["vierasID"];
		$otteluID = $rivi["otteluID"];
		
		if ($rivi["luovutusvoitto"] == 'koti'){
			$rivi["kotimaalit"] = 5;
			$rivi["vierasmaalit"] = 0;
		}
		if ($rivi["luovutusvoitto"] == 'vieras'){
			$rivi["kotimaalit"] = 0;
			$rivi["vierasmaalit"] = 5;
		}

		if ($kotiID == $joukkueID){
			$vhaku = sql("SELECT nimi, joukkueID FROM joukkue WHERE joukkueID = $vierasID");
			$tehdyt = $rivi["kotimaalit"];
			$paastetyt = $rivi["vierasmaalit"];
		}
		else {
			$vhaku = sql("SELECT nimi, joukkueID FROM joukkue WHERE joukkueID = $kotiID");
			$tehdyt = $rivi["vierasmaalit"];
			$paastetyt = $rivi["kotimaalit"];
		}
	
		$vastus = mysql_result($vhaku, 0, 0);
		$vastusID = mysql_result($vhaku, 0, 1);

		if($kotiID == $joukkueID) {
			$t_ottelu = "".logosmall($joukkueID)."$joukkue - ".logosmall($vastusID)."<a href=\"/tilastot/?tilasto=joukkue&id=$vastusID&kausi=$kau\">$vastus</a>";
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
			$t_ottelu = "".logosmall($vastusID)."<a href=\"/tilastot/?tilasto=joukkue&id=$vastusID&kausi=$kau\">$vastus</a> - ".logosmall($joukkueID)."$joukkue";
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

		$t_tilastot = "<a href=\"/tilastot/?tilasto=ottelu&id=$otteluID&kausi=$kau\">tilastot</a>";

		$t_rivi = array($rivi["pvm2"], $t_ottelu, $t_tulos, $t_tilastot);
		
		taulukkorivi($t_rivi, 4, $t_optiot);	
	}
	echo "<!--</table><br><br>\n-->";
	
if($tulostusjuttu == "Liiga" or $tulostusjuttu == "1. Divari" or $tulostusjuttu == "2. Divari" or $tulostusjuttu == "5vs5-liiga"){

	$t_optiot = array("", "", " align=\"center\"", " align=\"center\"");
	
?>
<!--	<table class="jeah" width="450">
     <tr>
        <td width="21%"><b>pvm</b></td>
        <td width="49%"><b>ottelu</b></td>
      <td align="center" width="13%"><b>tulos</b></td>
      <td width="12%">&nbsp;</td>
     </tr>-->
<?php

$joukkue2 = $joukkueID;
$joukkuenimi = $joukkue;
$ottelutilasto = $stID;

if($tulostusjuttu == "5vs5-liiga"){
$ehtojuttu = "";
}else{
$ehtojuttu = "AND sarjatilastoID <> 685";
}

$qq = mysql_query("SELECT *
FROM `rstilasto`
WHERE `joukkueID` =$joukkueID
$ehtojuttu
ORDER BY `rstilasto`.`sarjatilastoID` DESC
LIMIT 1") or die(mysql_error());		
while ($rr = mysql_fetch_assoc($qq)){
$sarjatilasto = $rr["sarjatilastoID"];
$lohko = $rr["lohko"];
}


if($lohko <> 0){
$lohkoehto = " AND lohko='".$lohko."' ";
}

$q = mysql_query("SELECT * FROM rstilasto WHERE sarjatilastoID='".$sarjatilasto."' AND `joukkueID` NOT LIKE '".$joukkue2."' ".$lohkoehto."");		
while ($r = mysql_fetch_assoc($q)){

	$q2 = mysql_query("SELECT * FROM joukkue WHERE joukkueID='".$r["joukkueID"]."' LIMIT 1");		
	while ($r2 = mysql_fetch_assoc($q2)){
		$q3 = mysql_query("SELECT kotiID,vierasID,sarjatilastoID FROM ottelu WHERE sarjatilastoID='".$ottelutilasto."' AND kotiID='".$joukkue2."' AND vierasID='".$r2["joukkueID"]."' LIMIT 1") or die("Virhe!");
		$tulos = mysql_num_rows($q3);

	if($tulos == 0){
	$ottelujuttu = ''.logosmall($id).''.$joukkuenimi.' - '.logosmall($r2["joukkueID"]).'<a href="/tilastot/?tilasto=joukkue&id='.$r2["joukkueID"].'&kausi='.$kau.'">'.$r2["nimi"].'</a>';

			$t_rivi = array("-", $ottelujuttu, "-", "ei pelattu");
		$t_optiot = array("", "", " align=\"center\"", " align=\"center\"");
			taulukkorivi($t_rivi, 4, $t_optiot);
	}

	}
	
}

//

$q = mysql_query("SELECT * FROM rstilasto WHERE sarjatilastoID='".$sarjatilasto."' AND `joukkueID` NOT LIKE '".$joukkue2."' ".$lohkoehto."");		
while ($r = mysql_fetch_assoc($q)){

$q2 = mysql_query("SELECT * FROM joukkue WHERE joukkueID='".$r["joukkueID"]."' LIMIT 1");		
while ($r2 = mysql_fetch_assoc($q2)){

	$q3 = mysql_query("SELECT kotiID,vierasID,sarjatilastoID FROM ottelu WHERE sarjatilastoID='".$ottelutilasto."' AND kotiID='".$r2["joukkueID"]."' AND vierasID='".$joukkue2."' LIMIT 1") or die("Virhe!");
	$tulos = mysql_num_rows($q3);

if($tulos == 0){
//echo ''.$r2["nimi"].' vs. '.$joukkuenimi.'<br />';

$ottelujuttu = ''.logosmall($r2["joukkueID"]).'<a href="/tilastot/?tilasto=joukkue&id='.$r2["joukkueID"].'&kausi='.$kau.'">'.$r2["nimi"].'</a> - '.logosmall($id).''.$joukkuenimi.'';

		$t_rivi = array("-", $ottelujuttu, "-", "ei pelattu");
		
		taulukkorivi($t_rivi, 4, $t_optiot);
}

}
	
}
			
echo '</table>';
}}}}
?>
			</pre>
		</div>
	</div>
<?php
include_once(incDir."/footer.php");
?>