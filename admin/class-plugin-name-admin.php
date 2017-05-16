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
class Plugin_Name_Admin{

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
    public function __construct($plugin_name, $version){
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles(){
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/plugin-name-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts(){
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false);
    }
    public function add_plugin_admin_menu(){
        add_menu_page('Subscribe', 'Subscribe', 'manage_options', 'plugin-name', array($this, 'display_plugin_setup_page'));
        add_submenu_page('plugin-name',
        'Subscribe Options', 'Subscribe Options', 'manage_options',
        'plugin-name', array($this, 'display_plugin_setup_page'));
        add_submenu_page('plugin-name',
        'Subscribe List', 'Subscribe List', 'manage_options',
        'plugin-name-list', array($this, 'display_plugin_setup_page'));
    }
    public function add_action_links($links){
        $settings_link = array(
        '<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge($settings_link, $links);
    }
    public function display_plugin_setup_page(){
        include_once('partials/plugin-name-admin-display.php');
    }
    public function subscribe_initialize_plugin_options(){

        add_settings_section(
            'general_settings_section',         
            'Subscribe Options',                  
            'subscribe_general_options_callback', 
            'plugin-name'                           
        );
            add_settings_field(
                'opt_in',                      
                'Opt in option',                           
                'subscribe_toggle_optin_callback',   
                'plugin-name',                          
                'general_settings_section',         
                array(                             
                    'Activate this setting in order to send confirmation link to your subscribers.'
                )
        );
            add_settings_field(
                'email',                      
                'From email',                           
                'subscribe_from_email_callback',   
                'plugin-name',                         
                'general_settings_section',        
                array(                              
                    'Type the email which you are going to use when sending emails to your subscribers.'
                )
        );
            add_settings_field(
        'name',                     
        'From name',                           
        'subscribe_from_name_callback',   
        'plugin-name',                          
        'general_settings_section',         
            array(                              
                'Type the name which you are going to use when sending emails to your subscribers.'
            )
        );
            add_settings_field(
        'button_text',                      
        'Button text',                           
        'subscribe_button_text_callback',   
        'plugin-name',                          
        'general_settings_section',         
            array(                              
                'Choose the display text for your submit button.'
            )
        );
            add_settings_field(
        'placeholder',                      
        'Placeholder',                           
        'subscribe_placeholder_callback',   
        'plugin-name',                          
        'general_settings_section',         
            array(                              
                'Choose the placeholder text for email subscribers.'
            )
        );
            add_settings_field(
        'opt_in_subject',                      
        'Confirmation Email Subject',                           
        'subscribe_confirmation_email_subject_callback',   
        'plugin-name',                          
        'general_settings_section'        
        );
            add_settings_field(
        'opt_in_content',                      
        'Confirmation Email Content',                           
        'subscribe_confirmation_email_content_callback',   
        'plugin-name',                          
        'general_settings_section'         
        );
            add_settings_field(
        'subject',                      
        'Email Subject',                           
        'subscribe_email_subject_callback',   
        'plugin-name',                          
        'general_settings_section'        

        );
            add_settings_field(
        'content',                      
        'Email Content',                           
        'subscribe_email_content_callback',   
        'plugin-name',                          
        'general_settings_section'         
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
        }
    }
    function subscribe_general_options_callback(){
        echo '<p>Select which areas of content you wish to display.</p>';
    } 
    function subscribe_toggle_optin_callback($args){
        $options = get_option('subscribe_initialize_plugin_options');
        $html = '<input type="checkbox" id="opt_in" name="opt_in" value="1" ' . checked(1, get_option('opt_in', $options), false) . '/>';
        $html .= '<label for="opt_in"> '  . $args[0] . '</label>';
        echo $html;
    }
    function subscribe_from_email_callback($args){
        $options = get_option('subscribe_initialize_plugin_options');
        $url = '';
        if (isset($options['email'])) {
            $url = $options['email'];
        }
        $html = '<input type="text" id="email" name="email" value="' . get_option('email', $options) . '" />';
        $html .= '<label for="email"> '  . $args[0] . '</label>';  
        echo $html;
    } 
    function subscribe_from_name_callback($args){
        $options = get_option('subscribe_initialize_plugin_options');
        $url = '';
        if (isset($options['name'])) {
            $url = $options['name'];
        } 
        $html = '<input type="text" id="name" name="name" value="' . get_option('name') . '" />';
        $html .= '<label for="name"> '  . $args[0] . '</label>';
        echo $html;
    }
    function subscribe_button_text_callback($args){
        $options = get_option('subscribe_initialize_plugin_options');
        $url = '';
        if (isset($options['button_text'])) {
            $url = $options['button_text'];
        }
        $html = '<input type="text" id="button_text" name="button_text" value="' . get_option('button_text') . '" />';
        $html .= '<label for="button_text"> '  . $args[0] . '</label>';
        echo $html;
    }
    function subscribe_placeholder_callback($args){
        $options = get_option('subscribe_initialize_plugin_options');
        $url = '';
        if (isset($options['placeholder'])) {
            $url = $options['placeholder'];
        }
        $html = '<input type="text" id="placeholder" name="placeholder" value="' . get_option('placeholder') . '" />';
        $html .= '<label for="placeholder"> '  . $args[0] . '</label>';
        echo $html;
    }

    function subscribe_confirmation_email_subject_callback($args)
    {
        $options = get_option('subscribe_email_plugin_options');
        $url = '';
        if (isset($options['opt_in_subject'])) {
            $url = $options['opt_in_subject'];
        } 
        if (get_option('opt_in')) {  
        $html = '<input placeholder="Type default confirmation email subject." type="text" id="opt_in_subject" name="opt_in_subject" value="' . get_option('opt_in_subject') . '" />';
        } else {
            $html ='Your opt in option is not active.';
        }
        echo $html;
    }
    function subscribe_confirmation_email_content_callback($args)
    {
        $options = get_option('subscribe_email_plugin_options');
        $url = '';
        if (isset($options['opt_in_subject'])) {
            $url = $options['opt_in_subject'];
        }
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
        }

        $html = '<input placeholder="Type defaul email subject." type="text" id="subject" name="subject" value="' . get_option('subject') . '" />';
         
        echo $html;
    }
    function subscribe_email_content_callback($args)
    {
        $options = get_option('subscribe_email_plugin_options');
        $url = '';
        if (isset($options['subject'])) {
            $url = $options['subject'];
        }
        $html ='<textarea placeholder ="Type default email content."id="content" name="content" rows="5" cols="50">' . get_option('content'). '</textarea>';
         
        echo $html;
    }
