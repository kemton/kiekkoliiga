<?php
class KiekkoPlayer {
	
	private $id;
	private $name;
	private $isVIP;
	private $country;
	private $team;
	private $created;
	private $lookingForTeam;
	private $experienceLevel;
	private $autoplayLevel;
	private $leftDuringGame;
	private $lastOnline;
	private $freeText;
	private $hideStats;
	private $kiekkoPlayerStats = array();
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
	
}
?>