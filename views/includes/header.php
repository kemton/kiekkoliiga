<?php
include("functionInclude.php");
?>
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
		<!--
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
		-->
		</style>
</head>

<body>
	<div id="wrap">
		
		<div id="header">
			<div id="top">
				<?php
					$dl = unserialize($_REQUEST["deadline"]);
					$deadlineName = $dl->__get("name");
					$timestamp = $dl->__get("deadline");
					$deadline = date_parse($timestamp);
					$timeToDeadline = timeToDeadline($deadline["day"], $deadline["month"], $deadline["year"], $deadline["hour"]);
					echo("{$deadlineName} deadlineen: {$timeToDeadline}");
				?>
			</div>
			<div id="login">
				<?php include_once("login.php"); ?>
			</div>
		</div>