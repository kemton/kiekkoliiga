<?php
class League {
	private $id;
	private $name;
	private $leagueLevel;
	private $season;
	private $conference;
	private $steers = array(); //sarjatilastot
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
	
	public function setSteer($steer) {
		array_push($this->steers, $steer);
	}
}
?>