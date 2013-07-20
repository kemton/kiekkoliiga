<?php
class UploadAccess extends DatabaseAccess {
	
	private $GET_AVAILABLE_UPLOADS = "SELECT u.uploadID, u.otsikko, u.sarjataulukko, u.ottelut, u.porssi, s.sarjatilastoID, s.sarjaID, s.tyyppi, s.nimi, s.primaari, s.seloste FROM upload AS u
									LEFT JOIN sarjatilasto AS s ON s.sarjatilastoID = u.ottelut
									ORDER BY uploadID";
	private $REGULAR_SEASON_UPLOAD_TEAM = "SELECT joukkueID
						FROM joukkuesivu
						WHERE joukkuesivu.sarjatilastoID = :standingId
						ORDER BY nimi";
	private $PLAYOFF_UPLOAD_TEAM = "SELECT ppsarjaID, joukkue1ID, joukkue2ID
						FROM ppsarja
						WHERE sarjatilastoID = :matchId
						ORDER BY ppsarjaID DESC";
	private $INIT_MATCH = "";
	private $ADD_MATCH = "";
	
	public function getAvailableUploads() {
		try {
			$uploads = parent::executeStatement($this->GET_AVAILABLE_UPLOADS, array());
			$uploadObj = new Upload();
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
	
	public function getRegularSeasonLeagueTeams($standingId) {
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
	
	public function getPlayoffLeagueTeams($matchId) {
		try {
			$teams = parent::executeStatement($this->PLAYOFF_UPLOAD_TEAM, array('matchId' => $matchId));
			$teamAccess = new TeamAccess();
			$teamList = array();
			foreach ($teams as $row) {
				$uploadPlayoffTeam = new UploadPlayoffTeam();
				$uploadPlayoffTeam->__set('team1', $teamAccess->getTeamById($row["joukkueID1"]));
				$uploadPlayoffTeam->__set('team2', $teamAccess->getTeamById($row["joukkueID2"]));
				$teamList[] = $uploadPlayoffTeam; 
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $uploadPlayoffTeam;
	}
	
	public function initMatchUpload($leagueId, $homeTeamId, $visitorTeamId) {
		try {
			if (!is_numeric($leagueId) || $leagueId == 0) throw new Exception("Invalid league ID");
			if (!is_numeric($homeTeamId) || $homeTeamId == 0) throw new Exception("Invalid hometeam ID");
			if (!is_numeric($visitorTeamId) || $visitorTeamId == 0) throw new Exception("Invalid visitingteam ID");
			
			$result = parent::executeStatement($this->INIT_MATCH, array("leagueId" => $leagueId, "homeTeamId" => $homeTeamId, "visitorTeamId" => $visitorTeamId));
			if (count($result) <> 2) throw new Exception("Something is wrong");
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