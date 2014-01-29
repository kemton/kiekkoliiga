<?php

$user = unserialize($_SESSION["user"]);

if(!$user) {
	exit("Et ole kirjautunut sisään.");
}
$team = $user->__get("player")->__get("team");
$isAdmin = $user->__get("player")->__get("isAdmin");
$isBoard = $user->__get("isAdmin");

?>
<div class="box">
	<div class="top">
		<div class="padding">Siirrot</div>
	</div>
	<div class="content">

		<?php 
		
		$notifications = unserialize($_REQUEST["notifications"]);
		foreach($notifications as $notification) {
			print_notification_box($notification);
		}
		
		
		
		$invitations = unserialize($_REQUEST["invitations"]);
		foreach($invitations as $invitation) {
			$id = $invitation->__get("id");
			$teamName = $invitation->__get("team")->__get("name");
			$inviter = $invitation->__get("inviter");
			print_notification_box("{$inviter} on kutsunut sinut joukkueeseen <b>{$teamName}</b>. <a href=\"/transfers/accept_transfer/{$id}\" style=\"color: green;\">Hyväksy</a> | <a href=\"/transfers/reject_transfer/{$id}\" style=\"color: red\">Hylkää</a>");
		}
		
		if($isBoard) {
			?>
			<h5>Hyväksymättömät siirrot</h5>
			<table border=0>
				<tr>
					<th>Pelaaja</th>
					<th>Uusi joukkue</th>
					<th>Hyväksy</th>
					<th>Hylkää</th>
				</tr>
			<?php
			$transfers_for_board = unserialize($_REQUEST["transfers_for_board"]);
			foreach($transfers_for_board as $transfer) {
				echo("<tr>\n");
				echo("<td>{$transfer->__get("player")->__get("name")}</td>\n");
				echo("<td>{$transfer->__get("team")->__get("name")}</td>\n");
				echo("<td><a href='/transfers/board_accept_transfer/{$transfer->__get("id")}>Hyväksy</a></td>\n");
				echo("<td><a href='/transfers/board_reject_transfer/{$transfer->__get("id")}>Hylkää</a></td>\n");
				echo("</tr>\n\n");
			}
		}
		echo("</table>");
		if($team->__get("id") != 0) {
			?>
			<h2>Joukkueen kokoonpano</h2>
			<table border=0>
			<?php
			foreach($team->__get("players") as $player) {
				echo("<tr>\n<td>{$player->__get('name')}</td>\n");
				if($isAdmin) {
					echo("<td><a href='/transfers/remove_from_squad/{$player->__get('id')}'> Poista kokoonpanosta</a></td>\n");
					if(!$player->__get("isAdmin")) {
						echo("<td><a href='/transfers/add_vh/{$player->__get('id')}/{$player->__get('name')}'>Kutsu vastuuhenkilöksi</a></td>\n");
					}
				}
				else if($player->__get('id') == $user->__get("player")->__get("id")) {
					echo("<td><a href='/transfers/remove_from_squad/{$player->__get('id')}'> Poistu kokoonpanosta</a></td>\n");
				}
				echo("</tr>\n");
			}
			?>
			</table>
			<br/><br/>
			
			<?php
			if($isAdmin) {
			?>
			<h5>Kutsu pelaaja kokoonpanoon</h5>
			<form action="/transfers/invite_to_squad" method="post">
				<input type="text" name="name" />
				<input type="submit" value="Kutsu"/>
			</form>
			<br/><br/>
			<?php
			}
		}
		else {
			echo("Et kuulu minkään joukkueen kokoonpanoon.");
		}
		
		?>
	</div>
</div>