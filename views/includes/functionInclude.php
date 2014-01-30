<?php

include("comments.php");

function logosmall($teamID, $px = 12, $nospace = 0) {
	if($px == ""){ $px = 12; } // 121013 kemton, funktiota käytettiin ennen: logosmall(1234, "", 1)
	$filename = "images/logos/small/".$teamID.".gif";
	
	if (file_exists($filename)) {
		$showlogo = "/images/logos/small/".$teamID.".gif";
	} else {
		$showlogo = "/images/logos/small/null.png";
	}
	$imageTag = '<img src="'.$showlogo.'" width="'.$px.'" height="'.$px.'" alt="teamlogo" />';
	if($nospace <> 1) $imageTag .= "&nbsp;";
	return $imageTag;
}

function logolarge($teamID, $px = 120, $nospace = 0) {
	if($px == ""){ $px = 120; }
	$filename = "images/logos/".$teamID.".gif";
	
	if (file_exists($filename)) {
		$showlogo = "/images/logos/".$teamID.".gif";
	} else {
		$showlogo = "/images/kla_logo.png";
	}
	$imageTag = '<img src="'.$showlogo.'" width="'.$px.'" height="'.$px.'" alt="teamlogo" />';
	if($nospace <> 1) $imageTag .= "&nbsp;";
	return $imageTag;
}

function teamlogo($teamID, $nospace = 0) {
	$filename = "images/logos/".$teamID.".gif";
	
	if (file_exists($filename)) {
		$showlogo = "/images/logos/".$teamID.".gif";
	} else {
		$showlogo = "/images/kla_logo.png";
	}
	$imageTag = '<img src="'.$showlogo.'" alt="teamlogo" />';
	if($nospace <> 1) $imageTag .= "&nbsp;";
	return $imageTag;
}

function printPlayerNameWithLink($id, $name, $isBoard) {
	if($id != 0) {
		echo("<b><a href=\"/player/{$name}\"");
		if($isBoard) {
			 echo("style=\"color: #ee0000;\"");
		}
		echo(">");
	}
	echo $name;
	if($id != 0) {
		echo("</a></b>");
	}
}

function bbc($text){

	$text = preg_replace("/\[b\](.*)\[\/b\]/smU", "<b>$1</b>", $text); 
	$text = preg_replace("/\[u\](.*)\[\/u\]/smU", "<u>$1</u>", $text); 
	$text = preg_replace("/\[i\](.*)\[\/i\]/smU", "<i>$1</i>", $text); 
	$text = preg_replace("/\[s\](.*)\[\/s\]/smU", "<s>$1</s>", $text); 
	$text = preg_replace ( "/\[url=(.*)\](.*)\[\/url\]/smU", "<a href=\"" . str_replace ( '"', "%22", "$1" ) . "\">$2</a>", $text );
	$text = preg_replace("/\[color=(.*)\](.*)\[\/color\]/smU", '<span style="color:$1">$2</span>', $text );
	$text = preg_replace("/\[size=(.*)\](.*)\[\/size\]/smU", '<span style="font-size: $1">$2</span>', $text );
	$text = preg_replace("/\[url\](.*)\[\/url\]/smU", "<a href=\"$1\">$1</a>", $text); 
	$text = preg_replace("/\[img\](.*)\[\/img\]/smU", "<img src=\"$1\" alt=\"kuva\" />", $text); 

	$text = preg_replace("/\[img width\=(.*)\](.*)\[\/img\]/smU", "<img width=\"$1\" src=\"$2\" alt=\"kuva\" />", $text); 

	$text = preg_replace("/\[img height\=(.*)\](.*)\[\/img\]/smU", "<img height=\"$1\" src=\"$2\" alt=\"kuva\" />", $text); 

	$text = preg_replace("/\[img width\=(.*)\ height\=(.*)\](.*)\[\/img\]/smU", "<img height=\"$1\" width=\"$2\" src=\"$3\" alt=\"kuva\" />", $text); 
	$text = preg_replace("/\[img height\=(.*)\ width\=(.*)\](.*)\[\/img\]/smU", "<img height=\"$1\" width=\"$2\" src=\"$3\" alt=\"kuva\" />", $text); 

	$text = preg_replace("/\[img width\=(.*)\ height\=(.*)\ align\=(.*)\](.*)\[\/img\]/smU", "<img height=\"$1\" width=\"$2\" align=\"$3\" src=\"$4\" alt=\"kuva\" />", $text); 
	$text = preg_replace("/\[img height\=(.*)\ width\=(.*)\](.*)\[\/img\]/smU", "<img height=\"$1\" width=\"$2\" align=\"$3\" src=\"$4\" alt=\"kuva\" />", $text); 

	return $text;
}


function timeToDeadline($day, $month, $year, $hour){

	$tuloste = "";
	$aaika=mktime($hour,0,0,$month,$day,$year)-time();
	if(intval($aaika/31536000) < 0){ 
		$mennyt = true; 
	}
	$aaika=$aaika-intval($aaika/31536000)*31536000;
	$tuloste .= intval($aaika/86400)." päivää, ";
	
	if(intval($aaika/86400) < 0){ 
		$mennyt = true; 
	}
	$aaika=$aaika-intval($aaika/86400)*86400;
	$tuloste .= intval($aaika/3600)." tuntia ja ";
	
	if(intval($aaika/3600) < 0){ 
		$mennyt = true; 
	}
	$aaika=$aaika-intval($aaika/3600)*3600;
	$tuloste .= intval($aaika/60)." minuuttia";
	
	if(intval($aaika/60) < 0){ 
		$mennyt = true; 
	}
	$aaika=$aaika-intval($aaika/60)*60;
	if(intval($aaika) < 0){ $mennyt = true; }
	
	if($mennyt == true){
		return "0 päivää, 0 tuntia ja 0 minuuttia";
	}else{
		return $tuloste;
	}
	
}


function print_row_for_table($data, $column_option = array()) {
	static $row_number = 0;
	$row_number++;
	
	if($row_number % 2 == 0) {
		$parity = 'even';
	}
	else {
		$parity = 'odd';
	}
	echo("<tr class=\"{$parity}{$row_number}\">\n");

	foreach($data as $column) {
		echo("\t<td>" . $column . "</td>\n");
	}
	echo("</tr>\n");
}


function print_notification_box($text) {
	echo("<div class=\"notification\">{$text}</div>");
}


?>