<?php
class Standings {
	private $team;
	private $matches;
	private $wins;
	private $draws;
	private $losses;
	private $goals;
	private $goalsAgainst;
	private $points;
	private $goalDifference;
	private $scoresPerMatch;
	
	public function __construct($matches, $wins, $draws, $losses, $goals, $goalsAgainst, $points, $goalDifference, $scoresPerMatch) {
		$this->__set('matches', $matches);
		$this->__set('wins', $wins);
		$this->__set('draws', $draws);
		$this->__set('losses', $losses);
		$this->__set('goals', $goals);
		$this->__set('goalsAgainst', $goalsAgainst);
		$this->__set('points', $points);
		$this->__set('goalDifference', $goalDifference);
		$this->__set('scoresPerMatch', $scoresPerMatch);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
}
?>