<?php
error_reporting(E_ERROR | E_WARNING);
//error_reporting(E_ERROR);
ini_set("display_errors", 1);
//header('Content-Type: text/html; charset=iso-8859-1');
session_start();
require_once ("Config.php");
require_once ("autoload.php");
require_once('forum/SSI.php');
$uri = $_SERVER['REQUEST_URI'];
$controller = explode('/', $uri);
$controller = array_slice($controller, 1); // Delete first item, because its always empty

$router = new Router();
$page = $router->doRequest($controller, $context); // $context if smf SSI
if ($page <> NULL || $page <> FALSE) {include_once($page);} // valid include
//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";
?>