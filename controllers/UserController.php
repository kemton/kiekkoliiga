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
			if (!is_object($user)) { throw new Exception("Tämä sivu toimii vain sisäänkirjautuneilla.");}
			
			$action = $request[1];
			if ($action <> NULL) {
				if (method_exists(get_class($this), $action)) {
					$return = $this->$action($request);
				} else {
					header("Status: 404 Not Found");
				}
			} else {
				$return = $this->settings();
			}
		} catch (Exception $e) {
			throw $e;
		}
		return  $return;
	}
	
	private function settings() {
		try {
			$user = unserialize($_SESSION['user']);
			$authAccess = new AuthAccess();
			$_REQUEST["isAuthed"] = $authAccess->isUserAuthed($user->__get('id'));
			$_REQUEST["auth"] = serialize($authAccess->getAuthByForumId($user->__get('id')));
		} catch (AuthException $e) {
			//$_REQUEST["auth"] = $e->getMessage();
		} catch (Exception $e) {
			throw $e;
		}
		return "userPage";
	}
	
	private function auth_user() {
		try {
			$user = unserialize($_SESSION['user']);
			$authAccess = new AuthAccess();
			$authAccess->authPlayer($user->__get('id'), $_POST["kiekkonick"], $_POST["authcode"]);
		} catch (Exception $e) {
			throw $e;
		}
		header("Location: /user/");
	}
	
	private function destroy_auth() {
		$user = unserialize($_SESSION['user']);
		$forumId = $user->__get('id');
		$authAccess = new AuthAccess();
		$authAccess->destroyAuthByForumId($forumId);
		header("Location: /user/");
	}
}
?>