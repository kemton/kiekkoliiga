<div id="left">
	<!--
			<div class="box">
				<div class="top">
					<div class="padding">Otsake</div>
				</div>
				<div class="content">
					Lorem ipsum...
				</div>
			</div>
	-->
	<div class="box borderbottom">
		<div class="top">
			<div class="padding">Mainos</div>
		</div>
		<div class="ad center">
			<script type="text/javascript"><!--
			google_ad_client = "ca-pub-8676090212108942";
			/* Kiekkoliiga mainos*/
			google_ad_slot = "5112082564";
			google_ad_width = 200;
			google_ad_height = 200;
			//-->
			</script>
			<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
		</div>
	</div>

	<div class="box">
		<ul class="menu auroramenu">
			<li>
				<a href="#" class="vframe_title"><div class="padding">Johdon tiedotteet</div></a>
				<a style="display: none;" class="aurorashow" href="#"></a>
				<a style="display: inline;" class="aurorahide" href="#"></a>
				<ul class="borderbottom"> 
					<li>
						<div class="content">
							<?php
							foreach (unserialize($_REQUEST["lastBoardInfo"]) as $value) {
								echo "<strong>Johto</strong> - {$value->__get('time')}<br />\n";
								echo "<a href=\"/board-info/{$value->__get('id')}\"><i>{$value->__get('header')}</i></a><br /><br />\n";
							}
							?>
						</div>
					</li>
					<li><div class="content bordertop"><a href="/board-info/">(näytä kaikki)</a></div></li>
				</ul>
			</li>
		</ul>
	</div>
	
	<div class="box">
		<ul class="menu auroramenu">
			<li>
				<a href="#" class="vframe_title"><div class="padding">Paitsio</div></a>
				<a style="display: none;" class="aurorashow" href="#"></a>
				<a style="display: inline;" class="aurorahide" href="#"></a>
				<ul class="borderbottom"> 
					<li>
						<div class="content">
							<?php
							foreach (unserialize($_REQUEST["lastPaitsio"]) as $value) {
								echo "<strong>{$value->__get('writer')}</strong> - {$value->__get('time')}<br />\n";
								echo "<a href=\"/paitsio/{$value->__get('id')}\"><i>{$value->__get('header')}</i></a><br /><br />\n";
							}
							?>
						</div>
					</li>
					<li><div class="content bordertop"><a href="/paitsio/">(näytä kaikki)</a></div></li>
				</ul>
			</li>
		</ul>
	</div>
	<div class="box">
		<ul class="menu auroramenu">
			<li>
				<a href="#" class="vframe_title"><div class="padding">Viimeeksi kommentoidut</div></a>
				<a style="display: none;" class="aurorashow" href="#"></a>
				<a style="display: inline;" class="aurorahide" href="#"></a>
				<ul class="noborderbottom"> 
					<li>
						<div class="content">
							<?php
							$comments = unserialize($_REQUEST["lastComment"]);
							echo("<ul>");
							foreach ($comments as $comment) {
								echo("<small>{$comment['time']} - ");
								printPlayerNameWithLink($comment['writerId'], $comment['writerName'], $comment['writerIsBoard']);
								echo("</small><li><a href=\"{$comment['targetLink']}\">{$comment['name']}</a></li><br/>");
							}
							echo("</ul>");
							?>
						</div>
					</li>
				</ul>
			</li>
		</ul>
	</div>
	
</div>
