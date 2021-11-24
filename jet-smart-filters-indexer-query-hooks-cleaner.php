<?php
/**
 * Plugin Name: JetSmartFilters - indexer query hooks cleaner
 * Plugin URI:  #
 * Description: Removes all hooks from the "query" filter to avoid rewriting the SQL query.
 * Version:     1.0.0
 * Author:      Crocoblock
 * Author URI:  https://crocoblock.com/
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

include plugin_dir_path( __FILE__ ) . 'include/class-reset-restore-hooks.php';

new Jet_Reset_Restore_Hooks( 'query', 'jet-smart-filters/indexer/before-prepare-data', 'jet-smart-filters/indexer/after-prepare-data' );
