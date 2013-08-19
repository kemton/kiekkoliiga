<?php
class UserController extends Controller {
	
	public function execute($request) {
		$return = "userPage";
		try {
			$user = unserialize($_SESSION["user"]);
			$leftbar = new LeftbarController();
			$leftbar->execute($request);
			$rightbar = new RightbarController();
			$rightbar->execute($request);
			
			$action = $request[1];
			if ($action <> NULL) {
				if (method_exists(get_class($this), $action)) {
					$return = $this->$action($request);
				} else {
					header("Status: 404 Not Found");
				}
			} else {
				$return = $this->auth();
			}
		} catch (Exception $e) {
			throw $e;
		}
		return  $return;
	}
	
	private function auth() {
		try {
			
		} catch (Exception $e) {
			throw $e;
		}
		return "userPage";
	}
	
}
?>