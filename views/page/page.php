<?php $page = unserialize($_REQUEST["pageObject"]); ?>
<div class="box">
	<div class="top">
		<div class="padding"><?php echo($page->__get("header")); ?></div>
	</div>
	<div class="content">
		<?php echo($page->__get("text")); ?>
	</div>
</div>