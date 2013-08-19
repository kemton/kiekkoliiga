<?php
class SeasonAccess extends DatabaseAccess {
	private $GET_SEASON_BY_ID = "SELECT kausi.kausiID, kausi.kausi FROM kausi WHERE kausi.kausiID = :seasonid";
	private $GET_LATEST_SEASON = "SELECT kausi.kausiID, kausi.kausi FROM kausi ORDER BY kausi.kausiID DESC LIMIT 1";
	private $GET_ALL_SEASONS 	 =  "SELECT kausiID, kausi FROM kausi ORDER BY kausiID DESC";
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getSeasonById($seasonId) {
		try {
			$seasonResult = parent::executeStatement($this->GET_SEASON_BY_ID, array("seasonid" => $seasonId));
			$id = $seasonResult[0]["kausiID"];
			$name = $seasonResult[0]["kausi"];
			
			$season = new Season($id, $name);
		} catch (Exception $e) {
			throw $e;
		}
		return $season;
	}
	
	public function getLatestSeason() {
		try {
			$seasonResult = parent::executeStatement($this->GET_LATEST_SEASON, array());
			$id = $seasonResult[0]["kausiID"];
			$name = $seasonResult[0]["kausi"];
			
			$season = new Season($id, $name);
		} catch (Exception $e) {
			throw $e;
		}
		return $season;
	}
	
	public function getAllSeasons() {
		try {
			$seasonsResult = parent::executeStatement($this->GET_ALL_SEASONS, array());
			$seasons = array();
			foreach ($seasonsResult as $value) {
				$id = $value["kausiID"];
				$name = $value["kausi"];
				
				$newSeason = new Season($id, $name);
				$seasons[] = $newSeason;
			}
			
		} catch (Exception $e) {
			throw $e;
		}
		return $seasons;
	}
}
?>