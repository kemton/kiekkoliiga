<?php
include_once (incDir."/header.php");
include_once (incDir."/navigation.php");
include_once (incDir."/leftbar.php");
include_once (incDir."/rightbar.php");
?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding">Käyttäjän asetukset</div>
		</div>
		<div class="content">
			Tunnistautumalla saat käyttöösi sivuilla kommentointi-oikeudet, ja pystyt hoitamaan pelaajasiirtoja.<br /><br />
			
			Auth-koodin saat lähettämällä kiekossa viestin:
			<div class="padding"><strong>/msg PandaBot !auth</strong></div>
			<hr />
			<?php
			$isAuthed = $_REQUEST["isAuthed"];
			$auth = unserialize($_REQUEST["auth"]);
			if ($isAuthed) {
				echo "<strong>Olet tunnistautunut nimimerkillä:</strong> <a href=\"http://kiekko.tk/user.cws?name={$auth->name}\">{$auth->name}</a><br /><br />
				Tarvittaessa voit tunnistautua uudelleen toisella nimimerkillä alemman lomakkeen avulla.<br />";
			}
			?>
			<form id="uploadResult" action="/user/auth_user/" method="post">
				<table cellpadding="1" cellspacing="1">
					<tr><td>Kiekkonick:</td><td><input name="kiekkonick" size="10" maxlength="10" type="text" /></td></tr>
					<tr><td>Auth-koodi:</td><td><input name="authcode" size="5" maxlength="5" type="text" /></td></tr>
					<tr><td></td><td><button type="submit">Tunnistaudu kiekkopelaajaksi</button></td></tr>
				</table>
			</form>
		</div>
	</div>
<?php include_once (incDir."/footer.php"); ?>