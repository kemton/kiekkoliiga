<?php
class PlayoffsStanding {
	private $team1;
	private $team2;
	private $team1Wins;
	private $team2Wins;
	private $matches = array();
	
	public function __construct($team1, $team2, $team1Wins, $team2Wins, $matches) {
		$this->__set('team1', $team1);
		$this->__set('team2', $team2);
		$this->__set('team1Wins', $team1Wins);
		$this->__set('team2Wins', $team2Wins);
		$this->__set('matches', $matches);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
}
?>