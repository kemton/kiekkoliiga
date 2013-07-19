<?php
class MatchPeriod {
	private $periodNumber;
	private $homeTeamControl;
	private $visitorTeamControl;
	private $homeTeamShots;
	private $visitorTeamShots;
	private $homeTeamSaves;
	private $visitorTeamSaves;
	
	public function __construct($periodNumber, $homeTeamControl, $visitorTeamControl, $homeTeamShots, $visitorTeamShots, $homeTeamSaves, $visitorTeamSaves) {
		$this->periodNumber = $periodNumber;
		$this->homeTeamControl = $homeTeamControl;
		$this->visitorTeamControl = $visitorTeamControl;
		$this->homeTeamShots = $homeTeamShots;
		$this->visitorTeamShots = $visitorTeamShots;
		$this->homeTeamSaves = $homeTeamSaves;
		$this->visitorTeamSaves = $visitorTeamSaves;
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
}
?>