<?php
class ArchivesController extends Controller {
	
	public function execute($request) {
		try {
			parent::execute($request);
			
			$return = "archivesPage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
}
?>