<div class="config_list_wrap">
	<h2 class="title">Configuration</h2>
	<div class="config_list">
		<div class="config_section">
			<div class="section_header">Library Settings</div>
			<div class="config_wrap">
				<div class="config_item">
					<label>Manga directory</label>
					<input id="manga_directory" value="<?php echo $view->getMangaDirectory (); ?>" type="text" autocomplete="off" />
				</div>
				<div class="config_item">
					<label>Assets directory</label>
					<input id="assets_directory" value="<?php echo $view->getAssetsDirectory (); ?>" type="text" autocomplete="off" />
				</div>
				<div class="config_item">
					<label>Directory structure</label>
					<input id="directory_structure" value="<?php echo $view->getDirectoryStructure  (); ?>" type="text" autocomplete="off" />
				</div>
				<div class="config_item">
					<div id="rescan_library_btn">
						Rescan Manga Library
					</div>
				</div>
			</div>
		</div>
		<div class="config_section">
			<div class="section_header">Reader Settings</div>
			<div class="config_wrap">
				<div class="config_item">
					<label>Reader Display Style</label>
					<select id="reader_display_style" autocomplete="off">
						<option value="1" <?php echo $view->getReaderDisplayStyle () === 1 ? 'selected' : '' ?>>
							Display as single panel
						</option>
						<option value="2" <?php echo $view->getReaderDisplayStyle () === 2 ? 'selected' : ''; ?>>
							Display as continous strip
						</option>
					</select>
				</div>
				<div class="config_item">
					<label>Library Display Style</label>
					<select id="library_view_type" autocomplete="off">
						<option value="1" <?php echo $view->getLibraryViewType () === 1 ? 'selected' : ''; ?>>
							Display as covers
						</option>
						<option value="2" <?php echo $view->getLibraryViewType () === 2 ? 'selected' : ''; ?>>
							Display as bookcase
						</option>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>
