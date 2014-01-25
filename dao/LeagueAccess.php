<?php
class LeagueAccess extends DatabaseAccess {
	private $GET_ALL_LEAGUES_BY_SEASONID = "SELECT DISTINCT(sarja.sarjaID), sarja.kausiID FROM sarja
										LEFT JOIN sarjatilasto ON sarjatilasto.sarjaID = sarja.sarjaID
										WHERE sarja.kausiID = :seasonid AND sarja.sarjataso <> 'cup'";
	private $GET_LEAGUES_DATA_BY_LEAGUEID = "SELECT sarja.sarjaID, kausi.kausiID, kausi.kausi, sarja.sarjataso, sarja.nimi AS sarjaNimi, sarja.lohkot, sarjatilasto.sarjatilastoID, sarjatilasto.tyyppi, sarjatilasto.nimi AS sarjatasoNimi
										FROM sarja
										LEFT JOIN sarjatilasto ON sarjatilasto.sarjaID = sarja.sarjaID
										LEFT JOIN kausi ON kausi.kausiID = sarja.kausiID
										WHERE sarja.sarjaID = :leagueId AND sarja.sarjataso <> 'cup'";
	private $GET_COUNT_USERS   = "SELECT count(*) AS users FROM smf_members";
	private $GET_COUNT_PLAYERS = "SELECT count(*) AS players FROM pelaaja";
	private $GET_COUNT_MATCHES = "SELECT count(*) AS matches FROM ottelu";
	private $GET_SUM_STATS     = "SELECT SUM(maalit) AS goals, SUM(syotot) AS assists FROM tehotilasto";
	private $GET_COUNT_COMMENTS = "SELECT COUNT(*) AS comments, (SELECT COUNT(*) AS comments2 FROM kommentointi) AS comments2 FROM kommentit";
	
	public function __construct() {
		parent::__construct();
	}
	
	public function isRegularSeason($leagueType) {
		if ($leagueType == 'ottelut' || $leagueType == 'yhdistetty') {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function isPlayoffLeague($leagueType) {
		if ($leagueType == 'pudotuspelit' || $leagueType == 'cup' || $leagueType == 'cup2') {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function getAllLeaguesBySeasonId($seasonId) {
		try {
			$leaguesResult = parent::executeStatement($this->GET_ALL_LEAGUES_BY_SEASONID, array("seasonid" => $seasonId));
			$leagues = array();
			foreach ($leaguesResult as $value) {
				$league = $this->getLeagueByLeagueId($value["sarjaID"]);
				$leagues[] = $league;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $leagues;
	}
	
	// getLeagueBy sarja.sarjaID
	public function getLeagueByLeagueId($leagueId) {
		try {
			$seasonAccess = new SeasonAccess();
			$leagueResult = parent::executeStatement($this->GET_LEAGUES_DATA_BY_LEAGUEID, array("leagueId" => $leagueId));
			$season = $seasonAccess->getSeasonById($leagueResult[0]["kausiID"]);
			$league = new League;
			$league->__set('id', $leagueResult[0]["sarjaID"]);
			$league->__set('leagueLevel', $leagueResult[0]["sarjataso"]);
			$league->__set('name', $leagueResult[0]["sarjaNimi"]);
			$league->__set('season', $season);
			$league->__set('conference', $leagueResult[0]["lohkot"]);
			
			foreach ($leagueResult as $value) {
				$leagueSteer = new LeagueSteer;
				$leagueSteer->__set('leagueSteerId', $value["sarjatilastoID"]);
				$leagueSteer->__set('leagueSteerName', $value["sarjatasoNimi"]);
				$leagueSteer->__set('leagueSteerType', $value["tyyppi"]);
				$league->setSteer($leagueSteer);
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $league;
	}
	
	public function getLeagueStats() {
		try {
			$users = $this->getCountUsers();
			$players = $this->getCountPlayers();
			$matches = $this->getCountMatches();
			$goals = $this->getSumGoals();
			$assists = $this->getSumAssists();
			$points = $goals + $assists;
			$comments = $this->getCountComments();
			$leagueStats = new LeagueStats($users, $players, $matches, $goals, $assists, $points, $comments);
		} catch (Exception $e) {
			throw $e;
		}
		return $leagueStats;
	}
	
	public function getCountUsers() {
		try {
			$result = parent::executeStatement($this->GET_COUNT_USERS, array());
			$users = $result[0]["users"];
		} catch (Exception $e) {
			throw $e;
		}
		return $users;
	}
	
	public function getCountPlayers() {
		try {
			$result = parent::executeStatement($this->GET_COUNT_PLAYERS, array());
			$players = $result[0]["players"];
		} catch (Exception $e) {
			throw $e;
		}
		return $players;
	}
	
	public function getCountMatches() {
		try {
			$result = parent::executeStatement($this->GET_COUNT_MATCHES, array());
			$matches = $result[0]["matches"];
		} catch (Exception $e) {
			throw $e;
		}
		return $matches;
	}
	
	public function getSumGoals() {
		try {
			$result = parent::executeStatement($this->GET_SUM_STATS, array());
			$goals = $result[0]["goals"];
		} catch (Exception $e) {
			throw $e;
		}
		return $goals;
	}
	
	public function getSumAssists() {
		try {
			$result = parent::executeStatement($this->GET_SUM_STATS, array());
			$assists = $result[0]["assists"];
		} catch (Exception $e) {
			throw $e;
		}
		return $assists;
	}
	
	public function getCountComments() {
		try {
			$result = parent::executeStatement($this->GET_COUNT_COMMENTS, array());
			$comments1 = $result[0]["comments"];
			$comments2 = $result[0]["comments2"];
			$comments = $comments1 + $comments2;
		} catch (Exception $e) {
			throw $e;
		}
		return $comments;
	}
	
}
?>