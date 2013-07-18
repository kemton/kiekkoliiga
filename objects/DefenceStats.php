<?php
class DefenceStats {
	private $team;
	private $saves;
	private $goalsAgainst;
	private $savesPerMatch;
	private $goalsAgainstPerMatch;
	private $savesPercent;
	
	public function __construct($saves, $goalsAgainst, $savesPerMatch, $goalsAgainstPerMatch, $savesPercent) {
		$this->__set('saves', $saves);
		$this->__set('goalsAgainst', $goalsAgainst);
		$this->__set('savesPerMatch', $savesPerMatch);
		$this->__set('goalsAgainstPerMatch', $goalsAgainstPerMatch);
		$this->__set('savesPercent', $savesPercent);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
}
?>