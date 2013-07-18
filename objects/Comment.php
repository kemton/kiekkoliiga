<?php
class Comment {
	
	private $id;
	private $writerName;
	private $writer;
	private $commentText;
	private $timestamp;
	private $deleted;
	private $deletedBy;
	

	function __construct ($id, $writerName, $writer, $commentText, $timestamp, $deleted, $deletedBy) {
		$this->__set("id", $id);
		$this->__set("writerName", $writerName);
		$this->__set("writer", $writer);
		$this->__set("commentText", $commentText);
		$this->__set("timestamp", $timestamp);
		$this->__set("deleted", $deleted);
		$this->__set("deletedBy", $deletedBy);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
	
}
?>