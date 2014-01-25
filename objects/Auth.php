<?php
class Auth {
	
	private $forumId;
	private $name;
	private $kiekkoId;
	private $playerId;
	private $experienceLevel;
	private $created;
			 
	function __construct ($forumId, $name, $kiekkoId, $playerId, $experienceLevel, $created) {
		$this->__set("forumId", $forumId);
		$this->__set("name", $name);
		$this->__set("kiekkoId", $kiekkoId);
		$this->__set("playerId", $playerId);
		$this->__set("experienceLevel", $experienceLevel);
		$this->__set("created", $created);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
	
}
?>