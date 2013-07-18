<?php
class KiekkoCupController extends Controller {
	
	public function execute($request) {
		try {
			parent::execute($request);
			
			$return = "kiekkoCupPage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
}
?>