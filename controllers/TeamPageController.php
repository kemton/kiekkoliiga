<?php
class TeamPageController extends Controller {
	
	public function execute($request) {
		try {
			$leftbar = new LeftbarController();
			$leftbar->execute($request);
			$rightbar = new StatisticsbarController();
			$rightbar->execute($request);
			
			
			$id = urldecode($request[1]);
			
			$season = ApplicationHelper::getSeason();
			$seasonId = $season->__get("id");
			$teamAccess = new TeamAccess();
			$statisticsAccess = new StatisticsAccess();

			if (!is_numeric($id)) { // If parameter is name
				$name = urldecode($id);
				$name = utf8_decode($name);
				$team = $teamAccess->getTeamByName($name);
				$id = $team->__get("id");
			}
			
			$team = $teamAccess->getTeamById($id);
			$teamPressReleases = $teamAccess->getTeamPressReleasesById($id);
			$teamSeasons = $teamAccess->getTeamSeasonLeaguesWithTypesById($id, $seasonId);
			
			foreach($teamSeasons as &$season) {
				$type = $season['type'];
				if ($type == 'pudotuspelit' || $type == 'ottelut' || $type == 'yhdistetty' || $type == 'cup2'){
					$season['matches'] = $teamAccess->getTeamMatchesByCompetitionIdAndTeamId($season['competitionId'], $id);
				}
				else if ($type == 'pisteporssi'){
					$season['statsPlayers'] = $statisticsAccess->getCompetitionStatsForPlayersByCompetitionIdAndTeamId($id, $season['competitionId']);
				}
			}
			
			
			$teamHistory["players"] = $teamAccess->getAllPlayersByTeamId($id);
			$teamHistory["seasonPlacings"] = $teamAccess->getTeamSeasonPlacingsByTeamId($id);
			$teamHistory["regularSeasonStatistics"] = $teamAccess->getRegularSeasonStatisticsByTeamId($id);
			$allSeasonStatistics = $teamAccess->getPlayoffsSeasonStatisticsByTeamId($id);
			
			$previousPlayoffs = "";
			foreach($allSeasonStatistics as $rivi) {
				if($rivi["nimi"] != $previousPlayoffs) {
					$tehdyt = 0;
					$paastetyt = 0;
					$voitot = 0;
					$tasapelit = 0;
					$tappiot = 0;
					$ottelut = 0;
					$tm = 0;
					$pm = 0;
				}
				if ($id == $rivi["kotiID"]){
					$tehdyt = $rivi["kotimaalit"];
					$paastetyt = $rivi["vierasmaalit"];
				}
				else {
					$tehdyt = $rivi["vierasmaalit"];
					$paastetyt = $rivi["kotimaalit"];
				}
			
				if ($tehdyt > $paastetyt){
					$voitot++;
				}
				else if ($tehdyt == $paastetyt){
					$tasapelit++;
				}
				else {
					$tappiot++;
				}
				$ottelut++;
				
				if ($rivi["luovutusvoitto"] == 'ei'){
					$tm = $tm + $tehdyt;
					$pm = $pm + $paastetyt;
				}
				
				$maaliero = $tm - $pm;
				
				$playoffs = array();
				$playoffs['matches'] = $ottelut;
				$playoffs['scored'] = $tm;
				$playoffs['againstScored'] = $pm;
				$playoffs['wins'] = $voitot;
				$playoffs['ties'] = $tasapelit;
				$playoffs['loses'] = $tappiot;
				$playoffs['goalDifference'] = $maaliero;
				
				$teamHistory["playoffsSeasonStatistics"]["{$rivi['nimi']}"] = $playoffs;
				$previousPlayoffs = $rivi["nimi"];
			}
			
			$_REQUEST["team"] = serialize($team);
			$_REQUEST["teamSeasons"] = serialize($teamSeasons);
			$_REQUEST["teamPressReleases"] = serialize($teamPressReleases);
			$_REQUEST["teamHistory"] = serialize($teamHistory);
			
			$return = "teamPage";
		} catch (Exception $e) {
			$return = "exceptionPage";
			throw $e;
		}
		return $return;
	}
	
	
	
}
?>