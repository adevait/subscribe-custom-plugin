<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Activator{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate(){
        $my_post = array(
          'post_title'    => 'Verify',
          'post_content'  => 'This is page for email verification.',
          'post_status'   => 'publish',
          'post_author'   => get_current_user_id(),
          'post_type'     => 'page',
        );

         wp_insert_post( $my_post, '' );
        }
}
