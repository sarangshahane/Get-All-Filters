<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       sarangshshane.in
 * @since      1.0.0
 *
 * @package    Get_All_Filters
 * @subpackage Get_All_Filters/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Get_All_Filters
 * @subpackage Get_All_Filters/public
 * @author     Sarang Shahane <sarangshahane@rocketmail.com>
 */
class Get_All_Filters_Public {

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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	
	/**
	 * Calls on initialization
	 *
	 * @since 1.0.0
	 */
	public static function init() {

		self::initialise_plugin();
		self::init_hooks();
	}

	/**
	 * Initialises the Plugin Name.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	static public function initialise_plugin() {

		$plugin_name 	= 'Get All Filters';
		$short_name 	= 'GFilters';
		$page 			= 'get_all_filters';

		define( 'GAF_PLUGIN_NAME', $plugin_name );
		define( 'GAF_PLUGIN_SHORT_NAME', $short_name );
		define( 'GAF_PAGE_NAME', $page );

	}


	/**
	 * Init Hooks.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	static public function init_hooks() {

		if ( ! is_admin() ) {
			return;
		}

		// Add Get All Filters menu option to admin.
		add_action( 'network_admin_menu', __CLASS__ . '::add_get_all_filters_menu' );
		add_action( 'admin_menu', __CLASS__ . '::add_get_all_filters_menu' );
		// add_action( 'admin_menu', __CLASS__ . '::submenu', 999 );

		add_action( 'admin_enqueue_scripts', __CLASS__ . '::enqueue_styles', 20 );

		add_action( 'get_all_filters_render_admin_content', __CLASS__ . '::render_content' );

	}


	/**
	 * Add submenu to admin menu.
	 *
	 * @since 1.1.5
	 */
	static public function add_get_all_filters_menu() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		add_menu_page(
			'Get All Filters',
			'Get All Filters',
			'manage_options',
			GET_ALL_FILTERS_SLUG,
			__CLASS__ . '::render',
			'dashicons-filter',
			40.7
		);
	}

	/**
	 * Renders the admin settings.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	static public function render() {
		$action = ( isset( $_GET['action'] ) ) ? sanitize_text_field( $_GET['action'] ) : '';
		$action = ( ! empty( $action ) && '' != $action ) ? $action : 'general';
		$action = str_replace( '_', '-', $action );

		// Enable header icon filter below.
		$header_wrapper_class = apply_filters( 'gaf_header_wrapper_class', array( $action ) );

		include_once GET_ALL_FILTERS_DIR . 'public/partials/get-all-filters-public-display.php';
	}

	/**
	 * Renders the admin settings content.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	static public function render_content() {

		$action = ( isset( $_GET['action'] ) ) ? sanitize_text_field( $_GET['action'] ) : '';
		$action = ( ! empty( $action ) && '' != $action ) ? $action : 'general';
		$action = str_replace( '_', '-', $action );
		$action = 'general';

		$header_wrapper_class = apply_filters( 'gaf_header_wrapper_class', array( $action ) );

		include_once GET_ALL_FILTERS_DIR . 'public/partials/get-all-filters-public-display.php';
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	static public function enqueue_styles() {

		wp_enqueue_style( GAF_PLUGIN_NAME, plugin_dir_url( __FILE__ ) . 'css/get-all-filters-public.css', array(), GET_ALL_FILTERS_VER, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/get-all-filters-public.js', array( 'jquery' ), $this->version, false );

	}

}

Get_All_Filters_Public::init();