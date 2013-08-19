<?php
class PaitsioController extends Controller {
	
	public function execute($request) {
		try {
			parent::execute($request);
			
			$id = $request[1];
			$info = new InformationAccess();
			
			if ($id != null && is_numeric($id)) {
				$onePaitsio = $info->getPaitsioArticleById($id);
				$_REQUEST["paitsioArticle"] = serialize($onePaitsio);
				
				// Update read count
				if($_SESSION["read"] <> "paitsio#".$id) {
					$readCount = $info->updatePaitsioReadCount($id);
					$_SESSION["read"] = "paitsio#".$id;
				}
			} else {
				$allPaitsio = $info->getAllPaitsioArticle();
				$_REQUEST["allPaitsioArticles"] = serialize($allPaitsio);
			}
			$return = "paitsioPage";
		} catch (Exception $e) {
			throw $e;
		}
		return $return;
	}
	
}
?>