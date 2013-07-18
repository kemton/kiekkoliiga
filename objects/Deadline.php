<?php
class Deadline {
	private $id;
	private $name;
	private $deadline;
	
	public function __construct($id, $name, $deadline) {
		$this->__set("id", $id);
		$this->__set("name", $name);
		$this->__set("deadline", $deadline);
	}
		
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
}
?>