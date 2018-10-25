<div class="library_metadata">
	<div class="section_left">
		<div class="series_title">
			<?php echo $view->getTitle (); ?>
		</div>
	</div>
	<div class="section_middle">
		<div class="section_header">Summary</div>
		<div class="section_block">
			<?php echo $view->getSummary (); ?>
		</div>
	</div>
	<div class="section_right">
		<div class="section_header">Tags</div>
		<div class="section_block">
			<?php
			foreach ($view->getGenres () as $genre) { ?>
				<div class="tag_wrap">
					<span><?php echo $genre; ?></span>
				</div>
			<?php
			}
			
			if (empty ($view->getGenres ())) { ?>
				<i>No tags available</i>
			<?php
			} ?>
		</div>
	</div>
	<div style="clear: both;"></div>
</div>
<div class="left_wrap">
	<div class="sticky_glue"></div>
	<div class="chapter_container">
		<div class="header">Chapter List</div>
		<?php
		foreach ($view->getChapters () as $chapter) { ?>
			<a href="<?php echo $chapter['link']; ?>">
				<?php echo $chapter['title']; ?>
			</a>
		<?php
		} ?>
	</div>
</div>
<div class="library_display_container">
	<?php
	foreach ($view->getVolumes () as $volume) { ?>
		<div class="manga_volume_wrap">
			<a href="<?php echo $volume['link']; ?>">
				<div class="placeholder" data-origin="<?php echo $volume['source']; ?>">
					<img src="\resources\icons\loading-3s-200px.svg" />
				</div>
			</a>
		</div>
	<?php
	} ?>
</div>
<div style="clear: both"></div>
