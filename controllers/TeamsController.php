<?php
class TeamsController extends Controller {
	
	public function execute($request) {
		try {
			parent::execute($request);
			
			$return = "teamsPage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
}
?>