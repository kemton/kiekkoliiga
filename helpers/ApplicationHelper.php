<?php
class ApplicationHelper {

	public static function current_user() {

		if (isset($_SESSION["user"])) {
			return TRUE;
		} else {
			return FALSE;
		}
		
	}

}
?>