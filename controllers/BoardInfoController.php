<?php
class BoardInfoController extends Controller {
	
	public function execute($request) {
		try {
			parent::execute($request);
			
			$id = $request[1];
			$boardinfo = new InformationAccess();
			
			if ($id != null && is_numeric($id)) {
				$oneBoardInfo = $boardinfo->getBoardInfoById($id);
				$_REQUEST["boardInfo"] = $oneBoardInfo;
				
				// Update read count
				if($_SESSION["read"] <> "paitsio#".$id) {
					$readCount = $boardinfo->updatePaitsioReadCount($id);
					$_SESSION["read"] = "paitsio#".$id;
				}
			} else {
				$allBoardInfos = $boardinfo->getAllBoardInfos();
				$_REQUEST["allBoardInfos"] = $allBoardInfos;
			}
			
			$return = "boardInfoPage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
}
?>