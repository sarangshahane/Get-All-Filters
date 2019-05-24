<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              sarangshshane.in
 * @since             1.0.0
 * @package           Get-All-Filters
 *
 * @wordpress-plugin
 * Plugin Name:       Get all Filters 
 * Plugin URI:        www.getallfilters.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Sarang Shahane
 * Author URI:        sarangshshane.in
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       get-all-filters
 * Domain Path:       /languages
 */


/**
 * Set constants.
 */
define( 'GET_ALL_FILTERS_FILE', __FILE__ );

/**
 * Loader
 */
require_once 'classes/class-get-all-filters-loader.php';
