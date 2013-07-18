<?php
class SeasonController extends Controller {
	
	/*public function execute($request) {
		try {
			parent::execute($request);
			
			$return = "home";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}*/
	
	public function getSeasonById($id) {
		try {
			$seasonAccess = new SeasonAccess();
			$season = $seasonAccess->getSeasonById($id);
		} catch (Exception $e) {
			throw $e;
		}
		return $season;
	}
	
	public function getCurrentSeason() {
		try {
			$settingsAccess = new SettingsAccess();
			$season = $settingsAccess->getCurrentSeason();
		} catch (Exception $e) {
			throw $e;
		}
		return $season;
	}
	
	public function getLatestSeason() {
		try {
			$seasonAccess = new SeasonAccess();
			$season = $seasonAccess->getLatestSeason();
		} catch (Exception $e) {
			throw $e;
		}
		return $season;
	}
	
}
?>