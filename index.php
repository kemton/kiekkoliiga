<?php
if (DEBUG_MODE) ini_set("display_errors", 1);ini_set("display_startup_errors",1);error_reporting(-1);

session_start();
require_once("Config.php");
require_once("autoload.php");
require_once('forum/SSI.php');
$uri = $_SERVER['REQUEST_URI'];
$controller = explode('/', $uri);
$controller = array_slice($controller, 1); // Delete first item, because its always empty

$router = new Router();
$page = $router->doRequest($controller, $context); // $context if smf SSI

include_once(incDir."functionInclude.php");
include_once(incDir."/header.php");
include_once(incDir."/leftbar.php");

if (isset($_REQUEST["standingsList"])) {
	include_once(incDir."/rightbar.php");
} else if (isset($_REQUEST["leagues"])) {
	include_once(incDir."/statisticsbar.php");
}

echo "<div id=\"content\">";
if (isset($page)) include_once($page);

include_once(incDir."/footer.php");
?>