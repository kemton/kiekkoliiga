<?php
class PlayerStatsPerSeason {
	private $season;
	private $leagueLevel;
	private $team;
	private $matches;
	private $goals;
	private $assists;
	private $points;
	private $plusMinus;
	
	function __construct() {
		
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
}
?>