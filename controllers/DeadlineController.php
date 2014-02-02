<?php
class DeadlineController extends Controller {
	
	
	public function execute($request) {
		try {	
			parent::execute($request);
			$seasonAccess = new SeasonAccess();
			$season = $seasonAccess->getCurrentSeason();
			$seasonId = $season->__get("id");
			
			$deadlineAccess = new DeadlineAccess();
			$deadlines = $deadlineAccess->getAllDeadlinesBySeasonId($seasonId);
			
			$pageAccess = new PageAccess();
			$_REQUEST["pageObject"] = $pageAccess->getPageByName("timetables");
			
			$_REQUEST["deadlines"] = serialize($deadlines);
		} catch (Exception $e) {
			$return = "exceptionPage";
			throw $e;
		}
		
		return "deadlinePage";
	}
	
	public function getFirst() {
		try {
			$deadlineAccess = new DeadlineAccess();
			$deadline = $deadlineAccess->getCurrentDeadline();
			
			$_REQUEST["deadline"] = serialize($deadline);
		} catch (Exception $e) {
			throw $e;
		}
	}
}
?>