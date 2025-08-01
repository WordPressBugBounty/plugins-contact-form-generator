<?php
// no direct access!
defined('ABSPATH') or die("No direct access");

// 2.5.0 fix
if (isset($_GET['page'])) {
    $allowed_pages = ['cfg_fields', 'cfg_forms', 'cfg_templates'];
    $page = sanitize_text_field($_GET['page']);
    $act  = isset($_GET['act']) ? sanitize_text_field($_GET['act']) : '';

    if (
        in_array($page, $allowed_pages, true) &&
        $act !== 'cfg_submit_data' &&
        !isset($_REQUEST['cfg_token'])
    ) {
        $cfg_token = bin2hex(random_bytes(32));
        $_SESSION['cfg_token'] = $cfg_token;
    }
}

// 2.7.0 fix
$session_cfg_token = isset($_SESSION["cfg_token"]) ? sanitize_text_field($_SESSION["cfg_token"]) : '';


function cfgen_admin() {
	global $wpcfg_options;
	ob_start(); ?>
	<div class="wrap">
		<?php include ('admin/header.php');?>
		<?php include ('admin/content.php');?>
		<?php include ('admin/footer.php');?>
	</div>
	<?php
	echo ob_get_clean();
}

function cfgen_add_options_link() {
	$icon_url=plugins_url( '/images/project_16.png' , __FILE__ );
	
	add_menu_page('Contact Form Generator', 'Contact Form Generator', 'manage_options', 'contactformgenerator', 'cfgen_admin', $icon_url);
	
	$page1 = add_submenu_page('contactformgenerator', 'Contact Form Generator Overview', 'Overview', 'manage_options', 'contactformgenerator', 'cfgen_admin');
	$page2 = add_submenu_page('contactformgenerator', 'Forms', 'Forms', 'manage_options', 'cfg_forms', 'cfgen_admin');
	$page3 = add_submenu_page('contactformgenerator', 'Fields', 'Fields', 'manage_options', 'cfg_fields', 'cfgen_admin');
	$page4 = add_submenu_page('contactformgenerator', 'Templates', 'Templates', 'manage_options', 'cfg_templates', 'cfgen_admin');
	
	add_action('admin_print_scripts-' . $page1, 'cfgen_load_overview_scripts');
	add_action('admin_print_scripts-' . $page2, 'cfgen_load_forms_scripts');
	add_action('admin_print_scripts-' . $page3, 'cfgen_load_fields_scripts');
	add_action('admin_print_scripts-' . $page4, 'cfgen_load_template_scripts');
}

function cfgen_register_settings() {
	// creates our settings in the options table
	register_setting('wpcfg_settings_group', 'wpcfg_settings');
}

function cfgen_load_overview_scripts() {
	global $wpcfg_plugin_version;

	wp_enqueue_style('wpcfg-styles10', plugin_dir_url( __FILE__ ) . 'css/admin.css', false, $wpcfg_plugin_version);
	wp_enqueue_script('wpcfg-script1', plugin_dir_url( __FILE__ ) . 'js/admin.js', array('jquery'), $wpcfg_plugin_version);
}
function cfgen_load_forms_scripts() {
	global $wpcfg_plugin_version;

	wp_enqueue_style('wpgs-styles9', plugin_dir_url( __FILE__ ) . 'css/ui-lightness/jquery-ui-1.10.1.custom.css', false, $wpcfg_plugin_version);
	wp_enqueue_style('wpcfg-styles10', plugin_dir_url( __FILE__ ) . 'css/admin.css', false, $wpcfg_plugin_version);

	wp_enqueue_script('wpcfg-script14', plugin_dir_url( __FILE__ ) . 'js/admin.js', array('jquery','jquery-ui-core','jquery-ui-sortable', 'jquery-ui-dialog','jquery-ui-tabs'), $wpcfg_plugin_version);
	//wp_enqueue_script('wpcfg-script15', plugin_dir_url( __FILE__ ) . 'js/admin.js',array('jquery','jquery-ui-core','jquery-ui-accordion','jquery-ui-tabs','jquery-ui-slider'));
}
function cfgen_load_fields_scripts() {
	global $wpcfg_plugin_version;

	wp_enqueue_style('wpgs-styles9', plugin_dir_url( __FILE__ ) . 'css/ui-lightness/jquery-ui-1.10.1.custom.css', false, $wpcfg_plugin_version);
	wp_enqueue_style('wpcfg-styles10', plugin_dir_url( __FILE__ ) . 'css/admin.css', false, $wpcfg_plugin_version);
	wp_enqueue_style('wpcfg-styles11', plugin_dir_url( __FILE__ ) . 'css/options_styles.css', false, $wpcfg_plugin_version);

	wp_enqueue_script('wpcfg-script14', plugin_dir_url( __FILE__ ) . 'js/admin.js', array('jquery'), $wpcfg_plugin_version);
	//wp_enqueue_script('wpcfg-script15', plugin_dir_url( __FILE__ ) . 'js/admin.js',array('jquery','jquery-ui-core','jquery-ui-accordion','jquery-ui-tabs','jquery-ui-slider'));
	wp_enqueue_script('wpcfg-script15', plugin_dir_url( __FILE__ ) . 'js/options_functions.js',array('jquery','jquery-ui-core','jquery-ui-sortable', 'jquery-ui-dialog','jquery-ui-tabs'), $wpcfg_plugin_version);
}
function cfgen_load_template_scripts() {
	global $wpcfg_plugin_version;

	wp_enqueue_style('wpgs-styles1', plugin_dir_url( __FILE__ ) . 'css/ui-lightness/jquery-ui-1.10.1.custom.css', false,  $wpcfg_plugin_version);
	wp_enqueue_style('wpcfg-styles2', plugin_dir_url( __FILE__ ) . 'css/admin.css', false,  $wpcfg_plugin_version);
	wp_enqueue_style('wpcfg-styles3', plugin_dir_url( __FILE__ ) . 'css/colorpicker.css', false,  $wpcfg_plugin_version);
	wp_enqueue_style('wpcfg-styles4', plugin_dir_url( __FILE__ ) . 'css/layout.css', false,  $wpcfg_plugin_version);
	wp_enqueue_style('wpcfg-styles5', plugin_dir_url( __FILE__ ) . 'css/temp_j3.css', false,  $wpcfg_plugin_version);
	wp_enqueue_style('wpcfg-styles6', plugin_dir_url( __FILE__ ) . 'assets/css/cfg-tooltip.css', false,  $wpcfg_plugin_version);
	wp_enqueue_style('wpcfg-styles7', plugin_dir_url( __FILE__ ) . 'assets/css/cfg-datepicker.css', false,  $wpcfg_plugin_version);
	wp_enqueue_style('wpcfg-styles8', plugin_dir_url( __FILE__ ) . 'css/main.css', false,  $wpcfg_plugin_version);

	wp_enqueue_script('wpcfg-script1', plugin_dir_url( __FILE__ ) . 'js/admin.js', array('jquery','jquery-ui-core','jquery-ui-sortable', 'jquery-ui-dialog','jquery-ui-tabs'), $wpcfg_plugin_version);
	wp_enqueue_script('wpcfg-script2', plugin_dir_url( __FILE__ ) . 'js/colorpicker.js', array('jquery','jquery-ui-core'), $wpcfg_plugin_version);
	wp_enqueue_script('wpcfg-script3', plugin_dir_url( __FILE__ ) . 'js/eye.js', array('jquery','jquery-ui-core'), $wpcfg_plugin_version);
	wp_enqueue_script('wpcfg-script4', plugin_dir_url( __FILE__ ) . 'js/utils.js', array('jquery','jquery-ui-core'), $wpcfg_plugin_version);
}

add_action('admin_menu', 'cfgen_add_options_link');
add_action('admin_init', 'cfgen_register_settings');