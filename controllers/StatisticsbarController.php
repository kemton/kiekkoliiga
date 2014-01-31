<?php
class StatisticsbarController extends Controller {
	
	public function execute($request) {
		try {
			$season = ApplicationHelper::getSeason();
			/* statisticbar */
			$leagueAccess = new LeagueAccess();
			$leagues = $leagueAccess->getAllLeaguesBySeasonId($season->__get('id'));
			$_REQUEST["leagues"] = serialize($leagues);

			$seasonAccess = new SeasonAccess();
			$seasons = $seasonAccess->getAllSeasons();
			$_REQUEST["seasons"] = serialize($seasons);
			
			/* /statisticbar */
			$return = "rightbarPage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
}
?>