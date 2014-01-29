<div class="box">
	<div class="top">
		<div class="padding">Johdon tiedotteet</div>
	</div>
	<div class="content">
		<?php
		if (isset($_REQUEST["boardInfo"]) && $_REQUEST["boardInfo"] != null) {
			$boardInfo = unserialize($_REQUEST["boardInfo"]);
			
			echo $boardInfo->__get("writer")." - " . $boardInfo->__get("time") . " (luettu: " . $boardInfo->__get("read") . " kertaa)<br />\n";
			echo "<h3>".$boardInfo->__get("header") . "</h3>\n";
			echo "<p>" . bbc(nl2br($boardInfo->__get("text"))) . "</p><hr />";
			$comments = $boardInfo->__get("comments");
			$id = $boardInfo->__get("id");
			printBoardOrPressReleaseComments($comments, $id);
		} else {
			$boardInfos = unserialize($_REQUEST["allBoardInfos"]);
			foreach ($boardInfos as $key => $boardInfo) {
				echo "<a href=\"".path."board-info/" . $boardInfo->__get("id") . "\">" . $boardInfo->__get("header") . "</a> -- <strong>" . $boardInfo->__get("time") . "</strong> -- " . $boardInfo->__get("writer") . "<br />";
			}
		}
		?>
	</div>
</div>