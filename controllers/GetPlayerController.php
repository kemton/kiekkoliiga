<?php
class GetPlayerController extends Controller {
	
	public function execute($request) {
		$id_member = $request["idmember"];
		try {
			$playerAccess = new PlayerAccess();
			$player = $playerAccess->getData($id_member);
			$_REQUEST["user"] = $player;
			
			$return = "homePage";
		} catch (Exception $e) {
			$return = "exceptionPage";
			throw $e;
		}
		
		return $return;
		
	}
	
}
?>