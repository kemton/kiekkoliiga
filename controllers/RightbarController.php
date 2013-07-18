<?php
class RightbarController extends Controller {
	
	public function execute($request) {
		try {
			/* rightbar */
			$stats = new StatisticsAccess();
			
			$standings = $stats->getCurrentStandingsList();
			$_REQUEST["standingsList"] = $standings;
			
			/*
			$standings = $stats->getCurrentLeagueStandings();
			$_REQUEST["leagueStandings"] = $standings;
			
			$firstStandings = $stats->getCurrentFirstDivisionStandings();
			$_REQUEST["firstDivisionStandings"] = $firstStandings;
			
			$secondStandings = $stats->getCurrentSecondDivisionStandings();
			$_REQUEST["secondDivisionStandings"] = $secondStandings;
			*/
			/* /rightbar */
			
			$return = "rightbarPage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
}
?>