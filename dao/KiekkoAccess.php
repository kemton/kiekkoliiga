<?php
/*
 * KIEKKOAPI . "user/123337?fields=name,id"
 * KIEKKOAPI . "user/=kemton?fields=ALL"
 * KIEKKOAPI . "team/16093?fields=ALL"
 * 
 */
class KiekkoAccess extends DatabaseAccess {
	
	public function getKiekkoPlayerByPlayerName($playerName) {
		try {
			$param = "user/={$playerName}?fields=id,name,created,vip,country,lft,experience,stars,fled,hide_stats,membership,last_seen,freetext,stats&opt=0";
			$json = $this->getJsonFromKiekkoApiWithParam($param);
			
			if ($json <> NULL) {
				$kPlayer = new KiekkoPlayer();
				$kPlayer->__set("id", $json->id);
				$kPlayer->__set("name", $json->name);
				$kPlayer->__set("isVIP", $json->vip);
				$kPlayer->__set("country", $json->country);
				$kPlayer->__set("team", $json->membership->team->name);
				$kPlayer->__set("created", $json->created);
				$kPlayer->__set("lookingForTeam", $json->lft);
				$kPlayer->__set("experienceLevel", $json->experience);
				$kPlayer->__set("autoplayLevel", $json->stars);
				$kPlayer->__set("leftDuringGame", $json->fled);
				$kPlayer->__set("lastOnline", $json->last_seen);
				$kPlayer->__set("freeText", $json->freetext);
				$kPlayer->__set("hideStats", $json->hide_stats);
				
				if (!$json->hide_stats) {
					$playerStatsList = array();
					foreach ($json->stats as $stats) {
						$kiekkoPlayerStats = new KiekkoPlayerStats();
						$kiekkoPlayerStats->__set("team", $stats->team);
						$kiekkoPlayerStats->__set("goals", $stats->goals);
						$kiekkoPlayerStats->__set("assists", $stats->assist);
						$kiekkoPlayerStats->__set("points", $stats->goals + $stats->assist);
						$kiekkoPlayerStats->__set("plusminus", $stats->plusminus);
						$kiekkoPlayerStats->__set("p", $stats->p);
						$kiekkoPlayerStats->__set("o", $stats->o);
						$kiekkoPlayerStats->__set("g", $stats->g);
						$kiekkoPlayerStats->__set("s", $stats->s);
						$kiekkoPlayerStats->__set("e", $stats->e);
						$kiekkoPlayerStats->__set("rt", $stats->rt);
						$kiekkoPlayerStats->__set("ro", $stats->ro);
						$playerStatsList[] = $kiekkoPlayerStats;
					}
					$kPlayer->__set("kiekkoPlayerStats", $playerStatsList);
				}
				
				return $kPlayer;
			} else {
				throw new Exception('Invalid player');
			}
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	private function getJsonFromKiekkoApiWithParam($param) {
		$json = utf8_encode(file_get_contents(KIEKKOAPI . $param));
		$arrObj = json_decode($json);
		return $arrObj;
	}
	
	/*private function getPlayerKiekkoId($name) {
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
	}*/
	
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