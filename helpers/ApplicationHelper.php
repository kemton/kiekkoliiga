<?php
class ApplicationHelper {

	public static function current_user() {

		if (isset($_SESSION["user"])) {
			return TRUE;
		} else {
			return FALSE;
		}
		
	}

	public static function getSeason() {
		
		if (!isset($_SESSION["season"])) {
			$seasonController = new SeasonController();
			$_SESSION["season"] = serialize($seasonController->getCurrentSeason());
		}
		return unserialize($_SESSION["season"]);
	}
}
?>