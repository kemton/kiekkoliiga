<div id="right">
	<!--	
	<div class="box">
		<div class="top">
			<div class="padding">Otsake</div>
		</div>
		<div class="content">
	
		</div>
	</div>
	-->
	<?php
	$season = unserialize($_SESSION["season"]);
	?>
	<div class="box">
		<div class="top">
			
			<div class="padding">Tilastot <?php echo "{$season->__get('name')}"; ?></div>
		</div>
		<div class="content">
			<?php
			$leagues = unserialize($_REQUEST["leagues"]);
			foreach ($leagues as $value) {
				echo "<strong>{$value->__get('name')}</strong><br />\n";
				
				foreach ($value->__get('steers') as $steerValue) {
					echo "<a href=\"/statistics/{$steerValue->__get('leagueSteerType')}/{$steerValue->__get('leagueSteerId')}\">{$steerValue->__get('leagueSteerName')}</a><br />\n";
					if ($steerValue->__get('leagueSteerType') == 'sarjataulukko') {
						echo "<a href=\"/statistics/attack/{$steerValue->__get('leagueSteerId')}/\">Hyökkäystilastot</a><br />\n";
						echo "<a href=\"/statistics/defence/{$steerValue->__get('leagueSteerId')}/\">Puolustustilastot</a><br />\n";
					}
				}
				
				echo '<br />';
			}
			?>
			<a href="/statistics/leaguestats">Kiekkoliigan tilastot</a>
			<br />
			<form method="get" action="/statistics/">
				<strong>Valitse kausi:</strong><br />
				<select name="season">
					<?php
					$seasonsList = unserialize($_REQUEST["seasons"]);
					$userSeason = unserialize($_SESSION["season"]);
					foreach ($seasonsList as $season) {
						echo "<option value=\"{$season->__get('id')}\"".($season->__get('id') == $userSeason->__get('id') ? ' selected="selected"' : '').">{$season->__get('name')}</option>\n";
					} ?>
				</select>
				<br />
				<input type="submit" value="Vaihda" />
			</form>
			<br />
			<form>
				<strong>Hae pelaaja:</strong><br />
				<input type="text" name="searchplayer" placeholder="pelaaja" />
				<button type="button" onclick="search('/statistics/searchplayer/', this.form.searchplayer.value)">Hae</button>
			</form>
			<br />
			<form>
				<strong>Hae joukkue:</strong><br />
				<input type="text" name="searchteam" placeholder="joukkue" />
				<button type="button" onclick="search('/statistics/searchteam/', this.form.searchplayer.value)">Hae</button>
			</form>
		</div>
	</div>
</div>
