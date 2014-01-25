<?php
class TransferAccess extends DatabaseAccess {

	private $GET_AUTH_BY_FORUM_ID = "SELECT * FROM queue WHERE playerID = :playerId LIMIT 1";
	private $GET_AUTH_BY_PLAYER_ID = "SELECT * FROM auth WHERE pelaajaID = :playerId LIMIT 1";
	private $GET_PLAYER_INVITATIONS_BY_PLAYER_ID = "SELECT * FROM queue WHERE playerID = :playerId and active = 1 and player_approved = 0 and admin_approved = 0 ORDER BY datetime";
	private $GET_TRANSFER_BY_ID = "SELECT * FROM queue WHERE id = :id";
	private $ACCEPT_TRANSFER = "UPDATE queue SET player_approved = 1 WHERE id = :id";
	private $REJECT_TRANSFER = "UPDATE queue SET active = 0 WHERE id = :id";
	private $BOARD_ACCEPT_TRANSFER = "UPDATE queue SET admin_approved = 1 WHERE id = :id";
	private $ADD_NEW_TRANSFER = "INSERT INTO queue (authed_player, playerID, teamID, requestor, responsible_person, datetime, active, player_approved, admin_approved, type) VALUES (:authName, :invited, :teamId, :inviter, 0, NOW(), 1, 0, 0, :type)";
	private $GET_TRANSFERS_FOR_BOARD = "SELECT * FROM queue WHERE active = 1 and player_approved = 1 and admin_approved = 0";
	
	public function getPlayerInvitationsByPlayerId($playerId) {
		try {
			$key = parent::executeStatement($this->GET_PLAYER_INVITATIONS_BY_PLAYER_ID, array(":playerId" => $playerId));
			$results = array();
			if (!count($key) > 0) {
				return array();
			}
			foreach($key as $result) {
				$teamAccess = new TeamAccess();
				$teamId = $result["teamID"];
				$team = $teamAccess->getTeamById($teamId);
				$type = $result["type"];
				$id = $result["id"];
				$datetime = $result["datetime"];
				$invited = $result["playerID"];
				$inviter = $result["requestor"];
				$active = $result["active"];
				$playerApproved = $result["player_approved"];
				$adminApproved = $result["admin_approved"];
				$transfer = new Transfer($type, $id, $datetime, $invited, $inviter, $team, $active, $playerApproved, $adminApproved);
				$results[] = $transfer;
			}
			return $results;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function getTransfersForBoard() {
		try {
			$key = parent::executeStatement($this->GET_TRANSFERS_FOR_BOARD, array());
			$results = array();
			if (!count($key) > 0) {
				return array();
			}
			foreach($key as $result) {
				$teamAccess = new TeamAccess();
				$teamId = $result["teamID"];
				$team = $teamAccess->getTeamById($teamId);
				$type = $result["type"];
				$id = $result["id"];
				$datetime = $result["datetime"];
				$invited = $result["playerID"];
				$inviter = $result["requestor"];
				$active = $result["active"];
				$playerApproved = $result["player_approved"];
				$adminApproved = $result["admin_approved"];
				$transfer = new Transfer($type, $id, $datetime, $invited, $inviter, $team, $active, $playerApproved, $adminApproved);
				$results[] = $transfer;
			}
			return $results;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function getTransferById($id) {
		$key = parent::executeStatement($this->GET_TRANSFER_BY_ID, array(":id" => $id));
		$teamAccess = new TeamAccess();
		$team = $teamAccess->getTeamById($key[0][teamID]);
		$transfer = new Transfer($key[0][type], $key[0][id], 
		$key[0][datetime], $key[0][playerID], 
		$key[0][requestor], $team, 
		$key[0][active], $key[0][player_approved], 
		$key[0][admin_approved]);
		return $transfer;
	}
	
	public function acceptTransfer($transferId) {
		parent::updateStatement($this->ACCEPT_TRANSFER, array(":id" => $transferId));
	}
	
	public function rejectTransfer($transferId) {
		parent::updateStatement($this->REJECT_TRANSFER, array(":id" => $transferId));
	}
	
	public function boardAcceptTransfer($transferId) {
		parent::updateStatement($this->BOARD_ACCEPT_TRANSFER, array(":id" => $transferId));
	}
	
	public function boardRejectTransfer($transferId) {
		parent::updateStatement($this->REJECT_TRANSFER, array(":id" => $transferId));
	}
	
	public function invite($type, $invited, $inviter, $teamId, $authName) {
		parent::updateStatement($this->ADD_NEW_TRANSFER, array(":type" => $type, ":invited" => $invited, ":inviter" => $inviter, ":teamId" => $teamId, ":authName" => $authName));
	}
	
/*
	public function destroyAuthByForumId($forumId) {
		try {
			parent::updateStatement($this->DESTROY_AUTH, array("forumId" => $forumId));
		} catch (Exception $e) {
			throw $e;
		}
	}*/
	
}
?>