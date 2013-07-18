<?php
class BoardController extends Controller {
	
	public function execute($request) {
		try {
			parent::execute($request);
			
			$pageAccess = new PageAccess();
			$page = $pageAccess->getPageByName("board");
			$_REQUEST["pageObject"] = $page;
			
			$return = "boardPage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
}
?>