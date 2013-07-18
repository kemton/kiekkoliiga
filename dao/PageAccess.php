<?php
class PageAccess extends DatabaseAccess {
	private $GET_PAGE_BY_NAME = "SELECT id, header, text FROM pages WHERE name = :pageName";

	
	public function __construct() {
		parent::__construct();
	}
	
	public function getPageByName($pageName) {
		try {
			$result = parent::executeStatement($this->GET_PAGE_BY_NAME, array("pageName" => $pageName));
			$page = $result[0];
			$id = $page["id"];
			$header = $page["header"];
			$text = $page["text"];
			
			$page = new Page($id, $pageName, $header, $text);
		} catch (Exception $e) {
			throw $e;
		}
		return serialize($page);
	}
	
}
?>