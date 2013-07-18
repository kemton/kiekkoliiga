<?php
class StatisticsbarController extends Controller {
	
	public function execute($request) {
		try {
			$season = unserialize($_SESSION["season"]);
			/* statisticbar */
			$statsAccess = new StatisticsAccess();
			$leagues = $statsAccess->getAllLeaguesStatsBySeasonId($season->__get('id'));
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