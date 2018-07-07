<?php
namespace ViewItems\PageViews;

use \ViewItems\ViewAbstract;

/**
 * View class for the list of server configs on the config page.
 */
class ConfigView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/Config.css">';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="config_list_wrap">
			<h2 class="title">Configuration</h2>
			<div class="config_list">
				<div class="config_section">
					<div class="section_header">Library Settings</div>
					<div class="config_wrap">
						<div class="config_item">
							<label>Reader Display Style</label>
							<select id="reader_display_style" autocomplete="off">
								<option value="1" '.($this->getReaderDisplayStyle () === 1 ? 'selected' : '').'>Display as single panel</option>
								<option value="2" '.($this->getReaderDisplayStyle () === 2 ? 'selected' : '').'>Display as continous strip</option>
							</select>
						</div>
						<div class="config_item">
							<label>Manga directory</label>
							<input id="manga_directory" value="'.$this->getMangaDirectory ().'" type="text" autocomplete="off" />
						</div>
						<div class="config_item">
							<label>Library Display Style</label>
							<select id="library_view_type" autocomplete="off">
								<option value="1" '.($this->getLibraryViewType () === 1 ? 'selected' : '').'>Display as covers</option>
								<option value="2" '.($this->getLibraryViewType () === 2 ? 'selected' : '').'>Display as bookcase</option>
							</select>
						</div>
						<div class="config_item">
							<div id="rescan_library_btn" ">
								Rescan Manga Library
							</div>
						</div>
					</div>
				</div>';
				if ($this->getUserType () === 'admin') {
					$output .=
					'<div class="config_section">
						<div class="section_header">User Settings (Admin)</div>
						<div class="user_header">
							<div class="header_item header_username">Username</div>
							<div class="header_item header_type">User Type</div>
						</div>
						<div class="user_list">';
							foreach ($this->getUsers () as $user) {
								$output .=
								'<div class="user_item">
									<div class="username">
										'.$user['username'].'
									</div>
									<div class="user_editor_btn change_name_btn">Change Name</div>
									<div class="user_editor_btn change_pass_btn">Change Password</div>
									<select>';
										foreach ($this->getUserTypes () as $type) {
											$output .=
											'<option value="'.$type['type_name'].'" '.($user['type'] === $type['type_name'] ? 'selected' : '').'>'.$type['type_name'].'</option>';
										}
								$output .=
									'</select>
								</div>';
							}
					$output .=
						'</div>
					</div>';
				}
		$output .=
			'</div>
		</div>';
		
		return ($output);
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		$output =
		'<script type="text/javascript" src="/ViewItems/JS/Config.js"></script>';
		
		return ($output);
	}
	
	/**
	 * Gets the library view type.
	 * 
	 * @return int library view type
	 */
	protected function getLibraryViewType () {
		return ($this->library_view_type);
	}
	
	/**
	 * Gets the manga directory setting.
	 * 
	 * @return string manga directory setting
	 */
	protected function getMangaDirectory () {
		return ($this->manga_directory);
	}
	
	/**
	 * Gets the reader display style setting.
	 * 
	 * @return int reader display style setting
	 */
	protected function getReaderDisplayStyle () {
		return ($this->reader_display_style);
	}
	
	/**
	 * Gets the list of users.
	 * 
	 * @return array list of users
	 */
	protected function getUsers () {
		return ($this->users);
	}
	
	/**
	 * Gets the currently logged in user's type.
	 * 
	 * @return string user's type
	 */
	protected function getUserType () {
		return ($this->user_type);
	}
	
	/**
	 * Gets list of all available user types.
	 * 
	 * @return array list of user types
	 */
	protected function getUserTypes () {
		return ($this->user_types);
	}
	
	/**
	 * Sets the library view type.
	 * 
	 * @param int $config library view type
	 * 
	 * @throws TypeError on non-int config value
	 * @throws InvalidArgumentException on config value out of bounds
	 */
	protected function setLibraryViewType (int $config) {
		if (!in_array($config, [1, 2])) {
			throw new \InvalidArgumentException ('Argument (Library View Type) value must in set [1, 2]; '.$config.' given.');
		}
		
		$this->library_view_type = $config;
	}
	
	/**
	 * Sets the manga directory setting.
	 * 
	 * @param string $config manga directory setting
	 *
	 * @throws TypeError on non-string config value
	 * @throws InvalidArgumentException on empty config value
	 */
	protected function setMangaDirectory (string $config) {
		$config = trim ($config);
		
		if (empty ($config)) {
			throw new InvalidArgumentException ('Argument (Manga Directory) can not be empty.');
		}
		
		$this->manga_directory = $config;
	}
	
	/**
	 * Sets the reader display style setting.
	 * 
	 * @param int $config reader display style setting
	 * 
	 * @throws TypeError on non-integer config value
	 * @throws InvalidArgumentException on config value out of bounds
	 */
	protected function setReaderDisplayStyle (int $config) {
		if (!in_array($config, [1, 2])) {
			throw new \InvalidArgumentException ('Argument (Reader Display Style) value must in set [1, 2]; '.$config.' given.');
		}
		
		$this->reader_display_style = $config;
	}
	
	protected function setUsers (array $users) {
		foreach ($users as $user) {
			foreach (['username', 'type'] as $key) {
				if (!array_key_exists ($key, $users)) {
					throw new \InvalidArgumentException ('Argument (Users) items must each have key "'.$key.'".');
				}
			}
		}
		
		$this->users = $users;
	}
	
	protected function setUserType (string $user_type) {
		$this->user_type = $user_type;
	}
	
	protected function setUserTypes (array $user_types) {
		foreach ($user_types as $user_type) {
			if (!array_key_exists ('user_type', $users)) {
				throw new \InvalidArgumentException ('Argument (Users Types) items must each have key "user_type".');
			}
		}
		
		$this->user_types = $user_types;
	}
}
