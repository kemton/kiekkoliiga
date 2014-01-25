<?php
class TeamsController extends Controller {
	
	public function execute($request) {
		try {
			parent::execute($request);
			
			$stats = new StatisticsAccess();
			$teamList = $stats->getCurrentStandingsList();
			$_REQUEST["teamList"] = serialize($teamList);
			
			$return = "teamsPage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
}
?>