<!DOCTYPE html>
<html lang="fi">
<head>
	
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/css/main.css?7" />
	<link rel="shortcut icon" href="/favicon.ico" />
	
	<title>Kiekkoliiga</title>
	
	<meta name="description" content="Kiekkoliiga on Kiekko.tk -nettipelin pohjalle rakentuva nettijääkiekkoliiga, joka on toiminut vuodesta 2004 lähtien." />
	<meta name="keywords" content="kiekkoliiga, kiekko, nettijääkiekko, nettijääkiekkoliiga, liiga, kliiga" />
	<meta name="robots" content="index, follow" />
	
	<link rel="stylesheet" href="/css/jquery-ui-1.8.22.custom.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/css/themes/blue/style.css" type="text/css" media="all" />
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/js/auroramenu.js"></script>
	<script type="text/javascript" src="/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="/js/addComment.js"></script>
	<script type="text/javascript" src="/js/search.js"></script>
	
	<script>
		$(function() {
			$( "#resizable" ).resizable({
				handles: "se"
			});
		});
		
		$(function() {
			$( "#tabs" ).tabs();
		});
	</script>
	
	<meta property="og:site_name" content="Kiekkoliiga.net"/>
	<meta property="og:title" content="Kiekkoliiga.net"/>
	<meta property="og:type" content="website"/>
	<meta property="og:url" content="http://kiekkoliiga.net/"/>
	<meta property="og:image" content="http://kiekkoliiga.net/images/kla_logo.png"/>
	<meta property="og:locale" content="fi_FI" />

	<!-- © Kiekkoliiga 2004-<?php echo date("Y"); ?> -->

	<script type="text/javascript">
		/*<!--
		var unityObjectUrl = "http://webplayer.unity3d.com/download_webplayer-3.x/3.0/uo/UnityObject2.js";
		if (document.location.protocol == 'https:')
			unityObjectUrl = unityObjectUrl.replace("http://", "https://ssl-");
		document.write('<script type="text\/javascript" src="' + unityObjectUrl + '"><\/script>');
		-->
		</script>
		<script type="text/javascript">
		<!--
			var config = {
				width: 960, 
				height: 600,
				params: { enableDebugging:"0" }
				
			};
			config.params["disableContextMenu"] = true;
			var u = new UnityObject2(config);
			
			jQuery(function() {

				var $missingScreen = jQuery("#unityPlayer").find(".missing");
				var $brokenScreen = jQuery("#unityPlayer").find(".broken");
				$missingScreen.hide();
				$brokenScreen.hide();

				u.observeProgress(function (progress) {
					switch(progress.pluginStatus) {
						case "broken":
							$brokenScreen.find("a").click(function (e) {
								e.stopPropagation();
								e.preventDefault();
								u.installPlugin();
								return false;
							});
							$brokenScreen.show();
						break;
						case "missing":
							$missingScreen.find("a").click(function (e) {
								e.stopPropagation();
								e.preventDefault();
								u.installPlugin();
								return false;
							});
							$missingScreen.show();
						break;
						case "installed":
							$missingScreen.remove();
						break;
						case "first":
						break;
					}
				});
				u.initPlugin(jQuery("#unityPlayer")[0], "http://kiekko.tk/unity/kiekko4.unity3d");
			});
		-->
		</script>
		<style type="text/css">
		<!--
		div#unityPlayer {
			cursor: default;
			xcursor: url('http://kiekko.tk/unity/kursori32.gif') 16 16,crosshair;
			height: 600px;
			width: 960px;
		}
		-->*/
		</style>
</head>

<body>
	<div id="wrap">
		
		<div id="header">
			
			<div id="top">
				<?php
					$dl = unserialize($_REQUEST["deadline"]);
					$deadlineName = $dl->__get("name");
					$timestamp = $dl->__get("ends");
					$deadline = date_parse($timestamp);
					$timeToDeadline = timeToDeadline($deadline["day"], $deadline["month"], $deadline["year"], $deadline["hour"]);
					echo("{$deadlineName} deadlineen: {$timeToDeadline}");
				?>
				| <a href="/siirrot">Siirrot</a>
			</div>
			<div id="login">
				<?php if(!ApplicationHelper::current_user()) { ?>
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
						if ($user->__get('player') !== NULL) {

							$player = $user->__get('player');

							if ($player->__get('team') !== NULL) $team = $player->__get('team'); // player profile has team?

						}
						
						if (isset($player)) {
							echo "<strong><a href=\"/player/{$user->__get('name')}\">{$user->__get('name')}</a></strong>";
							
							if ($team->__get('id') !== NULL) echo ", <a href=\"/team/\"{$team->__get('name')}\">".logosmall($team->__get("id"), 14, 1)."{$team->__get("name")}";

							echo '<br />';
							if ($player->__get('isAdmin')) echo '<a href="">Joukkuetietojen päivitys</a><br />';
							
						} else {
						
							echo "<strong>{$user->__get("name")}</strong><br />";
						
						}
						
						echo '<a href="/user">Käyttäjän asetukset</a><br />';
						
						if ($user->__get('isReferee')) echo '<a href="/upload">Pelin lisääminen</a><br />';

						echo "<a href=\"/forum/index.php?action=logout;{$context["session_var"]}={$context['session_id']}\">Kirjaudu ulos</a>";
						
						if (isset($player) && $player->__get('isAdmin')) echo '<div style="float: right;"><a href="/admin">Hallinta</a></div>';

						?>
						</td>
					</tr>
				</table>
				<?php } ?>

			</div>

		</div>
		
		<div id="menu2" style="font-weight:normal;">
			<ul>
				<li><a href="<?php echo path; ?>">Etusivu</a></li>
				<li><a href="<?php echo path; ?>archives">Arkisto</a></li>
				<li><a href="<?php echo path; ?>teams">Joukkueet</a></li>
				<li><a href="<?php echo path; ?>rules">Säännöt</a></li>
				<li><a href="<?php echo path; ?>board">Johtokunta</a></li>
				<li><a href="<?php echo path; ?>paitsio">Paitsio</a></li>
				<li><a href="<?php echo path; ?>statistics">Tilastot</a></li>
				<li><a href="<?php echo path; ?>forum">Foorumi</a></li>
				<li><a href="<?php echo path; ?>kiekko-cup">Kiekko Cup</a></li>
				<li><a href="<?php echo path; ?>hall-of-fame">Hall of Fame</a></li>
				<li><a href="<?php echo path; ?>report">Raportoi</a></li>
				<li><a href="<?php echo path; ?>feedback">Palaute</a></li>
			</ul>
		</div>

		<div id="container">