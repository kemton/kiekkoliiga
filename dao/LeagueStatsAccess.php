<?php
class LeagueStatsAccess extends DatabaseAccess {
	private $GET_COUNT_USERS   = "SELECT count(*) AS users FROM smf_members";
	private $GET_COUNT_PLAYERS = "SELECT count(*) AS players FROM pelaaja";
	private $GET_COUNT_MATCHES = "SELECT count(*) AS matches FROM ottelu";
	private $GET_SUM_STATS     = "SELECT SUM(maalit) AS goals, SUM(syotot) AS assists FROM tehotilasto";
	private $GET_COUNT_COMMENTS = "SELECT COUNT(*) AS comments, (SELECT COUNT(*) AS comments2 FROM kommentointi) AS comments2 FROM kommentit";
	
	public function __construct() {
		parent::__construct();
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
		return serialize($leagueStats);
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