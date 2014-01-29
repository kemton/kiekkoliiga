<?php include_once (incDir."/statisticsbar.php"); ?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding">Joukkuehaun tulokset</div>
		</div>
		<div class="content">
			<?php
			$searchResult = unserialize($_REQUEST["searchResult"]);
			if (count($searchResult) <= 0) { echo "<strong>Ei hakutuloksia</strong>";}
			foreach ($searchResult as $team) {
				echo "<a href=\"/team/{$team->__get('name')}\">{$team->__get('name')}</a><br />";
			}
			?>
		</div>
	</div>