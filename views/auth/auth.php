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
			<?php 
			if(isset($_SESSION["user"])) {
				$user = unserialize($_SESSION["user"]);
				$auth = $user->__get("auth");
				if(!$auth->__get("name")) {
					echo("Tunnistautuminen:");
				}
				else {
					echo("Olet tunnistautunut nimimerkin <a href='pelaaja/{$auth->__get('name')}'>{$auth->__get('name')}</a> omistajaksi.<br/><br/> 
					Mikäli olet vaihtanut kiekkonimimerkkiäsi, niin klikkaa <a href='/auth/destroy'>tästä</a> poistaaksesi nykyisen tunnistautumisesi.");
				}
			}
			else {
				echo("Et ole kirjautunut sisään.");
			}
			
			?>
		</div>
	</div>
<?php
include_once (incDir."/footer.php");
?>