<?php
class AuthAccess extends DatabaseAccess {

	//private $SET_AUTH_FOR_PLAYER = "INSERT INTO auth SET id_member=:userId, name=:playerName, id_kiekko=:kiekkoId, created=:created, exp=:exp, updated=NOW()";
	private $GET_AUTH_BY_FORUM_ID = "SELECT * FROM auth WHERE id_member = :forumId LIMIT 1";
	private $GET_AUTH_BY_PLAYER_ID = "SELECT * FROM auth WHERE pelaajaID = :playerId LIMIT 1";
	private $ADD_AUTH = "INSERT INTO auth (id_member, name, id_kiekko, created, exp, updated)
						VALUES (:forumId, :name, :kiekkoId, :created, :exp, NOW())";
	private $UPDATE_AUTH = "UPDATE auth SET
						name = :name,
						id_kiekko = :kiekkoId,
						pelaajaID = :playerId,
						created = :created,
						exp = :exp,
						updated = NOW()
						WHERE id_member = :forumId";
	private $GET_PLAYER_BY_USER_ID = "SELECT auth.id_auth, auth.id_member, auth.pelaajaID, auth.name, auth.id_kiekko, auth.created, auth.exp, auth.updated FROM auth WHERE id_member = :memberId";
	
	//private $DESTROY_AUTH = "DELETE FROM auth WHERE id_member = :id_member";
	
	public function authPlayer($forumId, $playerName, $authCode) {
		try {
			$kiekkoAccess = new KiekkoAccess();
			$kiekkoPlayer = $kiekkoAccess->getKiekkoPlayerByPlayerName($playerName);
			
			$playerAccess = new PlayerAccess();
			$player = $playerAccess->getPlayerByName($playerName);
			$playerId = $player->__get('id');
			
			if ($this->verifyAuth($playerName, $authCode, $kiekkoPlayer->id)) {
				$auth = new Auth($forumId, $playerName, $kiekkoPlayer->id, $playerId, $kiekkoPlayer->experienceLevel, $kiekkoPlayer->created);
				
				if ($this->isUserAuthed($forumId)) {
					$result = parent::updateStatement($this->UPDATE_AUTH, array(":forumId" => $forumId, ":name" => $playerName, ":kiekkoId" => $kiekkoPlayer->id, ":playerId" => $playerId, ":created" => $kiekkoPlayer->created, ":exp" => $kiekkoPlayer->experienceLevel));
				} else {
					$result = parent::updateStatement($this->ADD_AUTH, array(":forumId" => $forumId, ":name" => $playerName, ":kiekkoId" => $kiekkoPlayer->id, ":playerId" => $playerId, ":created" => $kiekkoPlayer->created, ":exp" => $kiekkoPlayer->experienceLevel));
				}
				
			} else {
				throw new Exception("Tunnistautumis koodi on virheellinen.");
			}
			
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	private function verifyAuth($playerName, $authCode, $kiekkoId) {
		$timezone = new DateTimeZone( "Europe/London" );
		$dateTime = new DateTime();
		$dateTime->setTimezone( $timezone );
		$date = $dateTime->format('y-m-d H');
		$hash = md5(PANDABOTPASS . strtolower($playerName) . $kiekkoId . $date);
		$checksum = $hash[3] . $hash[8] . $hash[12] . $hash[22] . $hash[30];
		
		return (strtoupper($checksum) == $authCode) ? TRUE : FALSE;
		//return TRUE; // debug
	}
	
	public function isUserAuthed($forumId) {
		try {
			 $result = parent::rowCount($this->GET_AUTH_BY_FORUM_ID, array(":forumId" => $forumId));
			 if ($result >= 1) {
			 	return TRUE;
			 } else {
			 	return FALSE;
			 }
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function getAuthByForumId($forumId) {
		try {
				$result = parent::executeStatement($this->GET_AUTH_BY_FORUM_ID, array(":forumId" => $forumId));
				$result = $result[0];
				$forumId = $result['id_member'];
				$name = $result['name'];
				$kiekkoId = $result['id_kiekko'];
				$playerId = $result['pelaajaID'];
				$experienceLevel = $result['exp'];
				$created = $result['created'];
				
				$auth = new Auth($forumId, $name, $kiekkoId, $playerId, $experienceLevel, $created);
		} catch (Exception $e) {
			throw $e;
		}
		return $auth;
	}

	public function getAuthByPlayerId($playerId) {
		try {
			//if ($this->isUserAuthed($forumId)) {
				$result = parent::executeStatement($this->GET_AUTH_BY_PLAYER_ID, array(":playerId" => $playerId));
				$result = $result[0];
				$forumId = $result['id_member'];
				$name = $result['name'];
				$kiekkoId = $result['id_kiekko'];
				$playerId = $result['pelaajaID'];
				$experienceLevel = $result['exp'];
				$created = $result['created'];
				
				$auth = new Auth($forumId, $name, $kiekkoId, $playerId, $experienceLevel, $created);
			/*} else {
				throw new AuthException("Ei aikasempaa tunnistautumista");
			}*/
			
		} catch (AuthException $e) {
			throw $e;
		} catch (Exception $e) {
			throw $e;
		}
		return $auth;
	}
	
	public function getPlayerIdByUserId($forumId) {
		try {
			$key = parent::executeStatement($this->GET_PLAYER_BY_USER_ID, array(":forumId" => $forumId));
			if (count($key) > 0) {
				return $key[0]["pelaajaID"];
			} else {
				return 0;
			}
		} catch (Exception $e) {
			throw $e;
		}
		
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