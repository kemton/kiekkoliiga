<?php
class LogInController extends Controller {
	
	public function execute($SSIContext) {
		try {
			/**
			 * EI TOIMI UUSIEN FIXIEN TAKIA, KORJATTAVA!!!! kemton
			 * HOX! getPlayerById palauttaa nykyään player objectin
			 * ja tämän actionin työ delegoitava dao luokalle
			 */
			$id = $SSIContext["user"]["id"];
			$username = $SSIContext["user"]["username"];
			$isAdmin = $SSIContext["user"]["is_admin"] == 1 ? true : false;
			
			$playerAccess = new PlayerAccess();
			$user = $playerAccess->getLoggedInUser($id, $username, $isAdmin);
			
			$_SESSION["user"] = serialize($user);
			
			$return = "homePage";
		} catch (Exception $e) {
			$return = "exceptionPage";
			throw $e;
		}
		return $return;
	}
	
}
?>