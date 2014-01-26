<?php
class LeagueStage {
	
	private $id;
	private $stageName;
	private $league;
	private $team1;
	private $team2;
	private $team1Wins;
	private $team2Wins;
	

	function __construct ($id, $stageName, $league, $team1, $team2, $team1Wins, $team2Wins) {
		$this->__set("id", $id);
		$this->__set("stageName", $stageName);
		$this->__set("league", $league);
		$this->__set("team1", $team1);
		$this->__set("team2", $team2);
		$this->__set("team1Wins", $team1Wins);
		$this->__set("team2Wins", $team2Wins);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
	
}
?>