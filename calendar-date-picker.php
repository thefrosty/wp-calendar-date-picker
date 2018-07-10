<?php
/*
 * Plugin Name: Calendar Date Picker
 * Plugin URI: http://frosty.media/plugins/calendar-date-picker
 * Description: Show the <a href="http://jqueryui.com/">jQuery UI</a> <a href="http://jqueryui.com/datepicker/">Datepicker</a> on an input box next to the 'edit date' for exact date and time selection. Required javascript to be enabled. Uses <a href="http://trentrichardson.com/examples/timepicker/">Timepicker</a> by <a href="http://trentrichardson.com/">Trent Richardson</a>.
 * Version: 1.2.0
 * Author: Austin Passy
 * Author URI: http://austin.passy.co
 *
 * @copyright 2012-2014
 * @author Austin Passy
 * @link http://frostywebdesigns.com/
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package calendar_date_picker
 */

class calendar_date_picker {
	
	/** Singleton *************************************************************/
	private static $instance;
	
	var $version = '1.2.0';
	
	private $plugin_id,
			$plugin_name;			
	
	/**
	 * Main Instance
	 *
	 * @staticvar 	array 	$instance
	 * @return 		The one true instance
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
			self::$instance->init();
		}
		return self::$instance;
	}
	
	/**
	 * Init
	 */
	function init() {
		
		/* Settings */
		$this->plugin_id 		= 'calendar_date_picker';
		$this->plugin_name 	= 'Calendar Date Picker';
		$this->frosty_media();
		
		/* Add the scripts */
		add_action( 'admin_enqueue_scripts',		array( $this, 'enqueue_scripts' ) );
	}
	
	/**
	 * Load required actions, filters and classes for Frosty.Media plugins
	 *
	 */
	function frosty_media() {
			
		add_action( 'admin_init', array( $this, 'fm_add_plugin_license' ) );
		require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'classes/class-frosty-media-requires.php' );
	}
		
	/**
	 * Add our license data.
	 */
	public function fm_add_plugin_license() {
		if ( !class_exists( 'Frosty_Media_Licenses' ) )
			return;
			
		global $frosty_media_licenses;
		
		$plugin = array(
			'id' 			=> $this->plugin_id,
			'title' 		=> $this->plugin_name, //Must match EDD post_title!
			'version'		=> $this->version,
			'file'			=> __FILE__,
			'basename'		=> plugin_basename( __FILE__ ),
			'download_id'	=> '99',
			'author'		=> 'Austin Passy' // author of this plugin
		);
		
		$frosty_media_licenses->add_plugin( $plugin );		
	}
	
	/**
	 * Enqueue all scripts and styles.
	 *
	 */
	function enqueue_scripts( $hook ) {
		
		if ( 'post-new.php' === $hook || 'post.php' === $hook ) :
		
			/* Scripts */
			wp_enqueue_script( 'jquery-ui-timepicker', plugins_url( 'js/jquery-ui-timepicker-addon.js', __FILE__ ), array( 'jquery', 'jquery-ui-datepicker', 'jquery-ui-slider' ), '1.5.0', false );
			wp_enqueue_script( 'calendar-date-picker', plugins_url( 'js/functions.js', __FILE__ ), array( 'jquery', 'jquery-ui-timepicker', ), $this->version, false );
					
			/* Style */
			wp_enqueue_style( 'jquery-ui-timepicker-addon', plugins_url( 'css/jquery-ui-timepicker-addon.css', __FILE__ ), null, '1.5.0', 'screen' );
			wp_enqueue_style( 'calendar-date-picker', plugins_url( 'css/style.css', __FILE__ ), null, $this->version, 'screen' );
		
		endif;
	}
	
	/**
	 * HTML output of full date input field.
	 * Disabled for now, since datepicker is a jQuery script
	 * 	lets load the input field via javascript.
	 *
	 * @ref wp-admin/includes/meta-box.php:183
	 * add_action( 'post_submitbox_misc_actions' )
	 */
	function input_field() {
		echo '<input type="text" autocomplete="off" maxlength="16" size="44" value="" name="fulldate" placeholder="mm/dd/yyyy hh:mm" id="fulldate" />';
    }
	
}

/* Calendar Date Picker, AWAY! */
add_action( 'plugins_loaded', create_function( '', 'return calendar_date_picker::instance();' ) );