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
			$seasonAccess = new SeasonAccess();
			$_SESSION["season"] = serialize($seasonAccess->getCurrentSeason());
		}
		return unserialize($_SESSION["season"]);
	}
}
?>