<?php
class ReportController extends Controller {
	
	public function execute($request) {
		try {
			parent::execute($request);
			
			$return = "reportPage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
}
?>