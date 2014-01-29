<?php include_once (incDir."/rightbar.php"); ?>
	<div class="content">
			<?php
			
foreach (unserialize($_REQUEST["teamList"]) as $teamList) {
	echo "<div class=\"box\">
			<div class=\"top\">
				<div class=\"padding\">Sarjan nimi</div>
			</div>\n
			<div class=\"content\">";
	foreach ($teamList as $stand) {
		$team = $stand->__get('team');

		$logo = logosmall($team->__get('id'), 12, 1);
		echo "{$logo} <a href=\"/team/{$team->__get('name')}\">{$team->__get('name')}</a><br />\n";
	}
	echo "</div></div>\n";
}

new Debug(unserialize($_REQUEST["teamList"]));
?>

	</div>