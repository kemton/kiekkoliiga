<?php

class StatisticsAccess extends DatabaseAccess {
	
	private $GET_CURRENT_LEAGUE_STANDINGS_ID = "SELECT sarjatilasto.sarjatilastoID
										FROM rstilasto
										LEFT JOIN joukkue ON joukkue.joukkueID = rstilasto.joukkueID
										LEFT JOIN sarjatilasto ON sarjatilasto.sarjatilastoID = rstilasto.sarjatilastoID
										LEFT JOIN sarja ON sarja.sarjaID = sarjatilasto.sarjaID WHERE sarja.sarjataso = 'liiga' AND sarja.kausiID =
										(SELECT kausiID FROM kausi ORDER BY kausiID DESC LIMIT 1) ORDER BY voitot*2+tasapelit DESC, tehdyt-paastetyt DESC, tehdyt DESC";
	private $GET_FIRST_DIVISION_STANDINGS_ID = "SELECT sarjatilasto.sarjatilastoID
										FROM rstilasto
										LEFT JOIN joukkue ON joukkue.joukkueID = rstilasto.joukkueID
										LEFT JOIN sarjatilasto ON sarjatilasto.sarjatilastoID = rstilasto.sarjatilastoID
										LEFT JOIN sarja ON sarja.sarjaID = sarjatilasto.sarjaID WHERE sarja.sarjataso = 'divari' AND sarja.kausiID =
										(SELECT kausiID FROM kausi ORDER BY kausiID DESC LIMIT 1) ORDER BY voitot*2+tasapelit DESC, tehdyt-paastetyt DESC, tehdyt DESC";
	private $GET_SECOND_DIVISION_STANDINGS_ID = "SELECT sarjatilasto.sarjatilastoID
										FROM rstilasto
										LEFT JOIN joukkue ON joukkue.joukkueID = rstilasto.joukkueID
										LEFT JOIN sarjatilasto ON sarjatilasto.sarjatilastoID = rstilasto.sarjatilastoID
										LEFT JOIN sarja ON sarja.sarjaID = sarjatilasto.sarjaID WHERE sarja.sarjataso = '2. divari' AND sarja.kausiID =
										(SELECT kausiID FROM kausi ORDER BY kausiID DESC LIMIT 1) ORDER BY voitot*2+tasapelit DESC, tehdyt-paastetyt DESC, tehdyt DESC";
	/*private $GET_CURRENT_LEAGUE_STANDINGS = "SELECT sarjatilasto.sarjatilastoID, rstilasto.joukkueID, rstilasto.voitot, rstilasto.tasapelit, rstilasto.tappiot, rstilasto.tehdyt,rstilasto.paastetyt, rstilasto.pisteet, rstilasto.torjutut, joukkue.nimi
										FROM rstilasto
										LEFT JOIN joukkue ON joukkue.joukkueID = rstilasto.joukkueID
										LEFT JOIN sarjatilasto ON sarjatilasto.sarjatilastoID = rstilasto.sarjatilastoID
										LEFT JOIN sarja ON sarja.sarjaID = sarjatilasto.sarjaID WHERE sarja.sarjataso = 'liiga' AND sarja.kausiID =
										(SELECT kausiID FROM kausi ORDER BY kausiID DESC LIMIT 1) ORDER BY voitot*2+tasapelit DESC, tehdyt-paastetyt DESC, tehdyt DESC";
	private $GET_FIRST_DIVISION_STANDINGS = "SELECT sarjatilasto.sarjatilastoID, rstilasto.joukkueID, rstilasto.voitot, rstilasto.tasapelit, rstilasto.tappiot, rstilasto.tehdyt,rstilasto.paastetyt, rstilasto.pisteet, rstilasto.torjutut, joukkue.nimi
										FROM rstilasto
										LEFT JOIN joukkue ON joukkue.joukkueID = rstilasto.joukkueID
										LEFT JOIN sarjatilasto ON sarjatilasto.sarjatilastoID = rstilasto.sarjatilastoID
										LEFT JOIN sarja ON sarja.sarjaID = sarjatilasto.sarjaID WHERE sarja.sarjataso = 'divari' AND sarja.kausiID =
										(SELECT kausiID FROM kausi ORDER BY kausiID DESC LIMIT 1) ORDER BY voitot*2+tasapelit DESC, tehdyt-paastetyt DESC, tehdyt DESC";
	private $GET_SECOND_DIVISION_STANDINGS = "SELECT sarjatilasto.sarjatilastoID, rstilasto.joukkueID, rstilasto.voitot, rstilasto.tasapelit, rstilasto.tappiot, rstilasto.tehdyt,rstilasto.paastetyt, rstilasto.pisteet, rstilasto.torjutut, joukkue.nimi
										FROM rstilasto
										LEFT JOIN joukkue ON joukkue.joukkueID = rstilasto.joukkueID
										LEFT JOIN sarjatilasto ON sarjatilasto.sarjatilastoID = rstilasto.sarjatilastoID
										LEFT JOIN sarja ON sarja.sarjaID = sarjatilasto.sarjaID WHERE sarja.sarjataso = '2. divari' AND sarja.kausiID =
										(SELECT kausiID FROM kausi ORDER BY kausiID DESC LIMIT 1) ORDER BY voitot*2+tasapelit DESC, tehdyt-paastetyt DESC, tehdyt DESC";*/
	private $GET_ALL_CUP_TEAM_STANDINGS_BY_SEASONID = "SELECT sarja.sarjaID, kausi.kausiID, kausi.kausi, sarja.sarjataso, sarja.nimi AS sarjaNimi, sarja.lohkot, sarjatilasto.sarjatilastoID, sarjatilasto.tyyppi, sarjatilasto.nimi AS sarjatasoNimi
										FROM sarja
										LEFT JOIN sarjatilasto ON sarjatilasto.sarjaID = sarja.sarjaID
										LEFT JOIN kausi ON kausi.kausiID = sarja.kausiID AND sarja.kausiID = :seasonid
										WHERE sarja.kausiID = :seasonid AND sarja.sarjataso = 'cup'";
	private $GET_CURRENT_SEASON = "SELECT kausi.kausiID, kausi.kausi FROM kausi ORDER BY kausi.kausiID DESC LIMIT 1";
	private $GET_PLAYOFFS_STANDING_BY_ID = "SELECT po.ppsarjaID, po.sarjatilastoID, po.joukkue1ID, po.joukkue2ID, po.voitot1, po.voitot2, po.vaihe
									FROM ppsarja AS po
									WHERE sarjatilastoID = :id";
	private $GET_MATCHID_BY_PLAYOFFSID = "SELECT ottelu.otteluID
									FROM ppsarja
									LEFT JOIN ottelu ON ottelu.ppsarjaID = ppsarja.ppsarjaID
									WHERE ppsarja.ppsarjaID = :id";
	private $GET_STANDINGS_BY_ID = 	"SELECT rstilasto.joukkueID, joukkue.nimi, joukkue.lyhenne, rstilasto.voitot, rstilasto.tasapelit, rstilasto.tappiot, rstilasto.tehdyt, rstilasto.paastetyt, rstilasto.pisteet, rstilasto.torjutut
									FROM rstilasto
									LEFT JOIN joukkue ON joukkue.joukkueID = rstilasto.joukkueID
									WHERE sarjatilastoID = :standingsid
									ORDER BY pisteet DESC";
	private $GET_STANDINGS_BY_NAME = "SELECT sarja.nimi, rstilasto.rstilastoID, rstilasto.sarjatilastoID, rstilasto.joukkueID, joukkue.nimi, joukkue.lyhenne, rstilasto.voitot, rstilasto.tasapelit, rstilasto.tappiot, rstilasto.tehdyt, rstilasto.paastetyt, rstilasto.pisteet, rstilasto.torjutut
									FROM sarja
									LEFT JOIN sarjatilasto ON sarjatilasto.sarjaID = sarja.sarjaID
									LEFT JOIN rstilasto ON rstilasto.sarjatilastoID = sarjatilasto.sarjatilastoID
									LEFT JOIN joukkue ON joukkue.joukkueID = rstilasto.joukkueID
									WHERE sarja.sarjataso = :leaguesName AND sarja.kausiID = :seasonid AND sarjatilasto.tyyppi = 'sarjataulukko'
									ORDER BY pisteet DESC";
	private $GET_SCOREBOARD_BY_ID = "SELECT tehotilasto.pelaajaID, pelaaja.nimi AS pelaajaNimi, tehotilasto.joukkueID, joukkue.nimi AS joukkueNimi, tehotilasto.ottelut, tehotilasto.maalit, tehotilasto.syotot, tehotilasto.maaliero, (tehotilasto.maalit+tehotilasto.syotot) AS pisteet
									FROM tehotilasto
									LEFT JOIN pelaaja ON pelaaja.pelaajaID = tehotilasto.pelaajaID
									LEFT JOIN joukkue ON joukkue.joukkueID = tehotilasto.joukkueID
									WHERE sarjatilastoID = :scoreboardid
									ORDER BY pisteet DESC, ottelut ASC, maaliero DESC";
	private $GET_SCOREBOARD_BY_NAME = "SELECT sarja.nimi, tehotilasto.pelaajaID, pelaaja.nimi AS pelaajaNimi, tehotilasto.joukkueID, joukkue.nimi AS joukkueNimi, joukkue.lyhenne, tehotilasto.ottelut, tehotilasto.maalit, tehotilasto.syotot, tehotilasto.maaliero, (tehotilasto.maalit+tehotilasto.syotot) AS pisteet
									FROM sarja
									LEFT JOIN sarjatilasto ON sarjatilasto.sarjaID = sarja.sarjaID
									LEFT JOIN tehotilasto ON tehotilasto.sarjatilastoID = sarjatilasto.sarjatilastoID
									LEFT JOIN pelaaja ON pelaaja.pelaajaID = tehotilasto.pelaajaID
									LEFT JOIN joukkue ON joukkue.joukkueID = tehotilasto.joukkueID
									WHERE sarja.sarjataso = :leaguesName AND sarja.kausiID = :seasonid AND sarjatilasto.tyyppi = 'pisteporssi'
									ORDER BY pisteet DESC, ottelut ASC, maaliero DESC";
	private $GET_TEAMS_MATCHES_BY_ID = "SELECT ottelu.otteluID AS otteluID, ottelu.sarjatilastoID, ottelu.kotiID, joukkue.nimi AS kotiNimi, ottelu.vierasID AS vierasID,
									
									(SELECT joukkue.nimi AS vierasNimi FROM joukkue
									WHERE joukkue.joukkueID = vierasID) AS vierasNimi,
									
									ottelu.kotimaalit, ottelu.vierasmaalit, ottelu.ppsarjaID, ottelu.tuomari, Date_format(ottelu.pvm, '%d.%m.%Y') AS pvm, ottelu.aika, ottelu.jatkoaika, ottelu.raportti, ottelu.ktorjutut1, ottelu.ktorjutut2, ottelu.ktorjutut3, ottelu.vtorjutut1, ottelu.vtorjutut2, ottelu.vtorjutut3, ottelu.khallinta1, ottelu.khallinta2, ottelu.khallinta3, ottelu.vhallinta1, ottelu.vhallinta2, ottelu.vhallinta3,
									(SELECT COUNT(*) AS comments FROM kommentit WHERE kommentit.kohdeID = otteluID) AS comments
									
									FROM sarja
									LEFT JOIN sarjatilasto ON sarjatilasto.sarjaID = sarja.sarjaID
									LEFT JOIN ottelu ON ottelu.sarjatilastoID = sarjatilasto.sarjatilastoID
									LEFT JOIN joukkue ON joukkue.joukkueID = ottelu.kotiID
									WHERE sarjatilasto.sarjatilastoID = :matchesid
									ORDER BY otteluID DESC";
	private $GET_TEAMS_MATCHES_BY_NAME = "SELECT ottelu.otteluID AS otteluID, ottelu.sarjatilastoID, ottelu.kotiID, joukkue.nimi AS kotiNimi, ottelu.vierasID AS vierasID,
									
									(SELECT joukkue.nimi AS vierasNimi FROM joukkue
									WHERE joukkue.joukkueID = vierasID) AS vierasNimi,
									
									ottelu.kotimaalit, ottelu.vierasmaalit, ottelu.ppsarjaID, ottelu.tuomari, Date_format(ottelu.pvm, '%d.%m.%Y') AS pvm, ottelu.aika, ottelu.jatkoaika, ottelu.raportti, ottelu.ktorjutut1, ottelu.ktorjutut2, ottelu.ktorjutut3, ottelu.vtorjutut1, ottelu.vtorjutut2, ottelu.vtorjutut3, ottelu.khallinta1, ottelu.khallinta2, ottelu.khallinta3, ottelu.vhallinta1, ottelu.vhallinta2, ottelu.vhallinta3,
									(SELECT COUNT(*) AS comments FROM kommentit WHERE kommentit.kohdeID = otteluID) AS comments
									
									FROM sarja
									LEFT JOIN sarjatilasto ON sarjatilasto.sarjaID = sarja.sarjaID
									LEFT JOIN ottelu ON ottelu.sarjatilastoID = sarjatilasto.sarjatilastoID
									LEFT JOIN joukkue ON joukkue.joukkueID = ottelu.kotiID
									WHERE sarja.sarjataso = :leaguesName AND sarja.kausiID = :seasonid AND sarjatilasto.tyyppi = 'ottelut'
									ORDER BY otteluID DESC";
									
	private $GET_MATCH_BY_ID = "SELECT kausi, kotiID, vierasID, kotimaalit, vierasmaalit, sarjataso, tyyppi, ppsarjaID, tuomari, DATE_FORMAT(pvm,'%d.%m.%Y') AS pvm, aika, jatkoaika, luovutusvoitto, raportti, ktorjutut1, ktorjutut2, ktorjutut3, vtorjutut1, vtorjutut2, vtorjutut3, khallinta1, khallinta2, khallinta3, vhallinta1, vhallinta2, vhallinta3
								FROM ottelu
								LEFT JOIN sarjatilasto ON sarjatilasto.sarjatilastoID = ottelu.sarjatilastoID
								LEFT JOIN sarja ON sarja.sarjaID = sarjatilasto.sarjaID
								LEFT JOIN kausi ON kausi.kausiID = sarja.kausiID
								WHERE ottelu.otteluID = :matchid";
	private $GET_ATTACKSTATS_BY_ID = "SELECT rstilasto.joukkueID AS teamID, joukkue.nimi AS teamName, sarjatilasto.sarjaID AS sarja, (rstilasto.voitot + rstilasto.tasapelit + rstilasto.tappiot) AS games, rstilasto.tehdyt AS goals,
									
									(SELECT sum(vieras_torjutut)
									FROM sarjatilasto
									LEFT JOIN ottelu ON ottelu.sarjatilastoID = sarjatilasto.sarjatilastoID
									LEFT JOIN ottelut_erat ON ottelut_erat.otteluID = ottelu.otteluID
									WHERE ottelu.kotiID = teamID AND sarjatilasto.sarjaID = sarja AND sarjatilasto.tyyppi = 'ottelut'
									) AS homeGameShots,
									
									(SELECT sum(koti_torjutut)
									FROM sarjatilasto
									LEFT JOIN ottelu ON ottelu.sarjatilastoID = sarjatilasto.sarjatilastoID
									LEFT JOIN ottelut_erat ON ottelut_erat.otteluID = ottelu.otteluID
									WHERE ottelu.vierasID = teamID AND sarjatilasto.sarjaID = sarja AND sarjatilasto.tyyppi = 'ottelut'
									) AS guestGameShots
									
									FROM rstilasto
									LEFT JOIN joukkue ON joukkue.joukkueID = rstilasto.joukkueID
									LEFT JOIN sarjatilasto ON sarjatilasto.sarjatilastoID = rstilasto.sarjatilastoID
									WHERE rstilasto.sarjatilastoID = :id";
	private $GET_ATTACKSTATS_BY_NAME = "SELECT sarja.nimi, joukkue.nimi AS teamName, rstilasto.joukkueID AS teamID, (rstilasto.voitot + rstilasto.tasapelit + rstilasto.tappiot) AS games, rstilasto.tehdyt AS goals, sarjatilasto.sarjatilastoID AS stilastoID,
									
									(SELECT sum(ottelu.kotimaalit + ottelu.vtorjutut1 + ottelu.vtorjutut2 + ottelu.vtorjutut3) AS shots
									FROM sarja
									LEFT JOIN sarjatilasto ON sarjatilasto.sarjaID = sarja.sarjaID
									LEFT JOIN ottelu ON ottelu.sarjatilastoID = sarjatilasto.sarjatilastoID
									WHERE sarja.sarjataso = :leaguesName AND sarja.kausiID = :seasonid AND sarjatilasto.tyyppi = 'ottelut' AND ottelu.kotiID = teamID
									) AS homeGameShots,
									
									(SELECT sum(ottelu.vierasmaalit + ottelu.ktorjutut1 + ottelu.ktorjutut2 + ottelu.ktorjutut3) AS shots
									FROM sarja
									LEFT JOIN sarjatilasto ON sarjatilasto.sarjaID = sarja.sarjaID
									LEFT JOIN ottelu ON ottelu.sarjatilastoID = sarjatilasto.sarjatilastoID
									WHERE sarja.sarjataso = :leaguesName AND sarja.kausiID = :seasonid AND sarjatilasto.tyyppi = 'ottelut' AND ottelu.vierasID = teamID
									) AS guestGameShots
									
									FROM sarja
									LEFT JOIN sarjatilasto ON sarjatilasto.sarjaID = sarja.sarjaID
									LEFT JOIN rstilasto ON rstilasto.sarjatilastoID = sarjatilasto.sarjatilastoID
									LEFT JOIN joukkue ON joukkue.joukkueID = rstilasto.joukkueID
									WHERE sarja.sarjataso = :leaguesName AND sarja.kausiID = :seasonid AND sarjatilasto.tyyppi = 'sarjataulukko'";
	private $GET_DEFENCESTATS_BY_NAME = "SELECT sarja.nimi, joukkue.joukkueID AS teamID, joukkue.nimi AS teamName, rstilasto.torjutut AS saves, rstilasto.paastetyt AS goalsAgainst, (rstilasto.voitot + rstilasto.tasapelit + rstilasto.tappiot) AS games,
									
									(SELECT sum(ottelu.vierasmaalit + ottelu.ktorjutut1 + ottelu.ktorjutut2 + ottelu.ktorjutut3) AS shots
									FROM sarja
									LEFT JOIN sarjatilasto ON sarjatilasto.sarjaID = sarja.sarjaID
									LEFT JOIN ottelu ON ottelu.sarjatilastoID = sarjatilasto.sarjatilastoID
									WHERE sarja.sarjataso = :leaguesName AND sarja.kausiID = :seasonid AND sarjatilasto.tyyppi = 'ottelut' AND ottelu.kotiID = teamID
									) AS opponentHomeGameShots,
									
									(SELECT sum(ottelu.kotimaalit + ottelu.vtorjutut1 + ottelu.vtorjutut2 + ottelu.vtorjutut3) AS shots
									FROM sarja
									LEFT JOIN sarjatilasto ON sarjatilasto.sarjaID = sarja.sarjaID
									LEFT JOIN ottelu ON ottelu.sarjatilastoID = sarjatilasto.sarjatilastoID
									WHERE sarja.sarjataso = :leaguesName AND sarja.kausiID = :seasonid AND sarjatilasto.tyyppi = 'ottelut' AND ottelu.vierasID = teamID
									) AS opponentGuestGameShots
									
									FROM sarja
									LEFT JOIN sarjatilasto ON sarjatilasto.sarjaID = sarja.sarjaID
									LEFT JOIN rstilasto ON rstilasto.sarjatilastoID = sarjatilasto.sarjatilastoID
									LEFT JOIN joukkue ON joukkue.joukkueID = rstilasto.joukkueID
									WHERE sarja.sarjataso = :leaguesName AND sarja.kausiID = :seasonid AND sarjatilasto.tyyppi = 'sarjataulukko'";
	private $GET_DEFENCESTATS_BY_ID = "SELECT rstilasto.joukkueID AS teamID, joukkue.nimi AS teamName, sarjatilasto.sarjaID AS sarja, (rstilasto.voitot + rstilasto.tasapelit + rstilasto.tappiot) AS games, rstilasto.torjutut AS saves, rstilasto.paastetyt AS goalsAgainst,
									
									(SELECT sum(koti_torjutut + ottelu.vierasmaalit)
									FROM sarjatilasto
									LEFT JOIN ottelu ON ottelu.sarjatilastoID = sarjatilasto.sarjatilastoID
									LEFT JOIN ottelut_erat ON ottelut_erat.otteluID = ottelu.otteluID
									WHERE ottelu.kotiID = teamID AND sarjatilasto.sarjaID = sarja AND sarjatilasto.tyyppi = 'ottelut'
									) AS opponentHomeGameShots,
									
									(SELECT sum(vieras_torjutut + ottelu.kotimaalit)
									FROM sarjatilasto
									LEFT JOIN ottelu ON ottelu.sarjatilastoID = sarjatilasto.sarjatilastoID
									LEFT JOIN ottelut_erat ON ottelut_erat.otteluID = ottelu.otteluID
									WHERE ottelu.vierasID = teamID AND sarjatilasto.sarjaID = sarja AND sarjatilasto.tyyppi = 'ottelut'
									) AS opponentGuestGameShots
									
									FROM rstilasto
									LEFT JOIN joukkue ON joukkue.joukkueID = rstilasto.joukkueID
									LEFT JOIN sarjatilasto ON sarjatilasto.sarjatilastoID = rstilasto.sarjatilastoID
									WHERE rstilasto.sarjatilastoID = :id";
									
	private $GET_PLAYER_STATS_BY_MATCH_ID_AND_TEAM_ID = "SELECT tehot.pelaajaID, nimi, maalit, syotot, maaliero
                  FROM tehot, pelaaja         
                  WHERE otteluID = :matchId
                  AND tehot.joukkueID = :teamId
                  AND tehot.pelaajaID = pelaaja.pelaajaID";
	private $GET_COMPETITION_STATS_FOR_PLAYERS_BY_COMPETITION_ID_AND_TEAM_ID = "SELECT pelaaja.nimi AS nimi, pelaaja.pelaajaID, 
									SUM(ottelut) AS ot, SUM(maalit) AS ma, 
									SUM(syotot) AS sy, SUM(maalit)+SUM(syotot) AS pt,
                  (SUM(maalit)+SUM(syotot))/SUM(ottelut) AS pperot, maaliero
									FROM pelaaja, tehotilasto
									WHERE pelaaja.pelaajaID = tehotilasto.pelaajaID
									AND tehotilasto.joukkueID = :teamId
									AND sarjatilastoID = :competitionId
									GROUP BY pelaaja.pelaajaID
									ORDER BY pt DESC, ma DESC, ot, nimi";
		
	function __construct() {
		parent::__construct();
	}
	
	public function getCurrentSeason() {
		try {
			$season = parent::executeStatement($this->GET_CURRENT_SEASON, array());
			$key = $season[0]["kausiID"];
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
	
	public function getCurrentLeagueStandingsId() {
		try {
			$key = parent::executeStatement($this->GET_CURRENT_LEAGUE_STANDINGS_ID, array());
			$result = $key[0]["sarjatilastoID"];
		} catch (Exception $e) {
			throw $e;
		}
		return $result;
	}
	
	public function getCurrentFirstDivisionStandingsId() {
		try {
			$key = parent::executeStatement($this->GET_FIRST_DIVISION_STANDINGS_ID, array());
			$result = $key[0]["sarjatilastoID"];
		} catch (Exception $e) {
			throw $e;
		}
		return $result;
	}
	
	public function getCurrentSecondDivisionStandingsId() {
		try {
			$key = parent::executeStatement($this->GET_SECOND_DIVISION_STANDINGS_ID, array());
			$result = $key[0]["sarjatilastoID"];
		} catch (Exception $e) {
			throw $e;
		}
		return $result;
	}

	public function getCurrentStandingsList() {
		try {
			$league = $this->getCurrentLeagueStandingsId();
			$firstDivision = $this->getCurrentFirstDivisionStandingsId();
			$secondDivision = $this->getCurrentSecondDivisionStandingsId();
			
			$standingsList = array();
			$standingsList[] = $this->getStandingsById($league);
			$standingsList[] = $this->getStandingsById($firstDivision);
			$standingsList[] = $this->getStandingsById($secondDivision);
		} catch (Exception $e) {
			throw $e;
		}
		return $standingsList;
	}

	public function getStandingsById($standingsid) {
		try {
			$standingResult = parent::executeStatement($this->GET_STANDINGS_BY_ID, array("standingsid" => $standingsid));
			$standings = array();
			$teamAccess = new TeamAccess();
			foreach ($standingResult as $value) {
				$teamId = $value["joukkueID"];
				$wins = $value["voitot"];
				$draws = $value["tasapelit"];
				$losses = $value["tappiot"];
				$goals = $value["tehdyt"];
				$goalsAgainst = $value["paastetyt"];
				$points = $value["pisteet"];
				$matches = $wins + $draws + $losses;
				$goalDifference = $goals - $goalsAgainst;
				$scoresPerMatch = 0;
				if($matches > 0) {
					$scoresPerMatch = round($points/$matches, 2);
				}
				
				$standingRow = new Standings($matches, $wins, $draws, $losses, $goals, $goalsAgainst, $points, $goalDifference, $scoresPerMatch);
				
				$team = $teamAccess->getTeamById($teamId);
				$standingRow->__set('team', $team);
				$standings[] = $standingRow;
			}
			
		} catch (Exception $e) {
			throw $e;
		}
		return $standings;
	}
	
	/*public function getStandingsByName($leaguesName, $seasonid) {
		if ($seasonid == null) {
			try {
				$key = parent::executeStatement($this->GET_CURRENT_SEASON, array());
				$seasonid = $key[0]["kausiID"];
			} catch (Exception $e) {
				throw $e;
			}
		}
		try {
			$key = parent::executeStatement($this->GET_STANDINGS_BY_NAME, array("leaguesName" => $leaguesName, "seasonid" => $seasonid));
			if ($key == null) {throw new Exception("Something's going wrong!");}
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}*/
	
	public function getScoreboardById($scoreboardid) {
		try {
			$scoreboardResult = parent::executeStatement($this->GET_SCOREBOARD_BY_ID, array("scoreboardid" => $scoreboardid));
			$scoreboards = array();
			$playerAccess = new PlayerAccess();
			$teamAccess = new TeamAccess();
			
			foreach ($scoreboardResult as $value) {
				$playerId = $value["pelaajaID"];
				$teamId = $value["joukkueID"];
				$matches = $value["ottelut"];
				$goals = $value["maalit"];
				$assists = $value["syotot"];
				$points = $value["pisteet"];
				$plusMinus = $value["maaliero"];
				$pointsPerMatch = round($points/$matches, 2);
				
				$newScoreboard = new Scoreboard($matches, $goals, $assists, $points, $pointsPerMatch, $plusMinus);
				$player = $playerAccess->getPlayerById($playerId);
				$newScoreboard->__set('player', $player);
				$team = $teamAccess->getTeamById($teamId);
				$newScoreboard->__set('team', $team);
				
				$scoreboards[] = $newScoreboard;
			}
			
		} catch (Exception $e) {
			throw $e;
		}
		return $scoreboards;
	}
	
	/*public function getScoreboardByName($leaguesName, $seasonid) {
		if ($seasonid == null) {
			try {
				$key = parent::executeStatement($this->GET_CURRENT_SEASON, array());
				$seasonid = $key[0]["kausiID"];
			} catch (Exception $e) {
				throw $e;
			}
		}
		try {
			if ($leaguesName == null) {throw new Exception("Failed league name");}
			if ($seasonid == null) {throw new Exception("Failed season");}
			$key = parent::executeStatement($this->GET_SCOREBOARD_BY_NAME, array("leaguesName" => $leaguesName, "seasonid" => $seasonid));
			if ($key == null) {throw new Exception("Something's going wrong!");}
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}*/
	
	public function getMatchesById($matchesid) {
		
		try {
			$results = parent::executeStatement($this->GET_TEAMS_MATCHES_BY_ID, array("matchesid" => $matchesid));
			$matches = array();
			
			$teamAccess = new TeamAccess();
			
			foreach($results as $match) {
				$id = $match['otteluID'];
				
				$homeTeamId = $match['kotiID'];
				$visitorTeamId = $match['vierasID'];
				$homeTeam = $teamAccess->getTeamById($homeTeamId);
				$visitorTeam = $teamAccess->getTeamById($visitorTeamId);
				
				$homeTeamGoals = $match['kotimaalit'];
				$visitorTeamGoals = $match['vierasmaalit'];
				$date = $match['pvm'];
				$report = $match['raportti'];
				$comments = $match['comments'];
				$homeTeamName = $match['kotiNimi'];
				$visitorTeamName = $match['vierasNimi'];
				$newMatch = new Match($id, null, null, $homeTeam, $visitorTeam, $homeTeamGoals, $visitorTeamGoals, null, null, $date, null, $report, $comments, null, null, null, null);
				$matches[] = $newMatch;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $matches;
	}
	
	public function getMatchById($matchId) {
		try {
		
			$teamAccess = new TeamAccess();
			$leagueStageAccess = new LeagueStageAccess();
			$periodStatsAccess = new PeriodStatsAccess();
			$commentsAccess = new CommentsAccess();
			
			$result = parent::executeStatement($this->GET_MATCH_BY_ID, array("matchid" => $matchId));
			$match = $result[0];
			
			$id = $matchId;
			$homeTeamId = $match["kotiID"];
			$visitorTeamId = $match["vierasID"];
			$homeTeamGoals = $match["kotimaalit"];
			$visitorTeamGoals = $match["vierasmaalit"];
			$seasonName = $match["kausi"];
			$league = $match["sarjataso"];
			$stageId = $match["ppsarjaID"];
			$date = $match["pvm"];
			$time = $match["aika"];
			$report = $match["raportti"];
			$referee = $match["tuomari"];
			$walkover = $match["luovutusvoitto"];
			$overtime = $match["jatkoaika"];
			
			$homeTeam = $teamAccess->getTeamById($homeTeamId);
			$visitorTeam = $teamAccess->getTeamById($visitorTeamId);
			$stage = $leagueStageAccess->getLeagueStageById($stageId);
			$periodStats = $periodStatsAccess->getPeriodStatsByMatchId($id);
			$comments = $commentsAccess->getMatchCommentsByMatchId($id);
			
			$homeTeamMatchPlayers = $this->getMatchPlayersByMatchIdAndTeamId($id, $homeTeamId);
			$visitorTeamMatchPlayers = $this->getMatchPlayersByMatchIdAndTeamId($id, $visitorTeamId);
			
			$theMatch = new Match($id, $league, $stage, $homeTeam, $visitorTeam, $homeTeamGoals, $visitorTeamGoals, $homeTeamMatchPlayers, $visitorTeamMatchPlayers, $date, $time, $report, $comments, $referee, $walkover, $overtime, $periodStats);
			
		} catch (Exception $e) {
			throw $e;
		}
		return $theMatch;
	}
	
	/*public function getMatchesByName($leaguesName, $seasonid) {
		if ($seasonid == null) {
			try {
				$key = parent::executeStatement($this->GET_CURRENT_SEASON, array());
				$seasonid = $key[0]["kausiID"];
			} catch (Exception $e) {
				throw $e;
			}
		}
		try {
			$key = parent::executeStatement($this->GET_TEAMS_MATCHES_BY_NAME, array("leaguesName" => $leaguesName, "seasonid" => $seasonid));
			if ($key == null) {throw new Exception("Something's going wrong!");}
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}*/
	
	public function getAttackStatsById($id) {
		try {
			$attackStats = parent::executeStatement($this->GET_ATTACKSTATS_BY_ID, array("id" => $id));
			$attackStatsList = array();
			$teamAccess = new TeamAccess();
			
			foreach ($attackStats as $value) {
				$teamId = $value["teamID"];
				$matches = $value["games"];
				$goals = $value["goals"];
				$homeGameShots = $value["homeGameShots"];
				$guesGameShots = $value["guesGameShots"];
				$shots = $homeGameShots+$guesGameShots;
				$shotsPerMatch = 0;
				$goalsPerMatch = 0;
				$scoringPercent = 0;
				if($matches > 0) {
					$shotsPerMatch = round($shots/$matches, 2);
					$goalsPerMatch = round($goals/$matches, 2);
					$scoringPercent = round(($goals+$shots)/$matches, 2);
				}
				$newAttackStats = new AttackStats($shots, $goals, $shotsPerMatch, $goalsPerMatch, $scoringPercent);
				$team = $teamAccess->getTeamById($teamId);
				$newAttackStats->__set('team', $team);
				$attackStatsList[] = $newAttackStats;
			}
			
		} catch (Exception $e) {
			throw $e;
		}
		return $attackStatsList;
	}
	
	public function getAttackStatsByName($leaguesName, $seasonid) {
		try {
			$key = parent::executeStatement($this->GET_ATTACKSTATS_BY_NAME, array("leaguesName" => $leaguesName, "seasonid" => $seasonid));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
	
	public function getDefenceStatsByName($leaguesName, $seasonid) {
		try {
			$key = parent::executeStatement($this->GET_DEFENCESTATS_BY_NAME, array("leaguesName" => $leaguesName, "seasonid" => $seasonid));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
	
	public function getDefenceStatsById($id) {
		try {
			$defenceResults = parent::executeStatement($this->GET_DEFENCESTATS_BY_ID, array("id" => $id));
			$defenceStatsList = array();
			$teamAccess = new TeamAccess();
			
			foreach ($defenceResults as $value) {
				$teamId = $value["teamID"];
				$matches = $value["games"];
				$saves = $value["saves"];
				$goalsAgainst = $value["goalsAgainst"];
				$opponentHomeGameShots = $value["opponentHomeGameShots"];
				$opponentGuestGameShots = $value["opponentGuestGameShots"];
				$totalShots = $opponentHomeGameShots + $opponentGuestGameShots;
				
				$savesPerMatch = 0;
				$goalsAgainstPerMatch = 0;
				if($matches > 0) {
					$savesPerMatch = round($saves/$matches, 2);
					$goalsAgainstPerMatch = round($goalsAgainst/$matches, 2);
				}
				
				$savesPercent = 0;
				if($totalShots > 0) {
					$savesPercent = round(($saves/$totalShots)*100, 2);
				}
				$newDefenceStats = new DefenceStats($saves, $goalsAgainst, $savesPerMatch, $goalsAgainstPerMatch, $savesPercent);
				$team = $teamAccess->getTeamById($teamId);
				$newDefenceStats->__set('team', $team);
				$defenceStatsList[] = $newDefenceStats;
			}
			
		} catch (Exception $e) {
			throw $e;
		}
		return $defenceStatsList;
	}
	
	public function getMatchPlayersByMatchIdAndTeamId($matchId, $teamId) {
		try {
			$playerAccess = new PlayerAccess();
			$matchPlayers = array();
			$results = parent::executeStatement($this->GET_PLAYER_STATS_BY_MATCH_ID_AND_TEAM_ID, array("teamId" => $teamId, "matchId" => $matchId));
			foreach($results as $row) {
				$playerId = $row['pelaajaID'];
				$player = $playerAccess->getPlayerById($playerId);
				$goals = $row['maalit'];
				$assists = $row['syotot'];
				$plusminus = $row['maaliero'];
				$matchPlayer = new MatchPlayer($player, $goals, $assists, $plusminus);
				$matchPlayers[] = $matchPlayer;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $matchPlayers;
	}
	
	public function getPlayoffsStanding($playoffsId) {
		try {
			$standings = array();
			$teamAccess = new TeamAccess();
			$results = parent::executeStatement($this->GET_PLAYOFFS_STANDING_BY_ID, array("id" => $playoffsId));
			foreach($results as $row) {
				$PlayoffsStanding = new PlayoffsStanding();
				$team1 = $teamAccess->getTeamById($row["joukkue1ID"]);
				$team2 = $teamAccess->getTeamById($row["joukkue2ID"]);
				$PlayoffsStanding->__set('team1', $team1);
				$PlayoffsStanding->__set('team2', $team2);
				$PlayoffsStanding->__set('team1Wins', $row["voitot1"]);
				$PlayoffsStanding->__set('team2Wins', $row["voitot2"]);
				
				$pairPlayoffsId = $row["ppsarjaID"];
				$matches = array();
				$playoffsMatchIds = parent::executeStatement($this->GET_MATCHID_BY_PLAYOFFSID, array("id" => $pairPlayoffsId));
				foreach ($playoffsMatchIds as $matchId) {
					$playoffMatches = $this->getMatchById($matchId["otteluID"]);
					$matches[] = $playoffMatches;
				}
				$PlayoffsStanding->__set('matches', $matches);
				
				$standings[] = $PlayoffsStanding;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $standings;
	}
	
	public function getCompetitionStatsForPlayersByCompetitionIdAndTeamId($teamId, $competitionId) {
		try {
			$key = parent::executeStatement($this->GET_COMPETITION_STATS_FOR_PLAYERS_BY_COMPETITION_ID_AND_TEAM_ID, array("teamId" => $teamId, "competitionId" => $competitionId));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
	
	
}

?>