<?php
/**
 * @author nikokiuru
 * Database: Sarjatilasto
 */
class LeagueSteer {
	private $leagueSteerId;
	private $leagueSteerType; //ex. ottelut
	private $leagueSteerName; //ex. Ottelut
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	public function __get($name) {
		return $this->$name;
	}
}