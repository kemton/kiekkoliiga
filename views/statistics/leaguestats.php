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
		echo "Tehdyt maalit: {$leagueStats->__get('goals')}<br />";
		echo "Tehdyt syötöt: {$leagueStats->__get('assists')}<br />";
		echo "Tehdyt tehopisteet: {$leagueStats->__get('points')}<br />";
		echo "Sivuston kommentit: {$leagueStats->__get('comments')}<br />";
		?>
	</div>
</div>