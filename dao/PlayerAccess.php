<?php
class PlayerAccess extends DatabaseAccess {
	private $GET_PLAYER_DATA_BY_ID = "SELECT pelaaja.pelaajaID, pelaaja.nimi, pelaaja.joukkueID, joukkue.nimi AS joukkueNimi, pelaaja.entiset, pelaaja.vastuuhklo FROM pelaaja
								LEFT JOIN joukkue ON joukkue.joukkueID = pelaaja.joukkueID
								WHERE pelaaja.pelaajaID = :playerid";
	private $GET_PLAYER_DATA_BY_NAME = "SELECT pelaaja.pelaajaID, pelaaja.nimi, pelaaja.joukkueID, joukkue.nimi AS joukkueNimi, pelaaja.entiset, pelaaja.vastuuhklo FROM pelaaja
								LEFT JOIN joukkue ON joukkue.joukkueID = pelaaja.joukkueID
								WHERE pelaaja.nimi = :playerName";
	private $GET_ALL_PLAYER_ACHIEVEMENTS = "SELECT kausi.kausi, kausi.kausiID, saavutusrivi.saavutusID, joukkue.nimi, saavutus.saavutus, saavutusrivi.jaettu FROM saavutusrivi
								LEFT JOIN kausi ON kausi.kausiID = saavutusrivi.kausiID
								LEFT JOIN joukkue ON joukkue.joukkueID = saavutusrivi.joukkueID
								LEFT JOIN saavutus ON saavutus.saavutusID = saavutusrivi.saavutusID
								WHERE saavutusrivi.pelaajaID = :playerid ORDER BY saavutusrivi.saavutusID, kausi.kausiID";
	private $GET_ALL_PLAYER_ACHIEVEMENTS_BY_NAME = "SELECT kausi.kausi, kausi.kausiID, saavutusrivi.saavutusID, joukkue.nimi, saavutus.saavutus, saavutusrivi.jaettu FROM saavutusrivi
								LEFT JOIN kausi ON kausi.kausiID = saavutusrivi.kausiID
								LEFT JOIN joukkue ON joukkue.joukkueID = saavutusrivi.joukkueID
								LEFT JOIN saavutus ON saavutus.saavutusID = saavutusrivi.saavutusID
								LEFT JOIN pelaaja ON pelaaja.pelaajaID = saavutusrivi.pelaajaID
								WHERE pelaaja.nimi = :playerName ORDER BY saavutusrivi.saavutusID, kausi.kausiID";
	private $GET_ALL_PLAYER_STATS = "SELECT joukkue.nimi AS joukkue, sarja.kausiID AS kau, pelaaja.pelaajaID,
						joukkue.joukkueID, sarjataso, SUM(ottelut) AS ottelut, SUM(maalit) AS maalit,
						SUM(syotot) AS syotot, SUM(maalit)+SUM(syotot) AS pisteet, kausi, maaliero,
						sarja.nimi AS sarjataso
						FROM pelaaja, joukkue, tehotilasto, sarjatilasto, sarja, kausi
						WHERE pelaaja.pelaajaID = :playerid
						AND pelaaja.pelaajaID = tehotilasto.pelaajaID
						AND tehotilasto.joukkueID = joukkue.joukkueID
						AND tehotilasto.sarjatilastoID = sarjatilasto.sarjatilastoID
						AND sarjatilasto.sarjaID = sarja.sarjaID
						AND sarja.kausiID = kausi.kausiID
						AND primaari = 1
						GROUP BY tehotilasto.sarjatilastoID, joukkue.joukkueID
						ORDER BY kau, (CASE sarjataso WHEN 'liiga' THEN 1 WHEN 'divari' THEN 1 ELSE 2 END) ASC";
	private $GET_ALL_PLAYER_STATS_BY_NAME = "SELECT joukkue.nimi AS joukkue, sarja.kausiID AS seasonid, pelaaja.pelaajaID,
						joukkue.joukkueID, sarjataso, SUM(ottelut) AS ottelut, SUM(maalit) AS maalit,
						SUM(syotot) AS syotot, SUM(maalit)+SUM(syotot) AS pisteet, maaliero,
						sarja.nimi AS sarjataso
						FROM pelaaja, joukkue, tehotilasto, sarjatilasto, sarja, kausi
						WHERE pelaaja.nimi = :playerName
						AND pelaaja.pelaajaID = tehotilasto.pelaajaID
						AND tehotilasto.joukkueID = joukkue.joukkueID
						AND tehotilasto.sarjatilastoID = sarjatilasto.sarjatilastoID
						AND sarjatilasto.sarjaID = sarja.sarjaID
						AND sarja.kausiID = kausi.kausiID
						AND primaari = 1
						GROUP BY tehotilasto.sarjatilastoID, joukkue.joukkueID
						ORDER BY seasonid, (CASE sarjataso WHEN 'liiga' THEN 1 WHEN 'divari' THEN 1 ELSE 2 END) ASC";
	private $GET_PLAYER_TOTAL_STATS = "SELECT pelaaja.pelaajaID, sarja.nimi, SUM(ottelut) AS ottelut, SUM(maalit) AS maalit, 
				SUM(syotot) AS syotot, SUM(maalit)+SUM(syotot) AS pisteet, kausi, maaliero 
				FROM pelaaja, tehotilasto, sarjatilasto, sarja, kausi
				WHERE pelaaja.pelaajaID = :playerid
				AND pelaaja.pelaajaID = tehotilasto.pelaajaID
				AND tehotilasto.sarjatilastoID = sarjatilasto.sarjatilastoID
				AND sarjatilasto.sarjaID = sarja.sarjaID
				AND sarja.kausiID = kausi.kausiID
				AND primaari = 1
				GROUP BY sarjataso
				ORDER BY sarjatilasto.tyyppi, (CASE sarjataso 
					WHEN 'liiga' THEN 2
					WHEN 'playoffs' THEN 1 
					WHEN 'divari' THEN 4
					WHEN 'liigakarsinta' THEN 3
					WHEN '2. divari' THEN 6 
					WHEN 'divarikarsinta' THEN 5 
					WHEN '3. divari' THEN 8 
					WHEN '2. divarin karsinta' THEN 7 
					WHEN '4. divari' THEN 10
					WHEN '3. divarin karsinta' THEN 9
					ELSE 11 END) ASC";
	private $GET_PLAYER_TOTAL_STATS_BY_NAME = "SELECT pelaaja.pelaajaID, sarja.nimi, sarja.sarjataso, SUM(ottelut) AS ottelut, SUM(maalit) AS maalit, 
				SUM(syotot) AS syotot, SUM(maalit)+SUM(syotot) AS pisteet, kausi, maaliero 
				FROM pelaaja, tehotilasto, sarjatilasto, sarja, kausi
				WHERE pelaaja.nimi = :playerName
				AND pelaaja.pelaajaID = tehotilasto.pelaajaID
				AND tehotilasto.sarjatilastoID = sarjatilasto.sarjatilastoID
				AND sarjatilasto.sarjaID = sarja.sarjaID
				AND sarja.kausiID = kausi.kausiID
				AND primaari = 1
				GROUP BY sarjataso
				ORDER BY sarjatilasto.tyyppi, (CASE sarjataso 
					WHEN 'liiga' THEN 2
					WHEN 'playoffs' THEN 1 
					WHEN 'divari' THEN 4
					WHEN 'liigakarsinta' THEN 3
					WHEN '2. divari' THEN 6 
					WHEN 'divarikarsinta' THEN 5 
					WHEN '3. divari' THEN 8 
					WHEN '2. divarin karsinta' THEN 7 
					WHEN '4. divari' THEN 10
					WHEN '3. divarin karsinta' THEN 9
					ELSE 11 END) ASC";
	private $GET_PLAYER_LAST_MATCHES = "SELECT ottelu.otteluID, sarja.kausiID, maalit, syotot, DATE_FORMAT(pvm,'%d.%m.%Y') AS datetime, 
							maaliero, tehot.joukkueID, kotiID, vierasID AS vieras, kotimaalit, vierasmaalit, joukkue.nimi AS kotijoukkue,
							
							(SELECT joukkue.nimi AS vierasjoukkue FROM tehot, ottelu, joukkue
							WHERE tehot.pelaajaID = :playerid
							AND joukkue.joukkueID = vieras
							AND tehot.otteluID = ottelu.otteluID
							AND luovutusvoitto = 'ei' LIMIT 1) AS vierasjoukkue
							
							FROM tehot, ottelu, joukkue, sarjatilasto, sarja
							WHERE tehot.pelaajaID = :playerid
							AND joukkue.joukkueID = kotiID
							AND tehot.otteluID = ottelu.otteluID
							AND luovutusvoitto = 'ei'
							AND ottelu.sarjatilastoID = sarjatilasto.sarjatilastoID
							AND sarjatilasto.sarjaID = sarja.sarjaID
							ORDER BY pvm DESC, aika DESC LIMIT 10";
	/*private $GET_PLAYER_LAST_MATCHES_BY_NAME = "SELECT ottelu.otteluID, sarja.kausiID, maalit, syotot, DATE_FORMAT(pvm,'%d.%m.%Y') AS datetime, 
							maaliero, tehot.joukkueID, kotiID, vierasID AS vieras, kotimaalit, vierasmaalit, joukkue.nimi AS kotijoukkue,
							
							(SELECT joukkue.nimi AS vierasjoukkue FROM tehot, ottelu, joukkue, pelaaja
							WHERE tehot.pelaajaID = pelaaja.pelaajaID
							AND pelaaja.nimi = :playerName
							AND joukkue.joukkueID = vieras
							AND tehot.otteluID = ottelu.otteluID
							AND luovutusvoitto = 'ei' LIMIT 1) AS vierasjoukkue
							
							FROM tehot, ottelu, joukkue, sarjatilasto, sarja, pelaaja
							WHERE tehot.pelaajaID = pelaaja.pelaajaID
							AND pelaaja.nimi = :playerName
							AND joukkue.joukkueID = kotiID
							AND tehot.otteluID = ottelu.otteluID
							AND luovutusvoitto = 'ei'
							AND ottelu.sarjatilastoID = sarjatilasto.sarjatilastoID
							AND sarjatilasto.sarjaID = sarja.sarjaID
							ORDER BY pvm DESC, aika DESC LIMIT 10";*/
	private $GET_PLAYER_LAST_MATCHES_BY_NAME = "SELECT tehot.otteluID
							FROM tehot
							LEFT JOIN pelaaja ON pelaaja.pelaajaID = tehot.pelaajaID
							WHERE pelaaja.nimi = :playerName ORDER BY tehotID DESC LIMIT 10";
	private $GET_PLAYER_SUSPENSIONS = "SELECT kiellot.nimi, kiellot.kielto, kiellot.syy, kiellot.aika, kiellot.tapa, kiellot.pituus, kiellot.paattynyt
							FROM kiellot WHERE playerID = :playerID";
	private $GET_PLAYER_SUSPENSIONS_BY_NAME = "SELECT kiellot.nimi, kiellot.kielto, kiellot.syy, kiellot.aika, kiellot.tapa, kiellot.pituus, kiellot.paattynyt
							FROM kiellot WHERE kiellot.nimi = :playerName";
	private $GET_PLAYER_ID_BY_FORUM_ID = "SELECT pelaajaID FROM auth WHERE id_member = :forumId LIMIT 1";
	private $GET_FORUM_ID_BY_PLAYER_ID = "SELECT id_member FROM auth WHERE pelaajaID = :playerId LIMIT 1";
	private $GET_PLAYER_BY_USER_ID = "SELECT auth.id_auth, auth.id_member, auth.pelaajaID, auth.name, auth.id_kiekko, auth.created, auth.exp, auth.updated FROM auth WHERE id_member = :memberId";
	private $IS_USER_REFEREE = "SELECT smf_members.tuomari FROM smf_members WHERE id_member = :memberId";
	private $GET_IS_BOARD_BY_FORUM_ID = "SELECT COUNT(*) AS isBoard FROM smf_members WHERE id_member = :forumId AND id_group = 1";
	private $GET_FORUM_NAME_BY_FORUM_ID = "SELECT member_name FROM smf_members WHERE id_member = :forumId LIMIT 1";
	private $SEARCH_PLAYER ="SELECT pelaajaID FROM pelaaja WHERE nimi LIKE :playerName OR entiset LIKE :playerName LIMIT 20";
	private $ADD_PLAYER_TO_TEAM = "UPDATE pelaaja SET joukkueID = :teamId, vastuuhklo = 0, ollut_vh = 0 WHERE pelaajaID = :playerId LIMIT 1";
	private $REMOVE_PLAYER_FROM_TEAM = "UPDATE pelaaja SET joukkueID = 0, vastuuhklo = 0, ollut_vh = 0 WHERE pelaajaID = :playerId LIMIT 1";
	private $MAKE_VH = "UPDATE pelaaja SET vastuuhklo = 1, ollut_vh = 1 WHERE pelaajaID = :playerId LIMIT 1";
	private $REMOVE_VH = "UPDATE pelaaja SET vastuuhklo = 0 WHERE pelaajaID = :playerId LIMIT 1";
	
	function __construct() {
		try {
			parent::__construct();
		} catch (Exception $e) {
			echo "Kaatui StatsAccess<br />";
			throw $e;
		}
	}
	
	public function getPlayerById($playerId) {
		try {
			$key = parent::executeStatement($this->GET_PLAYER_DATA_BY_ID, array(":playerid" => $playerId));
			if (empty($key)) { throw new Exception('Player id '.$playerId.' not found');}
			$playerData = $key[0];
			
			$playerName = $playerData["nimi"];
			$playerTeamId = $playerData["joukkueID"];
			$playerOlderName = $playerData["entiset"];
			$playerIsAdmin = ($playerData["vastuuhklo"] == 1) ? TRUE : FALSE;
			$isBoard = $this->isBoardByPlayerId($playerId);

			$player = new Player($playerId, $playerName, $playerTeamId, $playerOlderName, $playerIsAdmin, $isBoard);
			$player->__set('suspensionsList', $this->getPlayerSuspensionsByName($playerName));

			if (isset($playerTeamId)) {
				$teamAccess = new TeamAccess();
				$team = $teamAccess->getTeamById($playerTeamId);
				$player->__set('team', $team);
			}
			
		} catch (Exception $e) {
			throw $e;
		}
		return $player;
	}	
	
	public function getPlayerByForumId($forumId) {
		try {
			$playerId = $this->getPlayerIdByForumId($forumId);
			if($playerId != 0) {
				return $this->getPlayerById($playerId);
			}
			$result = parent::executeStatement($this->GET_FORUM_NAME_BY_FORUM_ID, array(":forumId" => $forumId));
			$name = @$result[0]["member_name"];
			$isBoard = $this->isBoardByForumId($forumId);
			$player = new Player(0, $name, null, "", false, $isBoard);
		} catch (Exception $e) {
			throw $e;
		}
		return $player;
	}
	
	public function getPlayerByName($playerName) {
		try {
			$key = parent::executeStatement($this->GET_PLAYER_DATA_BY_NAME, array(":playerName" => $playerName));
			if (empty($key)) { throw new Exception('Player '.$playerName.' not found');}
			$playerData = $key[0];
			$teamAccess = new TeamAccess();
			
			$id = $playerData["pelaajaID"];
			$playerTeamId = $playerData["joukkueID"];
			$previousNames = $playerData["entiset"];
			$isAdmin = ($playerData["vastuuhklo"] == 1) ? TRUE : FALSE;
			$isBoard = $this->isBoardByPlayerId($id);

			$player = new Player($id, $playerName, $playerTeamId, $previousNames, $isAdmin, $isBoard);
			$player->__set('suspensionsList', $this->getPlayerSuspensionsByName($playerName));

			if (isset($playerTeamId)) {
				$teamAccess = new TeamAccess();
				$team = $teamAccess->getTeamById($playerTeamId);
				$player->__set('team', $team);
			}

		} catch (Exception $e) {
			throw $e;
		}
		return $player;
	}
	
	public function getPlayerStatsByName($playerName) {
		try {
			/* kemton: Hämärä kohta, katsottava uusiksi, nopeasti tehty!! */
			$player = $this->getPlayerByName($playerName);
			$id = $player->__get("id");
			$name = $player->__get('name');
			$team = $player->__get('team');
			$previousNames = $player->__get("previousNames");
			$isAdmin = $player->__get("isAdmin");
			$isBoard = $player->__get("isBoard");
			/* ---------------------------------- */

			$playerStats = new PlayerStats($id, $name, $team, $previousNames, $isAdmin, $isBoard);
			$playerStats->__set('suspensionsList', $player->__get("suspensionsList"));
			
			$statsPerSeason = $this->getPlayerStatsPerSeasonByName($playerName);
			$playerStats->__set('statsPerSeason', $statsPerSeason);
			
			$achievements = $this->getPlayerAchievementsByName($playerName);
			$playerStats->__set('achievements', $achievements);
			
			$totalStats = $this->getPlayerTotalStatsByName($playerName);
			$playerStats->__set('leagueTotalStats', $totalStats);
			
			$lastMatches = $this->getPlayerLastMatchesByName($playerName);
			$playerStats->__set('lastMatches', $lastMatches);
			
			$kiekkoAccess = new KiekkoAccess();
			$kiekkoPlayer = $kiekkoAccess->getKiekkoPlayerByPlayerName($playerName);
			$playerStats->__set('kiekkoPlayer', $kiekkoPlayer);
			
		} catch (Exception $e) {
			throw $e;
		}
		
		return $playerStats;
	}
	
	/*public function getPlayerAchievementsById($playerID) {
		try {
			$key = parent::executeStatement($this->GET_ALL_PLAYER_ACHIEVEMENTS, array(":playerid" => $playerID));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}*/
	
	public function getPlayerAchievementsByName($playerName) {
		try {
			$achievementsResult = parent::executeStatement($this->GET_ALL_PLAYER_ACHIEVEMENTS_BY_NAME, array(":playerName" => $playerName));
			$achievementsList = array();
			$seasonAccess = new SeasonAccess();
			foreach ($achievementsResult as $value) {
				$season = $seasonAccess->getSeasonById($value["kausiID"]);
				$team = $value["nimi"];
				$achievements = new PlayerAchievements($value["saavutusID"], $season, $team, $value["saavutus"], $value["jaettu"]);
				$achievementsList[] = $achievements;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $achievementsList;
	}
	
	/*public function getPlayerStatsById($playerID) {
		try {
			$key = parent::executeStatement($this->GET_ALL_PLAYER_STATS, array(":playerid" => $playerID));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}*/
	
	public function getPlayerStatsPerSeasonByName($playerName) { // Note: old getPlayerStatsByName
		try {
			$statsPerSeasonList = parent::executeStatement($this->GET_ALL_PLAYER_STATS_BY_NAME, array(":playerName" => $playerName));
			
			$statsList = array();
			$seasonAccess = new SeasonAccess();
			$teamAccess = new TeamAccess();
			
			foreach ($statsPerSeasonList as $stats) {
				$seasonStats = new PlayerStatsPerSeason();
				$seasonStats->__set('season', $seasonAccess->getSeasonById($stats["seasonid"]));
				$seasonStats->__set('leagueLevel', $stats["sarjataso"]);
				$seasonStats->__set('team', $teamAccess->getTeamById($stats["joukkueID"]));
				$seasonStats->__set('matches', $stats["ottelut"]);
				$seasonStats->__set('goals', $stats["maalit"]);
				$seasonStats->__set('assists', $stats["syotot"]);
				$seasonStats->__set('points', $stats["pisteet"]);
				$seasonStats->__set('plusMinus', $stats["maaliero"]);
				
				$statsList[] = $seasonStats;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $statsList;
	}
	/*
	public function getPlayerTotalStatsById($playerID) {
		try {
			$key = parent::executeStatement($this->GET_PLAYER_TOTAL_STATS, array(":playerid" => $playerID));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}*/
	
	public function getPlayerTotalStatsByName($playerName) {
		try {
			$result = parent::executeStatement($this->GET_PLAYER_TOTAL_STATS_BY_NAME, array(":playerName" => $playerName));
			$statsList = array();
			
			foreach ($result as $stat) {
				$league = $stat["nimi"];
				$matches = $stat["ottelut"];
				$goals = $stat["maalit"];
				$assists = $stat["syotot"];
				$points = $stat["pisteet"];
				
				$totalStats = new PlayerLeagueTotalStats($league, $matches, $goals, $assists, $points);
				$statsList[] = $totalStats;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $statsList;
	}
	
	/*public function getPlayerLastMatchesById($playerID) {
		try {
			$key = parent::executeStatement($this->GET_PLAYER_LAST_MATCHES, array(":playerid" => $playerID));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}*/
	
	public function getPlayerLastMatchesByName($playerName) {
		try {
			$result = parent::executeStatement($this->GET_PLAYER_LAST_MATCHES_BY_NAME, array(":playerName" => $playerName));
			$matchList = array();
			$sa = new StatisticsAccess();
			foreach ($result as $value) {
				$match = $sa->getMatchById($value["otteluID"]);
				$matchList[] = $match;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $matchList;
	}
	
	/*public function getPlayerSuspensionsById($playerID) {
		try {
			$key = parent::executeStatement($this->GET_PLAYER_SUSPENSIONS, array(":playerid" => $playerID));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}*/
	
	public function getPlayerSuspensionsByName($playerName) {
		try {
			$suspensions = parent::executeStatement($this->GET_PLAYER_SUSPENSIONS_BY_NAME, array(":playerName" => $playerName));
			
			$list = array();
			foreach ($suspensions as $suspension) {
				$suspensionObj = new PlayerSuspension();
				$suspensionObj->__set('description', $suspension["kielto"]);
				$suspensionObj->__set('length', $suspension["pituus"]);
				$suspensionObj->__set('type', $suspension["tapa"]);
				$suspensionObj->__set('date', $suspension["aika"]);
				$list[] = $suspensionObj;
			}

		} catch (Exception $e) {
			throw $e;
		}
		return $list;
	}
	
	public function getPlayerIdByUserId($userId) {
		try {
			$suspensions = parent::executeStatement($this->GET_PLAYER_BY_USER_ID, array(":memberId" => $userId));
			//if (empty($suspensions)) { throw new Exception('User not found');}

			$list = array();
			foreach ($suspensions as $suspension) {
				$suspensionObj = new PlayerSuspension();
				$suspensionObj->__set('description', $suspension["kielto"]);
				$suspensionObj->__set('length', $suspension["pituus"]);
				$suspensionObj->__set('type', $suspension["tapa"]);
				$suspensionObj->__set('date', $suspension["aika"]);
				$list[] = $suspensionObj;
			}

		} catch (Exception $e) {
			throw $e;
		}
		return $list;
	}
	
	public function isUserReferee($memberId) {
		try {
			$key = parent::executeStatement($this->IS_USER_REFEREE, array(":memberId" => $memberId));
			$isReferee = ($key[0]["tuomari"] == 1) ? TRUE : FALSE;
		} catch (Exception $e) {
			throw $e;
		}
		return $isReferee;
	}
	
	public function getPlayerIdByForumId($forumId) {
		try {
			$key = parent::executeStatement($this->GET_PLAYER_ID_BY_FORUM_ID, array(":forumId" => $forumId));
			$id = @$key[0]["pelaajaID"];
		} catch (Exception $e) {
			throw $e;
		}
		return $id;
	}
	
	public function getForumIdByPlayerId($playerId) {
		try {
			$key = parent::executeStatement($this->GET_FORUM_ID_BY_PLAYER_ID, array(":playerId" => $playerId));
			$id = @$key[0]["id_member"];
		} catch (Exception $e) {
			throw $e;
		}
		return $id;
	}
	
	public function isBoardByPlayerId($playerId) {
		try {
			$forumId = $this->getForumIdByPlayerId($playerId);
			return $this->isBoardByForumId($forumId);
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function isBoardByForumId($forumId) {
		try {
			$key = parent::executeStatement($this->GET_IS_BOARD_BY_FORUM_ID, array(":forumId" => $forumId));
			$isBoard = ($key[0]["isBoard"] > 0) ? true : false;
		} catch (Exception $e) {
			throw $e;
		}
		return $isBoard;
	}
	
	public function getLoggedInUser($forumId, $username, $isAdmin) {
		try {
			$authAccess = new AuthAccess();
			
			$user = new User($forumId, $username, $isAdmin);
			
			$isReferee = $this->isUserReferee($forumId);
			$user->__set('isReferee', $isReferee);
			
			$auth = $authAccess->getAuthByForumId($forumId);
			$user->__set('auth', $auth);
			
			$playerId = $auth->__get('playerId');
			if ($playerId <> 0) {
				$player = $this->getPlayerById($playerId);
				$user->__set('player', $player);
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $user;
	}

	public function searchPlayer($key) {
		try {
			$result = parent::executeStatement($this->SEARCH_PLAYER, array("playerName" => "%{$key}%"));
			$playerList = array();
			foreach ($result as $value) {
				$player = $this->getPlayerById($value["pelaajaID"]);
				$playerList[] = $player;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $playerList;
	}
	
	public function addPlayerToTeam($playerId, $teamId) {
		parent::updateStatement($this->ADD_PLAYER_TO_TEAM, array(":playerId" => $playerId, ":teamId" => $teamId));
	}
	
	public function removePlayerFromTeam($playerId) {
		parent::updateStatement($this->REMOVE_PLAYER_FROM_TEAM, array(":playerId" => $playerId));
	}

	public function makeVh($playerId) {
		parent::updateStatement($this->MAKE_VH, array(":playerId" => $playerId));
	}
	
	public function removeVh($playerId) {
		parent::updateStatement($this->REMOVE_VH, array(":playerId" => $playerId));
	}
}
?>