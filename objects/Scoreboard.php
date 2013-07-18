<?php
class Scoreboard {
	private $player;
	private $team;
	private $matches;
	private $goals;
	private $assists;
	private $points;
	private $pointsPerMatch;
	private $plusMinus;
	
	public function __construct($matches, $goals, $assists, $points, $pointsPerMatch, $plusMinus) {
		$this->__set('matches', $matches);
		$this->__set('goals', $goals);
		$this->__set('assists', $assists);
		$this->__set('points', $points);
		$this->__set('pointsPerMatch', $pointsPerMatch);
		$this->__set('plusMinus', $plusMinus);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
}
?>