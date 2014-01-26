<?php
include_once (incDir."/header.php");
include_once (incDir."/navigation.php");
include_once (incDir."/leftbar.php");
include_once (incDir."/rightbar.php");

$page = $_REQUEST["pageObject"];
?>
<div id="content">
	<div class="box">
		<?php foreach ($page as $row) {?>
		<div class="top">
			<div class="padding"><?php echo($row->__get("player")); ?></div>
		</div>
		<div class="content">
			<?php echo($row->__get("text")); ?>
		</div>
		<?php } ?>
	</div>
<?php
include_once (incDir."/footer.php");
?>