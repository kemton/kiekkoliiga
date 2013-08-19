<?php
class LeftbarController extends Controller {
	
	public function execute($request) {
		try {
			/* leftbar */
			$informationAccess = new InformationAccess();
			
			$board = $informationAccess->getLastBoardInfo();
			$_REQUEST["lastBoardInfo"] = serialize($board);
			
			$paitsio = $informationAccess->getLastPaitsio();
			$_REQUEST["lastPaitsio"] = serialize($paitsio);
			
			$lastComment = $informationAccess->getLastCommented();
			$_REQUEST["lastComment"] = serialize($lastComment);
			
			$news = $informationAccess->getLastNews();
			$_REQUEST["lastNews"] = serialize($news);
			
			$LFT = $informationAccess->getLastLookingForTeam();
			$_REQUEST["lastLfg"] = serialize($LFT);
			/* /leftbar */
			
			$return = "leftbarPage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
}
?>