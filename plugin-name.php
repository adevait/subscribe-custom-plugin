<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       Subscribe Button
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       Just another subscribe button
 * Version:           1.0.0
 * Author:            Stefan Mitrevski
 * Author URI:        https://github.com/mitrevski94
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}
require_once('public/partials/plugin-name-public-display.php');

add_action('wp_enqueue_scripts', 'ajax_test_enqueue_scripts');
function ajax_test_enqueue_scripts() {
    wp_enqueue_script('jquery');
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_plugin_name() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-plugin-name-activator.php';
    Plugin_Name_Activator::activate();
    create_table();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_name() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-plugin-name-deactivator.php';
    Plugin_Name_Deactivator::deactivate();
}

function create_table() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'subscribe';

    $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		email VARCHAR(255) NOT NULL,
        hash VARCHAR(32) NOT NULL,
		confirm TINYINT(1) DEFAULT '0' NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'activate_plugin_name');
register_deactivation_hook(__FILE__, 'deactivate_plugin_name');
register_activation_hook(__FILE__, 'create_table');

add_action( 'init', 'process_post' );

function process_post() {

    if(strpos($_SERVER["REQUEST_URI"], 'verify')) {

        if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
            global $wpdb;
            $email = $_GET['email']; 
            $hash = $_GET['hash']; 

            $search = $wpdb->get_results("SELECT email, hash, confirm FROM wp_subscribe WHERE email='".$email."' AND hash='".$hash."' AND confirm='0'");
            if(!empty($search)){
                $match = 1;
            }
            else{
                $match = 0;
            }
            if($match > 0){
                    $table = $wpdb->prefix . 'subscribe';
                    $data = array('confirm'=>'1');
                    $where = array(
                        'email' => $email,
                        'hash' => $hash,
                        'confirm' => 0,
                    );
                    $wpdb->update($table, $data, $where);
                    echo '<div>Your registration was succesful, from now on you will be the first to receive the latest news.</div>';
                    ?><a href="<?php echo home_url()?>" type="button">Go back</a><?php
                    
            }else{
                    echo '<div>Invalid approach, please use the link that has been send to your email.</div>';
                ?><a href="<?php echo home_url()?>" type="button">Go back</a><?php
            }
        }
        wp_die();
    }
}
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-plugin-name.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name(){
    $plugin = new Plugin_Name();
    $plugin->run();
}
run_plugin_name();
