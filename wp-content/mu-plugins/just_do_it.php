<?php
/*
Plugin Name: Just do it !
Plugin URI:
Description:
Version: 0.1
Author:
Author URI:
*/
new just_do_it();

class just_do_it {
	private $must_plugins = array(
		'WP Multibyte Patch' => 'wp-multibyte-patch/wp-multibyte-patch.php',
	);

	function __construct() {
		add_action('shutdown', array(&$this, 'plugins_loaded'));
	}

	public function plugins_loaded() {
		$activePlugins = get_settings('active_plugins');
		foreach ($this->must_plugins as $key => $plugin) {
			if ( !array_search($plugin, $activePlugins) ) {
				activate_plugin( $plugin, '', $this->is_multisite() );
			}
		}
	}

	private function is_multisite() {
		return function_exists('is_multisite') && is_multisite();
	}
}
