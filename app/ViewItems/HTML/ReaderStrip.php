<div class="strip_wrap">
	<?php
	foreach ($view->getFilePaths () as $path) { ?>
		<div class="placeholder" data-origin="<?php echo $path; ?>">
			<img src="\resources\icons\loading-3s-200px.svg" />
		</div>
	<?php
	} 
	
	if (!empty ($view->getNextChapterLink ())) { ?>
		<div class="continue_btn">
			<a href="<?php echo $view->getNextChapterLink (); ?>">
				Continue to next chaper.
			</a>
		</div>
	<?php
	} ?>
</div>
