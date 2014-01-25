<?php
include_once (incDir."/header.php");
include_once (incDir."/navigation.php");
include_once (incDir."/leftbar.php");
include_once (incDir."/statisticsbar.php");
?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding">Player achievements</div>
		</div>
		<div class="content">
<?php
/**** Achievements ****/

$achievements = unserialize($_REQUEST["playerAchievements"]);
if (unserialize($_REQUEST["playerAchievements"]) <> NULL) {
	echo "<h4>Saavutukset:</h4>";
	foreach ($achievements as $ach) {
		$season = $ach->__get('season');
		echo "{$season->__get('name')} - {$ach->__get('name')} joukkueessa {$ach->__get('team')}<br />";
	}
}
/**** Achievements end ****/
?>
			
		</div>
	</div>
<?php
include_once (incDir."/footer.php");
?>