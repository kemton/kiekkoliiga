
<?php
class Page {
	private $id;
	private $name;
	private $header; 
	private $text; 
	
	function __construct($id, $name, $header, $text) {
		$this->__set('id', $id);
		$this->__set('name', $name);
		$this->__set('header', $header);
		$this->__set('text', $text);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
}
?>