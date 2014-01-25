<?php
class TransfersController extends Controller {
	
	public function execute($request) {
		try {
			parent::execute($request);
			$_REQUEST["notifications"] = array();
			$user = unserialize($_SESSION['user']);
			if($user) {
				$action = $request[1];
				if ($action <> NULL) {
					if (method_exists(get_class($this), $action)) {
						$this->$action($request);
					} else {
						header("Status: 404 Not Found");
					}
				}
				
				$id = $user->__get("player")->__get("id");
				$transferAccess = new TransferAccess();
				
				$_REQUEST["invitations"] = serialize($transferAccess->getPlayerInvitationsByPlayerId($id));
				$_REQUEST["transfers_for_board"] = serialize($transferAccess->getTransfersForBoard());
				$_REQUEST["notifications"] = serialize($_REQUEST["notifications"]);
			}
		} catch (Exception $e) {
			throw $e;
		}
		return "transfersPage";
	}
	
	private function add_vh($request) {
		$user = unserialize($_SESSION['user']);
		if($user->__get("player")->__get("isAdmin")) {
			$transferAccess = new TransferAccess();
			$invitedPlayerId = $request[2];
			$invitedPlayerAuthName = $request[3];
			$inviter = $user->__get("player")->__get("name");
			$team = $user->__get("player")->__get("team")->__get("id");
			$transferAccess->invite("vastuuhnklo", $invitedPlayerId, $inviter, $team, $invitedPlayerAuthName);
			notification_box("Pelaajaa {$invitedPlayerAuthName} pyydetty vastuuhenkilöksi.");
		}
	}
	
	private function invite_to_squad($request) {
		$name = mysql_real_escape_string($_POST["name"]);
		$playerAccess = new PlayerAccess();
		$player = $playerAccess->getPlayerByName($name);
		if(!$player) {
			exit("Pelaajaa ei löytynyt.");
		}
		$user = unserialize($_SESSION['user']);
		if($user->__get("player")->__get("isAdmin")) {
			$transferAccess = new TransferAccess();
			$invitedPlayerId = $player->__get("id");
			$inviter = $user->__get("player")->__get("name");
			$team = $user->__get("player")->__get("team")->__get("id");
			$transferAccess->invite("pelaajasiirto", $invitedPlayerId, $inviter, $team, $name);
			notification_box("Pelaaja {$name} kutsuttu kokoonpanoon.");
		}
	}
	
	private function accept_transfer($request) {
		$transferAccess = new TransferAccess();
		$transferAccess->acceptTransfer($request[2]);
		notification_box("Siirto hyväksytty.");
	}
	
	private function reject_transfer($request) {
		$transferAccess = new TransferAccess();
		$transferAccess->rejectTransfer($request[2]);
		notification_box("Siirto hylätty.");
	}
	
	private function board_accept_transfer($request) {
		$user = unserialize($_SESSION['user']);
		if($user->__get("isAdmin") or true) {
			$transferId = $request[2];
			$transferAccess = new TransferAccess();
			$transferAccess->boardAcceptTransfer($transferId);
			
			$transfer = $transferAccess->getTransferById($transferId);
			$transferType = $transfer->__get("type");
			$playerId = $transfer->__get("invited");
			$playerAccess = new PlayerAccess();
			if($transferType == "pelaajasiirto") {
				$teamId = $transfer->__get("team")->__get("id");
				$playerAccess->addPlayerToTeam($playerId, $teamId);
			}
			else if($transferType == "vastuuhnklo") {
				$playerAccess->makeVh($playerId);
			}
			notification_box("Siirto hyväksytty.");
		}
	}
	
	private function board_reject_transfer($request) {
		$transferAccess = new TransferAccess();
		$transferAccess->boardRejectTransfer($request[2]);
		notification_box("Siirto hylätty.");
	}
	
	private function remove_from_squad($request) {
		$playerId = $request[2];
		$playerAccess = new PlayerAccess();
		$player = $playerAccess->getPlayerById($playerId);
		$user = unserialize($_SESSION['user']);
		if($user->__get("isAdmin") 
		or ($user->__get("player")->__get("isAdmin") and $user->__get("player")->__get("team")->__get("id") == $player->__get("team")->__get("id"))
		or $playerId == $user->__get("player")->__get("id")) {
			$playerAccess->removePlayerFromTeam($playerId);
		}
		notification_box("Pelaaja poistettu kokoonpanosta.");
	}
}

	

function notification_box($text) {
	$_REQUEST["notifications"][] = $text;
}
?>