<?php
class TeamAccess extends DatabaseAccess {
	
	private $GET_TEAM_BY_ID = "SELECT joukkue.joukkueID, joukkue.nimi, joukkue.lyhenne, joukkue.kotipaita, joukkue.vieraspaita, joukkue.irc,
							pelaaja.pelaajaID, pelaaja.nimi AS playername, pelaaja.entiset, vastuuhklo FROM joukkue
							LEFT JOIN pelaaja ON pelaaja.joukkueID = joukkue.joukkueID
							WHERE joukkue.joukkueID = :teamid";
	private $GET_TEAM_BY_NAME = "SELECT joukkue.joukkueID, joukkue.nimi, joukkue.lyhenne, joukkue.kotipaita, joukkue.vieraspaita, joukkue.irc,
							pelaaja.pelaajaID, pelaaja.nimi AS playername, pelaaja.entiset, vastuuhklo FROM joukkue
							LEFT JOIN pelaaja ON pelaaja.joukkueID = joukkue.joukkueID
							WHERE joukkue.nimi = :name";
	private $GET_CURRENT_SEASON_LEAGUES_BY_ID = "SELECT sarjatilasto.sarjaID, sarja.nimi, sarja.sarjataso FROM sarjatilasto
							LEFT JOIN joukkuesivu ON joukkuesivu.sarjatilastoID = sarjatilasto.sarjatilastoID
							LEFT JOIN sarja ON sarja.sarjaID = sarjatilasto.sarjaID
							WHERE joukkuesivu.joukkueID = :teamid
							AND sarja.kausiID = (SELECT kausi.kausiID FROM kausi ORDER BY kausi.kausiID DESC LIMIT 1)
							GROUP BY sarjatilasto.sarjaID";
	private $GET_CURRENT_SEASON_LEAGUES_BY_NAME = "SELECT sarjatilasto.sarjaID, sarja.nimi, sarja.sarjataso FROM sarjatilasto
							LEFT JOIN joukkuesivu ON joukkuesivu.sarjatilastoID = sarjatilasto.sarjatilastoID
							LEFT JOIN sarja ON sarja.sarjaID = sarjatilasto.sarjaID
							LEFT JOIN joukkue ON joukkue.joukkueID = joukkuesivu.joukkueID
							WHERE joukkue.nimi = :teamName
							AND sarja.kausiID = (SELECT kausi.kausiID FROM kausi ORDER BY kausi.kausiID DESC LIMIT 1)
							GROUP BY sarjatilasto.sarjaID";
	private $GET_SEASON_LEAGUES_BY_ID = "SELECT sarjatilasto.sarjaID, sarja.nimi, sarja.sarjataso FROM sarjatilasto
							LEFT JOIN joukkuesivu ON joukkuesivu.sarjatilastoID = sarjatilasto.sarjatilastoID
							LEFT JOIN sarja ON sarja.sarjaID = sarjatilasto.sarjaID
							WHERE joukkuesivu.joukkueID = :teamid
							AND sarja.kausiID = :season
							GROUP BY sarjatilasto.sarjaID";
	private $GET_SEASON_LEAGUES_BY_NAME = "SELECT sarjatilasto.sarjaID, sarja.nimi, sarja.sarjataso FROM sarjatilasto
							LEFT JOIN joukkuesivu ON joukkuesivu.sarjatilastoID = sarjatilasto.sarjatilastoID
							LEFT JOIN sarja ON sarja.sarjaID = sarjatilasto.sarjaID
							LEFT JOIN joukkue ON joukkue.joukkueID = joukkuesivu.joukkueID
							WHERE joukkue.nimi = :teamName
							AND sarja.kausiID = :season
							GROUP BY sarjatilasto.sarjaID";
	private $GET_SEASON_LEAGUES_WITH_TYPES_BY_ID = "SELECT DISTINCT sarjatilasto.sarjatilastoID as competitionId, sarjatilasto.tyyppi AS type, 
							sarja.nimi as competitionName, sarjatilasto.nimi AS stageName
              FROM joukkuesivu, sarjatilasto, sarja
              WHERE joukkueID = :teamId
              AND joukkuesivu.sarjatilastoID = sarjatilasto.sarjatilastoID
              AND sarjatilasto.sarjaID = sarja.sarjaID
              AND kausiID = :seasonId
              AND primaari = 1
              ORDER BY sarjatilasto.sarjatilastoID, sarjatilasto.tyyppi";
	private $GET_PRESS_RELEASES_BY_TEAM_ID = "SELECT tiedoteID
	             FROM lehdistotiedotteet
               WHERE lehdistotiedotteet.joukkueID = :teamId
               ORDER BY aika DESC";
	private $GET_TEAM_MATCHES_BY_COMPETITION_ID_AND_TEAM_ID = "SELECT otteluID, kotiID, vierasID, kotimaalit, vierasmaalit, pvm, DATE_FORMAT(pvm,'%d.%m.%Y') AS pvm2, luovutusvoitto
               FROM ottelu
               WHERE (kotiID = :teamId OR vierasID = :teamId)
               AND ottelu.sarjatilastoID = :competitionId
               ORDER BY pvm DESC, aika DESC, otteluID DESC";
	private $GET_ALL_PLAYERS_BY_TEAM_ID = "SELECT nimi AS name
               FROM pelaaja, tehotilasto
               WHERE pelaaja.pelaajaID = tehotilasto.pelaajaID
               AND tehotilasto.joukkueID = :teamId
               GROUP BY nimi
               ORDER BY nimi";
	private $GET_TEAM_SEASON_PLACINGS_BY_TEAM_ID = "SELECT sijoitukset.sijoitus AS placement, kausi.kausi AS seasonName, sijoitukset.sarjataso AS league, status
							FROM sijoitukset, kausi 
              WHERE joukkueID = :teamId
              AND sijoitukset.kausiID = kausi.kausiID";
	private $GET_REGULAR_SEASON_STATISTICS_BY_TEAM_ID = "SELECT * FROM rstilasto, sarjatilasto, sarja, kausi
              WHERE joukkueID = :teamId 
							AND tyyppi='sarjataulukko'
              AND rstilasto.sarjatilastoID = sarjatilasto.sarjatilastoID
              AND sarjatilasto.sarjaID = sarja.sarjaID
              AND sarja.kausiID = kausi.kausiID
              AND primaari = 1
							ORDER BY sarjataso";
	private $GET_PLAYOFFS_SEASON_STATISTICS_BY_TEAM_ID = "SELECT * FROM ottelu, sarjatilasto, sarja
							 WHERE (kotiID = :teamId OR vierasID = :teamId)
							 AND ottelu.sarjatilastoID = sarjatilasto.sarjatilastoID
							 AND sarjatilasto.sarjaID = sarja.sarjaID
							 AND (sarjataso='playoffs' OR sarjataso='liigakarsinta' OR sarjataso='divarikarsinta' OR sarjataso='2. divarin karsinta')
							 AND primaari = 1
							 ORDER BY sarjataso";
	private $SEARCH_TEAM = "SELECT j.joukkueID FROM joukkue AS j WHERE j.nimi LIKE :teamName LIMIT 10";
	
	function __construct() {
		parent::__construct();
	}
	
	public function getTeamById($teamid) {
		try {
			$key = parent::executeStatement($this->GET_TEAM_BY_ID, array("teamid" => $teamid));
			$team = @new Team($key["0"]["joukkueID"], $key["0"]["nimi"], $key["0"]["lyhenne"], $key["0"]["kotipaita"], $key["0"]["vieraspaita"], $key["0"]["irc"]);
			foreach ($key as $value) {
				$value["vastuuhklo"] = ($value["vastuuhklo"] == 1) ? true : false;
				$player = new Player($value["pelaajaID"], $value["playername"], $key["0"]["joukkueID"], $value["entiset"], $value["vastuuhklo"], null);
				$team->setPlayer($player);
			}
			
		} catch (Exception $e) {
			throw $e;
		}
		return $team;
	}
	
	public function getTeamByName($name) {
		try {
			$key = parent::executeStatement($this->GET_TEAM_BY_NAME, array("name" => $name));
			$team = new Team($key["0"]["joukkueID"], $key["0"]["nimi"], $key["0"]["lyhenne"], $key["0"]["kotipaita"], $key["0"]["vieraspaita"], $key["0"]["irc"]);
			foreach ($key as $value) {
				$value["vastuuhklo"] = ($value["vastuuhklo"] == 1) ? true : false;
				$player = new Player($value["pelaajaID"], $value["playername"], $key["0"]["joukkueID"], $value["entiset"], $value["vastuuhklo"], null);
				$player = $player;
				$team->setPlayer($player);
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $team;
	}
	
	public function getTeamCurrentSeasonLeaguesById($teamid) {
		try {
			$key = parent::executeStatement($this->GET_CURRENT_SEASON_LEAGUES_BY_ID, array("teamid" => $teamid));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
	
	public function getTeamCurrentSeasonLeaguesByName($teamName) {
		try {
			$key = parent::executeStatement($this->GET_CURRENT_SEASON_LEAGUES_BY_NAME, array("teamName" => $teamName));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
	
	public function getTeamSeasonLeaguesById($teamId, $seasonId) {
		try {
			$key = parent::executeStatement($this->GET_SEASON_LEAGUES_BY_ID, array("teamid" => $teamId, "season" => $seasonId));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
	
	public function getTeamSeasonLeaguesWithTypesById($teamId, $seasonId) {
		try {
			$key = parent::executeStatement($this->GET_SEASON_LEAGUES_WITH_TYPES_BY_ID, array("teamId" => $teamId, "seasonId" => $seasonId));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
	
	public function getTeamSeasonLeaguesByName($teamName, $seasonId) {
		try {
			$key = parent::executeStatement($this->GET_SEASON_LEAGUES_BY_NAME, array("teamName" => $teamName, "season" => $seasonId));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
	
	public function getTeamPressReleasesById($teamId) {
		try {
			$informationAccess = new InformationAccess;
			$results = parent::executeStatement($this->GET_PRESS_RELEASES_BY_TEAM_ID, array("teamId" => $teamId));
			$pressReleases = array();
			foreach($results as $result) {
				$id = $result["tiedoteID"];
				$pressRelease = $informationAccess->getBoardInfoById($id);
				$pressReleases[] = $pressRelease;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $pressReleases;
	}
	
	public function getTeamMatchesByCompetitionIdAndTeamId($competitionId, $teamId) {
		try {
			$result = parent::executeStatement($this->GET_TEAM_MATCHES_BY_COMPETITION_ID_AND_TEAM_ID, array(":competitionId" => $competitionId, ":teamId" => $teamId));
			$matches = array();
			foreach($result as $row) {
				$matchId = $row['otteluID'];
				$homeTeamId = $row['kotiID'];
				$homeTeam = $this->getTeamById($homeTeamId);
				$visitorTeamId = $row['vierasID'];
				$visitorTeam = $this->getTeamById($visitorTeamId);
				$homeTeamGoals = $row['kotimaalit'];
				$visitorTeamGoals = $row['vierasmaalit'];
				$date = $row['pvm2'];
				$walkover = $row['luovutusvoitto'];
				$match = new Match($matchId, $competitionId, null, $homeTeam, $visitorTeam, $homeTeamGoals, $visitorTeamGoals, null, null, $date, null, null, null, null, $walkover, null, null);
				$matches[] = $match;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $matches;
	}
	
	public function getAllPlayersByTeamId($teamId) {
		try {
			$key = parent::executeStatement($this->GET_ALL_PLAYERS_BY_TEAM_ID, array("teamId" => $teamId));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
	
	public function getTeamSeasonPlacingsByTeamId($teamId) {
		try {
			$key = parent::executeStatement($this->GET_TEAM_SEASON_PLACINGS_BY_TEAM_ID, array("teamId" => $teamId));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
	
	public function getRegularSeasonStatisticsByTeamId($teamId) {
		try {
			$key = parent::executeStatement($this->GET_REGULAR_SEASON_STATISTICS_BY_TEAM_ID, array("teamId" => $teamId));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
	
	public function getPlayoffsSeasonStatisticsByTeamId($teamId) {
		try {
			$key = parent::executeStatement($this->GET_PLAYOFFS_SEASON_STATISTICS_BY_TEAM_ID, array("teamId" => $teamId));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
	
	public function searchTeam($key) {
		try {
			$result = parent::executeStatement($this->SEARCH_TEAM, array(":teamName" => "%{$key}%"));
			$teamList = array();
			foreach ($result as $value) {
				$team = $this->getTeamById($value["joukkueID"]);
				$teamList[] = $team;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $teamList;
	}
}
?>