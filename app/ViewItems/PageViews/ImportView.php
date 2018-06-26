<?php
namespace ViewItems\PageViews;

use ViewItems\ViewAbstract;

/**
 * View for importer output the importing squence.
 */
class ImportView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		return ('<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/Importer.css">');
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="importer_app">
			<div class="frame file_upload">
				<div class="upload_area">
					<input id="dirinput" type="file" />
				</div><!--
			 --><div class="help_area">
					<h2>Documentation</h2>
					<div class="help_area_inner">
						<h3>Basics</h3>
						<p>
							Upload a .zip file containing your manga contents.
							After uploading, you will be taken through the process
							of binding the files to the meta structure of the manga
							as well as collecting metadata for said series.
						</p>
						<p>
							You can find the expected folder structure of the
							uploaded manga below.
						</p>
						<h3>Expected structure</h3>
						<p>
							Inside your zip file, the structure should be as such:
						</p>
						<ol>
							<li>Series Name</li>
							<ol>
								<li>Volume 1</li>
								<ol>
									<li>Chapter 1</li>
									<ol>
										<li>Page 1.jpg</li>
										<li>Page 2.jpg</li>
									</ol>
								</ol>
							</ol>
						</ol>
						<p>
							Note that the system will attemp to find numeric
							patterns in the volume, chapter, and page items
							and their titles therefore do not have to follow
							a strict naming convention.
						</p>
						<p>
							It is, however, beneficial to standardize your naming
							convention in a style similar to
							<a href="https://github.com/Daiz/manga-naming-scheme">this</a>.
						</p>
					</div>
				</div>
			</div>
		</div>';
		
		return ($output);
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		return ('');
	}
}
