<?php
class DeadlineController extends Controller {
	
	public function execute($request) {
		try {
			$deadlineAccess = new DeadlineAccess();
			$deadline = $deadlineAccess->getCurrentDeadline();
			
			$_REQUEST["deadline"] = serialize($deadline);
		} catch (Exception $e) {
			$return = "exceptionPage";
			throw $e;
		}
		
		return "deadlinePage";
	}
	
}
?>