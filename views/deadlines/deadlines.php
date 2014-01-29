<?php $page = $_REQUEST["pageObject"]; ?>
<div class="box">
	<div class="top">
		<div class="padding"><?php echo($page->__get("header")); ?></div>
	</div>
	<div class="content">
		<?php
		
		$deadlineArray = unserialize($_REQUEST["deadlines"]);
		
		foreach($deadlineArray as $competitionName => $deadlines) {
			if($competitionName != "") {
				echo("<h5>{$competitionName}</h5>");
			
				foreach($deadlines as $deadline) {
					
					$name = $deadline->__get("name");
					$starts = $deadline->__get("starts");
					$ends = $deadline->__get("ends");
					$notes = $deadline->__get("notes");
					$length = $deadline->__get("duration");
					
					echo("{$name} deadline {$starts} - {$ends} ({$length} viikkoa, {$notes})<br/>");
					
					
				}
			}
		}
		
		?>
		<br/><br/>
		<?php echo($page->__get("text")); ?>
	</div>
</div>