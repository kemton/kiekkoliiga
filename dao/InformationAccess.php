<?php
class InformationAccess extends DatabaseAccess {
	private $GET_LAST_BOARD_INFO = "SELECT tiedoteID, kausiID, otsikko, DATE_FORMAT(aika,'%d.%m.%Y') AS pvm
							FROM lehdistotiedotteet WHERE sarjataso = 'johto' ORDER BY aika DESC LIMIT 0, 5";
	private $GET_LAST_PAITSIO = "SELECT id, otsikko, lahettaja, aika, luettu, DATE_FORMAT(aika, '%d.%m.%Y') AS aika2 FROM a_paitsio_jutut ORDER BY id DESC LIMIT 5";
	private $GET_LAST_COMMENTED = "SELECT kommenttiID, kohde, kohdeID, kirjoittaja, kirjoittajaID, kommentti, aika, active, DATE_FORMAT(aika, '%d.%m.') AS aika2 FROM kommentit WHERE poistettu IS NULL ORDER BY kommenttiID DESC LIMIT 10";
	private $GET_LAST_NEWS = "SELECT id_msg, id_topic, id_board, poster_time, poster_time, id_member, id_msg_modified, subject, poster_name,
							smileys_enabled, modified_time, modified_name, body, icon, approved FROM smf_messages WHERE id_board='1' ORDER BY id_topic DESC LIMIT 5";
	private $GET_NEWS_BY_ID = "SELECT id_msg, id_topic, id_board, poster_time, poster_time, id_member, id_msg_modified, subject, poster_name,
							smileys_enabled, modified_time, modified_name, body, icon, approved FROM smf_messages WHERE id_board = :newsId LIMIT 1";

	private $GET_LAST_TEAM_NEWS = "SELECT lehdistotiedotteet.tiedoteID, lehdistotiedotteet.joukkueID, lehdistotiedotteet.kausiID, lehdistotiedotteet.sarjataso,
								lehdistotiedotteet.kirjoittaja, lehdistotiedotteet.otsikko, lehdistotiedotteet.teksti, lehdistotiedotteet.aika,
								lehdistotiedotteet.luettu, joukkue.nimi, joukkue.lyhenne, DATE_FORMAT(aika,'%d.%m.%Y') AS pvm
								FROM lehdistotiedotteet LEFT JOIN joukkue ON lehdistotiedotteet.joukkueID = joukkue.joukkueID
								WHERE sarjataso <> 'johto' ORDER BY aika DESC LIMIT 0, 5";
	private $GET_LAST_LFT = "SELECT id_msg, poster_time, id_member, id_msg_modified, subject, poster_name, poster_email, body FROM smf_messages WHERE id_topic='4409' AND id_msg <> '17753' OR id_topic='4410' AND id_msg <> '17754' ORDER BY id_msg DESC LIMIT 5";
	private $GET_BOARD_INFO_BY_ID = "SELECT tiedoteID, kausiID, sarjataso, kirjoittaja, otsikko, teksti, muokattu, luettu, DATE_FORMAT(aika, '%d.%m.%Y') AS aika2 FROM lehdistotiedotteet WHERE tiedoteID = :boardInfoId LIMIT 1";
	private $GET_ALL_BOARD_INFOS = "SELECT tiedoteID, kausiID, sarjataso, kirjoittaja, otsikko, teksti, muokattu, luettu, DATE_FORMAT(aika, '%d.%m.%Y') AS aika2 FROM lehdistotiedotteet WHERE sarjataso = 'johto' ORDER BY tiedoteID DESC";
	private $GET_PAITSIO_ARTICLE_BY_ID = "SELECT id, otsikko, lahettaja, teksti, aika, luettu, DATE_FORMAT(aika, '%d.%m.%Y') AS aika2 FROM a_paitsio_jutut WHERE id = :paitsioid LIMIT 1";
	private $GET_ALL_PAITSIO_ARTICLE = "SELECT id, otsikko, lahettaja, aika, luettu, DATE_FORMAT(aika, '%d.%m.%Y') AS aika2 FROM a_paitsio_jutut ORDER BY id DESC";
	private $UPDATE_PAITSIO_READ_COUNT = "UPDATE a_paitsio_jutut SET luettu=luettu+1 WHERE id = :paitsioid LIMIT 1";
	
	function __construct() {
		parent::__construct();
	}
	
	public function getLastBoardInfo() {
		try {
			$boardInfo = parent::executeStatement($this->GET_LAST_BOARD_INFO, array());
			$boardInfos = array();
			foreach($boardInfo as $value) {
				$id = $value["tiedoteID"];
				$header = $value["otsikko"];
				$time = $value["pvm"];
				$writer = 'Johto';
				
				$newBoardInfo = new BoardInfo($id, $header, $writer, $time, "", "", null);
				$boardInfos[] = $newBoardInfo;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $boardInfos;
	}
	
	public function getLastPaitsio() {
		try {
			$paitsioInfo = parent::executeStatement($this->GET_LAST_PAITSIO, array());
			$paitsioInfos = array();
			foreach($paitsioInfo as $value) {
				$id = $value["id"];
				$header = $value["otsikko"];
				$time = $value["aika2"];
				$writer = $value["lahettaja"];
				$text = "";
				$read = $value["luettu"];
				$newPaitsioInfo = new BoardInfo($id, $header, $writer, $time, $text, $read, null);
				$paitsioInfos[] = $newPaitsioInfo;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $paitsioInfos;
	}
	
	public function getLastCommented() {
		try {
			$playerAccess = new PlayerAccess();
			$commentsAccess = new CommentsAccess();
			$statisticsAccess = new StatisticsAccess();
			$results = parent::executeStatement($this->GET_LAST_COMMENTED, array());
			$comments = array();
			foreach($results as $result) {
				$writerId = $result["kirjoittajaID"];
				$writer = $playerAccess->getPlayerByForumId($writerId);
				$writerId = $writer->__get("id");
				$writerName = $writer->__get("name");
				$writerIsBoard = $writer->__get("isBoard");
				
				$time = $result["aika"];
				$time = explode(" ", $time);
				$date = explode("-", $time[0]);
				$time = explode(":", $time[1]);
				$timeString = "{$date[2]}.{$date[1]}. {$time[0]}:{$time[1]}";
				
				$target = $result["kohde"];
				$targetId = $result["kohdeID"];
				if($target == 0) { // Board or Press release
					$boardInfo = $this->getBoardInfoById($targetId);
					$name = $boardInfo->__get("header");
					$targetLink = "/board-info/";
				}
				else if($target == 1) { // Match
					$match = $statisticsAccess->getMatchById($targetId);
					$name = $match->getName();
					$targetLink = "/statistics/ottelu/";
				}
				else if($target == 2) { // Paitsio
					$boardInfo = $this->getPaitsioArticleById($targetId);
					$name = $boardInfo->__get("header");
					$targetLink = "/paitsio/";
				}
				else if($target == 3) { // News
					//$boardInfo = $this->getNewsById($targetId);
					//$name = $boardInfo->__get("header");
					$targetLink = "/news/";
				}
				
				$targetLink .= $targetId;
				
				$comments[] = array("writerId" => $writerId, "writerName" => $writerName, "writerIsBoard" => $writerIsBoard, "time" => $timeString, "name" => $name, "targetLink" => $targetLink);
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $comments;
	}

	public function getNewsById($newsId) {
		try {
			$key = parent::executeStatement($this->$GET_NEWS_BY_ID, array('newsId' => $newsId));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
	
	public function getLastNews() {
		try {
			$key = parent::executeStatement($this->GET_LAST_NEWS, array());
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
	
	public function getLastTeamNews() {
		try {
			$results = parent::executeStatement($this->GET_LAST_TEAM_NEWS, array());
			foreach($results as $boardInfo) {
				$id = $boardInfo['tiedoteID'];
				$header = $boardInfo['otsikko'];
				$writer = $boardInfo['lyhenne'];
				$time = $boardInfo['pvm'];
				$newBoardInfo = new BoardInfo($id, $header, $writer, $time, null, null, null);
				$boardInfos[] = $newBoardInfo;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $boardInfos;
	}
	
	public function getLastLookingForTeam() {
		try {
			$key = parent::executeStatement($this->GET_LAST_LFT, array());
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
	public function getBoardInfoById($boardInfoId) {
		try {
			$commentsAccess = new CommentsAccess();
			$result = parent::executeStatement($this->GET_BOARD_INFO_BY_ID , array("boardInfoId" => $boardInfoId));
			$result = $result[0];
			$id = $result['tiedoteID'];
			$header = $result['otsikko'];
			$writer = $result['kirjoittaja'];
			$time = $result['aika2'];
			$text = $result['teksti'];
			$read = $result['luettu'];
			$comments = $commentsAccess->getBoardOrPressReleaseCommentsById($id);
			$boardInfo = new BoardInfo($id, $header, $writer, $time, $text, $read, $comments);
		} catch (Exception $e) {
			throw $e;
		}
		return $boardInfo;
	}
	
	public function getAllBoardInfos() {
		try {
			$results = parent::executeStatement($this->GET_ALL_BOARD_INFOS , array());
			$boardInfos = array();
			foreach($results as $boardInfo) {
				$id = $boardInfo['tiedoteID'];
				$header = $boardInfo['otsikko'];
				$writer = $boardInfo['kirjoittaja'];
				$time = $boardInfo['aika2'];
				$newBoardInfo = new BoardInfo($id, $header, $writer, $time, null, null, null);
				$boardInfos[] = $newBoardInfo;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $boardInfos;
	}

	public function getPaitsioArticleById($paitsioid) {
		try {
			$commentsAccess = new CommentsAccess();
			$result = parent::executeStatement($this->GET_PAITSIO_ARTICLE_BY_ID , array("paitsioid" => $paitsioid));
			$result = $result[0];
			$id = $result['id'];
			$header = $result['otsikko'];
			$writer = $result['lahettaja'];
			$time = $result['aika2'];
			$text = $result['teksti'];
			$read = $result['luettu'];
			$comments = $commentsAccess->getPaitsioCommentsById($id);
			$boardInfo = new BoardInfo($id, $header, $writer, $time, $text, $read, $comments);
		} catch (Exception $e) {
			throw $e;
		}
		return $boardInfo;
	}
	
	public function getAllPaitsioArticle() {
		try {
			$results = parent::executeStatement($this->GET_ALL_PAITSIO_ARTICLE , array());
			$boardInfos = array();
			foreach($results as $boardInfo) {
				$id = $boardInfo['id'];
				$header = $boardInfo['otsikko'];
				$writer = $boardInfo['lahettaja'];
				$time = $boardInfo['aika2'];
				$newBoardInfo = new BoardInfo($id, $header, $writer, $time, null, null, null);
				$boardInfos[] = $newBoardInfo;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $boardInfos;
	}
	
	public function updatePaitsioReadCount($paitsioid) {
		try {
			$key = parent::updateStatement($this->UPDATE_PAITSIO_READ_COUNT , array("paitsioid" => $paitsioid));
		} catch (Exception $e) {
			throw $e;
		}
		return $key;
	}
}
?>