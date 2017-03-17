<?php

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    global $wpdb;
    // Verify data
    $email = $_GET['email']; // Set email variable
    $hash = $_GET['hash']; // Set hash variable
    $search = $wpdb->get_results("SELECT email, hash, confirm FROM wp_stefan_stefan WHERE email='".$email."' AND hash='".$hash."' AND confirm='0'"); 
	$match  = mysql_num_rows($search);//if match 1, else 0 
	if($match > 0){
    // We have a match, activate the account
		$confirm = $wpdb->get_results("SELECT confirm FROM wp_stefan_stefan WHERE email='".$email."' AND hash='".$hash."'");
		if($confirm = 0){
			$wpdb->update("wp_stefan_stefan, confirm = '1', email='".$email"' AND hash='".$hash"' AND confirm='0'");
		}
		else{
			echo '<div class="statusmsg">Your subscription is already confirmed.</div>';
		}
	}else{
    // No match -> invalid url
			echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
	}
}else{
    // Invalid approach
    echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
}