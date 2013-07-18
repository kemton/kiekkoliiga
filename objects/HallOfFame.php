<?php
class HallOfFame {
	private $id;
	private $adder;
	private $ip;
	private $player;
	private $text;
	private $time;
	
	public function __construct($id, $adder, $ip, $player, $text, $time) {
		$this->__set("id", $id);
		$this->__set("adder", $adder);
		$this->__set("ip", $ip);
		$this->__set("player", $player);
		$this->__set("text", $text);
		$this->__set("time", $time);
	}
		
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
}
?>