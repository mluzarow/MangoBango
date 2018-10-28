<h2 class="home_header">Library Statistics</h2>
<div class="statbox_grid_display">
	<?php
	foreach ($view->getBoxContents() as $box) { ?>
		<div class="statbox_wrap">
			<div class="title"><?php echo $box['title']; ?></div>
			<div class="statbox_inner_wrap">
				<span><?php echo $box['value']; ?></span>
			</div>
		</div>
	<?php
	} ?>
</div>
