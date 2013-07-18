<?php
class User {
	private $id;
	private $name;
	private $isAdmin; // Site administrator
	private $player; // if user have player profile
	private $isReferee;
	
	function __construct($id, $name, $isAdmin) {
		$this->__set('id', $id);
		$this->__set('name', $name);
		$this->__set('isAdmin', $isAdmin);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
}
?>