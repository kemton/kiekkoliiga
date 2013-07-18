<?php
class BoardInfo {
	private $id;
	private $header;
	private $writer;
	private $time;
	private $text;
	private $read;
	private $comments;
	
	function __construct ($id, $header, $writer, $time, $text, $read, $comments) {
		$this->__set("id", $id);
		$this->__set("header", $header);
		$this->__set("writer", $writer);
		$this->__set("time", $time);
		$this->__set("text", $text);
		$this->__set("read", $read);
		$this->__set("comments", $comments);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
	
}
?>