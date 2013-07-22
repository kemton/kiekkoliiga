<?php
class Match {
	
	protected $id;
	protected $league;
	protected $stage;
	protected $homeTeam;
	protected $visitorTeam;
	protected $homeTeamGoals;
	protected $visitorTeamGoals;
	protected $homeTeamMatchPlayers;
	protected $visitorTeamMatchPlayers;
	protected $date;
	protected $time;
	protected $hasReport;
	protected $comments;
	protected $referee;
	protected $walkover;
	protected $overtime;
	protected $periodStats;
	
	
	function __construct ($id, $league, $stage, $homeTeam, $visitorTeam, $homeTeamGoals, $visitorTeamGoals, $homeTeamMatchPlayers, $visitorTeamMatchPlayers, $date, $time, $report, $comments, $referee, $walkover, $overtime, $periodStats) {
		$this->__set("id", $id);
		$this->__set("league", $league);
		$this->__set("stage", $stage);
		$this->__set("homeTeam", $homeTeam);
		$this->__set("visitorTeam", $visitorTeam);
		$this->__set("homeTeamGoals", $homeTeamGoals);
		$this->__set("visitorTeamGoals", $visitorTeamGoals);
		$this->__set("homeTeamMatchPlayers", $homeTeamMatchPlayers);
		$this->__set("visitorTeamMatchPlayers", $visitorTeamMatchPlayers);
		$this->__set("date", $date);
		$this->__set("time", $time);
		$this->__set("report", $report);
		$this->__set("comments", $comments);
		$this->__set("referee", $referee);
		$this->__set("walkover", $walkover);
		$this->__set("overtime", $overtime);
		$this->__set("periodStats", $periodStats);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
	
	public function getName() {
		return unserialize($this->homeTeam)->__get("name") . " - " . unserialize($this->visitorTeam)->__get("name");
	}
	
}
?>