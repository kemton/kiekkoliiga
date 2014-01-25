<?php
class Transfer {
	protected $type;
	protected $id;
	protected $datetime;
	protected $invited;
	protected $inviter;
	protected $team;
	protected $active;
	protected $playerApproved;
	protected $adminApproved;
	
	function __construct($type, $id, $datetime, $invited, $inviter, $team, $active, $playerApproved, $adminApproved) {
		$this->__set("type", $type);
		$this->__set("id", $id);
		$this->__set("datetime", $datetime);
		$this->__set("invited", $invited);
		$this->__set("inviter", $inviter);
		$this->__set("team", $team);
		$this->__set("active", $active);
		$this->__set("playerApproved", $playerApproved);
		$this->__set("adminApproved", $adminApproved);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
}
?>