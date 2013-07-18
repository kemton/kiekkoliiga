<?php
class Season {
	private $id;
	private $name;
	
	public function __construct($id, $name) {
		$this->setId($id);
		$this->setName($name);
	}
		
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
		
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	public function getName() {
		return $this->name;
	}
}
?>