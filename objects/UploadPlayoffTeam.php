<?php
class UploadPlayoffTeam {
	private $id;
	private $team1;
	private $team2;
	
	function __construct($id, $teams1, $teams2) {
		$this->__set("id", $id);
		$this->__set("team1", $team1);
		$this->__set("team2", $team2);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
}
?>