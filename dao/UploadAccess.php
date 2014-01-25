<?php
class UploadAccess extends DatabaseAccess {
	
	private $GET_AVAILABLE_UPLOADS = "SELECT u.uploadID, u.otsikko, u.sarjataulukko, u.ottelut, u.porssi, s.sarjatilastoID, s.sarjaID, s.tyyppi, s.nimi, s.primaari, s.seloste
						FROM upload AS u
						LEFT JOIN sarjatilasto AS s ON s.sarjatilastoID = u.ottelut
						ORDER BY uploadID";
	private $REGULAR_SEASON_UPLOAD_TEAM = "SELECT joukkueID, sarjatilastoID
						FROM joukkuesivu
						WHERE joukkuesivu.sarjatilastoID = :standingId";
	private $PLAYOFF_UPLOAD_TEAM = "SELECT ppsarjaID, sarjatilastoID, joukkue1ID, joukkue2ID, vaihe
						FROM ppsarja
						WHERE sarjatilastoID = :standingId
						ORDER BY ppsarjaID DESC";
	private $INIT_MATCH = "";
	private $INIT_PLAYOFF_MATCH = "SELECT s.sarjaID, u.uploadID, u.otsikko, u.sarjataulukko AS standingId, u.ottelut, u.porssi, pp.ppsarjaID, pp.joukkue1ID, pp.joukkue2ID, pp.voitot1, pp.voitot2, pp.vaihe
						FROM upload AS u
						LEFT JOIN ppsarja AS pp ON pp.sarjatilastoID = u.ottelut
						LEFT JOIN sarjatilasto AS s ON s.sarjatilastoID = u.ottelut
						WHERE uploadID = :uploadId AND pp.ppsarjaID = :pairId";
	private $ADD_MATCH = "INSERT INTO ottelu
						(sarjatilastoID, kotiID, vierasID, kotimaalit, vierasmaalit, tuomari, pvm, aika)
						VALUES (:league, :homeTeamId, :visitorTeamId, :homeTeamGoals, :visitorTeamGoals, :referee, CURDATE(), CURTIME())";
	private $ADD_MATCH_PLAYER = "UPDATE tehotilasto SET
						(joukkueID, ottelut, maalit, syotot, tahdet, maaliero)
						VALUES (:statsid, :leagueid, :playerid, :teamid, :matches, :goals, :assists, :stars, :plusminus)
						WHERE sarjatilastoID = :leagueid AND pelaajaID = :playerid";

	public function getAvailableUploads() {
		try {
			$uploads = parent::executeStatement($this->GET_AVAILABLE_UPLOADS, array());
			$leagueAccess = new LeagueAccess();
			foreach ($uploads as $upload) {
				if ($leagueAccess->isRegularSeason($upload["tyyppi"])) {
					$uploadObj = new UploadRegularSeason($upload["uploadID"], $upload["otsikko"], $upload["sarjataulukko"], $upload["ottelut"], $upload["porssi"], $upload["tyyppi"], $upload["nimi"]);
					$uploadObj->__set('teams', $this->getRegularSeasonLeagueTeams($upload["sarjataulukko"]));
				} elseif ($leagueAccess->isPlayoffLeague($upload["tyyppi"])) {
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
		return $uploadList;
	}

	private function getRegularSeasonLeagueTeams($standingId) {
		try {
			$teams = parent::executeStatement($this->REGULAR_SEASON_UPLOAD_TEAM, array('standingId' => $standingId));
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
				$team1 = $teamAccess->getTeamById($row["joukkue1ID"]);
				$team2 = $teamAccess->getTeamById($row["joukkue2ID"]);
				$uploadPlayoffTeam = new UploadPlayoffTeam($row["ppsarjaID"], $team1, $team2);
				$teamList[] = $uploadPlayoffTeam; 
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $teamList;
	}
	
	private function initMatchUpload($leagueId, $homeTeamId, $visitorTeamId) {
		try {
			$leagueAccess = new LeagueAccess();
			$teamAccess = new TeamAccess();
			/*
			$match = new MatchUpload();
			$match->__set('league', $leagueAccess->getLeagueByLeagueId($leagueId));
			$match->__set('homeTeam', $teamAccess->getTeamById($homeTeamId));
			$match->__set('visitorTeam', $teamAccess->getTeamById($visitorTeamId));*/
			$match = array(
				'league' => $leagueAccess->getLeagueByLeagueId($leagueId),
				'homeTeam' => $teamAccess->getTeamById($homeTeamId),
				'visitorTeam' => $teamAccess->getTeamById($visitorTeamId)
			);
		} catch (Exception $e) {
			throw $e;
		}
		return $match;
	}
	
	public function initRegularSeasonMatchUpload($leagueId, $homeTeamId, $visitorTeamId) {
		try {
			if (!is_numeric($leagueId) || $leagueId == 0) throw new Exception("Invalid league ID");
			if (!is_numeric($homeTeamId) || $homeTeamId == 0) throw new Exception("Invalid hometeam ID");
			if (!is_numeric($visitorTeamId) || $visitorTeamId == 0) throw new Exception("Invalid visitingteam ID");
			
			// Tarkastukset!
			//$result = parent::executeStatement($this->INIT_MATCH, array("leagueId" => $leagueId, "homeTeamId" => $homeTeamId, "visitorTeamId" => $visitorTeamId));
			//if (count($result) <> 2) throw new Exception("Something went wrong");
			$match = $this->initMatchUpload($leagueId, $homeTeamId, $visitorTeamId);
		} catch (Exception $e) {
			throw $e;
		}
		return $match;
	}
	
	public function initPlayoffMatchUpload($uploadId, $pairId) {
		try {
			if (!is_numeric($uploadId) || $uploadId == 0) throw new Exception("Invalid upload ID");
			if (!is_numeric($pairId) || $pairId == 0) throw new Exception("Invalid playoff-pair");
			
			$result = parent::executeStatement($this->INIT_PLAYOFF_MATCH, array("uploadId" => $uploadId, "pairId" => $pairId));
			if (count($result) <> 1) throw new Exception("Something went wrong");
			$leagueAccess = new LeagueAccess();
			$teamAccess = new TeamAccess();
			$wins1 = $result[0]["voitot1"];
			$wins2 = $result[0]["voitot2"];
			$wins = $wins1+$wins2;
			
			// playing direction
			if (!$wins%2) {
				$homeTeamId = $result[0]["joukkue1ID"];
				$visitorTeamId = $result[0]["joukkue2ID"];
			} else {
				$visitorTeamId = $result[0]["joukkue1ID"];
				$homeTeamId = $result[0]["joukkue2ID"];
			}
			$leagueId = $result[0]["sarjaID"];
			$match = $this->initMatchUpload($leagueId, $homeTeamId, $visitorTeamId);
		} catch (Exception $e) {
			throw $e;
		}
		return $match;
	}
	
	public function addMatch(Match $match) {
		die('addMatch debug');
		try {
			parent::beginTransaction();
			
			$params = array(
				"league" => $match->__get('league'),
				"stage" => $match->__get('stage'),
				"homeTeamId" => $match->__get('homeTeam')->__get('name'),
				"visitorTeamId" => $match->__get('visitorTeam')->__get('name'),
				"homeTeamGoals" => $match->__get('homeTeamGoals'),
				"visitorTeamGoals" => $match->__get('visitorTeamGoals'),
				"date" => $match->__get('date'),
				"time" => $match->__get('time'),
				"referee" => $match->__get('referee'),
				"walkover" => $match->__get('walkover'),
				"overtime" => $match->__get('overtime'),
				"periodStats" => $match->__get('periodStats')
			);
			
			foreach ($match->__get('homeTeamMatchPlayers') as $player) {
				$this->uploadMatchPlayer($player, $match->__get('league'));
			}
			
			foreach ($match->__get('visitorTeamMatchPlayers') as $player) {
				$this->uploadMatchPlayer($player, $match->__get('league'));
			}
			
			$result = parent::updateStatement($this->ADD_MATCH, $params);
			parent::commit();
			
			return parent::lastInsertId();
			
		} catch (Exception $e) {
			parent::rollBack();
			throw $e;
		}
	}
	
	private function uploadMatchPlayer(MatchPlayer $matchPlayer, $leagueid) {
		try {
			$params = array(
				"player" => $matchPlayer->__get('player'),
				"goals" => $matchPlayer->__get('goals'),
				"assists" => $matchPlayer->__get('assists'),
				"plusminus" => $matchPlayer->__get('plusminus'),
				"leagueid" => $leagueid
			);
			$result = parent::updateStatement($this->ADD_MATCH_PLAYER, $params);
		} catch (Exception $e) {
			throw $e;
		}
	}

}
?>