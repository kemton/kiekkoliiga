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
	private $GET_PRESS_RELEASES_BY_TEAM_ID = "SELECT tiedoteID
	             FROM lehdistotiedotteet
               WHERE lehdistotiedotteet.joukkueID = :teamId
               ORDER BY aika DESC";
	private $SEARCH_TEAM = "SELECT j.joukkueID FROM joukkue AS j WHERE j.nimi LIKE '%:teamName%' LIMIT 10";
	
	function __construct() {
		parent::__construct();
	}
	
	public function getTeamById($teamid) {
		try {
			$key = parent::executeStatement($this->GET_TEAM_BY_ID, array("teamid" => $teamid));
			$team = new Team($key["0"]["joukkueID"], $key["0"]["nimi"], $key["0"]["lyhenne"], $key["0"]["kotipaita"], $key["0"]["vieraspaita"], $key["0"]["irc"]);
			foreach ($key as $value) {
				$value["vastuuhklo"] = ($value["vastuuhklo"] == 1) ? true : false;
				$player = new Player($value["pelaajaID"], $value["playername"], $key["0"]["joukkueID"], $value["entiset"], $value["vastuuhklo"], null);
				$player = serialize($player);
				$team->setPlayer($player);
			}
			
		} catch (Exception $e) {
			throw $e;
		}
		return serialize($team);
	}
	
	public function getTeamByName($name) {
		try {
			$key = parent::executeStatement($this->GET_TEAM_BY_NAME, array("name" => $name));
			$team = new Team($key["0"]["joukkueID"], $key["0"]["nimi"], $key["0"]["lyhenne"], $key["0"]["kotipaita"], $key["0"]["vieraspaita"], $key["0"]["irc"]);
			foreach ($key as $value) {
				$value["vastuuhklo"] = ($value["vastuuhklo"] == 1) ? true : false;
				$player = new Player($value["pelaajaID"], $value["playername"], $key["0"]["joukkueID"], $value["entiset"], $value["vastuuhklo"], null);
				$player = serialize($player);
				$team->setPlayer($player);
			}
		} catch (Exception $e) {
			throw $e;
		}
		return serialize($team);
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
	
	public function getTeamSeasonLeaguesById($teamid, $seasonId) {
		try {
			$key = parent::executeStatement($this->GET_SEASON_LEAGUES_BY_ID, array("teamid" => $teamid, "season" => $seasonId));
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
	
	public function searchTeam($key) {
		try {
			$result = parent::executeStatement($this->SEARCH_TEAM, array(":teamName" => $key));
			$teamList = array();
			foreach ($result as $value) {
				$team = $this->getTeamById($value["joukkueID"]);
				$teamList[] = $team;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return serialize($teamList);
	}
}
?>