<?php
abstract class UploadMatch {
	protected $id;
	protected $header;
	protected $standingId;
	protected $matchId;
	protected $scoreboardId;
	protected $type;
	protected $name;
	protected $teams = array();
	
	function __construct($id, $header, $standingId, $matchId, $scoreboardId, $type, $name) {
		$this->__set("id", $id);
		$this->__set("header", $header);
		$this->__set("standingId", $standingId);
		$this->__set("matchId", $matchId);
		$this->__set("scoreboardId", $scoreboardId);
		$this->__set("type", $type);
		$this->__set("name", $name);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
}
?>