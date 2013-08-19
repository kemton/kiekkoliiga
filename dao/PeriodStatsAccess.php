<?php
class PeriodStatsAccess extends DatabaseAccess {

	private $GET_PERIOD_STATS_BY_MATCH_ID = "SELECT * FROM ottelut_erat WHERE otteluID = :matchId";
	
	public function getPeriodStatsByMatchId($matchId) {
		try {
			$results = parent::executeStatement($this->GET_PERIOD_STATS_BY_MATCH_ID, array("matchId" => $matchId));
			$periodStats = array();
			foreach($results as $row) {
				$era = $row['era'];
				$homeSaves = $row['koti_torjutut'];
				$homePossession = $row['koti_hallinta'];
				$visitorSaves = $row['vieras_torjutut'];
				$visitorPossession = $row['vieras_hallinta'];
				$periodStats['home']['saves'][$era] = $homeSaves;
				$periodStats['home']['possession'][$era] = $homePossession;
				$periodStats['visitor']['saves'][$era] = $visitorSaves;
				$periodStats['visitor']['possession'][$era] = $visitorPossession;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $periodStats;
	}

}
?>