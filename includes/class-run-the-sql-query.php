<?php

/**
 * The file that defines the core plugin class
 *
 * @since      1.0.0
 *
 * @package    Run_The_SQL_Query
 * @subpackage Run_The_SQL_Query/includes
 */

/**
 * The core plugin class.
 *
 * @since      1.0.0
 * @package    Run_The_SQL_Query
 * @subpackage Run_The_SQL_Query/includes
 * @author     Your Name <email@example.com>
 */
class Run_The_SQL_Query {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Plugin_Name_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'run-the-sql-query';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-run-the-sql-query-loader.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-run-the-sql-query-admin.php';

		$this->loader = new Run_The_SQL_Query_Loader();

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Run_The_SQL_Query_Admin( $this->get_plugin_name(), $this->get_version() );

		// $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_admin_menus' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_settings_menu' );
		
		$this->loader->add_action( 'admin_init', $plugin_admin, 'add_settings_group' );
		
		$this->loader->add_action( 'init', $plugin_admin, 'user_cap_check' );
		
		// $this->loader->add_action( 'admin_notices', $plugin_admin, 'notify_admin' );
		
		$this->loader->add_action( 'admin_print_styles-tools_page_run-the-sql-query', $plugin_admin, 'enqueue_styles' );

		$this->loader->add_action( 'admin_print_scripts-tools_page_run-the-sql-query', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'wp_ajax_run_the_sql_query', $plugin_admin, 'run_query' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
