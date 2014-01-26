<?php
class LeagueStageAccess extends DatabaseAccess {

	private $GET_STAGE_BY_STAGE_ID = "SELECT * FROM ppsarja WHERE ppsarjaID = :stageId";
	
	public function getLeagueStageById($stageId) {
		try {
			$teamAccess = new TeamAccess();
		
			$result = parent::executeStatement($this->GET_STAGE_BY_STAGE_ID, array("stageId" => $stageId));
			
			$result_pair = @$result[0];

			$id = $result_pair['ppsarjaID'];
			$stageName = $result_pair['vaihe'];
			$league = $result_pair['sarjatilastoID'];
			
			$team1Id = $result_pair['joukkue1ID'];
			$team2Id = $result_pair['joukkue2ID'];
			$team1 = $teamAccess->getTeamById($team1Id);
			$team2 = $teamAccess->getTeamById($team2Id);
			
			$team1Wins = $result_pair['voitot1'];
			$team2Wins = $result_pair['voitot2'];
			
			$stage = new LeagueStage($id, $stageName, $league, $team1, $team2, $team1Wins, $team2Wins);

		} catch (Exception $e) {
			throw $e;
		}
		return $stage;
	}

}
?>