<div class="reader_wrap">
	<div class="img_wrap">
		<?php
		$first_image_class = 'selected_image';
		foreach ($view->getFilePaths() as $path) { ?>
			<div class="placeholder <?php echo $first_image_class; ?>" data-origin="<?php echo $path; ?>">
				<img src="\resources\icons\loading-3s-200px.svg" />
			</div>
			
			<?php
			$first_image_class = '';
		}
		
		if (!empty ($view->getNextChapterLink ())) { ?>
			<a class="next_chapter" href="<?php echo $view->getNextChapterLink (); ?>"></a>
		<?php
		} ?>
	</div>
</div>
