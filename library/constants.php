<?php

/* CONSTANTS */
define('HOME_URI', home_url());
define('SITENAME', get_bloginfo('name'));
define('SITEDESC', get_bloginfo('description'));

define('PARENT_URI', get_template_directory_uri());
define('THEME_URI', get_stylesheet_directory_uri());
define('THEME_IMG', THEME_URI . '/assets/images');
define('THEME_CSS', THEME_URI . '/css');
define('THEME_JS', THEME_URI . '/javascript');
define('THEME_ADMIN', THEME_URI . '/admin');

define('ADMIN_EMAIL', get_bloginfo('admin_email'));
define('THEMEDESIGNER_URL', 'http://www.tomhermans.com');

?>