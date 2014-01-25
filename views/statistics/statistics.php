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
			<?php
			$season = unserialize($_SESSION["season"]);
			echo "<h2>Kausi {$season->__get('name')}</h2><br />";
			
			/*$league = unserialize($_REQUEST["leagues"]);
			foreach ($league as $key) {
				$key = unserialize($key);
				echo $key->__get('name');
				foreach ($key->__get('steers') as $k) {
					echo $k->__get('leagueSteerId');
				}
			}*/
			
			//echo "<pre>";
			//print_r($league);
			//echo "</pre>";
			?>
		</div>
	</div>
<?php
include_once (incDir."/footer.php");
?>