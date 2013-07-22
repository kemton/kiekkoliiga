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
			$league = unserialize($uploadMatch["league"]);
			$homeTeam = unserialize($uploadMatch["homeTeam"]);
			$visitorTeam = unserialize($uploadMatch["visitorTeam"]);
			
			$homeTeamPlayers = $homeTeam->__get('players');
			$visitorTeamPlayers = $visitorTeam->__get('players');
			?>
			<form action="">
				<strong><?php echo $homeTeam->__get('name'); ?></strong> <input type="text" maxlength="2" size="2" name="homeGoals" value="">
				<strong><?php echo $visitorTeam->__get('name'); ?></strong> <input type="text" maxlength="2" size="2" name="visitorGoals" value="">
				<br /><br />
				
				jatkoaika <input type="checkbox" name="overtime" />(rastita jos ottelu meni jatkoajalle)<br /><br />
				 
				<table>
					<tr>
						<td>Koti:<br />
						<?php for ($i=1; $i < 9; $i++) { ?>
						<select name="homePlayer<?php echo $i; ?>">
							<option value="0"></option>
							<?php
								foreach ($homeTeamPlayers as $player) {
									$player = unserialize($player);
									echo "<option value=\"{$player->__get('id')}\">{$player->__get('name')}</option>";
								}
							?>
						</select>
						<input type="text" maxlength="2" size="2" value="" name="goals<?php echo $i; ?>">+
						<input type="text" maxlength="2" size="2" value="" name="assists<?php echo $i; ?>">
						+/-: <input type="text" maxlength="3" size="3" value="" name="plusMinus<?php echo $i; ?>">
						<br />
						<?php } ?>
						<td>Vieras:<br />
						<?php for ($i=1; $i < 9; $i++) { ?>
							<select name="visitingPlayer<?php echo $i; ?>">
							<option value="0"></option>
							<?php
								foreach ($visitorTeamPlayers as $player) {
									$player = unserialize($player);
									echo "<option value=\"{$player->__get('id')}\">{$player->__get('name')}</option>";
								}
							?>
							</select>
							<input type="text" maxlength="2" size="2" value="" name="goals<?php echo $i; ?>" />+
							<input type="text" maxlength="2" size="2" value="" name="assists<?php echo $i; ?>" />
							+/-: <input type="text" maxlength="3" size="3" value="" name="plusMinus<?php echo $i; ?>" /><br />
						<?php } ?>
						</td>
					</tr>
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
							<input type="text" maxlength="3" size="3" value="" name="saves1" /><br />
							<input type="text" maxlength="3" size="3" value="" name="saves2" /><br />
							<input type="text" maxlength="3" size="3" value="" name="saves3" />
						</td>
						<td width=50></td>
						<td>
							<input type="text" maxlength="3" size="3" value="" name="saves1" /><br />
							<input type="text" maxlength="3" size="3" value="" name="saves2" /><br />
							<input type="text" maxlength="3" size="3" value="" name="saves3" />
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
							<input type="text" maxlength="3" size="3" value="" name="control1" />%<br />
							<input type="text" maxlength="3" size="3" value="" name="control2" />%<br />
							<input type="text" maxlength="3" size="3" value="" name="control3" />%<br />
						</td>
						<td width=50></td>
						<td>
							<input type="text" maxlength="3" size="3" value="" name="control1" />%<br />
							<input type="text" maxlength="3" size="3" value="" name="control2" />%<br />
							<input type="text" maxlength="3" size="3" value="" name="control3" />%<br />
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