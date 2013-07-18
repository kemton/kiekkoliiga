<?php
include_once (incDir."/header.php");
include_once (incDir."/navigation.php");
include_once (incDir."/leftbar.php");
include_once (incDir."/rightbar.php");
?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding">Virhe</div>
		</div>
		<div class="content">
			<strong><?php echo $_REQUEST["exception"]; ?></strong>
		</div>
	</div>
<?php
include_once (incDir."/footer.php");
?>