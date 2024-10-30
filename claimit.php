<?php
/*

Plugin Name:  ClaimIt Webmaster Tools
Plugin URI:   https://www.rizonesoft.com/wordpress/claimit/
Description:  Simple plugin to claim your website on webmaster tools like in Google, Bing, Yandex, etc.
Version:      2.0.5
Author:       Rizonesoft.com
Author URI:   https://www.rizonesoft.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  claimit
Domain Path:  /languages

*/

/*
    Copyright (C) 2008-2018 Rizonesoft.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//
define('CLAIMIT_URL', WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)));
define('CLAIMIT_PATH', WP_PLUGIN_DIR.'/'.dirname(plugin_basename(__FILE__)));
define('CLAIMIT_VERSION', '2.0.5');
//

//some default value
add_option('claimit_google_webmaster', '');
add_option("claimit_google_submit_button", 'Default', '', 'yes');
add_option('claimit_bing_webmaster', '');
add_option('claimit_yandex_webmaster', '');
add_option('claimit_pinterest', '');
add_option('claimit_weboftrust_webmaster', '');
add_option('claimit_webutation_webmaster', '');
add_option('claimit_header_section', '');
add_option('claimit_body_section', '');
add_option('claimit_footer_section', '');

Function claimit_header_output()
{
	$ci_google_wm = get_option('claimit_google_webmaster');
	$ci_bing_wm = get_option('claimit_bing_webmaster');
	$ci_yandex_wm = get_option('claimit_yandex_webmaster');
	$ci_pinterest_wm = get_option('claimit_pinterest');
	$ci_weboftrust_wm = get_option('claimit_weboftrust_webmaster');
	$ci_webutation_wm = get_option('claimit_webutation_webmaster');
	$ci_header_section = get_option('claimit_header_section');

	echo "\n";
	echo "<!-- ClaimIt by Rizonesoft.com -->\n";
	
	if (is_front_page() ) {
        if (!($ci_google_wm == ""))
		{
			$ci_google_wm_meta = '<meta name="google-site-verification" content="' . $ci_google_wm . '" /> ';
			echo $ci_google_wm_meta . "\n";
		}

		if (!($ci_bing_wm == ""))
		{
			$ci_bing_wm_meta = '<meta name="msvalidate.01" content="' . $ci_bing_wm . '" />';
			echo $ci_bing_wm_meta . "\n";
		}

		if (!($ci_yandex_wm == ""))
		{
			$ci_yandex_wm_meta = '<meta name="yandex-verification" content="' . $ci_yandex_wm . '" />';
			echo $ci_yandex_wm_meta . "\n";
		}

		if (!($ci_pinterest_wm == ""))
		{
			$ci_pinterest_wm_meta = '<meta name="p:domain_verify" content="' . $ci_pinterest_wm . '" />';
			echo $ci_pinterest_wm_meta . "\n";
		}
	
		if (!($ci_weboftrust_wm == ""))
		{
			$ci_weboftrust_wm_meta = '<meta name="wot-verification" content="' . $ci_weboftrust_wm . '" />';
			echo $ci_weboftrust_wm_meta . "\n";
		}
	
		if (!($ci_webutation_wm == ""))
		{
			$ci_webutation_wm_meta = '<meta name="webutation-site-verification" content="' . $ci_webutation_wm . '" />';
			echo $ci_webutation_wm_meta . "\n";
		}
    }

	if (! ($ci_header_section == "")) {
			echo $ci_header_section . "\n";
	}

	echo "<!-- /ClaimIt by Rizonesoft.com -->";
	echo "\n";
	
	// turn output buffering on 
	ob_start();

}

function claimit_footer_output() {

	$ci_footer_section = get_option('claimit_footer_section');
	$ci_body_section = get_option('claimit_body_section');
	
		$get_claimit_buffers = ob_get_clean();
		$claimit_body_pattern ='/<[bB][oO][dD][yY]\s[A-Za-z]{2,5}[A-Za-z0-9 "_=\-\.]+>|<body>/';
		ob_start();

		if (preg_match($claimit_body_pattern, $get_claimit_buffers, $get_claimit_buffers_return)) {
			$claimit_body_container = $get_claimit_buffers_return[0] . "\n<!-- ClaimIt by Rizonesoft.com -->\n" . $ci_body_section . "\n<!-- /ClaimIt by Rizonesoft.com -->\n";
			echo preg_replace($claimit_body_pattern, $claimit_body_container, $get_claimit_buffers);
		}
	ob_flush();
	
	echo "\n<!-- ClaimIt by Rizonesoft.com -->\n";
	
	if (! ($ci_footer_section == "")) {
			echo $ci_footer_section . "\n";
	}
	
	echo "<!-- /ClaimIt by Rizonesoft.com -->\n";
}

function claimit_options_page() {

	if (isset ( $_POST ['update_webmaster'] )) {
		if (! isset ( $_POST ['my_claimit_update_setting'] ))
			die ( "Hmm .. looks like you didn't send any credentials.. No CSRF for you! " );
		if (! wp_verify_nonce ( $_POST ['my_claimit_update_setting'], 'claimit-update-setting' ))
			die ( "Hmm .. looks like you didn't send any credentials.. No CSRF for you! " );

		update_option ( 'claimit_google_webmaster', ( string ) sanitize_text_field($_POST ["input_claimit_google_webmaster"] ));
		update_option (	'claimit_google_submit_button', esc_html($_POST['checkbox_claimit_google_submit'] ? $_POST['checkbox_claimit_google_submit'] : ''));
		update_option ( 'claimit_bing_webmaster', ( string ) sanitize_text_field($_POST ["input_claimit_bing_webmaster"] ));
		update_option ( 'claimit_yandex_webmaster', ( string ) sanitize_text_field($_POST ["input_claimit_yandex_webmaster"] ));
		update_option ( 'claimit_pinterest', ( string ) sanitize_text_field($_POST ["input_claimit_pinterest"] ));
		update_option ( 'claimit_weboftrust_webmaster', ( string ) sanitize_text_field($_POST ["input_claimit_weboftrust_webmaster"] ));
		update_option ( 'claimit_webutation_webmaster', ( string ) sanitize_text_field($_POST ["input_claimit_webutation_webmaster"] ));
		echo '<div id="message" class="updated fade"><p><strong>Webmaster Options Updated.</strong></p></div>';
		echo '</strong>';
	}
		
	if (isset ( $_POST ['update_headerfooter'] )) {
		if (! isset ( $_POST ['my_claimit_update_setting'] ))
			die ( "Hmm .. looks like you didn't send any credentials.. No CSRF for you! " );
		if (! wp_verify_nonce ( $_POST ['my_claimit_update_setting'], 'claimit-update-setting' ))
			die ( "Hmm .. looks like you didn't send any credentials.. No CSRF for you! " );

		update_option ( 'claimit_header_section', ( string ) stripslashes_deep ( $_POST ['text_claimit_header_section'] ) );
		update_option ( 'claimit_body_section', ( string ) stripslashes_deep ( $_POST ['text_claimit_body_section'] ) );
		update_option ( 'claimit_footer_section', ( string ) stripslashes_deep ( $_POST ['text_claimit_footer_section'] ) );
		echo '<div id="message" class="updated fade"><p><strong>Header/Footer Sections Updated.</strong></p></div>';
		echo '</strong>';
	}
	
	$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'webmaster_options';
	
	?>
	
	<div class="wrap">

		<div id="icon-options" class="icon32"></div>
		<h2>ClaimIt Settings</h2>
		<?php settings_errors(); ?>
			
		<h2 class="nav-tab-wrapper">
			<a href="?page=claimit&tab=webmaster_options" class="nav-tab <?php echo $active_tab == 'webmaster_options' ? 'nav-tab-active' : ''; ?>">Webmaster</a>
			<!-- <a href="?page=claimit&tab=analytics" class="nav-tab <?php // echo $active_tab == 'analytics' ? 'nav-tab-active' : ''; ?>">Analytics</a> -->
			<a href="?page=claimit&tab=header_footer" class="nav-tab <?php echo $active_tab == 'header_footer' ? 'nav-tab-active' : ''; ?>">Header / Footer</a>
		</h2>

        <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
			<input type="hidden" name="claimit_info_update" id="claimit_info_update" value="true"/>

				<?php if ($active_tab == 'webmaster_options') { ?>
				
				<h3>Webmaster Options</h3>
				
				<table class="form-table">
					<tr valign="top">
						<th scope="row" style="width:200px;"><label><b>Google</b> Webmaster Tools</label></th>
						<td>
							<input name="input_claimit_google_webmaster" type="text" size="65" value="<?php echo get_option('claimit_google_webmaster'); ?>" />
							<div style="margin-top:10px;">
								Go to <a style="text-decoration:none;" href="https://www.google.com/webmasters/" onclick="return ! window.open(this.href);">Google Webmaster Tools</a> to claim your site.
								<br /><font color="grey">e.g. <code>&lt;meta name="google-site-verification" content="<font color="red">z5mJLjVGtEe5qzCefW1pamxI7H46u19n4XnxEzgl1AU</font>" /&gt;</code></font>
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" style="width:200px;"><label>Show Fetch as Google button?</label></th>
						<td>
							<input type="hidden" name="checkbox_claimit_google_submit" value="0" />
							<input type="checkbox" name="checkbox_claimit_google_submit" value="1" <?php echo checked(1, get_option('claimit_google_submit_button'), true); ?> />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" style="width:200px;"><label><b>Bing</b> Webmaster Tools</label></th>
						<td>
							<input id="styled" name="input_claimit_bing_webmaster" type="text" size="65" value="<?php echo get_option('claimit_bing_webmaster'); ?>" />
							<div style="margin-top:10px;">
								Go to <a style="text-decoration:none;" href="http://www.bing.com/toolbox/webmaster" onclick="return ! window.open(this.href);">Bing WebMaster Tools</a> to claim your site.
								<br /><font color="grey">e.g. <code>&lt;meta name="msvalidate.01" content="<font color="red">0FC3FD705126161B052E755A56F8952D</font>" /&gt;</code></font>
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" style="width:200px;"><label><b>Yandex</b> Webmaster Tools</label></th>
						<td>
							<input id="styled" name="input_claimit_yandex_webmaster" type="text" size="65" value="<?php echo get_option('claimit_yandex_webmaster'); ?>" />
							<div style="margin-top:10px;">
								Go to <a style="text-decoration:none;" href="https://webmaster.yandex.com" onclick="return ! window.open(this.href);">Yandex Webmaster Tools</a> to claim your site.
								<br /><font color="grey">e.g. <code>&lt;meta name="yandex-verification" content="<font color="red">38d8a338cfc6ca38</font>" /&gt;</code></font>
							</div>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row" style="width:200px;"><label><b>Pinterest</b> Site Verification</label></th>
						<td>
							<input id="styled" name="input_claimit_pinterest" type="text" size="65" value="<?php echo get_option('claimit_pinterest'); ?>" />
							<div style="margin-top:10px;">
								Go to <a style="text-decoration:none;" href="https://business.pinterest.com/en/verify-your-website" onclick="return ! window.open(this.href);">Pinterest for Business</a> to learn more.
								<br /><font color="grey">e.g. <code>&lt;meta name="p:domain_verify" content="<font color="red">059392ec2b568da3289258913b033d65</font>" /&gt;</code></font>
							</div>
						</td>
					</tr>

				</table>
				
				<h3>Online Reputation</h3>

				<table class="form-table">

					<tr valign="top">
						<th scope="row" style="width:200px;"><label><b>W</b>eb <b>O</b>f <b>T</b>rust</label></th>
						<td>
							<input name="input_claimit_weboftrust_webmaster" type="text" size="65" value="<?php echo get_option('claimit_weboftrust_webmaster'); ?>"/>
							<div>
								Go to your account on <a style="text-decoration:none;" href="http://www.mywot.com/" onclick="return ! window.open(this.href);">WOT</a> to claim your site.
								<br/><font color="grey">e.g. <code>&lt;meta name="wot-verification" content="<font color="red">8c55f65333232d9ead0e</font>" /&gt;</code></font>
							</div>
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row" style="width:200px;"><label>Webutation</b></label></th>
						<td>
							<input name="input_claimit_webutation_webmaster" type="text" size="65" value="<?php echo get_option('claimit_webutation_webmaster'); ?>" />
							<div>
								Go to <a style="text-decoration:none;" href="http://www.webutation.net/" onclick="return ! window.open(this.href);">Webutation.net</a> to claim your site.
								<br/><font color="grey">e.g. <code>&lt;meta name="webutation-site-verification" content="<font color="red">webutationadd55e935f38ea21b8be38a585ffe255</font>" /&gt;</code></font>
							</div>
						</td>
					</tr>

				</table>
				
				<div class="submit">
					<input name="my_claimit_update_setting" type="hidden"
					value="<?php echo wp_create_nonce('claimit-update-setting'); ?>" /> <input
					type="submit" name="update_webmaster" class="button-primary"
					value="<?php _e('Save Changes'); ?>" />
				</div>
			
				<?php } elseif ($active_tab == 'analytics') { ?>
				<?php } elseif ($active_tab == 'header_footer') { ?>
				
				<h3>Extra HTML code to be inserted in to Header or Footer Section</h3>

				<table class="form-table">
					<tr valign="top">
						<th scope="row" style="width:200px;"><label>Header (HTML Only)</label></th>
						<td>
							<textarea name="text_claimit_header_section" cols="80"
								rows="8"><?php echo get_option('claimit_header_section'); ?></textarea>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" style="width:200px;"><label>Body (HTML Only)</label></th>
						<td>
							<textarea name="text_claimit_body_section" cols="80"
								rows="8"><?php echo get_option('claimit_body_section'); ?></textarea>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" style="width:200px;"><label>Footer (HTML Only)</label></th>
						<td>
							<textarea name="text_claimit_footer_section"cols="80"
								rows="8"><?php echo get_option('claimit_footer_section'); ?></textarea>
						</td>
					</tr>
				</table>
				
				<div class="submit">
					<input name="my_claimit_update_setting" type="hidden"
					value="<?php echo wp_create_nonce('claimit-update-setting'); ?>" /> <input
					type="submit" name="update_headerfooter" class="button-primary"
					value="<?php _e('Save Changes'); ?>" />
				</div>
				
			<?php } ?>

			<h2><b>ClaimIt</b> <?php _e('Description', 'claimit'); ?></h2>
			<p><em><?php _e('You are using', 'claimit'); ?> <b>ClaimIt</b> <?php _e('version', 'claimit'); ?> <b><?php echo CLAIMIT_VERSION; ?></b>.</em></p>
			<p><?php _e('Claim your website on webmaster tools like in Google, Bing, Yandex, etc.', 'claimit'); ?></p>

			<p>For more information and updates, visit the <a href="https://www.rizonesoft.com/" rel="external">official web site</a></p>

		</form>

	</div>

<?php
}

function claimit_admin() {
	add_options_page(__('Webmaster', 'claimit'), __('Webmaster', 'claimit'), 'manage_options', 'claimit', 'claimit_options_page');

}

add_filter( 'plugin_action_links', 'claimit_add_action_links', 10, 5 );
add_filter( 'plugin_row_meta', 'claimit_row_meta', 10, 2 );

function claimit_add_action_links( $actions, $plugin_file ) {
 
 $action_links = array(
   'documentation' => array(
      'label' => __('Documentation', 'claimit'),
      'url' => 'https://www.rizonesoft.com/wordpress/claimit/'
       ),
    'settings' => array(
      'label' => __('Settings', 'claimit'),
      'url' => 'options-general.php?page=claimit'
       )
   );
 
  return claimit_plugin_action_links( $actions, $plugin_file, $action_links, 'before');
}

function claimit_row_meta( $actions, $plugin_file ) {
 
 $action_links = array(
 
   'donate' => array(
      'label' => __('Donate', 'claimit'),
      'url'   => 'https://www.paypal.me/rizonesoft'
    ));
 
  return claimit_plugin_action_links( $actions, $plugin_file, $action_links, 'after');
}

function  claimit_plugin_action_links ( $actions, $plugin_file,  $action_links = array(), $position = 'after' ) { 
 
  static $plugin;
 
  if( !isset($plugin) ) {
      $plugin = plugin_basename( __FILE__ );
  }
 
  if( $plugin == $plugin_file && !empty( $action_links ) ) {
 
     foreach( $action_links as $key => $value ) {
 
        $link = array( $key => '<a href="' . $value['url'] . '">' . $value['label'] . '</a>' );
 
         if( $position == 'after' ) {
 
            $actions = array_merge( $actions, $link );    
 
         } else {
 
            $actions = array_merge( $link, $actions );
         }
 
 
      }//foreach
 
  }// if
 
  return $actions;
 
}

add_action('admin_menu', 'claimit_admin');
add_action('wp_head', 'claimit_header_output');
add_action('wp_footer', 'claimit_footer_output');
add_action('post_submitbox_misc_actions', 'claimit_submit_to_google_button');


function claimit_submit_to_google_button() {

	if ( get_option('claimit_google_submit_button') ) {

		$cep_id = get_the_ID();
	
		$site_url = get_site_url();
		$post_slug_slash = substr(get_permalink(), strlen(get_option('home')));
		$post_slug = ltrim($post_slug_slash, '/');

			$html  = '<div id="major-publishing-actions" style="border-top:0px;background:transparent;">';
			$html .= '<div id="publishing-action" style="margin-bottom:10px;">';
			$html .= '<a class="button-secondary" href="https://www.google.com/webmasters/tools/googlebot-fetch?hl=en&siteUrl='.$site_url.'/&path='.$post_slug.'" target="_blank">Fetch as Google</a>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="clear"></div>';
		if ( get_post_status ( $cep_id ) == 'publish' ) {
			echo $html;
		} else {
		
		}
	
	}
}

?>