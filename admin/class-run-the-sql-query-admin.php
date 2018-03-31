<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Run_The_SQL_Query
 * @subpackage Run_The_SQL_Query/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Run_The_SQL_Query
 * @subpackage Run_The_SQL_Query/admin
 * @author     Your Name <email@example.com>
 */
class Run_The_SQL_Query_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $db;
	private $tables = array();

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/run-the-sql-query-admin.css', array(), $this->version, 'all' );
	
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/run-the-sql-query-admin.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'jsontotable', plugin_dir_url( __FILE__ ) . 'js/jquery.jsontotable.min.js', array( 'jquery' ), '1.1.3', false );

	}

	/**
	 * Register the the admin menus.
	 *
	 * @since    1.0.0
	 */
	public function add_admin_menus() {
		$cap = get_option( 'run-the-sql-query-settings' );
		add_management_page( 'Run The SQL Query', 'Run The SQL Query', $cap, 'run-the-sql-query', array( $this, 'admin_page' ) );	
	}

	/**
	 * Load the tables from database and show Run The SQL Query's admin page.
	 *
	 * @since    1.0.0
	 */
	public function admin_page() {

    	if (!$this->db) {
			$this->db = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
		}

		$rst = mysqli_query($this->db, "SHOW TABLES" );
		while ( $row = mysqli_fetch_array( $rst ) ) {
			array_push($this->tables, $row[0]);
		}		

    	require 'partials/run-the-sql-query-display.php';

	}

	/**
	 * Register settings group.
	 *
	 * @since    1.0.0
	 */
	public function add_settings_group() {
		
    	register_setting( 'run-the-sql-query-settings', 'run-the-sql-query-settings' );
	}

	/**
	 * Register the settings menu
	 *
	 * @since    1.0.0
	 */
	public function add_settings_menu() {
	
    	add_options_page( 'Run The SQL Query Settings', 'Run The SQL Query Settings', 'manage_options', 'run-the-sql-query-settings', array( $this, 'admin_page_settings') );	
	}

	/**
	 * Show settings page for the plugin.
	 *
	 * @since    1.0.0
	 */
	public function admin_page_settings() {

    	require 'partials/run-the-sql-query-display-settings.php';

	}

	/**
	 * Execute the query in the database and return result in a json response.
	 *
	 * @since    1.0.0
	 */
	public function run_query() {

		check_ajax_referer( 'run_the_sql_query', 'security' );

		$results = array();
		$results['rows'] = array();

		$query = trim( stripslashes( $_POST['query'] ) );

    	if (!$this->db) {
			$this->db = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
		}

		if ( $rst = mysqli_query( $this->db, $query ) ) {

			if ( preg_match( "/^\s*(alter|create|drop|rename|insert|delete|update|replace|truncate) /i", $query ) ) {
				$results['affected_rows'] = mysqli_affected_rows( $this->db );
			} else {
				$first = true;
				while ( $row = mysqli_fetch_assoc( $rst ) ) {
					if ( $first ) {
						$results['rows'][] = array_keys( $row );
						$first = false;
					}
					$results['rows'][] = array_values( $row );
				}
			}		
		} else {

			$results['error'] = mysqli_error( $this->db );
			wp_send_json_error($results);

		}

		wp_send_json_success($results);

	}

	/**
	 * This function shows the notification to the admin.
	 *
	 * @since    1.0.0
	 */
	function notify_admin() {
		
		// Only show the notification to admin.
		
		if( ! current_user_can( 'manage_options' ) ) {
			return;
		}
			?>
				<div class="error notice is-dismissible">
					<p><strong>Run The SQL Query: </strong>Your current capabilty setting doesn't allow you to use this plugin, you can change capability setting in Settings &gt; <a href="options-general.php?page=run-the-sql-query-settings">Run The SQL Query Settings</a>.</p>
				</div>
			<?php

	}	

	/**
	 * This function checks the user capability and shows a notification if user does not have enough
	 * capability or display the console page inside tolls menu if user has the capability.
	 * This function also sets a default setting.
	 *
	 * @since    1.0.0
	 */
	function user_cap_check() {
		
		$cap = get_option( 'run-the-sql-query-settings' );
		
		// Check if the db setting is empty and add default value.
		if( ! $cap ) {
			update_option( 'run-the-sql-query-settings', 'manage_options' );
			$cap = 'manage_options';	
		}
		
		// If the user has capability then create the console page in tools menu. Or display the notification to 
		// change the settings.
		if( current_user_can( $cap ) ) {
			add_action( 'admin_menu', array( $this, 'add_admin_menus' ) );
		} else {
			add_action( 'admin_notices', array( $this, 'notify_admin' ) );
		}
	}
}