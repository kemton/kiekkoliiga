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
			$_REQUEST["uploads"] = serialize($uploadAccess->getAvailableUploads());
		} catch (Exception $e) {
			throw $e;
		}
		return "uploadPage";
	}
	
	private function match($request) {
		/*$leagueId = $request["2"];
		$homeTeamId = $request["3"];
		$visitorTeamId = $request["4"];*/
		$leagueId = $_GET["leagueid"];
		$homeTeamId = $_GET["hometeam"];
		$visitorTeamId = $_GET["visitorteam"];
		try {
			$uploadAccess = new UploadAccess();
			// get teams name and players, and check is valid match (still initialize)
			$_REQUEST["uploadMatch"] = serialize($uploadAccess->initRegularSeasonMatchUpload($leagueId, $homeTeamId, $visitorTeamId));
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
			$_REQUEST["uploadMatch"] = serialize($uploadAccess->initPlayoffMatchUpload($uploadId, $pairId));
		} catch (Exception $e) {
			throw $e;
		}
		return "uploadMatchPage";
	}
	
	private function addmatch($request) {
		$leagueId = $request["2"];
		try {
			$playerAccess = new PlayerAccess();
			$teamAccess = new TeamAccess();
			$stage = $leagueStageAccess->getLeagueStageById($stageId);
			
			$match = new Match(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
			$match->__set('league', $_POST["league"]);
			$match->__set('stage', $_POST["league"]);
			$match->__set('homeTeam', $teamAccess->getTeamById($_POST["homeTeamId"]));
			$match->__set('visitorTeam', $teamAccess->getTeamById($_POST["visitorTeamId"]));
			$match->__set('homeTeamGoals', $_POST["homeTeamGoals"]);
			$match->__set('visitorTeamGoals', $_POST["visitorTeamGoals"]);
			$match->__set('hasReport', isset($_POST["report"]));
			$match->__set('report', $_POST["report"]);
			
			$homePlayerList = array();
			for ($i=1; $i < 9; $i++) {
				if (!$_POST["homePlayer{$i}"] == 0) {
					$player = $playerAccess->getPlayerById($_POST["homePlayer{$i}"]);
					$goals = $_POST["homePlayerGoals{$i}"];
					$assists = $_POST["homePlayerAssists{$i}"];
					$plusMinus = $_POST["homePlayerPlusMinus{$i}"];
					$matchPlayer = new MatchPlayer($player, $goals, $assists, $plusMinus);
					$homePlayerList[] = $matchPlayer;
				}
			}
			$match->__set('homeTeamMatchPlayers', $homePlayerList);
			
			$visitingPlayerList = array();
			for ($i=1; $i < 9; $i++) {
				if (!$_POST["visitingPlayer{$i}"] == 0) {
					$player = $playerAccess->getPlayerById($_POST["visitingPlayer{$i}"]);
					$goals = $_POST["visitingPlayerGoals{$i}"];
					$assists = $_POST["visitingPlayerAssists{$i}"];
					$plusMinus = $_POST["visitingPlayerPlusMinus{$i}"];
					$matchPlayer = new MatchPlayer($player, $goals, $assists, $plusMinus);
					$visitingPlayerList[] = $matchPlayer;
				}
			}
			$match->__set('visitorTeamMatchPlayers', $visitingPlayerList);
			
			$match->__set('date', date("Y-m-d"));
			$match->__set('time', date("H:i:s"));
			$match->__set('referee', $_POST["referee"]);
			$match->__set('walkover', FALSE);
			$match->__set('overtime', $_POST["overtime"]);
			for ($i=1; $i < 4; $i++) {
				$homeTeamControl = $_POST["homeTeamControl{$i}"];
				$visitingTeamControl = $_POST["visitingTeamControl{$i}"];
				
				$homeTeamSaves = $_POST["homeTeamSaves{$i}"];
				$visitingTeamSaves = $_POST["VisitingTeamSaves{$i}"];
				
				// Ei pystytä laskemaan eräkohtasia laukauksia, kun ei ole eräkohtaista maalitilastointia
				$homeTeamShots = $homeTeamSaves + $_POST["visitorTeamGoals"];
				$visitingTeamShots = $visitingTeamSaves + $_POST["homeTeamGoals"];
				
				$periodStats = new MatchPeriod($i, $homeTeamControl, $visitingTeamControl, $homeTeamShots, $visitingTeamShots, $homeTeamSaves, $visitingTeamSaves);
				$periodStatsList[] = $periodStats;
			}
			
			$match->__set('periodStats', $periodStatsList);
			
			$uploadAccess = new UploadAccess();
			//$_REQUEST["addedMatchId"] = serialize($uploadAccess->addMatch($match));
			
			echo "<pre>";
			print_r($match);
			echo "</pre>";
		} catch (Exception $e) {
			throw $e;
		}
		return "addMatchPage";
	}
}
?>