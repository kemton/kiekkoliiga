<?php
class PlayerSuspension {
	private $description;
	private $length;
	private $type;
	private $date;
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
}
?>