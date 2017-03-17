<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Admin
{

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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Plugin_Name_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Plugin_Name_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/plugin-name-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Plugin_Name_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Plugin_Name_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false);
    }
    
    
    public function add_plugin_admin_menu()
    {
        add_menu_page('Subscribe', 'Subscribe', 'manage_options', 'plugin-name', array($this, 'display_plugin_setup_page'));
        add_submenu_page('plugin-name',
        'Subscribe Options', 'Subscribe Options', 'manage_options',
        'plugin-name', array($this, 'display_plugin_setup_page'));
        add_submenu_page('plugin-name',
        'Subscribe List', 'Subscribe List', 'manage_options',
        'plugin-name-list', array($this, 'display_plugin_setup_page'));
        //add_submenu_page( 'Subscribe', 'Subscribe Options', 'Subscribe Options', 'manage_options', 'plugin-name-options', array($this, 'display_plugin_setup_page'));
    }
    public function add_action_links($links)
    {
        /*
    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
    */
        $settings_link = array(
        '<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge($settings_link, $links);
    }
    public function display_plugin_setup_page()
    {
        include_once('partials/plugin-name-admin-display.php');
    }
    public function subscribe_initialize_plugin_options()
    {

    // First, we register a section. This is necessary since all future options must belong to one.
    add_settings_section(
        'general_settings_section',         // ID used to identify this section and with which to register options
        'Subscribe Options',                  // Title to be displayed on the administration page
        'subscribe_general_options_callback', // Callback used to render the description of the section
        'plugin-name'                           // Page on which to add this section of options
    );
        add_settings_field(
    'opt_in',                      // ID used to identify the field throughout the theme
    'Opt in option',                           // The label to the left of the option interface element
    'subscribe_toggle_optin_callback',   // The name of the function responsible for rendering the option interface
    'plugin-name',                          // The page on which this option will be displayed
    'general_settings_section',         // The name of the section to which this field belongs
        array(                              // The array of arguments to pass to the callback. In this case, just a description.
            'Activate this setting in order to send confirmation link to your subscribers.'
        )
    );
        add_settings_field(
    'email',                      // ID used to identify the field throughout the theme
    'From email',                           // The label to the left of the option interface element
    'subscribe_from_email_callback',   // The name of the function responsible for rendering the option interface
    'plugin-name',                          // The page on which this option will be displayed
    'general_settings_section',         // The name of the section to which this field belongs
        array(                              // The array of arguments to pass to the callback. In this case, just a description.
            'Type the email which you are going to use when sending emails to your subscribers.'
        )
    );
        add_settings_field(
    'name',                      // ID used to identify the field throughout the theme
    'From name',                           // The label to the left of the option interface element
    'subscribe_from_name_callback',   // The name of the function responsible for rendering the option interface
    'plugin-name',                          // The page on which this option will be displayed
    'general_settings_section',         // The name of the section to which this field belongs
        array(                              // The array of arguments to pass to the callback. In this case, just a description.
            'Type the name which you are going to use when sending emails to your subscribers.'
        )
    );
        add_settings_field(
    'button_text',                      // ID used to identify the field throughout the theme
    'Button text',                           // The label to the left of the option interface element
    'subscribe_button_text_callback',   // The name of the function responsible for rendering the option interface
    'plugin-name',                          // The page on which this option will be displayed
    'general_settings_section',         // The name of the section to which this field belongs
        array(                              // The array of arguments to pass to the callback. In this case, just a description.
            'Choose the display text for your submit button.'
        )
    );
        add_settings_field(
    'placeholder',                      // ID used to identify the field throughout the theme
    'Placeholder',                           // The label to the left of the option interface element
    'subscribe_placeholder_callback',   // The name of the function responsible for rendering the option interface
    'plugin-name',                          // The page on which this option will be displayed
    'general_settings_section',         // The name of the section to which this field belongs
        array(                              // The array of arguments to pass to the callback. In this case, just a description.
            'Choose the placeholder text for email subscribers.'
        )
    );
        add_settings_field(
    'opt_in_subject',                      // ID used to identify the field throughout the theme
    'Confirmation Email Subject',                           // The label to the left of the option interface element
    'subscribe_confirmation_email_subject_callback',   // The name of the function responsible for rendering the option interface
    'plugin-name',                          // The page on which this option will be displayed
    'general_settings_section'        // The name of the section to which this field belongs
    );
        add_settings_field(
    'opt_in_content',                      // ID used to identify the field throughout the theme
    'Confirmation Email Content',                           // The label to the left of the option interface element
    'subscribe_confirmation_email_content_callback',   // The name of the function responsible for rendering the option interface
    'plugin-name',                          // The page on which this option will be displayed
    'general_settings_section'         // The name of the section to which this field belon
    );
        add_settings_field(
    'subject',                      // ID used to identify the field throughout the theme
    'Email Subject',                           // The label to the left of the option interface element
    'subscribe_email_subject_callback',   // The name of the function responsible for rendering the option interface
    'plugin-name',                          // The page on which this option will be displayed
    'general_settings_section'        // The name of the section to which this field belongs

    );
        add_settings_field(
    'content',                      // ID used to identify the field throughout the theme
    'Email Content',                           // The label to the left of the option interface element
    'subscribe_email_content_callback',   // The name of the function responsible for rendering the option interface
    'plugin-name',                          // The page on which this option will be displayed
    'general_settings_section'         // The name of the section to which this field belon
    );
    
        register_setting(
    'general',
    'opt_in'
    );
        register_setting(
    'general',
    'email'
    );
        register_setting(
    'general',
    'name'
    );
        register_setting(
    'general',
    'button_text'
    );
        register_setting(
    'general',
    'placeholder'
    );
        register_setting(
    'general',
    'opt_in_subject'
    );
        register_setting(
    'general',
    'opt_in_content'
    );
        register_setting(
    'general',
    'subject'
    );
        register_setting(
    'general',
    'content'
        );
    } // end sandbox_initialize_theme_options
 
/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */
 
/**
 * This function provides a simple description for the General Options page.
 *
 * It is called from the 'sandbox_initialize_theme_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
}
function subscribe_general_options_callback()
{
    echo '<p>Select which areas of content you wish to display.</p>';
} // end sandbox_general_options_callback
function subscribe_toggle_optin_callback($args)
{
    $options = get_option('subscribe_initialize_plugin_options');
    // Note the ID and the name attribute of the element match that of the ID in the call to add_settings_field
    $html = '<input type="checkbox" id="opt_in" name="opt_in" value="1" ' . checked(1, get_option('opt_in', $options), false) . '/>';
     
    // Here, we will take the first argument of the array and add it to a label next to the checkbox
    $html .= '<label for="opt_in"> '  . $args[0] . '</label>';
     
    echo $html;
} // end sandbox_toggle_header_callback
function subscribe_from_email_callback($args)
{
    $options = get_option('subscribe_initialize_plugin_options');
    $url = '';
    if (isset($options['email'])) {
        $url = $options['email'];
    } // end if
     
    // Render the output
    $html = '<input type="text" id="email" name="email" value="' . get_option('email', $options) . '" />';
     // end sandbox_twitter_callback

    // Note the ID and the name attribute of the element match that of the ID in the call to add_settings_field
    //$html = '<input type="email" id="email" name="email" placeholder="abc@example.com"/>';
     
    // Here, we will take the first argument of the array and add it to a label next to the checkbox
    $html .= '<label for="email"> '  . $args[0] . '</label>';
     
    echo $html;
} // end sandbox_toggle_header_callback
function subscribe_from_name_callback($args)
{
    $options = get_option('subscribe_initialize_plugin_options');
    $url = '';
    if (isset($options['name'])) {
        $url = $options['name'];
    } // end if
     
    // Render the output
    $html = '<input type="text" id="name" name="name" value="' . get_option('name') . '" />';
     // end sandbox_twitter_callback

    // Note the ID and the name attribute of the element match that of the ID in the call to add_settings_field
    //$html = '<input type="email" id="email" name="email" placeholder="abc@example.com"/>';
     
    // Here, we will take the first argument of the array and add it to a label next to the checkbox
    $html .= '<label for="name"> '  . $args[0] . '</label>';
     
    echo $html;
} // end sandbox_toggle_header_callback
function subscribe_button_text_callback($args)
{
    $options = get_option('subscribe_initialize_plugin_options');
    $url = '';
    if (isset($options['button_text'])) {
        $url = $options['button_text'];
    } // end if
     
    // Render the output
    $html = '<input type="text" id="button_text" name="button_text" value="' . get_option('button_text') . '" />';
     // end sandbox_twitter_callback

    // Note the ID and the name attribute of the element match that of the ID in the call to add_settings_field
    //$html = '<input type="email" id="email" name="email" placeholder="abc@example.com"/>';
     
    // Here, we will take the first argument of the array and add it to a label next to the checkbox
    $html .= '<label for="button_text"> '  . $args[0] . '</label>';
     
    echo $html;
} // end sandbox_toggle_header_callback
function subscribe_placeholder_callback($args)
{
    $options = get_option('subscribe_initialize_plugin_options');
    $url = '';
    if (isset($options['placeholder'])) {
        $url = $options['placeholder'];
    } // end if
     
    // Render the output
    $html = '<input type="text" id="placeholder" name="placeholder" value="' . get_option('placeholder') . '" />';
     // end sandbox_twitter_callback

    // Note the ID and the name attribute of the element match that of the ID in the call to add_settings_field
    //$html = '<input type="email" id="email" name="email" placeholder="abc@example.com"/>';
     
    // Here, we will take the first argument of the array and add it to a label next to the checkbox
    $html .= '<label for="placeholder"> '  . $args[0] . '</label>';
     
    echo $html;
} // end sandbox_toggle_header_callback

function subscribe_confirmation_email_subject_callback($args)
{
    //$opt_in_options = get_option( 'subscribe_general_plugin_options' );
    $options = get_option('subscribe_email_plugin_options');
    $url = '';
    if (isset($options['opt_in_subject'])) {
        $url = $options['opt_in_subject'];
    } // end if
    if (get_option('opt_in')) {
        // Render the output
    $html = '<input placeholder="Type default confirmation email subject." type="text" id="opt_in_subject" name="opt_in_subject" value="' . get_option('opt_in_subject') . '" />';
     // end sandbox_twitter_callback

    // Note the ID and the name attribute of the element match that of the ID in the call to add_settings_field
    //$html = '<input type="email" id="email" name="email" placeholder="abc@example.com"/>';
     
    // Here, we will take the first argument of the array and add it to a label next to the checkbox
    } else {
        $html ='Your opt in option is not active.';
    }
    echo $html;
}
function subscribe_confirmation_email_content_callback($args)
{
    //$opt_in_options = get_option( 'subscribe_general_plugin_options' );
    $options = get_option('subscribe_email_plugin_options');
    $url = '';
    if (isset($options['opt_in_subject'])) {
        $url = $options['opt_in_subject'];
    } // end if
    // Render the output
    if (get_option('opt_in')) {
        $html ='<textarea placeholder ="Type default confirmation email content."id="opt_in_content" name="opt_in_content" rows="5" cols="50">' . get_option('opt_in_content') . '</textarea>';
    } else {
        $html ='Your opt in option is not active.';
    }
    echo $html;
}
function subscribe_email_subject_callback($args)
{
    $options = get_option('subscribe_email_plugin_options');
    $url = '';
    if (isset($options['subject'])) {
        $url = $options['subject'];
    } // end if
     
    // Render the output
    $html = '<input placeholder="Type defaul email subject." type="text" id="subject" name="subject" value="' . get_option('subject') . '" />';
     // end sandbox_twitter_callback

    // Note the ID and the name attribute of the element match that of the ID in the call to add_settings_field
    //$html = '<input type="email" id="email" name="email" placeholder="abc@example.com"/>';
     
    // Here, we will take the first argument of the array and add it to a label next to the checkbox
     
    echo $html;
}
function subscribe_email_content_callback($args)
{
    $options = get_option('subscribe_email_plugin_options');
    $url = '';
    if (isset($options['subject'])) {
        $url = $options['subject'];
    } // end if
    // Render the output
    $html ='<textarea placeholder ="Type default email content."id="content" name="content" rows="5" cols="50">' . get_option('content'). '</textarea>';
     
    echo $html;
}
