<?php
class SettingsAccess extends DatabaseAccess {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function __get($name) {
		try {
			return $this->$name();
		} catch (Exception $e) {
			throw $e;
		}
		
	}
	
	public function getCurrentSeason() {
		try {
			// Get current season from settings table
			//$id = parent::executeStatement($this->GET_CURRENT_SEASON, array());
			$id = 31;
			
			$seasonAccess = new SeasonAccess();
			$season = $seasonAccess->getSeasonById($id);
		} catch (Exception $e) {
			throw $e;
		}
		return $season;
	}
	
}
?>