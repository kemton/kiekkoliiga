<div class="box">
	<div class="top">
		<div class="padding">Kiekkoliigan tilastot</div>
	</div>
	<div class="content">
		<?php
		$leagueStats = unserialize($_REQUEST["leagueStats"]);
		echo "Käyttäjämäärä: {$leagueStats->__get('users')}<br />";
		echo "Pelaajamäärä: {$leagueStats->__get('players')}<br />";
		echo "Pelattuja otteluja: {$leagueStats->__get('matches')}<br />";
		?>
	</div>
</div>