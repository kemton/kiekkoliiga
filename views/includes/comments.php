<?php

define("COMMENT_TYPE_BOARD_OR_PRESS_RELEASE", "BoardOrPressRelease");
define("COMMENT_TYPE_MATCH", "Match");
define("COMMENT_TYPE_PAITSIO", "Paitsio");
define("COMMENT_TYPE_NEWS", "News");

function printBoardOrPressReleaseComments($comments, $id) {
	printComments($comments, $id, COMMENT_TYPE_BOARD_OR_PRESS_RELEASE);
}

function printMatchComments($comments, $matchId) {
	printComments($comments, $matchId, COMMENT_TYPE_MATCH);
}

function printPaitsioComments($comments, $paitsioId) {
	printComments($comments, $paitsioId, COMMENT_TYPE_PAITSIO);
}

function printNewsComments($comments, $newsId) {
	printComments($comments, $newsId, COMMENT_TYPE_NEWS);
}


function printComments($comments, $targetId, $type) {
	echo("<div id=\"comments\">");
	foreach($comments as $comment) {
		$id = $comment->__get("id");
		$time = $comment->__get("timestamp");
		$commentText = $comment->__get("commentText");
		
		$writer = unserialize($comment->__get("writer"));
		$writerId = $writer->__get("id");
		$writerName = $writer->__get("name");
		if($writerName == "") {
			$writerName = $comment->__get("writerName");
		}
		$writerIsBoard = $writer->__get("isBoard");

		printComment($id, $time, $commentText, $writerId, $writerName, $writerIsBoard);
	}
	echo("</div>");

	if($_SESSION["user"]) { // tarkistetaan onko käyttäjä kirjautunut
		printCommentField($type, $targetId);
	}
}


function printComment($commentId, $time, $comment, $writerId, $writerName, $writerIsBoard) {
?>
<a name="kommentti<?php echo $commentId ?>"></a>
<div style='border:1px solid #b2b9be; background-color: #dce4ea; margin-bottom: 5px;'>
	<div style='padding: 1px;'>
		<div style='background-color: #c7d5df; padding: 3px;'>
				<?php printPlayerNameWithLink($writerId, $writerName, $writerIsBoard); ?>
			<span style='font-size: 90%; color: #4d5a63;'><?php echo $time; ?></span>
			<div style='width: 45%; float: right; text-align: right;'></div>
		</div>
		<div style='padding: 3px;'><?php echo nl2br(stripcslashes($comment)); ?></div>
	</div>
</div>
<?php
}


function printCommentField($type, $targetId) {
?>
<div id="commenting">
<form name="" id="addComment" action="" method="POST">
		<textarea id="commentbox" name="textarea" class="commentbox resizable" style="width: 500px; height: 50px;"></textarea>
		<input type="button" name="submit" id="submit" value="Lähetä" onclick="add<?php echo($type); ?>Comment(<?php echo($targetId); ?>);" />
</form>
<div id="result"></div>
</div>
<?php
}

?>