<?php
/*
 * KIEKKOAPI . "user/123337?fields=name,id"
 * KIEKKOAPI . "user/=kemton?fields=ALL"
 * 
 */
class KiekkoAccess extends DatabaseAccess {
	
	private $SET_AUTH_FOR_PLAYER = "INSERT INTO auth SET id_member=:userId, name=:playerName, id_kiekko=:kiekkoId, created=:created, exp=:exp, updated=NOW()";
	
	public function authPlayer($authCode, $playerName) {
		try {
			if ($this->verifyAuth($authCode, $playerName)) {
				
			} else {
				throw new Exception('Tunnistautumis koodi on virheellinen.');
			}
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	private function verifyAuth($authCode, $playerName) {
		$timezone = new DateTimeZone( "Europe/London" );
		$dateTime = new DateTime();
		$dateTime->setTimezone( $timezone );
		$date = $dateTime->format('y-m-d H');
		
		$hash = md5(PANDABOTPASS . strtolower($playerName) . $this->getPlayerKiekkoId($playerName) . $date);
		$checksum = $hash[3] . $hash[8] . $hash[12] . $hash[22] . $hash[30];
		return ($checksum == $authCode) ? TRUE : FALSE;
	}
	
	private function getPlayerKiekkoId($name) {
		try {
			if ($page = @file_get_contents("http://kiekko.tk/user.cws?name=" . $name)) {
				$search = '/href[=]["]\/log.cws[?]player[=][0-9]*["]/';
				if (preg_match($search, $page, $matches) == 1) {
					if (preg_match('/[0-9]+/', $matches[0], $match) == 1) {
						$player_id = $match[0];
					}
				}
				return $player_id;
			} else {
				throw new Exception('Invalid player');
			}
		} catch (Exception $e) {
			throw $e;
		}
	}
	 
	/*private function getUrlData($url) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}*/
}
?>