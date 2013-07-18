<?php
class PlayerController extends Controller {
	
	public function execute($request) {
		try {
			$leftbar = new LeftbarController();
			$leftbar->execute($request);
			$rightbar = new StatisticsbarController();
			$rightbar->execute($request);
			
			$id = $request[1];
			$stats = new PlayerAccess();
			$action = $request[1];
			$tab = $request[2];
			
			if ($tab <> NULL) {
				if (method_exists(get_class($this), $tab)) {
					$return = $this->$tab($request);
				} else {
					header("Status: 404 Not Found");
				}
			} else {
				if (!is_numeric($id)) {
					$id = urldecode($id);
					$id = utf8_decode($id);
					
					$playerStats = $stats->getPlayerStatsByName($id);
					$_REQUEST["playerStats"] = $playerStats;
					
					/*$player = $stats->getPlayerByName($id);
					$_REQUEST["player"] = $player;
					
					$achievements = $stats->getPlayerAchievementsByName($playerid);
					$_REQUEST["playerAchievements"] = $achievements;
					
					$playerStats = $stats->getPlayerStatsByName($id);
					$_REQUEST["playerStatsGroupedBySeason"] = $playerStats;
					
					$playerTotalStats = $stats->getPlayerTotalStatsByName($id);
					$_REQUEST["playerTotalStats"] = $playerTotalStats;
					
					$playerLastMatches = $stats->getPlayerLastMatchesByName($id);
					$_REQUEST["playerLastMatches"] = $playerLastMatches;
					
					$playerSuspensions = $stats->getPlayerSuspensionsByName($id);
					$_REQUEST["playerSuspensions"] = $playerSuspensions;*/
				}
				$return = "playerPage";
			}
		} catch (Exception $e) {
			$return = "exceptionPage";
			throw $e;
		}
		return $return;
		
	}

	private function achievements($request) {
		$playerName = $request[1];
		try {
			$playerAccess = new PlayerAccess();
			$playerAchievements = $playerAccess->getPlayerAchievementsByName($playerName);
			$_REQUEST["playerAchievements"] = $playerAchievements;
			return "achievementsPage";
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	private function stats($request) {
		$playerName = $request[1];
		try {
			$playerAccess = new PlayerAccess();
			$kiekkotkStats = $playerAccess->getPlayerKiekkotkStatsByName($playerName);
			$_REQUEST["kiekkotkStats"] = $kiekkotkStats;
			return "kiekkotkStatsPage";
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	private function matches($request) {
		
	}
	
}
?>