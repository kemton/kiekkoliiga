<?php
class UploadController extends Controller {
	
	public function execute($request) {
		$return = "uploadPage";
		try {
			$user = unserialize($_SESSION["user"]);
			if (!$user->__get('isReferee')) { throw new Exception('You do not have permission. Take contact to board.');}
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
		return "uploadPage";
	}
	
	private function match($request) {
		$leagueId = $request["2"];
		$homeTeamId = $request["3"];
		$visitorTeamId = $request["4"];
		try {
			$uploadAccess = new UploadAccess();
			// get teams name and players, and check is valid match (still initialize)
			$_REQUEST["uploadMatch"] = $uploadAccess->initRegularSeasonMatchUpload($leagueId, $homeTeamId, $visitorTeamId);
		} catch (Exception $e) {
			throw $e;
		}
		return "uploadMatchPage";
	}
	
	private function playoffmatch($request) {
		//$uploadId = $request["2"];
		//$pairId = $request["3"];
		$uploadId = $_GET["uid"];
		$pairId = $_GET["pid"];
		try {
			$uploadAccess = new UploadAccess();
			// get teams name and players, and check is valid match (still initialize)
			$_REQUEST["uploadMatch"] = $uploadAccess->initPlayoffMatchUpload($uploadId, $pairId);
		} catch (Exception $e) {
			throw $e;
		}
		return "uploadMatchPage";
	}
	
	private function addmatch($request) {
		$leagueId = $request["2"];
		try {
			$match = new Match();
			$match->__set('league', $_POST["league"]);
			$match->__set('stage', $_POST["league"]);
			$match->__set('homeTeam', $_POST["homeTeamId"]);
			$match->__set('visitorTeam', $_POST["visitorTeamId"]);
			$match->__set('homeTeamGoals', $_POST["homeTeamGoals"]);
			$match->__set('visitorTeamGoals', $_POST["visitorTeamGoals"]);
			$match->__set('homeTeamMatchPlayers');
			$match->__set('visitorTeamMatchPlayers');
			$match->__set('date');
			$match->__set('time');
			$match->__set('referee', $_POST["referee"]);
			$match->__set('walkover', FALSE);
			$match->__set('overtime', $_POST["overtime"]);
			$match->__set('periodStats');
			
			$uploadAccess = new UploadAccess();
			$uploadAccess->addMatch($match);
			
		} catch (Exception $e) {
			throw $e;
		}
		return "uploadMatchPage";
	}
}
?>