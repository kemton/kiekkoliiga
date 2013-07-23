<?php
class TeamPageController extends Controller {
	
	public function execute($request) {
		try {
		
			$leftbar = new LeftbarController();
			$leftbar->execute($request);
			$rightbar = new StatisticsbarController();
			$rightbar->execute($request);
			
			$id = urldecode($request[1]);
			
			$seasonId = unserialize($_SESSION["season"])->__get("id");
			
			$teamAccess = new TeamAccess();
			
			if (!is_numeric($id)) { // If parameter is name
				$name = urldecode($id);
				$name = utf8_decode($name);
				$team = unserialize($teamAccess->getTeamByName($name));
				$id = $team->__get("id");
			}
			
			$team = $teamAccess->getTeamById($id);
			$teamSeasons = $teamAccess->getTeamSeasonLeaguesWithTypesById($id, $seasonId);
			$teamPressReleases = $teamAccess->getTeamPressReleasesById($id);
			
			$_REQUEST["team"] = $team;
			$_REQUEST["teamSeasons"] = $teamSeasons;
			$_REQUEST["teamPressReleases"] = $teamPressReleases;
			
			$return = "teamPage";
		} catch (Exception $e) {
			$return = "exceptionPage";
			throw $e;
		}
		return $return;
	}
	
	
	
}
?>