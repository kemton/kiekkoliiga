<?php
class PageController extends Controller {
	
	public function execute($request) {
		try {
			parent::execute($request);
			$page = $request[0];
			//$pageAccess = new PageAccess();
			//$_REQUEST["pageObject"] = $pageAccess->getPageByName();
			
			$action = $request[0];
			if ($action <> NULL) {
				$action = str_replace('-', '', $action);
				if (method_exists(get_class($this), $action)) {
					$return = $this->$action($request);
				} else {
					header("Status: 404 Not Found");
				}
			}
			
			$return = "pagePage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
	private function rules($request) {
		try {
			$pageAccess = new PageAccess();
			$_REQUEST["pageObject"] = $pageAccess->getPageByName("rules");
			
			$return = "rulesPage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
	private function halloffame($request) {
		try {
			$HOFAccess = new HallOfFameAccess();
			$_REQUEST["pageObject"] = $HOFAccess->getAllHOF("hall-of-fame");
			
			$return = "hallOfFamePage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
}
?>