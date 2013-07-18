<?php
class PlayerLeagueTotalStats {
	private $league;
	private $matches;
	private $goals;
	private $assists;
	private $points;
	
	function __construct($league, $matches, $goals, $assists, $points) {
		$this->__set('league', $league);
		$this->__set('matches', $matches);
		$this->__set('goals', $goals);
		$this->__set('assists', $assists);
		$this->__set('points', $points);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
}
?>