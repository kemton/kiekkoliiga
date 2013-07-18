<?php
class Team {
	private $id;
	private $name;
	private $abbreviation;
	private $homeJersey;
	private $guestJersey;
	private $ircChannel;
	private $players = array();
	
	function __construct ($id, $name, $abbreviation, $homeJersey, $guestJersey, $ircChannel) {
		$this->__set("id", $id);
		$this->__set("name", $name);
		$this->__set("abbreviation", $abbreviation);
		$this->__set("homeJersey", $homeJersey);
		$this->__set("guestJersey", $guestJersey);
		$this->__set("ircChannel", $ircChannel);
		/*$this->setid($id);
		$this->setName($name);
		$this->setAbbreviation($abbreviation);
		$this->setHomeJersey($homeJersey);
		$this->setGuestJersey($guestJersey);
		$this->setIrcChannel($ircChannel);*/
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
	
	/*public function setId($id) {
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
	
	public function setAbbreviation($abbreviation) {
		$this->abbreviation = $abbreviation;
	}
	public function getAbbreviation() {
		return $this->abbreviation;
	}
	
	public function setHomeJersey($homeJersey) {
		$this->homeJersey = $homeJersey;
	}
	public function getHomeJersey() {
		return $this->homeJersey;
	}
	
	public function setGuestJersey($guestJersey) {
		$this->guestJersey = $guestJersey;
	}
	public function getGuestJersey() {
		return $this->guestJersey;
	}
	
	public function setIrcChannel($ircChannel) {
		$this->ircChannel = $ircChannel;
	}
	public function getIrcChannel() {
		return $this->ircChannel;
	}
	*/
	public function setPlayer($player) {
		array_push($this->players, $player);
	}/*
	public function getPlayers() {
		return $this->players;
	}*/
	
}
?>