<?php
/**
 * Controller, Abstract class
 */
abstract class Controller {
	public function execute($request) {
		$leftbar = new LeftbarController();
		$leftbar->execute($request);
		$rightbar = new RightbarController();
		$rightbar->execute($request);
	}
}
?>