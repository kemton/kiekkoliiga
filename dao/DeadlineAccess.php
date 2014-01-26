<?php
class DeadlineAccess extends DatabaseAccess {
	private $GET_ALL_DEADLINES_BY_SEASON_ID = "SELECT id, name, DATE_FORMAT(starts, '%e.%c.') as startDate, DATE_FORMAT(ends, '%e.%c.') as endDate, duration, notes, competitionName FROM deadlines WHERE seasonId = :seasonId ORDER BY competitionName DESC, ends";
	private $GET_CURRENT_DEADLINE = "SELECT id, name, DATE_FORMAT(ends, '%Y-%m-%d %h:%i:%s') as ends FROM deadlines WHERE DATEDIFF(starts, NOW()) < 0 AND DATEDIFF(ends, NOW()) > 0 ORDER BY ends DESC LIMIT 1";
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getAllDeadlinesBySeasonId($seasonId) {
		try {
			$results = parent::executeStatement($this->GET_ALL_DEADLINES_BY_SEASON_ID, array(":seasonId" => $seasonId));
			foreach($results as $result) {
				$id = $result["id"];
				$name = $result["name"];
				$starts = $result["startDate"];
				$ends = $result["endDate"];
				$duration = $result["duration"];
				$competitionName = $result["competitionName"];
				$notes = $result["notes"];
				
				$deadline = new Deadline($id, $name, $starts, $ends, $duration, $notes);
				$deadlines[$competitionName][] = $deadline;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $deadlines;
	}
	
	public function getCurrentDeadline() {
		try {
			$result = parent::executeStatement($this->GET_CURRENT_DEADLINE, array());
			$id = @$result[0]["id"];
			$name = @$result[0]["name"];
			$ends = @$result[0]["ends"];
			
			$deadline = new Deadline($id, $name, null, $ends, null, null);
		} catch (Exception $e) {
			throw $e;
		}
		return $deadline;
	}
}
?>