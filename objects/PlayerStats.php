<?php
class PlayerStats extends Player {
	private $achievements;
	private $statsPerSeason;
	private $leagueTotalStats;
	private $lastMatches;
	
	function __construct($id, $name, $previousNames, $isAdmin, $isBoard) {
		parent::__construct($id, $name, $previousNames, $isAdmin, $isBoard);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
}
?>