<?php
/**
 * Plugin Name: Calendar Date Picker
 * Plugin URI: https://github.com/thefrosty/wp-calendar-date-picker
 * Description: Show a powerful datetime picker on an input box next to the 'edit date' for exact date and time selection. Required: javascript to be enabled.
 * Version: 2.1.0
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
class WP_Calendar_Date_Picker
{

    private const VERSION = '2.1.0';
    private const FLATPICKR = 'flatpickr';

    /**
     * Enqueue all scripts and styles.
     *
     * @param string $hook
     */
    public function enqueue_scripts(string $hook)
    {
        if (!in_array($hook, ['post-new.php', 'post.php'], true)) {
            return;
        }

        $min = (\defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
        \wp_register_script(
            self::FLATPICKR,
            \plugins_url('js/flatpickr' . $min . '.js', __FILE__),
            [],
            '4.6.3',
            true
        );
        \wp_register_script(
            'calendar-date-picker',
            \plugins_url('js/functions.js', __FILE__),
            [self::FLATPICKR],
            self::VERSION,
            true
        );
        \wp_enqueue_script('calendar-date-picker');
        \wp_enqueue_style(self::FLATPICKR, \plugins_url('css/flatpickr' . $min . '.css', __FILE__), null, '4.6.3', 'screen');
        \wp_enqueue_style('calendar-date-picker', \plugins_url('css/style.css', __FILE__), null, self::VERSION, 'screen');
    }
}

/* Calendar Date Picker, AWAY! */
\add_action('admin_enqueue_scripts', static function (string $hook) {
    (new WP_Calendar_Date_Picker())->enqueue_scripts($hook);
});
