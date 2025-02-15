<?php
/*
  Plugin Name: WP PayPal
  Version: 1.2.3.3
  Plugin URI: https://wphowto.net/wordpress-paypal-plugin-732
  Author: naa986
  Author URI: https://wphowto.net/
  Description: Easily accept PayPal payments in WordPress
  Text Domain: wp-paypal
  Domain Path: /languages
 */

if (!defined('ABSPATH'))
    exit;

class WP_PAYPAL {
    
    var $plugin_version = '1.2.3.3';
    var $plugin_url;
    var $plugin_path;
    
    function __construct() {
        define('WP_PAYPAL_VERSION', $this->plugin_version);
        define('WP_PAYPAL_SITE_URL', site_url());
        define('WP_PAYPAL_HOME_URL', home_url());
        define('WP_PAYPAL_URL', $this->plugin_url());
        define('WP_PAYPAL_PATH', $this->plugin_path());
        $debug_enabled = get_option('wp_paypal_enable_debug');
        if (isset($debug_enabled) && !empty($debug_enabled)) {
            define('WP_PAYPAL_DEBUG', true);
        } else {
            define('WP_PAYPAL_DEBUG', false);
        }
        $use_sandbox = get_option('wp_paypal_enable_testmode');
        if (isset($use_sandbox) && !empty($use_sandbox)) {
            define('WP_PAYPAL_USE_SANDBOX', true);
        } else {
            define('WP_PAYPAL_USE_SANDBOX', false);
        }
        define('WP_PAYPAL_DEBUG_LOG_PATH', $this->debug_log_path());
        $this->plugin_includes();
        $this->loader_operations();
    }

    function plugin_includes() {
        include_once('wp-paypal-order.php');
        include_once('paypal-ipn.php');
        if(is_admin()){
            include_once('extensions/wp-paypal-extensions-menu.php');
        }
    }

    function loader_operations() {
        register_activation_hook(__FILE__, array($this, 'activate_handler'));
        add_action('plugins_loaded', array($this, 'plugins_loaded_handler'));
        if (is_admin()) {
            add_filter('plugin_action_links', array($this, 'add_plugin_action_links'), 10, 2);
        }
        add_action('admin_notices', array($this, 'admin_notice'));
        add_action('wp_enqueue_scripts', array($this, 'plugin_scripts'));
        add_action('admin_menu', array($this, 'add_options_menu'));
        add_action('init', array($this, 'plugin_init'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_filter('manage_wp_paypal_order_posts_columns', 'wp_paypal_order_columns');
        add_action('manage_wp_paypal_order_posts_custom_column', 'wp_paypal_custom_column', 10, 2);
        add_shortcode('wp_paypal', 'wp_paypal_button_handler');
    }

    function plugins_loaded_handler() {  //Runs when plugins_loaded action gets fired
        load_plugin_textdomain( 'wp-paypal', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
        $this->check_upgrade();
    }

    function admin_notice() {
        if (WP_PAYPAL_DEBUG) {  //debug is enabled. Check to make sure log file is writable
            $real_file = WP_PAYPAL_DEBUG_LOG_PATH;
            if (!is_writeable($real_file)) {
                echo '<div class="updated"><p>' . __('WP PayPal Debug log file is not writable. Please check to make sure that it has the correct file permission (ideally 644). Otherwise the plugin will not be able to write to the log file. The log file (log.txt) can be found in the root directory of the plugin - ', 'wp-paypal') . '<code>' . WP_PAYPAL_URL . '</code></p></div>';
            }
        }
    }

    function activate_handler() {
        add_option('wp_paypal_plugin_version', $this->plugin_version);
        add_option('wp_paypal_email', get_bloginfo('admin_email'));
        add_option('wp_paypal_currency_code', 'USD');
    }

    function check_upgrade() {
        if (is_admin()) {
            $plugin_version = get_option('wp_paypal_plugin_version');
            if (!isset($plugin_version) || $plugin_version != $this->plugin_version) {
                $this->activate_handler();
                update_option('wp_paypal_plugin_version', $this->plugin_version);
            }
        }
    }

    function plugin_init() {
        //register orders
        wp_paypal_order_page();
        //process PayPal IPN
        wp_paypal_process_ipn();
    }

    function add_meta_boxes() {
        //add_meta_box('wp-paypal-order-box', __('Edit PayPal Order', 'wp-paypal'), 'wp_paypal_order_meta_box', 'wp_paypal_order', 'normal', 'high');
    }

    function plugin_scripts() {
        if (!is_admin()) {
            
        }
    }

    function plugin_url() {
        if ($this->plugin_url)
            return $this->plugin_url;
        return $this->plugin_url = plugins_url(basename(plugin_dir_path(__FILE__)), basename(__FILE__));
    }

    function plugin_path() {
        if ($this->plugin_path)
            return $this->plugin_path;
        return $this->plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
    }

    function debug_log_path() {
        return WP_PAYPAL_PATH . '/log.txt';
    }

    function add_plugin_action_links($links, $file) {
        if ($file == plugin_basename(dirname(__FILE__) . '/main.php')) {
            $links[] = '<a href="'.esc_url(admin_url('edit.php?post_type=wp_paypal_order&page=wp-paypal-settings')).'">'.__('Settings', 'wp-paypal').'</a>';
        }
        return $links;
    }

    function add_options_menu() {
        if (is_admin()) {
            add_submenu_page('edit.php?post_type=wp_paypal_order', __('Settings', 'wp-paypal'), __('Settings', 'wp-paypal'), 'manage_options', 'wp-paypal-settings', array($this, 'options_page'));
            add_submenu_page('edit.php?post_type=wp_paypal_order', __('Debug', 'wp-paypal'), __('Debug', 'wp-paypal'), 'manage_options', 'wp-paypal-debug', array($this, 'debug_page'));
            add_submenu_page('edit.php?post_type=wp_paypal_order', __('Extensions', 'wp-paypal'), __('Extensions', 'wp-paypal'), 'manage_options', 'wp-paypal-extensions', 'wp_paypal_display_extensions_menu');
        }
    }

    function options_page() {
        $plugin_tabs = array(
            'wp-paypal-settings' => __('General', 'wp-paypal')
        );
        echo '<div class="wrap"><h2>'.__('WP PayPal', 'wp-paypal').' v' . WP_PAYPAL_VERSION . '</h2>';
        $url = 'https://wphowto.net/wordpress-paypal-plugin-732';
        $link_msg = sprintf( wp_kses( __( 'Please visit the <a target="_blank" href="%s">WP PayPal</a> documentation page for usage instructions.', 'wp-paypal' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( $url ) );
        echo '<div class="update-nag">'.$link_msg.'</div>';
        echo '<div id="poststuff"><div id="post-body">';

        if (isset($_GET['page'])) {
            $current = $_GET['page'];
            if (isset($_GET['action'])) {
                $current .= "&action=" . $_GET['action'];
            }
        }
        $content = '';
        $content .= '<h2 class="nav-tab-wrapper">';
        foreach ($plugin_tabs as $location => $tabname) {
            if ($current == $location) {
                $class = ' nav-tab-active';
            } else {
                $class = '';
            }
            $content .= '<a class="nav-tab' . $class . '" href="?post_type=wp_paypal_order&page=' . $location . '">' . $tabname . '</a>';
        }
        $content .= '</h2>';
        echo $content;

        $this->general_settings();

        echo '</div></div>';
        echo '</div>';
    }

    function general_settings() {
        if (isset($_POST['wp_paypal_update_settings'])) {
            $nonce = $_REQUEST['_wpnonce'];
            if (!wp_verify_nonce($nonce, 'wp_paypal_general_settings')) {
                wp_die('Error! Nonce Security Check Failed! please save the settings again.');
            }
            update_option('wp_paypal_enable_testmode', (isset($_POST["enable_testmode"]) && $_POST["enable_testmode"] == '1') ? '1' : '');
            update_option('wp_paypal_merchant_id', sanitize_text_field($_POST["paypal_merchant_id"]));
            update_option('wp_paypal_email', sanitize_text_field($_POST["paypal_email"]));
            update_option('wp_paypal_currency_code', sanitize_text_field($_POST["currency_code"]));
            echo '<div id="message" class="updated fade"><p><strong>';
            echo __('Settings Saved', 'wp-paypal').'!';
            echo '</strong></p></div>';
        }
        ?>
        <table class="wppaypal-general-settings-table">
            <tbody>
                <tr>
                    <td valign="top">
                        <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                            <?php wp_nonce_field('wp_paypal_general_settings'); ?>

                            <table class="form-table">

                                <tbody>

                                    <tr valign="top">
                                        <th scope="row"><?Php _e('Enable Test Mode', 'wp-paypal');?></th>
                                        <td> <fieldset><legend class="screen-reader-text"><span>Enable Test Mode</span></legend><label for="enable_testmode">
                                                    <input name="enable_testmode" type="checkbox" id="enable_testmode" <?php if (get_option('wp_paypal_enable_testmode') == '1') echo ' checked="checked"'; ?> value="1">
                                                    <?Php _e('Check this option if you want to enable PayPal sandbox for testing', 'wp-paypal');?></label>
                                            </fieldset></td>
                                    </tr>

                                    <tr valign="top">
                                        <th scope="row"><label for="paypal_merchant_id"><?Php _e('PayPal Merchant ID', 'wp-paypal');?></label></th>
                                        <td><input name="paypal_merchant_id" type="text" id="paypal_merchant_id" value="<?php echo get_option('wp_paypal_merchant_id'); ?>" class="regular-text">
                                            <p class="description"><?Php _e('Your PayPal Merchant ID', 'wp-paypal');?></p></td>
                                    </tr>

                                    <tr valign="top">
                                        <th scope="row"><label for="paypal_email"><?Php _e('PayPal Email', 'wp-paypal');?></label></th>
                                        <td><input name="paypal_email" type="text" id="paypal_email" value="<?php echo get_option('wp_paypal_email'); ?>" class="regular-text">
                                            <p class="description"><?Php _e('Your PayPal email address', 'wp-paypal');?></p></td>
                                    </tr>

                                    <tr valign="top">
                                        <th scope="row"><label for="currency_code"><?Php _e('Currency Code', 'wp-paypal');?></label></th>
                                        <td><input name="currency_code" type="text" id="currency_code" value="<?php echo get_option('wp_paypal_currency_code'); ?>" class="regular-text">
                                            <p class="description"><?Php _e('The currency of the payment', 'wp-paypal');?> (<?Php _e('example', 'wp-paypal');?>: USD, CAD, GBP, EUR)</p></td>
                                    </tr>

                                </tbody>

                            </table>

                            <p class="submit"><input type="submit" name="wp_paypal_update_settings" id="wp_paypal_update_settings" class="button button-primary" value="<?Php _e('Save Changes', 'wp-paypal');?>"></p></form>
                    </td>
                    <td valign="top" style="width: 300px">
                        <div style="background: #ffc; border: 1px solid #333; margin: 2px; padding: 3px 15px">
                        <h3><?php _e('Need More Features?', 'wp-paypal')?></h3>
                        <ol>
                        <li><?php printf(__('Check out the <a href="%s">plugin extensions</a>.', 'wp-paypal'), 'edit.php?post_type=wp_paypal_order&page=wp-paypal-extensions');?></li>
                        </ol>    
                        <h3><?php _e('Need Help?', 'wp-paypal')?></h3>
                        <ol>
                        <li><?php printf(__('Use the <a href="%s">Debug</a> menu for diagnostics.', 'wp-paypal'), 'edit.php?post_type=wp_paypal_order&page=wp-paypal-debug');?></li>
                        <li><?php printf(__('Check out the <a target="_blank" href="%s">support forum</a> and <a target="_blank" href="%s">FAQ</a>.', 'wp-paypal'), 'https://wordpress.org/support/plugin/wp-paypal/', 'https://wordpress.org/plugins/wp-paypal/#faq');?></li>
                        <li><?php printf(__('Visit the <a target="_blank" href="%s">plugin homepage</a>.', 'wp-paypal'), 'https://wphowto.net/wordpress-paypal-plugin-732');?></li>
                        </ol>
                        <h3><?php _e('Rate This Plugin', 'wp-paypal')?></h3>
                        <p><?php printf(__('Please <a target="_blank" href="%s">rate us</a> and give feedback.', 'wp-paypal'), 'https://wordpress.org/support/plugin/wp-paypal/reviews?rate=5#new-post');?></p>
                        </div>
                    </td>
                </tr>
            </tbody> 
        </table>    
        <?php
    }

    function debug_page() {
        ?>
        <div class="wrap">
            <h2><?Php _e('WP PayPal Debug Log', 'wp-paypal');?></h2>
            <div id="poststuff">
                <div id="post-body">
                    <?php
                    if (isset($_POST['wp_paypal_update_log_settings'])) {
                        $nonce = $_REQUEST['_wpnonce'];
                        if (!wp_verify_nonce($nonce, 'wp_paypal_debug_log_settings')) {
                            wp_die('Error! Nonce Security Check Failed! please save the settings again.');
                        }
                        update_option('wp_paypal_enable_debug', (isset($_POST["enable_debug"]) && $_POST["enable_debug"] == '1') ? '1' : '');
                        echo '<div id="message" class="updated fade"><p>'.__('Settings Saved', 'wp-paypal').'!</p></div>';
                    }
                    if (isset($_POST['wp_paypal_reset_log'])) {
                        $nonce = $_REQUEST['_wpnonce'];
                        if (!wp_verify_nonce($nonce, 'wp_paypal_reset_log_settings')) {
                            wp_die('Error! Nonce Security Check Failed! please save the settings again.');
                        }
                        if (wp_paypal_reset_log()) {
                            echo '<div id="message" class="updated fade"><p>'.__('Debug log file has been reset', 'wp-paypal').'!</p></div>';
                        } else {
                            echo '<div id="message" class="error"><p>'.__('Debug log file could not be reset', 'wp-paypal').'!</p></div>';
                        }
                    }
                    $real_file = WP_PAYPAL_DEBUG_LOG_PATH;
                    $content = file_get_contents($real_file);
                    $content = esc_textarea($content);
                    ?>
                    <div id="template"><textarea cols="70" rows="25" name="wp_paypal_log" id="wp_paypal_log"><?php echo $content; ?></textarea></div>                     
                    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                        <?php wp_nonce_field('wp_paypal_debug_log_settings'); ?>
                        <table class="form-table">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row"><?Php _e('Enable Debug', 'wp-paypal');?></th>
                                    <td> <fieldset><legend class="screen-reader-text"><span>Enable Debug</span></legend><label for="enable_debug">
                                                <input name="enable_debug" type="checkbox" id="enable_debug" <?php if (get_option('wp_paypal_enable_debug') == '1') echo ' checked="checked"'; ?> value="1">
                                                <?Php _e('Check this option if you want to enable debug', 'wp-paypal');?></label>
                                        </fieldset></td>
                                </tr>

                            </tbody>

                        </table>
                        <p class="submit"><input type="submit" name="wp_paypal_update_log_settings" id="wp_paypal_update_log_settings" class="button button-primary" value="<?Php _e('Save Changes', 'wp-paypal');?>"></p>
                    </form>
                    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                        <?php wp_nonce_field('wp_paypal_reset_log_settings'); ?>                            
                        <p class="submit"><input type="submit" name="wp_paypal_reset_log" id="wp_paypal_reset_log" class="button" value="<?Php _e('Reset Log', 'wp-paypal');?>"></p>
                    </form>
                </div>         
            </div>
        </div>
        <?php
    }

}

$GLOBALS['wp_paypal'] = new WP_PAYPAL();

function wp_paypal_button_handler($atts) {
    $atts = array_map('sanitize_text_field', $atts);
    $testmode = get_option('wp_paypal_enable_testmode');
    if (isset($testmode) && !empty($testmode)) {
        $atts['env'] = "sandbox";
    }
    $notify_url = home_url() . '/?wp_paypal_ipn=1';
    if(!isset($atts['notify_url']) || empty($atts['notify_url'])){
        $atts['notify_url'] = $notify_url;
    }
    $paypal_email = get_option('wp_paypal_email');
    $currency = get_option('wp_paypal_currency_code');
    if (isset($atts['currency']) && !empty($atts['currency'])) {
        
    } else {
        $atts['currency'] = $currency;
    }
    
    if(isset($atts['button']) && $atts['button']=="cart"){ 
        $button_code = wp_paypal_get_add_to_cart_button($atts);
    }
    else if(isset($atts['button']) && $atts['button']=="viewcart"){
        $button_code = wp_paypal_get_view_cart_button($atts);
    }
    else if(isset($atts['button']) && $atts['button']=="buynow"){ 
        $button_code = wp_paypal_get_buy_now_button($atts);
    }
    else if(isset($atts['button']) && $atts['button']=="donate"){
        $button_code = wp_paypal_get_donate_button($atts);
    }
    else if(isset($atts['button']) && $atts['button']=="subscribe"){
        $button_code = wp_paypal_get_subscribe_button($atts);
    }
    else{
        $button_code = __('Please enter a correct button type', 'wp-paypal');
    }
    return $button_code;
}

function wp_paypal_get_add_to_cart_button($atts){
    $button_code = '';
    $action_url = 'https://www.paypal.com/cgi-bin/webscr';
    if(isset($atts['env']) && $atts['env'] == "sandbox"){
        $action_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    }
    $target = '';
    if(isset($atts['target']) && !empty($atts['target'])) {
        $target = 'target="'.esc_attr($atts['target']).'" ';
    }
    $button_code .= '<form '.$target.'action="'.esc_url($action_url).'" method="post" >';
    $button_code .= '<input type="hidden" name="charset" value="utf-8">';
    $button_code .= '<input type="hidden" name="cmd" value="_cart">';
    $button_code .= '<input type="hidden" name="add" value="1">';
    $business = '';
    $paypal_merchant_id = get_option('wp_paypal_merchant_id');
    $paypal_email = get_option('wp_paypal_email');
    if(isset($paypal_merchant_id) && !empty($paypal_merchant_id)) {
        $business = $paypal_merchant_id;
    }
    else if(isset($paypal_email) && !empty($paypal_email)) {
        $business = $paypal_email;
    }
    
    if(isset($business) && !empty($business)) {
        $button_code .= '<input type="hidden" name="business" value="'.esc_attr($business).'">';
    }
    if(isset($atts['lc']) && !empty($atts['lc'])) {
        $lc = $atts['lc'];
        $button_code .= '<input type="hidden" name="lc" value="'.esc_attr($lc).'">';
    }
    if(isset($atts['name']) && !empty($atts['name'])) {
        $name = $atts['name'];
        $button_code .= '<input type="hidden" name="item_name" value="'.esc_attr($name).'">';
    }
    if(isset($atts['item_number']) && !empty($atts['item_number'])) {
        $item_number = $atts['item_number'];
        $button_code .= '<input type="hidden" name="item_number" value="'.esc_attr($item_number).'">';
    }
    if(isset($atts['amount']) && is_numeric($atts['amount'])) {
        $amount = $atts['amount'];
        $button_code .= '<input type="hidden" name="amount" value="'.esc_attr($amount).'">';
    }
    if(isset($atts['currency']) && !empty($atts['currency'])) {
        $currency = $atts['currency'];
        $button_code .= '<input type="hidden" name="currency_code" value="'.esc_attr($currency).'">';
    }
    $button_code .= '<input type="hidden" name="button_subtype" value="products">';
    $no_note = 0; //default
    if(isset($atts['no_note']) && is_numeric($atts['no_note'])) {
        $no_note = $atts['no_note'];
        $button_code .= '<input type="hidden" name="no_note" value="'.esc_attr($no_note).'">';
    }
    if(isset($atts['cn']) && !empty($atts['cn'])) {
        $cn = $atts['cn'];
        $button_code .= '<input type="hidden" name="cn" value="'.esc_attr($cn).'">';
    }
    $no_shipping = 0; //default
    if(isset($atts['no_shipping']) && is_numeric($atts['no_shipping'])) {
        $no_shipping = $atts['no_shipping'];
        $button_code .= '<input type="hidden" name="no_shipping" value="'.esc_attr($no_shipping).'">';
    }
    if(isset($atts['shipping']) && is_numeric($atts['shipping'])) {
        $shipping = $atts['shipping'];
        $button_code .= '<input type="hidden" name="shipping" value="'.esc_attr($shipping).'">';
    }
    if(isset($atts['shipping2']) && is_numeric($atts['shipping2'])) {
        $shipping2 = $atts['shipping2'];
        $button_code .= '<input type="hidden" name="shipping2" value="'.esc_attr($shipping2).'">';
    }
    if(isset($atts['tax']) && is_numeric($atts['tax'])) {
        $tax = $atts['tax'];
        $button_code .= '<input type="hidden" name="tax" value="'.esc_attr($tax).'">';
    }
    if(isset($atts['tax_rate']) && is_numeric($atts['tax_rate'])) {
        $tax_rate = $atts['tax_rate'];
        $button_code .= '<input type="hidden" name="tax_rate" value="'.esc_attr($tax_rate).'">';
    }
    if(isset($atts['handling']) && is_numeric($atts['handling'])) {
        $handling = $atts['handling'];
        $button_code .= '<input type="hidden" name="handling" value="'.esc_attr($handling).'">';
    }
    if(isset($atts['weight']) && is_numeric($atts['weight'])) {
        $weight = $atts['weight'];
        $button_code .= '<input type="hidden" name="weight" value="'.esc_attr($weight).'">';
    }
    if(isset($atts['weight_unit']) && !empty($atts['weight_unit'])) {
        $weight_unit = $atts['weight_unit'];
        $button_code .= '<input type="hidden" name="weight_unit" value="'.esc_attr($weight_unit).'">';
    }
    if(isset($atts['shopping_url']) && filter_var($atts['shopping_url'], FILTER_VALIDATE_URL)){
        $shopping_url = $atts['shopping_url'];
        $button_code .= '<input type="hidden" name="shopping_url" value="'.esc_attr($shopping_url).'">';
    }
    if(isset($atts['return']) && filter_var($atts['return'], FILTER_VALIDATE_URL)){
        $return = $atts['return'];
        $button_code .= '<input type="hidden" name="return" value="'.esc_attr($return).'">';
    }
    if(isset($atts['cancel_return']) && filter_var($atts['cancel_return'], FILTER_VALIDATE_URL)){
        $cancel_return = $atts['cancel_return'];
        $button_code .= '<input type="hidden" name="cancel_return" value="'.esc_attr($cancel_return).'">';
    }
    if(isset($atts['notify_url']) && !empty($atts['notify_url'])) {
        $notify_url = $atts['notify_url'];
        $button_code .= '<input type="hidden" name="notify_url" value="'.esc_attr($notify_url).'">';
    }
    if(isset($atts['custom']) && !empty($atts['custom'])) {
        $custom = $atts['custom'];
        $button_code .= '<input type="hidden" name="custom" value="'.esc_attr($custom).'">';
    }
    $button_code .= '<input type="hidden" name="bn" value="WPPayPal_AddToCart_WPS_US">';
    $button_code = apply_filters('wppaypal_variations', $button_code, $atts);
    if(strpos($button_code, 'Error') !== false){
        return $button_code;
    }
    $button_image_url = WP_PAYPAL_URL.'/images/add-to-cart.png';
    if(isset($atts['button_image']) && filter_var($atts['button_image'], FILTER_VALIDATE_URL)){
        $button_image_url = $atts['button_image'];
    }
    $button_code .= '<input type="image" src="'.esc_url($button_image_url).'" border="0" name="submit">';
    $button_code .= '</form>';
    return $button_code;        
}

function wp_paypal_get_view_cart_button($atts){
    $button_code = '';
    $action_url = 'https://www.paypal.com/cgi-bin/webscr';
    if(isset($atts['env']) && $atts['env'] == "sandbox"){
        $action_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    }
    $target = '';
    if(isset($atts['target']) && !empty($atts['target'])) {
        $target = 'target="'.esc_attr($atts['target']).'" ';
    }
    $button_code .= '<form '.$target.'action="'.esc_url($action_url).'" method="post" >';
    $button_code .= '<input type="hidden" name="charset" value="utf-8">';
    $button_code .= '<input type="hidden" name="cmd" value="_cart">';
    $button_code .= '<input type="hidden" name="display" value="1">';
    if(isset($atts['shopping_url']) && !empty($atts['shopping_url'])) {
        $shopping_url = $atts['shopping_url'];
        $button_code .= '<input type="hidden" name="shopping_url" value="'.esc_attr($shopping_url).'">';
    }
    $business = '';
    $paypal_merchant_id = get_option('wp_paypal_merchant_id');
    $paypal_email = get_option('wp_paypal_email');
    if(isset($paypal_merchant_id) && !empty($paypal_merchant_id)) {
        $business = $paypal_merchant_id;
    }
    else if(isset($paypal_email) && !empty($paypal_email)) {
        $business = $paypal_email;
    }
    
    if(isset($business) && !empty($business)) {
        $button_code .= '<input type="hidden" name="business" value="'.esc_attr($business).'">';
    }
    $button_image_url = WP_PAYPAL_URL.'/images/view-cart.png';
    if(isset($atts['button_image']) && filter_var($atts['button_image'], FILTER_VALIDATE_URL)){
        $button_image_url = $atts['button_image'];
    }
    $button_code .= '<input type="image" src="'.esc_url($button_image_url).'" border="0" name="submit">';
    $button_code .= '</form>';
    return $button_code;        
}

function wp_paypal_get_buy_now_button($atts){
    $button_code = '';
    $action_url = 'https://www.paypal.com/cgi-bin/webscr';
    if(isset($atts['env']) && $atts['env'] == "sandbox"){
        $action_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    }
    $target = '';
    if(isset($atts['target']) && !empty($atts['target'])) {
        $target = 'target="'.esc_attr($atts['target']).'" ';
    }
    $button_code .= '<form '.$target.'action="'.esc_url($action_url).'" method="post" >';
    $button_code .= '<input type="hidden" name="charset" value="utf-8">';
    $button_code .= '<input type="hidden" name="cmd" value="_xclick">';
    $business = '';
    $paypal_merchant_id = get_option('wp_paypal_merchant_id');
    $paypal_email = get_option('wp_paypal_email');
    if(isset($paypal_merchant_id) && !empty($paypal_merchant_id)) {
        $business = $paypal_merchant_id;
    }
    else if(isset($paypal_email) && !empty($paypal_email)) {
        $business = $paypal_email;
    }
    $price_variation = false;
    if(isset($atts['os0_amount0']) && is_numeric($atts['os0_amount0'])) {
        $price_variation = true;
    }
    if(isset($business) && !empty($business)) {
        $button_code .= '<input type="hidden" name="business" value="'.esc_attr($business).'">';
    }
    if(isset($atts['lc']) && !empty($atts['lc'])) {
        $lc = $atts['lc'];
        $button_code .= '<input type="hidden" name="lc" value="'.esc_attr($lc).'">';
    }
    if(isset($atts['name']) && !empty($atts['name'])) {
        $name = $atts['name'];
        $button_code .= '<input type="hidden" name="item_name" value="'.esc_attr($name).'">';
    }
    if(isset($atts['item_number']) && !empty($atts['item_number'])) {
        $item_number = $atts['item_number'];
        $button_code .= '<input type="hidden" name="item_number" value="'.esc_attr($item_number).'">';
    }
    if(!$price_variation){
        $amount_input_code = '';
        $amount_input_code = apply_filters('wppaypal_buynow_custom_amount', $amount_input_code, $button_code, $atts);
        if(!empty($amount_input_code)){
            $button_code .= $amount_input_code;
        }
        else{
            if(isset($atts['amount']) && is_numeric($atts['amount']) && $atts['amount'] > 0) {
                $amount = $atts['amount'];
                $button_code .= '<input type="hidden" name="amount" value="'.esc_attr($amount).'">';
            }
            else{
                $error = __('Amount cannot be empty', 'wp-paypal');
                return $error;
            }
        }
    }
    if(isset($atts['currency']) && !empty($atts['currency'])) {
        $currency = $atts['currency'];
        $button_code .= '<input type="hidden" name="currency_code" value="'.esc_attr($currency).'">';
    }
    $no_shipping = 0; //default
    if(isset($atts['no_shipping']) && is_numeric($atts['no_shipping'])) {
        $no_shipping = $atts['no_shipping'];
        $button_code .= '<input type="hidden" name="no_shipping" value="'.esc_attr($no_shipping).'">';
    }
    if(isset($atts['shipping']) && is_numeric($atts['shipping'])) {
        $shipping = $atts['shipping'];
        $button_code .= '<input type="hidden" name="shipping" value="'.esc_attr($shipping).'">';
    }
    if(isset($atts['shipping2']) && is_numeric($atts['shipping2'])) {
        $shipping2 = $atts['shipping2'];
        $button_code .= '<input type="hidden" name="shipping2" value="'.esc_attr($shipping2).'">';
    }
    if(isset($atts['tax']) && is_numeric($atts['tax'])) {
        $tax = $atts['tax'];
        $button_code .= '<input type="hidden" name="tax" value="'.esc_attr($tax).'">';
    }
    if(isset($atts['tax_rate']) && is_numeric($atts['tax_rate'])) {
        $tax_rate = $atts['tax_rate'];
        $button_code .= '<input type="hidden" name="tax_rate" value="'.esc_attr($tax_rate).'">';
    }
    $button_code = apply_filters('wppaypal_enable_buynow_discount', $button_code, $atts);
    if(isset($atts['handling']) && is_numeric($atts['handling'])) {
        $handling = $atts['handling'];
        $button_code .= '<input type="hidden" name="handling" value="'.esc_attr($handling).'">';
    }
    if(isset($atts['quantity']) && empty($atts['quantity'])) {
        $quantity_input_code = '';
        $quantity_input_code = apply_filters('wppaypal_variable_quantity', $quantity_input_code, $button_code, $atts);
        if(!empty($quantity_input_code)){
            $button_code .= $quantity_input_code;
        }
    }
    if(isset($atts['undefined_quantity']) && is_numeric($atts['undefined_quantity'])) {
        $undefined_quantity = $atts['undefined_quantity'];
        $button_code .= '<input type="hidden" name="undefined_quantity" value="'.esc_attr($undefined_quantity).'">';
    }
    if(isset($atts['weight']) && is_numeric($atts['weight'])) {
        $weight = $atts['weight'];
        $button_code .= '<input type="hidden" name="weight" value="'.esc_attr($weight).'">';
    }
    if(isset($atts['weight_unit']) && !empty($atts['weight_unit'])) {
        $weight_unit = $atts['weight_unit'];
        $button_code .= '<input type="hidden" name="weight_unit" value="'.esc_attr($weight_unit).'">';
    }
    if(isset($atts['return']) && filter_var($atts['return'], FILTER_VALIDATE_URL)){
        $return = $atts['return'];
        $button_code .= '<input type="hidden" name="return" value="'.esc_attr($return).'">';
    }
    if(isset($atts['cancel_return']) && filter_var($atts['cancel_return'], FILTER_VALIDATE_URL)){
        $cancel_return = $atts['cancel_return'];
        $button_code .= '<input type="hidden" name="cancel_return" value="'.esc_attr($cancel_return).'">';
    }
    if(isset($atts['notify_url']) && !empty($atts['notify_url'])) {
        $notify_url = $atts['notify_url'];
        $button_code .= '<input type="hidden" name="notify_url" value="'.esc_attr($notify_url).'">';
    }
    if(isset($atts['custom']) && !empty($atts['custom'])) {
        $custom = $atts['custom'];
        $button_code .= '<input type="hidden" name="custom" value="'.esc_attr($custom).'">';
    }
    $button_code .= '<input type="hidden" name="bn" value="WPPayPal_BuyNow_WPS_US">';
    $button_code = apply_filters('wppaypal_variations', $button_code, $atts);
    if(strpos($button_code, 'Error') !== false){
        return $button_code;
    }
    $button_image_url = WP_PAYPAL_URL.'/images/buy-now.png';
    if(isset($atts['button_image']) && filter_var($atts['button_image'], FILTER_VALIDATE_URL)){
        $button_image_url = $atts['button_image'];
    }
    $button_code .= '<input type="image" src="'.esc_url($button_image_url).'" border="0" name="submit">';
    $button_code .= '</form>';
    return $button_code;        
}

function wp_paypal_get_donate_button($atts){
    $button_code = '';
    $action_url = 'https://www.paypal.com/cgi-bin/webscr';
    if(isset($atts['env']) && $atts['env'] == "sandbox"){
        $action_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    }
    $target = '';
    if(isset($atts['target']) && !empty($atts['target'])) {
        $target = 'target="'.esc_attr($atts['target']).'" ';
    }
    $button_code .= '<form '.$target.'action="'.esc_url($action_url).'" method="post" >';
    $button_code .= '<input type="hidden" name="charset" value="utf-8">';
    $button_code .= '<input type="hidden" name="cmd" value="_donations">';
    $business = '';
    $paypal_merchant_id = get_option('wp_paypal_merchant_id');
    $paypal_email = get_option('wp_paypal_email');
    if(isset($paypal_merchant_id) && !empty($paypal_merchant_id)) {
        $business = $paypal_merchant_id;
    }
    else if(isset($paypal_email) && !empty($paypal_email)) {
        $business = $paypal_email;
    }
    
    if(isset($business) && !empty($business)) {
        $button_code .= '<input type="hidden" name="business" value="'.esc_attr($business).'">';
    }
    if(isset($atts['lc']) && !empty($atts['lc'])) {
        $lc = $atts['lc'];
        $button_code .= '<input type="hidden" name="lc" value="'.esc_attr($lc).'">';
    }
    if(isset($atts['name']) && !empty($atts['name'])) {
        $name = $atts['name'];
        $button_code .= '<input type="hidden" name="item_name" value="'.esc_attr($name).'">';
    }
    if(isset($atts['item_number']) && !empty($atts['item_number'])) {
        $item_number = $atts['item_number'];
        $button_code .= '<input type="hidden" name="item_number" value="'.esc_attr($item_number).'">';
    }
    if(isset($atts['currency']) && !empty($atts['currency'])) {
        $currency = $atts['currency'];
        $button_code .= '<input type="hidden" name="currency_code" value="'.esc_attr($currency).'">';
    }
    $no_shipping = 0; //default
    if(isset($atts['no_shipping']) && is_numeric($atts['no_shipping'])) {
        $no_shipping = $atts['no_shipping'];
        $button_code .= '<input type="hidden" name="no_shipping" value="'.esc_attr($no_shipping).'">';
    }
    if(isset($atts['return']) && filter_var($atts['return'], FILTER_VALIDATE_URL)){
        $return = $atts['return'];
        $button_code .= '<input type="hidden" name="return" value="'.esc_attr($return).'">';
    }
    if(isset($atts['cancel_return']) && filter_var($atts['cancel_return'], FILTER_VALIDATE_URL)){
        $cancel_return = $atts['cancel_return'];
        $button_code .= '<input type="hidden" name="cancel_return" value="'.esc_attr($cancel_return).'">';
    }
    if(isset($atts['notify_url']) && !empty($atts['notify_url'])) {
        $notify_url = $atts['notify_url'];
        $button_code .= '<input type="hidden" name="notify_url" value="'.esc_attr($notify_url).'">';
    }
    if(isset($atts['custom']) && !empty($atts['custom'])) {
        $custom = $atts['custom'];
        $button_code .= '<input type="hidden" name="custom" value="'.esc_attr($custom).'">';
    }
    $button_code .= '<input type="hidden" name="bn" value="WPPayPal_Donate_WPS_US">';
    $button_image_url = WP_PAYPAL_URL.'/images/donate.png';
    if(isset($atts['button_image']) && filter_var($atts['button_image'], FILTER_VALIDATE_URL)){
        $button_image_url = $atts['button_image'];
    }
    $button_code .= '<input type="image" src="'.esc_url($button_image_url).'" border="0" name="submit">';
    $button_code .= '</form>';
    return $button_code;        
}

function wp_paypal_get_subscribe_button($atts){
    $button_code = '';
    $action_url = 'https://www.paypal.com/cgi-bin/webscr';
    if(isset($atts['env']) && $atts['env'] == "sandbox"){
        $action_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    }
    $target = '';
    if(isset($atts['target']) && !empty($atts['target'])) {
        $target = 'target="'.esc_attr($atts['target']).'" ';
    }
    $button_code .= '<form '.$target.'action="'.esc_url($action_url).'" method="post" >';
    $button_code .= '<input type="hidden" name="charset" value="utf-8">';
    $button_code .= '<input type="hidden" name="cmd" value="_xclick-subscriptions">';
    $business = '';
    $paypal_merchant_id = get_option('wp_paypal_merchant_id');
    $paypal_email = get_option('wp_paypal_email');
    if(isset($paypal_merchant_id) && !empty($paypal_merchant_id)) {
        $business = $paypal_merchant_id;
    }
    else if(isset($paypal_email) && !empty($paypal_email)) {
        $business = $paypal_email;
    }
    
    if(isset($business) && !empty($business)) {
        $button_code .= '<input type="hidden" name="business" value="'.esc_attr($business).'">';
    }
    if(isset($atts['lc']) && !empty($atts['lc'])) {
        $lc = $atts['lc'];
        $button_code .= '<input type="hidden" name="lc" value="'.esc_attr($lc).'">';
    }
    if(isset($atts['name']) && !empty($atts['name'])) {
        $name = $atts['name'];
        $button_code .= '<input type="hidden" name="item_name" value="'.esc_attr($name).'">';
    }
    if(isset($atts['item_number']) && !empty($atts['item_number'])) {
        $item_number = $atts['item_number'];
        $button_code .= '<input type="hidden" name="item_number" value="'.esc_attr($item_number).'">';
    }
    if(isset($atts['a1']) && is_numeric($atts['a1'])) {
        $a1 = $atts['a1'];
        $button_code .= '<input type="hidden" name="a1" value="'.esc_attr($a1).'">';
        if(isset($atts['p1']) && is_numeric($atts['p1'])) {
            $p1 = $atts['p1'];
            $button_code .= '<input type="hidden" name="p1" value="'.esc_attr($p1).'">';
        }
        else{
            $button_code = __('Please enter a trial period duration p1', 'wp-paypal');
            return $button_code;
        }
        if(isset($atts['t1']) && !empty($atts['t1'])) {
            $t1 = $atts['t1'];
            $button_code .= '<input type="hidden" name="t1" value="'.esc_attr($t1).'">';
        }
        else{
            $button_code = __('Please enter a trial period units of duration t1', 'wp-paypal');
            return $button_code;
        }
    }
    if(isset($atts['a2']) && is_numeric($atts['a2'])) {
        $a2 = $atts['a2'];
        $button_code .= '<input type="hidden" name="a2" value="'.esc_attr($a2).'">';
        if(isset($atts['p2']) && is_numeric($atts['p2'])) {
            $p2 = $atts['p2'];
            $button_code .= '<input type="hidden" name="p2" value="'.esc_attr($p2).'">';
        }
        else{
            $button_code = __('Please enter a trial period 2 duration p2', 'wp-paypal');
            return $button_code;
        }
        if(isset($atts['t2']) && !empty($atts['t2'])) {
            $t2 = $atts['t2'];
            $button_code .= '<input type="hidden" name="t2" value="'.esc_attr($t2).'">';
        }
        else{
            $button_code = __('Please enter a trial period 2 units of duration t1', 'wp-paypal');
            return $button_code;
        }
    }
    $a3_input_code = '';
    $a3_input_code = apply_filters('wppaypal_subscribe_a3', $a3_input_code, $button_code, $atts);
    if(!empty($a3_input_code)){
        $button_code .= $a3_input_code;
    }
    else{
        if(isset($atts['a3']) && is_numeric($atts['a3']) && $atts['a3'] > 0) {
            $a3 = $atts['a3'];
            $button_code .= '<input type="hidden" name="a3" value="'.esc_attr($a3).'">';
        }
        else{
            $error = __('Please enter a regular subscription price a3', 'wp-paypal');
            return $error;
        }
    }
    if(isset($atts['p3']) && is_numeric($atts['p3'])) {
        $p3 = $atts['p3'];
        $button_code .= '<input type="hidden" name="p3" value="'.esc_attr($p3).'">';
    }
    else{
        $button_code = __('Please enter a subscription duration p3', 'wp-paypal');
        return $button_code;
    }
    if(isset($atts['t3']) && !empty($atts['t3'])) {
        $t3 = $atts['t3'];
        $button_code .= '<input type="hidden" name="t3" value="'.esc_attr($t3).'">';
    }
    else{
        $button_code = __('Please enter a subscription units of duration t3', 'wp-paypal');
        return $button_code;
    }
    if(isset($atts['src']) && is_numeric($atts['src'])) {
        $src = $atts['src'];
        $button_code .= '<input type="hidden" name="src" value="'.esc_attr($src).'">';
        if($src == '1'){
            if(isset($atts['srt']) && is_numeric($atts['srt'])) {
                $srt = $atts['srt'];
                $button_code .= '<input type="hidden" name="srt" value="'.esc_attr($srt).'">';
            }
        }
    }
    if(isset($atts['sra']) && is_numeric($atts['sra'])) {
        $sra = $atts['sra'];
        $button_code .= '<input type="hidden" name="sra" value="'.esc_attr($sra).'">';
    }
    if(isset($atts['currency']) && !empty($atts['currency'])) {
        $currency = $atts['currency'];
        $button_code .= '<input type="hidden" name="currency_code" value="'.esc_attr($currency).'">';
    }
    $button_code .= '<input type="hidden" name="no_note" value="1">'; //For Subscribe buttons, always set no_note to 1
    $no_shipping = 0; //default
    if(isset($atts['no_shipping']) && is_numeric($atts['no_shipping'])) {
        $no_shipping = $atts['no_shipping'];
        $button_code .= '<input type="hidden" name="no_shipping" value="'.esc_attr($no_shipping).'">';
    }
    if(isset($atts['return']) && filter_var($atts['return'], FILTER_VALIDATE_URL)){
        $return = $atts['return'];
        $button_code .= '<input type="hidden" name="return" value="'.esc_attr($return).'">';
    }
    if(isset($atts['cancel_return']) && filter_var($atts['cancel_return'], FILTER_VALIDATE_URL)){
        $cancel_return = $atts['cancel_return'];
        $button_code .= '<input type="hidden" name="cancel_return" value="'.esc_attr($cancel_return).'">';
    }
    if(isset($atts['notify_url']) && !empty($atts['notify_url'])) {
        $notify_url = $atts['notify_url'];
        $button_code .= '<input type="hidden" name="notify_url" value="'.esc_attr($notify_url).'">';
    }
    if(isset($atts['custom']) && !empty($atts['custom'])) {
        $custom = $atts['custom'];
        $button_code .= '<input type="hidden" name="custom" value="'.esc_attr($custom).'">';
    }
    $button_code .= '<input type="hidden" name="bn" value="WPPayPal_Subscribe_WPS_US">';
    $button_image_url = WP_PAYPAL_URL.'/images/subscribe.png';
    if(isset($atts['button_image']) && filter_var($atts['button_image'], FILTER_VALIDATE_URL)){
        $button_image_url = $atts['button_image'];
    }
    $button_code .= '<input type="image" src="'.esc_url($button_image_url).'" border="0" name="submit">';
    $button_code .= '</form>';
    return $button_code;        
}

function wp_paypal_debug_log($msg, $success, $end = false) {
    if (!WP_PAYPAL_DEBUG) {
        return;
    }
    $date_time = date('F j, Y g:i a');//the_date('F j, Y g:i a', '', '', FALSE);
    $text = '[' . $date_time . '] - ' . (($success) ? 'SUCCESS :' : 'FAILURE :') . $msg . "\n";
    if ($end) {
        $text .= "\n------------------------------------------------------------------\n\n";
    }
    // Write to log.txt file
    $fp = fopen(WP_PAYPAL_DEBUG_LOG_PATH, 'a');
    fwrite($fp, $text);
    fclose($fp);  // close file
}

function wp_paypal_debug_log_array($array_msg, $success, $end = false) {
    if (!WP_PAYPAL_DEBUG) {
        return;
    }
    $date_time = date('F j, Y g:i a');//the_date('F j, Y g:i a', '', '', FALSE);
    $text = '[' . $date_time . '] - ' . (($success) ? 'SUCCESS :' : 'FAILURE :') . "\n";
    ob_start();
    print_r($array_msg);
    $var = ob_get_contents();
    ob_end_clean();
    $text .= $var;
    if ($end) {
        $text .= "\n------------------------------------------------------------------\n\n";
    }
    // Write to log.txt file
    $fp = fopen(WP_PAYPAL_DEBUG_LOG_PATH, 'a');
    fwrite($fp, $text);
    fclose($fp);  // close filee
}

function wp_paypal_reset_log() {
    $log_reset = true;
    $date_time = date('F j, Y g:i a');//the_date('F j, Y g:i a', '', '', FALSE);
    $text = '[' . $date_time . '] - SUCCESS : Log reset';
    $text .= "\n------------------------------------------------------------------\n\n";
    $fp = fopen(WP_PAYPAL_DEBUG_LOG_PATH, 'w');
    if ($fp != FALSE) {
        @fwrite($fp, $text);
        @fclose($fp);
    } else {
        $log_reset = false;
    }
    return $log_reset;
}
