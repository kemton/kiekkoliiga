<?php
class LeagueStats {
	private $users;
	private $players;
	private $matches;
	private $goals;
	private $assists;
	private $points;
	private $comments;
	
	public function __construct($users, $players, $matches, $goals, $assists, $points, $comments) {
		$this->__set('users', $users);
		$this->__set('players', $players);
		$this->__set('matches', $matches);
		$this->__set('goals', $goals);
		$this->__set('assists', $assists);
		$this->__set('points', $points);
		$this->__set('comments', $comments);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
}
?>