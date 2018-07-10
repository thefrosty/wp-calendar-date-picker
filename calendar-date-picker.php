<?php
/**
 * Plugin Name: Calendar Date Picker
 * Plugin URI: https://github.com/thefrosty/wp-calendar-date-picker
 * Description: Show the <a href="http://jqueryui.com/">jQuery UI</a> <a href="http://jqueryui.com/datepicker/">Datepicker</a> on an input box next to the 'edit date' for exact date and time selection. Required javascript to be enabled. Uses <a href="http://trentrichardson.com/examples/timepicker/">Timepicker</a> by <a href="http://trentrichardson.com/">Trent Richardson</a>.
 * Version: 2.0.0
 * Author: Austin Passy
 * Author URI: https://austin.passy.co
 *
 * @copyright 2012-2018
 * @author Austin Passy
 * @link https://frosty.media/
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package WP_Calendar_Date_Picker
 */

/**
 * Class WP_Calendar_Date_Picker
 */
class WP_Calendar_Date_Picker {

    const VERSION = '2.0.0';

    /**
     * Init
     */
    public function add_hooks() {
        \add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    /**
     * Enqueue all scripts and styles.
     *
     * @param string $hook
     */
    function enqueue_scripts( string $hook ) {
        if ( ! in_array( $hook, [ 'post-new.php', 'post.php' ], true ) ) {
            return;
        }

        \wp_register_script(
            'jquery-ui-timepicker',
            \plugins_url( 'js/jquery-ui-timepicker-addon.js', __FILE__ ),
            [
                'jquery',
                'jquery-ui-datepicker',
                'jquery-ui-slider',
            ],
            '1.6.3',
            true
        );
        \wp_register_script(
            'calendar-date-picker',
            \plugins_url( 'js/functions.js', __FILE__ ),
            [
                'jquery',
                'jquery-ui-timepicker',
            ],
            self::VERSION,
            true
        );
        \wp_enqueue_script( 'calendar-date-picker' );
        \wp_enqueue_style( 'jquery-ui-timepicker-addon', \plugins_url( 'css/jquery-ui-timepicker-addon.css', __FILE__ ), null, '1.5.3', 'screen' );
        \wp_enqueue_style( 'calendar-date-picker', \plugins_url( 'css/style.css', __FILE__ ), null, self::VERSION, 'screen' );
    }

}

/* Calendar Date Picker, AWAY! */
\add_action( 'plugins_loaded', function() {
    if ( \is_admin() ) {
        ( new WP_Calendar_Date_Picker() )->add_hooks();
    }
} );
