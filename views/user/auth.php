<?php
include_once (incDir."/header.php");
include_once (incDir."/navigation.php");
include_once (incDir."/leftbar.php");
include_once (incDir."/rightbar.php");
?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding">Tunnistautuminen</div>
		</div>
		<div class="content">
			Tämän sivun kautta pystyt tunnistautumaan kiekkopelaajaksi, ja saat yhdistettyä Kiekkoliiga-tunnuksen - kiekko-tunnuksen kanssa.<br />
			Tunnistautumalla saat käyttöösä sivuilla kommentoiti-oikeudet, ja pystyt hoitamaan pelaajasiirtoja.<br /><br />
			
			Auth-koodin saat lähettämällä kiekossa viestin:
			<div class="padding"><strong>/msg PandaBot !auth</strong></div>
			<hr />
			<form id="uploadResult" action="/user/auth/" method="post">
				<table cellpadding="1" cellspacing="1">
					<tr><td>Kiekkonick:</td><td><input name="kiekkonick" size="10" maxlength="10" type="text" /></td></tr>
					<tr><td>Auth-koodi:</td><td><input name="authcode" size="5" maxlength="5" type="text" /></td></tr>
					<tr><td></td><td><button type="submit">Tunnistaudu kiekkopelaajaksi</button></td></tr>
				</table>
			</form>
		</div>
	</div>
<?php include_once (incDir."/footer.php"); ?>