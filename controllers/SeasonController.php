<?php
class SeasonController extends Controller {
	
	public function execute($request) {
		try {
			$seasonid = $_GET["id"];

			$seasonAccess = new SeasonAccess();
			$_SESSION["season"] = serialize($seasonAccess->getSeasonById($seasonid));

			header("Location: /statistics");
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
}
?>