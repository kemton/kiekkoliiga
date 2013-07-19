<?php
class UploadMatchController extends Controller {
	
	public function execute($request) {
		$return = "uploadPage";
		try {
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
				$return = $this->upload();
			}
		} catch (Exception $e) {
			throw $e;
		}
		return  $return;
	}
	
	private function upload() {
		try {
			$uploadAccess = new UploadAccess();
			$_REQUEST["uploads"] = $uploadAccess->getAvailableUploads();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	private function match($requeset) {
		$leagueId = $request["2"];
		$homeTeamId = $request["3"];
		$visitorTeamId = $request["4"];
		try {
			$uploadAccess = new UploadAccess();
			// get teams name and players, and check is valid match (still initialize)
			$_REQUEST["uploadMatch"] = $uploadAccess->initMatchUpload($leagueId, $homeTeamId, $visitorTeamId);
		} catch (Exception $e) {
			throw $e;
		}
		return "uploadMatchPage";
	}
	
	private function addmatch($requeset) {
		$leagueId = $request["2"];
		try {
			$match = new Match();
			$match->__set('league', $_POST["league"]);
			$match->__set('stage', $_POST["league"]);
			$match->__set('homeTeam', $_POST["league"]);
			$match->__set('visitorTeam', $_POST["league"]);
			$match->__set('homeTeamGoals', $_POST["league"]);
			$match->__set('visitorTeamGoals', $_POST["league"]);
			$match->__set('homeTeamMatchPlayers', $_POST["league"]);
			$match->__set('visitorTeamMatchPlayers', $_POST["league"]);
			$match->__set('date', $_POST["league"]);
			$match->__set('time', $_POST["league"]);
			$match->__set('referee', $_POST["league"]);
			$match->__set('walkover', $_POST["league"]);
			$match->__set('overtime', $_POST["league"]);
			$match->__set('periodStats', $_POST["league"]);
			
			$uploadAccess = new UploadAccess();
			$uploadAccess->addMatch($match);
			
		} catch (Exception $e) {
			throw $e;
		}
		return "uploadMatchPage";
	}
}
?>