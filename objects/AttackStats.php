<?php
class AttackStats {
	private $team;
	private $shots;
	private $goals;
	private $shotsPerMatch;
	private $goalsPerMatch;
	private $scoringPercent;
	
	public function __construct($shots, $goals, $shotsPerMatch, $goalsPerMatch, $scoringPercent) {
		$this->__set('shots', $shots);
		$this->__set('goals', $goals);
		$this->__set('shotsPerMatch', $shotsPerMatch);
		$this->__set('goalsPerMatch', $goalsPerMatch);
		$this->__set('scoringPercent', $scoringPercent);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
}
?>