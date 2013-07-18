<?php
class LeftbarController extends Controller {
	
	public function execute($request) {
		try {
			/* leftbar */
			$informationAccess = new InformationAccess();
			
			$board = $informationAccess->getLastBoardInfo();
			$_REQUEST["lastBoardInfo"] = $board;
			
			$paitsio = $informationAccess->getLastPaitsio();
			$_REQUEST["lastPaitsio"] = $paitsio;
			
			$lastComment = $informationAccess->getLastCommented();
			$_REQUEST["lastComment"] = $lastComment;
			
			$news = $informationAccess->getLastNews();
			$_REQUEST["lastNews"] = $news;
			
			$teamNews = $informationAccess->getLastTeamNews();
			$_REQUEST["lastTeamnews"] = $teamNews;
			
			$LFT = $informationAccess->getLastLookingForTeam();
			$_REQUEST["lastLfg"] = $LFT;
			/* /leftbar */
			
			$return = "leftbarPage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
}
?>