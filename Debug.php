<?php
class Debug {
	
	function __construct($data) {
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
	
}
?>