<?php
include_once (incDir."/header.php");
include_once (incDir."/navigation.php");
include_once (incDir."/leftbar.php");
include_once (incDir."/rightbar.php");

$page = $_REQUEST["pageObject"];
?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding"><?php echo($page->__get("header")); ?></div>
		</div>
		<div class="content">
			<?php echo($page->__get("text")); ?>
		</div>
	</div>
<?php
include_once (incDir."/footer.php");
?>