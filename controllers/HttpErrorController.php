<?php
class HttpErrorController extends Controller {
	
	public function execute($request) {
		try {
			/* leftbar */
			$leftbar = new LeftbarController();
			$leftbar->execute($request);
			
			/* rightbar */
			$stats = new StatisticsAccess();
			
			$standings = $stats->getCurrentLeagueStandings();
			$_REQUEST["leagueStandings"] = $standings;
			
			$firstStandings = $stats->getCurrentFirstDivisionStandings();
			$_REQUEST["firstDivisionStandings"] = $firstStandings;
			
			$secondStandings = $stats->getCurrentSecondDivisionStandings();
			$_REQUEST["secondDivisionStandings"] = $secondStandings;
			/* /rightbar */
			
			$return = "error404Page";
		} catch (Exception $e) {
			$return = "exceptionPage";
			throw $e;
		}
		return $return;
	}
	
}
?>