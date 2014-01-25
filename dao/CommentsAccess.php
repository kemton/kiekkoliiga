<?php
class CommentsAccess extends DatabaseAccess {

	private $BOARD_OR_PRESS_RELEASE_TYPE = 0;
	private $MATCH_TYPE = 1;
	private $PAITSIO_TYPE = 2;
	private $NEWS_TYPE = 3;
	
	private $GET_COMMENTS_BY_TYPE_ID = "SELECT kommenttiID, kirjoittaja, kirjoittajaID, kommentti, aika, poistettu, poistaja
																			FROM kommentit 
																			WHERE kohde = :type AND kohdeID = :typeId 
																			ORDER BY kommenttiID ASC";
	private $ADD_COMMENT = "INSERT INTO kommentit SET 
													kohde = :typeId, 
													kohdeID = :targetId, 
													kirjoittaja = :userName, 
													kirjoittajaID = :userId, 
													kommentti = :comment, 
													aika = NOW(), 
													ip = :ip";
	
	public function getBoardOrPressReleaseCommentsById($id) {
		try {
			return $this->getCommentsByTypeId($this->BOARD_OR_PRESS_RELEASE_TYPE, $id);
		} catch (Exception $e) {
			throw $e;
		}
	}

	public function getMatchCommentsByMatchId($matchId) {
		try {
			return $this->getCommentsByTypeId($this->MATCH_TYPE, $matchId);
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function getPaitsioCommentsById($paitsioId) {
		try {
			return $this->getCommentsByTypeId($this->PAITSIO_TYPE, $paitsioId);
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function getNewsCommentsByNewsId($newsId) {
		try {
			return $this->getCommentsByTypeId($this->NEWS_TYPE, $newsId);
		} catch (Exception $e) {
			throw $e;
		}
	}

	public function addComment($type, $targetId, $userName, $userId, $comment, $ip) {
		try {
			switch($type) {
				case "BoardOrPressRelease": 
					$typeId = $this->BOARD_OR_PRESS_RELEASE_TYPE;
					break;
				case "Match":
					$typeId = $this->MATCH_TYPE;
					break;
				case "Paitsio":
					$typeId = $this->PAITSIO_TYPE;
					break;
				case "News":
					$typeId = $this->NEWS_TYPE;
					break;
			}
			
			$affectedRows = parent::updateStatement($this->ADD_COMMENT, array("typeId" => $typeId, "targetId" => $targetId, "userName" => $userName, "userId" => $userId, "comment" => $comment, "ip" => $ip));
			if($affectedRows == 1) {
				return true;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return false;
	}

	private function getCommentsByTypeId($type, $typeId) {
		$playerAccess = new PlayerAccess();
		try {
			$results = parent::executeStatement($this->GET_COMMENTS_BY_TYPE_ID, array("type" => $type, "typeId" => $typeId));
			$comments = array();
			
			foreach($results as $row) {
				$id = $row['kommenttiID'];
				$writer = $row['kirjoittaja'];
				$commentText = $row['kommentti'];
				$timestamp = $row['aika'];
				$deleted = $row['poistettu'];
				
				$writerForumId = $row['kirjoittajaID'];
				$deletedById = $row['poistaja'];
				
				$writerObject = $playerAccess->getPlayerByForumId($writerForumId);
				$deletedByObject = $playerAccess->getPlayerByForumId($deletedByForumId);
				
				
				$comment = new Comment($id, $writer, $writerObject, $commentText, $timestamp, $deleted, $deletedByObject);
				$comments[] = $comment;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $comments;
	}
}
?>