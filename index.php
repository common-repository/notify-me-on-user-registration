<?php
/*
Plugin Name: Worldclassthemes Notify me Plugin
Plugin URI: https://worldclassthemes.com
Description: Add a secondary notification to wordpress when a user is registered
Version: 4.5
Author: Suhail Ahmad
Author URI: https://worldclassthemes.com
*/



//add_action( 'wp_enqueue_scripts', 'worldclassthemes_enqueue_script' );


// create custom plugin settings menu
add_action('admin_menu', 'wct_suhail_notify_me');

function wct_suhail_notify_me() {

	//create new top-level menu
	add_menu_page('Add an extra field to notify when a new user registered', 'Wct Notify Me', 'administrator', __FILE__, 'wtc_yt_plugin_page' , plugins_url('/images/icon.png', __FILE__) );

	//call register settings function
	add_action( 'admin_init', 'register_wtc_yt_plugin' );
}


function register_wtc_yt_plugin() {
	//register our settings
	register_setting( 'wct-suhail-settings-group', 'notify_my_wtc_suhail' );
	register_setting( 'wct-suhail-settings-group', 'notify_my_check_wtc_suhail' );
}

function wtc_yt_plugin_page() {
	?>


<div class="ytc_notify_me_form">
    <form method="post" action="options.php">
        <?php settings_fields( 'wct-suhail-settings-group' ); ?>
        <?php do_settings_sections( 'wct-suhail-settings-group' ); ?>
        
        <h2>Enter Email Address for Secondary Notification on new user registration</h2>
        
        <table class="form-table">
            <tr valign="top">
            <th scope="row">Enable Notification</th>
            <td><input type="checkbox" name="notify_my_check_wtc_suhail" <?php if(esc_attr( get_option('notify_my_check_wtc_suhail') ) ){ ?> checked="checked" <?php } ?> /></td>
            </tr>
            <tr valign="top">
            <th scope="row">Enter Email Address</th>
            <td><input type="email" name="notify_my_wtc_suhail" value="<?php echo esc_attr( get_option('notify_my_wtc_suhail') ); ?>" /></td>
            </tr>
            
            
        </table>
        
        <?php submit_button(); ?>
            
    </form>
    
    <br /><br />
    
    <p>For more premium plugins and themes, please visit <a href="https://worldclassthemes.com" target="_blank">worldclassthemes.com</a></p>
</div>

<h1>Special Offer</h1>
<h2>A beautiful Responsive One Page Wordpress theme</h2>
<a href="https://worldclassthemes.com/item/building-on-strength" target="_blank"><img src="<?php echo plugins_url('/images/offer.png', __FILE__); ?>" width="60%" /></a>

<style>
	.ytc_notify_me_form {
		border:silver solid 5px;
		padding:10px;
		width:80%;
		border-radius:5px;
		margin-left:15px;
	}
</style>

<?php 


} 


add_action( 'user_register', 'wtc_suhail_registration_save', 10, 1 );

function wtc_suhail_registration_save( $user_id ) {
	
		if(esc_attr( get_option('notify_my_check_wtc_suhail') ) ){
			global $wpdb, $wp_hasher;
			$user = get_userdata( $user_id );
			
			// The blogname option is escaped with esc_html on the way into the database in sanitize_option
			// we want to reverse this for the plain text arena of emails.
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
		
			$message  = sprintf(__('New user registration on your site %s:'), $blogname) . "\r\n\r\n";
			$message .= sprintf(__('Username: %s'), $user->user_login) . "\r\n\r\n";
			$message .= sprintf(__('Email: %s'), $user->user_email) . "\r\n";
		
			@wp_mail(esc_attr( get_option('notify_my_wtc_suhail')), sprintf(__('[%s] New User Registration'), $blogname), $message);
			
			//update_user_meta($user_id, 'first_name', $_POST['first_name']);
		}
}



?>