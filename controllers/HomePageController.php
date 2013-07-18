<?php
class HomePageController extends Controller {
	
	public function execute($request) {
		try {
			parent::execute($request);
			
			$return = "homePage";
		} catch (Exception $e) {
			$return = "exceptionPage";
			throw $e;
		}
		return $return;
	}
	
}
?>