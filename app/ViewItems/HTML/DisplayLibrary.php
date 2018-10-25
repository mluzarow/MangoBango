<div class="library_display_container">
	<?php
	foreach ($view->getMangaData () as $manga) { ?>
		<div class="manga_series_wrap">
			<h2 class="title"><?php echo $manga['title']; ?></h2>
			<a href="<?php echo $manga['link']; ?>">
				<div class="placeholder" data-origin="<?php echo $manga['path']; ?>">
					<img src="\resources\icons\loading-3s-200px.svg" />
				</div>
			</a>
		</div>
	<?php
	}
	
	if (empty ($view->getMangaData ())) { ?>
		<div class="nothing_to_show">
			No manga in your library :<
		</div>
	<?php
	} ?>
</div>
