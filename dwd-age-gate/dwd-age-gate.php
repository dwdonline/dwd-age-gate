<?php
/*
Plugin Name: AgeGate by DWD
Plugin URI: https://dwd.tech
Description: This plugin shows a popup for age verification.
Author: Philip Deatherage / DWD
Author URI: https://dwd.tech
Version: 1.0
*/

// let's add our js and css
add_action('wp_enqueue_scripts', 'age_gate_enqueue_script');
function age_gate_enqueue_script() { 
	if (!is_admin()) {  
	    wp_enqueue_script('js_cookie', plugin_dir_url( __FILE__ ) . 'assets/js/js-cookie.js', array('jquery'));
	    wp_enqueue_script('age_gate', plugin_dir_url( __FILE__ ) . 'assets/js/age.js', array('jquery'));
	    wp_enqueue_style('age_gate', plugin_dir_url(__FILE__) . 'assets/css/age.css', false);
	}
}

add_action('wp_footer','age_gate_call');

function age_gate_call() {
	if ( !is_admin() && !is_checkout() && !is_page('checkout') ) {
		?>
		<div id="popup" data-popup="popup-1" style="display:none;">
		    <div class="verify-window">
		        <h3>Age Verification</h3>
		        <p>Are you at least 21 years old?</p>

		        <div class="button-yes" data-popup-close="popup-1">
		            Yes
		        </div>

		        <a href="https://www.google.com" target="_parent">
		            <div class="button-no">
		                No
		            </div>
		        </a>
		    </div><!-- // verify window -->
		</div>
	<?php }
}
