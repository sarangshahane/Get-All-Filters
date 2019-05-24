<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       sarangshshane.in
 * @since      1.0.0
 *
 * @package    Get-All-Filters
 * @subpackage Get_All_Filters/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Get_All_Filters
 * @subpackage Get_All_Filters/includes
 * @author     Sarang Shahane <sarangshahane@rocketmail.com>
 */

if( ! class_exists( 'Get_All_Filters_Loader' ) ){

	final class Get_All_Filters_Loader {

		/**
		 * Member Variable
		 *
		 * @var instance
		 */
		private static $instance = null;

		/**
		 * Member Variable
		 *
		 * @var utils
		 */
		public $utils = null;

		/**
		 * The array of filters registered with WordPress.
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      array $filters The filters registered with WordPress to fire when the plugin loads.
		 */
		public $filters;


		/**
		 *  Initiator
		 */
		public static function get_instance() {

			if ( is_null( self::$instance ) ) {

				self::$instance = new self;

				/**
				 * Get All Filters loaded.
				 *
				 * Fires when Get All Filters was fully loaded and instantiated.
				 *
				 * @since 1.0.0
				 */
				do_action( 'get_all_filters_loaded' );
			}

			return self::$instance;
		}


		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 */
		public function __construct() {

			$this->define_constants();

			$this->register_activation_hook_actions();

			$this->register_deactivation_hook_actions();

			add_action( 'plugins_loaded', array( $this, 'load_get_all_filters_plugin' ), 99 );

			add_action( 'plugins_loaded', array( $this, 'load_cf_textdomain' ) );
		}

		/**
		 * Defines all constants
		 *
		 * @since    1.0.0
		 */
		public function define_constants() {

			define( 'GET_ALL_FILTERS_BASE', plugin_basename( GET_ALL_FILTERS_FILE ) );
			define( 'GET_ALL_FILTERS_DIR', plugin_dir_path( GET_ALL_FILTERS_FILE ) );
			define( 'GET_ALL_FILTERS_URL', plugins_url( '/', GET_ALL_FILTERS_FILE ) );
			define( 'GET_ALL_FILTERS_VER', '1.0.0' );
			define( 'GET_ALL_FILTERS_SLUG', 'get-all-filters' );

		}

		/**
		 * Loads plugin files.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		function load_get_all_filters_plugin() {

			$this->load_helper_files_components();
			$this->load_core_files();
			$this->load_core_components();

			/**
			 *  Get All Filters Init.
			 *
			 * Fires when Get All Filters is instantiated.
			 *
			 * @since 1.0.0
			 */
			do_action( 'get_all_filters_init' );
		}

		/**
		 * Load Helper Files and Components.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		function load_helper_files_components() {

			include_once GET_ALL_FILTERS_DIR . 'classes/class-get-all-filters-utils.php';
			$this->utils = Get_All_Filters_Utils::get_instance();
		}


		/**
		 * Load core files.
		 */
		function load_core_files() {
			/* Update compatibility. */
			require_once GET_ALL_FILTERS_DIR . 'classes/class-get-all-filters-update.php';

			include_once GET_ALL_FILTERS_DIR . 'classes/class-get-all-filters-settings.php';
		}

		/**
		 * Load Core Components.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		function load_core_components() {

			/* Get All Filters Class */
			include_once GET_ALL_FILTERS_DIR . 'public/class-get-all-filters-public.php';

		}

		/**
		 * Load Get All Filters Text Domain.
		 * This will load the translation textdomain depending on the file priorities.
		 *      1. Global Languages /wp-content/languages/%plugin-folder-name%/ folder
		 *      2. Local dorectory /wp-content/plugins/%plugin-folder-name%/languages/ folder
		 *
		 * @since  1.0.3
		 * @return void
		 */
		public function load_cf_textdomain() {

			// Default languages directory for Get All Filters.
			$lang_dir = GET_ALL_FILTERS_DIR . 'languages/';

			/**
			 * Filters the languages directory path to use for Get All Filters.
			 *
			 * @param string $lang_dir The languages directory path.
			 */
			$lang_dir = apply_filters( 'get_all_filters_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter.
			global $wp_version;

			$get_locale = get_locale();

			if ( $wp_version >= 4.7 ) {
				$get_locale = get_user_locale();
			}

			/**
			 * Language Locale for Get All Filters
			 *
			 * @var $get_locale The locale to use.
			 * Uses get_user_locale()` in WordPress 4.7 or greater,
			 * otherwise uses `get_locale()`.
			 */
			$locale = apply_filters( 'plugin_locale', $get_locale, 'get-all-filters' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'get-all-filters', $locale );

			// Setup paths to current locale file.
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/plugins/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/%plugin-folder-name%/ folder.
				load_textdomain( 'get-all-filters', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/%plugin-folder-name%/languages/ folder.
				load_textdomain( 'get-all-filters', $mofile_local );
			} else {
				// Load the default language files.
				load_plugin_textdomain( 'get-all-filters', false, $lang_dir );
			}
		}


		function register_activation_hook_actions(){

			register_activation_hook( GET_ALL_FILTERS_FILE, array( $this, 'activation_reset' ) );
		}

		function register_deactivation_hook_actions(){
			register_deactivation_hook( GET_ALL_FILTERS_FILE, array( $this, 'deactivation_reset' ) );
		}


		/**
		 * Activation Reset
		 */
		function activation_reset() {
			$this->update_default_settings();
		}

		/**
		 * Deactivation Reset
		 */
		function deactivation_reset(){
			return;
		}

		/**
		 *  Set the default settings.
		 */
		function update_default_settings() {

			$current_user     = wp_get_current_user();
			
			$default_settings = array(
				'gaf_status'                        => 'on',
			);

			foreach ( $default_settings as $option_key => $option_value ) {
				if ( ! get_option( $option_key ) ) {
					update_option( $option_key, $option_value );
				}
			}
		}
	}

	/**
	 *  Prepare if class 'Get_All_Filters_Loader' exist.
	 *  Kicking this off by calling 'get_instance()' method
	 */
	Get_All_Filters_Loader::get_instance();
}


if ( ! function_exists( 'gaf' ) ) {
	/**
	 * Get global class.
	 *
	 * @return object
	 */
	function gaf() {
		return Get_All_Filters_Loader::get_instance();
	}
}