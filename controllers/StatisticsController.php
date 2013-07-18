<?php
class StatisticsController extends Controller {
	
	public function execute($request) {
		$return = "statisticsPage";
		
		try {
			$leftbar = new LeftbarController();
			$leftbar->execute($request);
			$rightbar = new StatisticsbarController();
			$rightbar->execute($request);
			
			$action = $request[1];
			if ($action <> NULL) {
				if (method_exists(get_class($this), $action)) {
					$return = $this->$action($request);
				} else {
					header("Status: 404 Not Found");
				}
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}

	private function sarjataulukko($model) {
		$id = $model[2];
		try {
			$stats = new StatisticsAccess();
			$_REQUEST["standings"] = $stats->getStandingsById($id);
		} catch (Exception $e) {
			throw $e;
		}
		return "standingsPage";
	}
	
	private function pisteporssi($model) {
		$id = $model[2];
		try {
			$stats = new StatisticsAccess();
			$_REQUEST["scoreboard"] = $stats->getScoreboardById($id);
		} catch (Exception $e) {
			throw $e;
		}
		return "scoreboardPage";
	}
	
	private function ottelut($model) {
		$id = $model[2];
		try {
			$stats = new StatisticsAccess();
			$_REQUEST["matches"] = $stats->getMatchesById($id);
		} catch (Exception $e) {
			throw $e;
		}
		return "matchesPage";
	}
	
	private function ottelu($model) {
		$id = $model[2];
		try {
			$stats = new StatisticsAccess();
			$_REQUEST["match"] = $stats->getMatchById($id);
		} catch (Exception $e) {
			throw $e;
		}
		return "matchPage";
	}
	
	private function attack($model) {
		$id = $model[2];
		try {
			$stats = new StatisticsAccess();
			$_REQUEST["attackStats"] = $stats->getAttackStatsById($id);
		} catch (Exception $e) {
			throw $e;
		}
		return "attackPage";
	}
	
	private function defence($model) {
		$id = $model[2];
		try {
			$stats = new StatisticsAccess();
			$_REQUEST["defenceStats"] = $stats->getDefenceStatsById($id);
		} catch (Exception $e) {
			throw $e;
		}
		return "defencePage";
	}
	
	private function yhdistetty($model) {
		$id = $model[2];
		try {
			$stats = new StatisticsAccess();
			$_REQUEST["conferenceStanding"] = $stats->getStandingsById($id);
			$_REQUEST["conferenceMatches"] = $stats->getMatchesById($id);
		} catch (Exception $e) {
			throw $e;
		}
		return "conferencePage";
	}
	
	private function pudotuspelit($model) {
		$id = $model[2];
		try {
			$stats = new StatisticsAccess();
			$_REQUEST["playoffsStanding"] = $stats->getPlayoffsStanding($id);
		} catch (Exception $e) {
			throw $e;
		}
		return "playoffsPage";
	}
	
	public function leaguestats($request) {
		try {
			$leagueStatsAccess = new LeagueStatsAccess();
			$_REQUEST["leagueStats"] = $leagueStatsAccess->getLeagueStats();
		} catch (Exception $e) {
			throw $e;
		}
		return "leagueStatsPage";
	}
	
	public function searchplayer($request) {
		$key = $request[2];
		try {
			$playerAccess = new PlayerAccess();
			$_REQUEST["searchResult"] = $playerAccess->searchPlayer($key);
		} catch (Exception $e) {
			throw $e;
		}
		return "searchPlayerPage";
	}
	
	public function searchteam($request) {
		$key = $request[2];
		try {
			$teamAccess = new TeamAccess();
			$_REQUEST["searchResult"] = $teamAccess->searchTeam($key);
		} catch (Exception $e) {
			throw $e;
		}
		return "searchTeamPage";
	}
}
?>