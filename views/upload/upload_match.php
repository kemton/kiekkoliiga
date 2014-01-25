<?php
include_once (incDir."/header.php");
include_once (incDir."/navigation.php");
include_once (incDir."/leftbar.php");
include_once (incDir."/rightbar.php");
?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding">Add match</div>
		</div>
		<div class="content">
			<?php
			$user = unserialize($_SESSION["user"]);
			$uploadMatch = unserialize($_REQUEST["uploadMatch"]);
			$league = $uploadMatch["league"];
			$homeTeam = $uploadMatch["homeTeam"];
			$visitorTeam = $uploadMatch["visitorTeam"];
			
			$homeTeamPlayers = $homeTeam->__get('players');
			$visitorTeamPlayers = $visitorTeam->__get('players');
			?>
			<form action="/upload/addmatch/" method="post">
				<strong><?php echo $homeTeam->__get('name'); ?></strong> <input type="text" maxlength="2" size="2" name="homeGoals" value="">
				<strong><?php echo $visitorTeam->__get('name'); ?></strong> <input type="text" maxlength="2" size="2" name="visitorGoals" value="">
				<input type="hidden" name="homeTeamId" value="<?php echo $homeTeam->__get('id'); ?>" />
				<input type="hidden" name="visitorTeamId" value="<?php echo $visitorTeam->__get('id'); ?>" />
				<br /><br />
				jatkoaika <input type="checkbox" name="overtime" />(rastita jos ottelu meni jatkoajalle)<br /><br />
				<table>
					<tbody>
					<tr>
						<td>Koti:<br />
						<?php for ($i=1; $i < 9; $i++) { ?>
						<select name="homePlayer<?php echo $i; ?>">
							<option value="0"></option>
							<?php
								foreach ($homeTeamPlayers as $player) {
									echo "<option value=\"{$player->__get('id')}\">{$player->__get('name')}</option>";
								}
							?>
						</select>
						<input type="text" maxlength="2" size="1" value="" name="homePlayerGoals<?php echo $i; ?>">+
						<input type="text" maxlength="2" size="1" value="" name="homePlayerAssists<?php echo $i; ?>">
						+/-: <input type="text" maxlength="2" size="1" value="" name="homePlayerPlusMinus<?php echo $i; ?>">
						<br />
						<?php } ?>
						</td>
						<td>Vieras:<br />
						<?php for ($i=1; $i < 9; $i++) { ?>
							<select name="visitingPlayer<?php echo $i; ?>">
							<option value="0"></option>
							<?php
								foreach ($visitorTeamPlayers as $player) {
									echo "<option value=\"{$player->__get('id')}\">{$player->__get('name')}</option>";
								}
							?>
							</select>
							<input type="text" maxlength="2" size="1" value="" name="visitingPlayerGoals<?php echo $i; ?>" />+
							<input type="text" maxlength="2" size="1" value="" name="visitingPlayerAssists<?php echo $i; ?>" />
							+/-: <input type="text" maxlength="2" size="1" value="" name="visitingPlayerPlusMinus<?php echo $i; ?>" />
							<br />
						<?php } ?>
						</td>
					</tr>
					</tbody>
				</table>
				<br />
				<!-- Torjunnat alkaa -->
				<h3>Torjunnat</h3>
				<table>
					<tr>
						<td></td><td><?php echo $homeTeam->__get('name'); ?>:</td><td width=50></td><td><?php echo $visitorTeam->__get('name'); ?>:</td>
					</tr>
					<tr>
						<td>
							1. Erä:<br />
							2. Erä:<br />
							3. Erä:<br />
						</td>
						<td>
							<input type="text" maxlength="2" size="3" value="" name="homeTeamSaves1" /><br />
							<input type="text" maxlength="2" size="3" value="" name="homeTeamSaves2" /><br />
							<input type="text" maxlength="2" size="3" value="" name="homeTeamSaves3" />
						</td>
						<td width=50></td>
						<td>
							<input type="text" maxlength="2" size="3" value="" name="VisitingTeamSaves1" /><br />
							<input type="text" maxlength="2" size="3" value="" name="VisitingTeamSaves2" /><br />
							<input type="text" maxlength="2" size="3" value="" name="VisitingTeamSaves3" />
						</td>
					</tr>
				</table>
				<!-- Torjunnat loppuu -->
				<!-- Hallinta alkaa -->
				<h3>Kiekonhallinta</h3>
				<table>
					<tr>
						<td></td><td><?php echo $homeTeam->__get('name'); ?>:</td><td width=50></td><td><?php echo $visitorTeam->__get('name'); ?>:</td>
					</tr>
					<tr>
						<td>
						1. Erä:<br />
						2. Erä:<br />
						3. Erä:<br />
						</td>
						<td>
							<input type="text" maxlength="2" size="3" value="" name="homeTeamControl1" />%<br />
							<input type="text" maxlength="2" size="3" value="" name="homeTeamControl2" />%<br />
							<input type="text" maxlength="2" size="3" value="" name="homeTeamControl3" />%<br />
						</td>
						<td width=50></td>
						<td>
							<input type="text" maxlength="2" size="3" value="" name="visitingTeamControl1" />%<br />
							<input type="text" maxlength="2" size="3" value="" name="visitingTeamControl2" />%<br />
							<input type="text" maxlength="2" size="3" value="" name="visitingTeamControl3" />%<br />
						</td>
					</tr>
				</table>
				<!-- Hallinta loppuu -->
				Peliraportti (ei pakollinen):<br />
				<textarea rows="15" cols="50" name="report"></textarea>
				<br />
				Referee: <strong><?php echo $user->__get('name'); ?></strong><br /><br />
				
				<input type="hidden" name="referee" value="<?php echo $user->__get('name'); ?>">
				<button type="submit">Send match</button>
			</form>
		</div>
	</div>
<?php include_once (incDir."/footer.php"); ?>