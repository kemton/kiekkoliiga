<?php
include_once (incDir."/header.php");
include_once (incDir."/navigation.php");
include_once (incDir."/leftbar.php");
include_once (incDir."/rightbar.php");
?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding">Lisää</div>
		</div>
		<div class="content">
			<?php
			$uploads = unserialize($_REQUEST["uploads"]);
			foreach ($uploads as $upload) {
				echo $upload->__get('header')."<br />";
				$type = $upload->__get('type');
				
				if ($type == 'ottelut' || $type == 'yhdistetty') { // Regular Season
					echo "<form action=\"/upload/match/{$upload->__get('standingId')}\" method=\"get\">
					<select>";
					foreach ($upload->__get('teams') as $team) {
						$team = unserialize($team);
						echo "<option value=\"{$team->__get('id')}\">{$team->__get('name')}</option>";
					}
					echo "</select>
					<button type=\"submit\">Jatka</button>
					</form>";
				} elseif ($type == 'pudotuspelit' || $type == 'cup' || $type == 'cup2') { // Playoff & cup
					echo "<form action=\"/upload/playoffmatch\" method=\"get\">
					<select name=\"pid\">";
					foreach (unserialize($upload->__get('teams')) as $team) {
						$team1 = unserialize($team->__get('team1'));
						$team2 = unserialize($team->__get('team2'));
						echo "<option value=\"{$team->__get('id')}\">{$team1->__get('name')} - {$team2->__get('name')}</option>\n";
					}
					echo "</select>
					<input type=\"hidden\" name=\"uid\" value=\"{$upload->__get('id')}\" />
					<button type=\"submit\">Jatka</button>
					</form>";
				}
				
			}
			?>
		</div>
	</div>
<?php include_once (incDir."/footer.php"); ?>