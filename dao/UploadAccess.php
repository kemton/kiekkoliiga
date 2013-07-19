<?php
class UploadAccess extends DatabaseAccess {
	
	private $ADD_MATCH = "";
	private $INIT_MATCH = "";
	
	public function initMatchUpload($leagueId, $homeTeamId, $visitorTeamId) {
		try {
			if (!is_numeric($leagueId) || $leagueId == 0) throw new Exception("Invalid league ID");
			if (!is_numeric($homeTeamId) || $homeTeamId == 0) throw new Exception("Invalid hometeam ID");
			if (!is_numeric($visitorTeamId) || $visitorTeamId == 0) throw new Exception("Invalid visitingteam ID");
			
			$result = parent::executeStatement($this->INIT_MATCH, array("leagueId" => $leagueId, "homeTeamId" => $homeTeamId, "visitorTeamId" => $visitorTeamId));
			if (count($result) <> 2) throw new Exception("Something is wrong");
			$teamAccess = new TeamAccess();
			$match = new Match();
			$match->__set('league', $league); // $league object is available? => modify StatisticsAccess->getAllLeaguesStatsBySeasonId
			$match->__set('homeTeam', $teamAccess->getTeamById($homeTeamId));
			$match->__set('visitorTeam', $teamAccess->getTeamById($visitorTeamId));
		} catch (Exception $e) {
			throw $e;
		}
		return serialize($match);
	}
	
	public function addMatch(Match $match) {
		$return = false;
		try {
			$params = array(
				"league" => $match->__get('league'),
				"stage" => $match->__get('stage'),
				"homeTeam" => $match->__get('homeTeam'),
				"visitorTeam" => $match->__get('visitorTeam'),
				"homeTeamGoals" => $match->__get('homeTeamGoals'),
				"visitorTeamGoals" => $match->__get('visitorTeamGoals'),
				"homeTeamMatchPlayers" => $match->__get('homeTeamMatchPlayers'),
				"visitorTeamMatchPlayers" => $match->__get('visitorTeamMatchPlayers'),
				"date" => $match->__get('date'),
				"time" => $match->__get('time'),
				"referee" => $match->__get('referee'),
				"walkover" => $match->__get('walkover'),
				"overtime" => $match->__get('overtime'),
				"periodStats" => $match->__get('periodStats')
			);
			$result = parent::updateStatement($this->ADD_MATCH, $params);
			$return = true;
		} catch (Exception $e) {
			$return = false;
			throw $e;
		}
		return $return;
	}

}
?>