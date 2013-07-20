<?php
include_once (incDir."/header.php");
include_once (incDir."/navigation.php");
include_once (incDir."/leftbar.php");
include_once (incDir."/rightbar.php");
?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding">Lisää</div>
		</div>
		<div class="content">
			<?php
			$uploads = unserialize($_REQUEST["uploads"]);
			print_r($uplads);
			foreach ($uploads as $upload) {
				echo $upload->__get('header')."<br />";
			}
			?>
		</div>
	</div>
<?php include_once (incDir."/footer.php"); ?>