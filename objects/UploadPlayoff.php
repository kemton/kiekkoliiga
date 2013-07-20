<?php
class UploadPlayoff extends UploadMatch {
	
	function __construct($uploadId, $header, $standingId, $type, $name) {
		parent::__construct($uploadId, $header, $standingId, $type, $name);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
}
?>