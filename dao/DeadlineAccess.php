<?php
class DeadlineAccess extends DatabaseAccess {
	private $GET_CURRENT_DEADLINE = "SELECT id, name, DATE_FORMAT(deadline, '%Y-%m-%d %h:%i:%s') as deadline FROM deadlines ORDER BY deadline LIMIT 1";
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getCurrentDeadline() {
		try {
			$result = parent::executeStatement($this->GET_CURRENT_DEADLINE, array());
			$id = $result[0]["id"];
			$name = $result[0]["name"];
			$timestamp = $result[0]["deadline"];
			
			$deadline = new Deadline($id, $name, $timestamp);
		} catch (Exception $e) {
			throw $e;
		}
		return serialize($deadline);
	}
}
?>