<?php
/**
 * MCE
 *
 * @package			WordPress
 * @subpackage		MCE
 * @author			RogerTM
 * @license			license.txt
 * @link			https://excursionismocuba.com
 * @since 			MCE 1.0
 */

/**
 * Silents is gold... But we call the others
 */
require( get_stylesheet_directory() . '/inc/functions.php' );
require( get_stylesheet_directory() . '/inc/enqueue.php' );
require( get_stylesheet_directory() . '/inc/post-types.php' );
require( get_stylesheet_directory() . '/inc/cron.php' );
?>
