	function addBoardOrPressReleaseComment(targetId) {
		addComment("BoardOrPressRelease", targetId);
	}
	
	function addMatchComment(targetId) {
		addComment("Match", targetId);
	}

	function addPaitsioComment(targetId) {
		addComment("Paitsio", targetId);
	}
	
	function addNewsComment(targetId) {
		addComment("News", targetId);
	}
	
		
	function addComment(commentType, targetId){
		var comment = $('#commentbox').val();
		$.ajax({
			type: "POST",
			url: "/ajax/addComment.php",
			data: {target:targetId, type:commentType, commentText:comment}
		}).done(function( result ) {
			if(result == "notLoggedIn") {
				$("#result").html("Et ole kirjautunut. Kirjaudu sisään jättääksesi kommentin.");
			}
			else if(result == "connectionFailed") {
				$("#result").html("Tietokantayhteys epäonnistui. Ole hyvä, ja yritä uudelleen hetken kuluttua.");
			}
			else {
				$("#comments").append(comment);
				$("#result").html("Kommentti lisätty.");
				$('#commentbox').val("");
			}
		});
	}