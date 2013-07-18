<?php
class FeedbackController extends Controller {
	
	public function execute($request) {
		try {
			parent::execute($request);
			
			
			
			$return = "feedbackPage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
}
?>