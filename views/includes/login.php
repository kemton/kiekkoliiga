<?php
if(!isset($_SESSION["user"]))
{
?>
<form action="/forum/index.php?action=login2" method="post" accept-charset="ISO-8859-1">
	<input type="hidden" name="cookielength" value="-1" />
	<input type="hidden" name="hash_passwrd" value="" />
	
	<table class="floatRight padding10">
		<tr>
			<td colspan="2" class="padding1">
				<input type="text" name="user" class="inputu" />
			</td>
		</tr>
		<tr>
			<td colspan="2" class="padding1">
				<input type="password" name="passwrd" class="inputp" />
			</td>
		</tr>
		<tr>
			<td class="width26">
				<input type="submit" class="submit" name="login" value="" />
			</td>
			<td class="left">
				<span class="register_forgot">
					<a href="/forum/index.php?action=register">Rekisteröidy</a><br />
					<a href="/forum/index.php?action=reminder">Unohditko salasanasi?</a>
				</span>
			</td>
		</tr>
	</table>
</form>
<?php } else { ?>
<table id="logged" align="right">
	<tr>
		<td valign="top" style="padding: 5px; padding-left: 7px;padding-right: 7px;">
		<?php
		$user = unserialize($_SESSION["user"]); // User Object
		
		// user has player profile?
		if ($user->__get('player') <> NULL) {
			$player = $user->__get('player');
			// player profile has team?
			if ($player->__get('team') <> NULL) {
				$team = $player->__get('team');
			}
		}
		
		if ($player != NULL) {
			echo '<strong><a href="/player/'.$user->__get('name').'">'.$user->__get('name').'</a></strong>';
			
			if ($team->__get('id') != NULL) {
				echo ', <a href="/team/'.$team->__get('name').'">'.logosmall($team->__get('id'), 14, 1).$team->__get('name');
			
			}
			echo '<br />';
			if ($player->__get('isAdmin')) { echo '<a href="">Joukkuetietojen päivitys</a><br />'; }
		} else { echo '<strong>'.$user->__get('name').'</strong><br />'; }
		
		if ($user->__get('isReferee')) { echo '<a href="/upload">Pelin lisääminen</a><br />'; }
		echo '<a href="/page/forum/index.php?action=logout;' . $context['session_var'] . '=' . $context['session_id'] . '">Kirjaudu ulos</a>';
		
		if($player <> NULL){ // user has player profile?
			if ($player->__get('isAdmin')) {
				echo '<div style="float: right;"><a href="/admin">Hallinta</a></div>';
			}
		}
		
		?>
		</td>
	</tr>
</table>
<?
}
?>

