<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public/partials
 */
class subscribe_widget extends WP_Widget{

    // constructor
    public function __construct(){
        parent::__construct(false, $name = __('Subscribe Widget', 'wp_widget_plugin'));
        add_action('wp_ajax_sub_action', array( $this, 'sub_action' ));
    }

    // widget form creation
    public function form($instance){
        if ($instance) {
            $text = esc_attr($instance['text']);
        } else {
            $text = '';
        } ?>

	<p>
	<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="Email"/>
	</p>
	<?php

    }

    // widget update
    public function update($new_instance, $old_instance){
        $instance = $old_instance;
        $instance['text'] = strip_tags($new_instance['text']);
        return $instance;
    }

    // widget display
    public function widget($args, $instance)
    {
        extract($args);
           // these are the widget option
           ?>
		   <form method="POST" action="" id="sb_form">
		   		<input id="email" type="email" name="email" style="width:330px; height:35px;" placeholder="<?php echo get_option('placeholder'); ?>" required unique>
		   		<input type="hidden" name="action" value="Subscribe"/>
		   		<input type="button" id="subscribe" name="subscribe" style="width:330px; background-color:<?php echo get_option('bgcolor'); ?>; color:<?php echo get_option('color'); ?>;" value="<?php echo get_option('button_text'); ?>">

		   		<label id="successmessage"></label>
		   </form>
		   <script type="text/javascript">
		   		jQuery(document).ready(function($) {
		   			jQuery("#sb_form #subscribe").click(function(){

			   			jQuery.ajax({
	        				type: "POST",
	        				url: '/wp-admin/admin-ajax.php',
	        				data : {
								'action': 'sub_action',
								'email': email.value
							},
						    success: function(data) {
						    		if(data.success){
					                	successmessage = 'We have sent you a confirmation email. Please go to your 	email and confirm your subscription.';
					            	}
					            	else{ 
					            		successmessage = 'Invalid email format or email already taken.';}
					            		$("#successmessage").text(successmessage);
					            }, 
     					});
		   				
		   			});
	   		});
		   		
		   </script>
	<?php
    }
    public function sub_action(){
        global $wpdb;
        if ($_POST['email']) {
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo wp_send_json_error(); 
            } else {
                $table_name = $wpdb->prefix . "subscribe";
                $retrieve_data = $wpdb->get_results("SELECT email FROM $table_name WHERE `email` = '$email'");
                if ($retrieve_data && $wpdb->num_rows > 0) {
                    echo wp_send_json_error();
                } else {
                    $hash = md5(rand(0, 1000));
                    $wpdb->insert(
                        'wp_subscribe',
                        array(
                              'time' => current_time('mysql', 1),
                              'email' => $_POST['email'],
                              'hash' => $hash
                              )
                            
                            );
                    if (get_option('opt_in')) {
                        $subject = get_option('opt_in_subject');
                        $content = get_option('opt_in_content'). "\r\n".home_url() . '/verify?email='.$email.'&hash='.$hash.'';
                        $headers[] = 'From:'. get_option('name').'<'. get_option('email'). '>';
                        wp_mail($email, $subject, $content, $headers);
                    }
                    echo wp_send_json_success();
                }
            }
        }
        wp_die();
    }
}




// register widget
function register_subscribe_widget(){
    register_widget('subscribe_widget');
}
add_action('widgets_init', 'register_subscribe_widget');

//add_action('wp_head', 'myplugin_ajaxurl');

function myplugin_ajaxurl(){
    echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}
