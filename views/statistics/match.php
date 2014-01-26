<?php
include_once (incDir."/header.php");
include_once (incDir."/navigation.php");
include_once (incDir."/leftbar.php");
include_once (incDir."/statisticsbar.php");
?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding">Ottelu</div>
		</div>
		<div class="content">
<?php

$season = unserialize($_SESSION["season"]);
$seasonId = $season->__get("id");
$seasonName = $season->__get("name");

$match = unserialize($_REQUEST["match"]);
$report = $match->__get("report");

if ($seasonId > 7){
	$report = nl2br($report);
}

$stage = "";

$matchStageName = $match->__get("stage")->__get("stageName");

if ($matchStageName == 'ottelut' || $matchStageName == 'yhdistetty' || $matchStageName == ""){
	$stage = "runkosarjaottelu";
	
	if ($match->__get("league") == 'divarikarsinta' || $match->__get("league") == 'liigakarsinta'){
		$stage = "";
	}
}
else{
	$a = $matchStageName;
		
	if ($a == 'puolivälierät' || $a == 'divarin puolivälierät'){
		$stage = "puolivälierä";
	}
	else if ($a == 'välierät' || $a == 'divarin välierät'){
		$stage = "välierä";
	}
	else if ($a == 'pronssiottelu'){
		$stage = "pronssiottelu";
	}
	else if ($a == 'loppuottelu'){
		$stage = "loppuottelu";
	}
}

// ---------------------REFORMAT----------------------------------------
$p = $match->__get("periodStats");
$homeTeamSaves1 = @$p['home']['saves'][1];
$homeTeamSaves2 = @$p['home']['saves'][2];
$homeTeamSaves3 = @$p['home']['saves'][3];
$homeTeamPossession1 = @$p['home']['possession'][1];
$homeTeamPossession2 = @$p['home']['possession'][2];
$homeTeamPossession3 = @$p['home']['possession'][3];
$visitorTeamSaves1 = @$p['visitor']['saves'][1];
$visitorTeamSaves2 = @$p['visitor']['saves'][2];
$visitorTeamSaves3 = @$p['visitor']['saves'][3];
$visitorTeamPossession1 = @$p['visitor']['possession'][1];
$visitorTeamPossession2 = @$p['visitor']['possession'][2];
$visitorTeamPossession3 = @$p['visitor']['possession'][3];
// ---------------------REFORMAT----------------------------------------

echo '<style>table#gameBox {
font-family: arial, helvetica; 
line-height: 16px;
font-size: 12px;
border: 1px solid #b4c6d4;
text-align: center; background-color: #e5ecf1;
border-collapse: collapse;
float: right;
}
#gameBox th,#gameBox td { padding: 2px; padding-left: 4px; padding-right: 4px; text-align: center; border-bottom: 1px solid #b4c6d4; border-right: 1px solid #b4c6d4; }
#gameBox th.left,#gameBox td.left { text-align: left; }
#gameBox table tr:last-child td { border-bottom: 0; }
#gameBox th { font-weight: normal; background-color: #c9d7e1; }
#gameBox td img { width: 14px; height: 14px; vertical-align: top; }</style>';

$homeTeam = $match->__get("homeTeam");
$homeTeamName = $homeTeam->__get("name");
$homeTeamLogo = logosmall($homeTeam->__get("id"));

$visitorTeam = $match->__get("visitorTeam");
$visitorTeamName = $visitorTeam->__get("name");
$visitorTeamLogo = logosmall($visitorTeam->__get("id"));

$homeTeamGoals = $match->__get("homeTeamGoals");
$visitorTeamGoals = $match->__get("visitorTeamGoals");
$walkover = $match->__get("walkover");

$homeTeamShootings = $visitorTeamSaves1 + $visitorTeamSaves2 + $visitorTeamSaves3 + $homeTeamGoals;
$visitorTeamShootings = $homeTeamSaves1 + $homeTeamSaves2 + $homeTeamSaves3 + $visitorTeamGoals;

echo "<p>{$match->__get("league")} {$seasonName} {$stage}</p>";
echo "<h3>{$homeTeamLogo}<a class=\"otsikko\" href=\"/team/{$homeTeamName}\">{$homeTeamName}</a> - {$visitorTeamLogo}<a class=\"otsikko\" href=\"/team/{$visitorTeamName}\">{$visitorTeamName}</a> ";

if ($walkover == 'koti'){
	echo "5 - 0 luov.";
	if ($match->__get("time")!='00:00:00'){
		echo(" (" . $homeTeamGoals . " - " . $visitorTeamGoals . ")");
	} 
}
else if ($walkover == 'vieras'){
	echo "0 - 5 luov.";
	if ($match->__get("time")!='00:00:00'){
		echo(" (" . $homeTeamGoals . " - " . $visitorTeamGoals . ")");
	} 
}
else {
	echo($homeTeamGoals . " - " . $visitorTeamGoals);
}

if ($match->__get("overtime")==1){
	echo(" ja.");
}

echo("</h3>");

if($homeTeamSaves1 <> ""){
	echo '<table id="gameBox">
	<tr>
	<th class="left"><strong>Torjunnat</strong></th><th>1. erä</th><th>2. erä</th><th>3. erä</th>
	</tr>
	<tr>
	<td class="left">'.$homeTeamLogo.' '.$homeTeamName.'</td><td>'.$homeTeamSaves1.'</td><td>'.$homeTeamSaves2.'</td><td>'.$homeTeamSaves3.'</td>
	</tr>
	<tr>
	<td class="left">'.$visitorTeamLogo.' '.$visitorTeamName.'</td><td>'.$visitorTeamSaves1.'</td><td>'.$visitorTeamSaves2.'</td><td>'.$visitorTeamSaves3.'</td>
	</tr>
	<tr>
	<th class="left"><strong>Kiekonhallinta</strong></th><th>1. erä</th><th>2. erä</th><th>3. erä</th>
	</tr>
	<tr>
	<td class="left">'.$homeTeamLogo.' '.$homeTeamName.'</td><td>'.$homeTeamPossession1.'%</td><td>'.$homeTeamPossession2.'%</td><td>'.$homeTeamPossession3.'%</td>
	</tr>
	<tr>
	<td class="left">'.$visitorTeamLogo.' '.$visitorTeamName.'</td><td>'.$visitorTeamPossession1.'%</td><td>'.$visitorTeamPossession2.'%</td><td>'.$visitorTeamPossession3.'%</td>
	</tr>
	<tr>
	<th class="left"><strong>Vedot</strong></th><th colspan="3" class="left">yht.</th>
	</tr>
	<tr>
	<td class="left">'.$homeTeamLogo.' '.$homeTeamName.'</td><td colspan="3" class="left">'.$homeTeamShootings.'</td>
	</tr>
	<tr>
	<td class="left">'.$visitorTeamLogo.' '.$visitorTeamName.'</td><td colspan="3" class="left">'.$visitorTeamShootings.'</td>
	</tr>
	</table>';
}
echo("<p><a href=\"/team/\">" . $homeTeamName . "</a>:<br/><br/>");

printPlayerStats($match->__get("id"), $match->__get("homeTeamMatchPlayers"), $walkover);

echo("<br/><br/><a href=\"/team/\">" . $visitorTeamName . "</a>:<br/><br/>");

printPlayerStats($match->__get("id"), $match->__get("visitorTeamMatchPlayers"), $walkover);

if ($report != NULL){
	echo "<br/><br/>Otteluraportti:<hr />{$report}<hr /><br/>";
}
else {
	echo "<br/><br/>";
}

$user = unserialize($_SESSION["user"]);
if($user) {
	$currentUserName = $user->__get("name");
}

if ($match->__get("referee") == $currentUserName || $context["user"]["is_admin"] == 1){
	echo "<b><a href=\"/muokkaaottelua?id={$match->__get("id")}\">Ottelutilastojen ja raportin muokkaus.</a></b><br/>";
}

echo "<br/>Tuomari: " . $match->__get("referee") . "<br/>";

echo "<br/>Lisätty: {$match->__get("date")} {$match->__get("time")}<br/></p><hr />";

$comments = $match->__get("comments");
printMatchComments($comments, $match->__get("id"));

function printPlayerStats($matchId, $matchPlayers, $walkover){     
	//echo("<pre>");print_r($matchPlayers);echo("</pre>");
  if ($matchPlayers){
		foreach($matchPlayers as $matchPlayer){
			$player = $matchPlayer->__get("player");
			$id = $player->__get("id");
			$name = $player->__get("name");
			$goals = $matchPlayer->__get("goals");
			$assists = $matchPlayer->__get("assists");
			$total = $goals + $assists;
			$plusminus = $matchPlayer->__get("plusminus");
			if($plusminus > 0){ $plusminusText = '<span class="green">+'; }
			if($plusminus < 0){ $plusminusText = '<span class="red">'; }
			if($plusminus == 0){ $plusminusText = '<span class="blue">'; }
			$plusminusText .= $plusminus . '</span>';
			
			printf ("");
			echo("<a href=\"/player/{$name}\">{$name}</a> {$goals}+{$assists}={$total} {$plusminusText}\n<br/>");
		}
	}
	else if ($walkover == 'vieras' || $walkover == 'koti'){
		echo "";
	}
	else if ($matchId > 60){
		echo "Tehopisteitä ei tilastoitu.<br/>";
	}
	else {
		echo "Ottelukohtaisia tehopisteitä ei tallessa.<br/>";
	}
}
?>
		</div>
	</div>
<?php
include_once (incDir."/footer.php");
?>