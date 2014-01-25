<?php
class KiekkoPlayerStats {
	
	private $team;
	private $goals;
	private $assists;
	private $points;
	private $plusminus;
	private $p;
	private $o;
	private $g;
	private $s;
	private $e;
	private $rt;
	private $ro;
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
	
	public function getTeamName($team) {
		if (is_object($team)) {
			if (!$team->name == "") {
				return "<a href=\"http://kiekko.tk/teams/team.cws?team=" . urlencode(utf8_decode($team->name)) . "\">{$team->name}</a>";
			} else {
				return "(poistettu joukkue)";
			}
		} elseif ($team == -1) {
			return "(harjoituspelit)";
		} elseif ($team < -1) {
			return "vanhat joukkueet, " . $team * -1 . " kpl";
		} else {
			return "";
		}
	}
}
?>