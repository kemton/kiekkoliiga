<?php
class MatchPlayer {
	
	private $player;
	private $goals;
	private $assists;
	private $plusminus;
	
	
	function __construct ($player, $goals, $assists, $plusminus) {
		$this->__set("player", $player);
		$this->__set("goals", $goals);
		$this->__set("assists", $assists);
		$this->__set("plusminus", $plusminus);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
	
}
?>