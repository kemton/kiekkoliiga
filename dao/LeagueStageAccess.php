<?php
class LeagueStageAccess extends DatabaseAccess {

	private $GET_STAGE_BY_STAGE_ID = "SELECT * FROM ppsarja WHERE ppsarjaID = :stageId";
	
	public function getLeagueStageById($stageId) {
		try {
			$teamAccess = new TeamAccess();
		
			$result = parent::executeStatement($this->GET_STAGE_BY_STAGE_ID, array("stageId" => $stageId));
			
			$id = $result['ppsarjaID'];
			$stageName = $result['vaihe'];
			$league = $result['sarjatilastoID'];
			
			$team1Id = $result['joukkue1ID'];
			$team2Id = $result['joukkue2ID'];
			$team1 = $teamAccess->getTeamById($team1Id);
			$team2 = $teamAccess->getTeamById($team2Id);
			
			$team1Wins = $result['voitot1'];
			$team2Wins = $result['voitot2'];
			
			$stage = new LeagueStage($id, $stageName, $league, $team1, $team2, $team1Wins, $team2Wins);

		} catch (Exception $e) {
			throw $e;
		}
		return $stage;
	}

}
?>