<?php
class UploadAccess extends DatabaseAccess {
	
	private $GET_AVAILABLE_UPLOADS = "SELECT u.uploadID, u.otsikko, u.sarjataulukko, u.ottelut, u.porssi, s.sarjatilastoID, s.sarjaID, s.tyyppi, s.nimi, s.primaari, s.seloste
									FROM upload AS u
									LEFT JOIN sarjatilasto AS s ON s.sarjatilastoID = u.ottelut
									ORDER BY uploadID";
	private $REGULAR_SEASON_UPLOAD_TEAM = "SELECT joukkueID
						FROM joukkuesivu
						WHERE joukkuesivu.sarjatilastoID = :standingId
						ORDER BY nimi";
	private $PLAYOFF_UPLOAD_TEAM = "SELECT ppsarjaID, sarjatilastoID, joukkue1ID, joukkue2ID, vaihe
						FROM ppsarja
						WHERE sarjatilastoID = :standingId
						ORDER BY ppsarjaID DESC";
	private $INIT_MATCH = "SELECT u.uploadID, u.otsikko, u.sarjataulukko AS standingId, u.ottelut, u.porssi, pp.ppsarjaID, pp.joukkue1ID, pp.joukkue2ID, pp.voitot1, pp.voitot2, pp.vaihe
						FROM upload AS u
						LEFT JOIN ppsarja AS pp ON pp.sarjatilastoID = u.ottelut
						WHERE uploadID = :uploadId AND pp.ppsarjaID = :pairId";
	private $ADD_MATCH = "";
	
	public function getAvailableUploads() {
		try {
			$uploads = parent::executeStatement($this->GET_AVAILABLE_UPLOADS, array());
			foreach ($uploads as $upload) {
				if ($upload["tyyppi"] == 'ottelut' || $upload["tyyppi"] == 'yhdistetty') {
					$uploadObj = new UploadRegularSeason($upload["uploadID"], $upload["otsikko"], $upload["sarjataulukko"], $upload["ottelut"], $upload["porssi"], $upload["tyyppi"], $upload["nimi"]);
					$uploadObj->__set('teams', $this->getRegularSeasonLeagueTeams($upload["ottelut"]));
				} elseif ($upload["tyyppi"] == 'pudotuspelit' || $upload["tyyppi"] == 'cup' || $upload["tyyppi"] == 'cup2') {
					$uploadObj = new UploadPlayoff($upload["uploadID"], $upload["otsikko"], $upload["sarjataulukko"], $upload["ottelut"], $upload["porssi"], $upload["tyyppi"], $upload["nimi"]);
					$uploadObj->__set('teams', $this->getPlayoffLeagueTeams($upload["ottelut"]));
				} else {
					throw new Exception('Something went wrong, try again.');
				}
				$uploadList[] = $uploadObj;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return serialize($uploadList);
	}
	
	private function getRegularSeasonLeagueTeams($standingId) {
		try {
			$teams = parent::executeStatement($this->REGULAR_SEASON_UPLOAD_TEAM, array('standingId' => $standingsId));
			$teamAccess = new TeamAccess();
			$teamList = array();
			foreach ($teams as $row) {
				$team = $teamAccess->getTeamById($row["joukkueID"]);
				$teamList[] = $team; 
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $teamList;
	}
	
	private function getPlayoffLeagueTeams($standingId) {
		try {
			$teams = parent::executeStatement($this->PLAYOFF_UPLOAD_TEAM, array('standingId' => $standingId));
			$teamAccess = new TeamAccess();
			$teamList = array();
			foreach ($teams as $row) {
				$uploadPlayoffTeam = new UploadPlayoffTeam();
				$uploadPlayoffTeam->__set('id', $row["ppsarjaID"]);
				$uploadPlayoffTeam->__set('team1', $teamAccess->getTeamById($row["joukkue1ID"]));
				$uploadPlayoffTeam->__set('team2', $teamAccess->getTeamById($row["joukkue2ID"]));
				$teamList[] = $uploadPlayoffTeam; 
			}
		} catch (Exception $e) {
			throw $e;
		}
		return serialize($teamList);
	}
	
	public function initMatchUpload($leagueId, $homeTeamId, $visitorTeamId) {
		try {
			if (!is_numeric($leagueId) || $leagueId == 0) throw new Exception("Invalid league ID");
			if (!is_numeric($homeTeamId) || $homeTeamId == 0) throw new Exception("Invalid hometeam ID");
			if (!is_numeric($visitorTeamId) || $visitorTeamId == 0) throw new Exception("Invalid visitingteam ID");
			
			$result = parent::executeStatement($this->INIT_MATCH, array("leagueId" => $leagueId, "homeTeamId" => $homeTeamId, "visitorTeamId" => $visitorTeamId));
			if (count($result) <> 2) throw new Exception("Something went wrong");
			$leagueAccess = new LeagueAccess();
			$teamAccess = new TeamAccess();
			$match = new Match();
			$match->__set('league', $leagueAccess->getLeagueByLeagueId($leagueId));
			$match->__set('homeTeam', $teamAccess->getTeamById($homeTeamId));
			$match->__set('visitorTeam', $teamAccess->getTeamById($visitorTeamId));
		} catch (Exception $e) {
			throw $e;
		}
		return serialize($match);
	}
	
	public function initPlayoffMatchUpload($uploadId, $pairId) {
		try {
			if (!is_numeric($uploadId) || $uploadId == 0) throw new Exception("Invalid upload ID");
			if (!is_numeric($pairId) || $pairId == 0) throw new Exception("Invalid playoff-pair");
			
			$result = parent::executeStatement($this->INIT_MATCH, array("uploadId" => $uploadId, "pairId" => $pairId));
			if (count($result) <> 2) throw new Exception("Something went wrong");
			$leagueAccess = new LeagueAccess();
			$teamAccess = new TeamAccess();
			$match = new Match();
			$wins1 = $result[0]["voitot1"];
			$wins2 = $result[0]["voitot2"];
			$wins = $wins1+$wins2;
			
			// playing direction
			if ($wins%2) {
				$homeTeam = $result[0]["joukkue1ID"];
				$visitorTeam = $result[0]["joukkue2ID"];
			} else {
				$visitorTeam = $result[0]["joukkue1ID"];
				$homeTeam = $result[0]["joukkue2ID"];
			}
			
			$match->__set('league', $leagueAccess->getLeagueByLeagueId($result[0]["standingId"]));
			$match->__set('homeTeam', $teamAccess->getTeamById($homeTeam));
			$match->__set('visitorTeam', $teamAccess->getTeamById($visitorTeam));
		} catch (Exception $e) {
			throw $e;
		}
		return serialize($match);
	}
	
	public function addMatch(Match $match) {
		$return = false;
		try {
			$params = array(
				"league" => $match->__get('league'),
				"stage" => $match->__get('stage'),
				"homeTeam" => $match->__get('homeTeam'),
				"visitorTeam" => $match->__get('visitorTeam'),
				"homeTeamGoals" => $match->__get('homeTeamGoals'),
				"visitorTeamGoals" => $match->__get('visitorTeamGoals'),
				"homeTeamMatchPlayers" => $match->__get('homeTeamMatchPlayers'),
				"visitorTeamMatchPlayers" => $match->__get('visitorTeamMatchPlayers'),
				"date" => $match->__get('date'),
				"time" => $match->__get('time'),
				"referee" => $match->__get('referee'),
				"walkover" => $match->__get('walkover'),
				"overtime" => $match->__get('overtime'),
				"periodStats" => $match->__get('periodStats')
			);
			$result = parent::updateStatement($this->ADD_MATCH, $params);
			$return = true;
		} catch (Exception $e) {
			$return = false;
			throw $e;
		}
		return $return;
	}

}
?>