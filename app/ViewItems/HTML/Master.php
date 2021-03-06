<div class="topbar">
	<div class="logo">
		<a href="\">MangoBango</a>
	</div>
	<div class="icons_wrap">
		<div class="button btn_burger dropdown_menu_button">
			<i class="fas fa-bars"></i>
		</div>
		<div class="burger_dropdown dropdown_menu">
			<div class="menu_item login_wrap_mobile">
				<div class="login_text">
					<span>Logged in as</span>
					<span class="login_name"><?php echo $view->getUsername (); ?></span>
				</div>
				<div class="logout_btn">Log Out</div>
			</div>
			<div class="menu_item">
				<a href="/displaylibrary">
					<i class="fas fa-book"></i>
					<span>Library</span>
				</a>
			</div>
			<div class="menu_item">
				<a href="/config">
					<i class="fas fa-cogs"></i>
					<span>Settings</span>
				</a>
			</div>
		</div>
		<div class="button btn_library">
			<a href="/displaylibrary">
				<i class="fas fa-book"></i>
			</a>
		</div><?php
		?><div class="flyout library">
			<div class="search_wrap">
				<input class="search_box" type="text" autocomplete="off" />
			</div>
		</div><?php
		?><div class="button btn_config">
			<a href="/config">
				<i class="fas fa-cogs"></i>
			</a>
		</div>
		<div class="login_wrap">
			<div class="login_text">
				<span>Logged in as</span>
				<span class="login_name"><?php echo $view->getUsername (); ?></span>
			</div>
			<div class="dropdown_menu_button expand_arrow">
				<i class="fas fa-caret-down"></i>
			</div>
			<div class="dropdown_menu">
				<div class="logout_btn">Log Out</div>
			</div>
		</div>
	</div>
</div>
<div class="display_container">
	<?php echo $view->getViewContent ()->getHTML (); ?>
</div>
