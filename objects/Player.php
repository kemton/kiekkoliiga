<?php
class Player {
	protected $id;
	protected $name;
	protected $team;
	protected $previousNames;
	protected $isAdmin;
	protected $isBoard;
	protected $suspensionsList;
	
	function __construct($id, $name, $team, $previousNames, $isAdmin, $isBoard) {
		$this->__set("id", $id);
		$this->__set("name", $name);
		$this->__set("team", $team);
		$this->__set("previousNames", $previousNames);
		$this->__set("isAdmin", $isAdmin);
		$this->__set("isBoard", $isBoard);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
}
?>