<?php
class StatisticsbarController extends Controller {
	
	public function execute($request) {
		try {
			$season = unserialize($_SESSION["season"]);
			/* statisticbar */
			$leagueAccess = new LeagueAccess();
			$leagues = $leagueAccess->getAllLeaguesBySeasonId($season->__get('id'));
			$_REQUEST["leagues"] = $leagues;

			$seasonAccess = new SeasonAccess();
			$seasons = $seasonAccess->getAllSeasons();
			$_REQUEST["seasons"] = $seasons;
			
			/* /statisticbar */
			$return = "rightbarPage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
}
?>