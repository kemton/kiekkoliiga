<?php $page = $_REQUEST["pageObject"]; ?>
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