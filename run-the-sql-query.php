<?php

/**
 * Plugin Name:       Run The SQL Query
 * Plugin URI:        https://github.com/Sefirost/run-the-sql-query
 * Description:       Run SQL queries on your WordPress database, to operate use the plugin page under Tools &gt; <a href="tools.php?page=run-the-sql-query">Run The SQL Query</a> to operate.
 * Version:           1.0.0
 * Author:            Kelin Chauhan
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       run-the-sql-query
 * Network: True
 */

// If this file is called directly, abort.
if( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-run-the-sql-query.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_the_sql_query() {

	$plugin = new Run_The_SQL_Query();
	$plugin->run();

}
run_the_sql_query();
