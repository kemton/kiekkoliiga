<?php
class TeamLeagues {
	private $leagueId;
	private $leagueName;
	private $league;
	
	public function __construct($leagueId, $leagueName, $league) {
		$this->setLeagueId($leagueId);
		$this->setLeagueName($leagueName);
		$this->setLeague($league);
	}
	
	public function setLeagueId($leagueId) {
		$this->leagueId = $leagueId;
	}
	public function getLeagueId() {
		return $this->leagueId;
	}
	
	public function setLeagueName($leagueName) {
		$this->leagueName = $leagueName;
	}
	public function getLeagueName() {
		return $this->leagueName;
	}
	
	public function setLeague($league) {
		$this->league = $league;
	}
	public function getLeague() {
		return $this->league;
	}
}
?>