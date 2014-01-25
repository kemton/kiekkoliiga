<?php
class Deadline {
	private $id;
	private $name;
	private $starts;
	private $ends;
	private $duration;
	private $notes;
	
	public function __construct($id, $name, $starts, $ends, $duration, $notes) {
		$this->__set("id", $id);
		$this->__set("name", $name);
		$this->__set("starts", $starts);
		$this->__set("ends", $ends);
		$this->__set("duration", $duration);
		$this->__set("notes", $notes);
	}
		
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
}
?>