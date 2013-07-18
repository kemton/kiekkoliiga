<?php
include_once (incDir."/header.php");
include_once (incDir."/navigation.php");
include_once (incDir."/leftbar.php");
include_once (incDir."/rightbar.php");

$HOFs = unserialize($_REQUEST["HOFs"]);
?>
<div id="content">
	<div class="box">
		<div class="top">
			<div class="padding">Hall of Fame</div>
		</div>
		<div class="content">
			<img src="/images/hof.png" alt="Hall of Fame" style="margin-top: 25px;">
			<?php foreach($HOFs as $HOF) { ?>
			
			<table width="100%">
						<tbody><tr class="team">
						<td><h3><?php echo($HOF->__get("player")); ?></h3><img align="right" src="/images/HOF/<?php echo($HOF->__get("player")); ?>.png" alt="<?php echo($HOF->__get("player")); ?>" />
						<?php echo($HOF->__get("text")); ?>
						</td>
						</tr>
						</tbody></table>
					<br>
			
			<?php } ?>

			
		</div>
	</div>
<?php
include_once (incDir."/footer.php");
?>