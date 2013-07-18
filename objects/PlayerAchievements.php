<?php
class PlayerAchievements {
	private $id;
	private $season;
	private $team;
	private $name;
	private $share;
	
	function __construct($id, $season, $team, $name, $share) {
		$this->__set('id', $id);
		$this->__set('season', $season);
		$this->__set('team', $team);
		$this->__set('name', $name);
		$this->__set('share', $share);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
}
?>