<?php 
// no direct access!
defined('ABSPATH') or die("No direct access");

global $wpdb;

// 2.7.0 fix
global $session_cfg_token;

$id = (int) $_POST['id'];
$task = isset($_REQUEST['task']) ? sanitize_text_field($_REQUEST['task']) : '';
$name =  isset($_REQUEST['task']) ? sanitize_text_field($_POST['name']) : '';

// 2.5.0 fix, security check
$cfg_token = isset($_REQUEST['cfg_token']) ? sanitize_text_field($_REQUEST['cfg_token']) : '';
if($cfg_token == "" || $cfg_token != $_SESSION["cfg_token"]) {
	$redirect = "admin.php?page=cfg_templates&error=1";
	header("Location: ".$redirect);
	exit();
}

if($id == 0) {

    $id_template = (int) $_POST['id_template'];
    $sql = $wpdb->prepare(
        "SELECT `styles` FROM `{$wpdb->prefix}cfg_templates` WHERE `id` = %d",
        $id_template
    );
    $styles_json = $wpdb->get_var($sql);
	
	$sql = "SELECT MAX(`ordering`) FROM `".$wpdb->prefix."cfg_templates`";
	$max_order = $wpdb->get_var($sql) + 1;


    $published = isset($_POST['published']) ? (int) $_POST['published'] : 0;
    $max_order = (int) $max_order; // ensure integer

    // Assume $styles is a JSON-encoded string or serialized data you prepared earlier

    $wpdb->query( $wpdb->prepare(
        "
    INSERT INTO {$wpdb->prefix}cfg_templates
    (`name`, `styles`, `published`, `ordering`)
    VALUES (%s, %s, %d, %d)
    ",
        $name, $styles, $published, $max_order
    ) );


	
	$insrtid = (int) $wpdb->insert_id;
	if($insrtid != 0) {
		if($task == 'save')
			$redirect = "admin.php?page=cfg_templates&act=edit&id=".$insrtid;
		elseif($task == 'save_new')
			$redirect = "admin.php?page=cfg_templates&act=new";
		else
			$redirect = "admin.php?page=cfg_templates";
	}
	else
		$redirect = "admin.php?page=cfg_templates&error=1";
}
else {
	$styles = $_REQUEST['styles'];
	$styles_formated = '';
	$ind = 0;
	foreach($styles as $k => $val) {
		$styles_formated .= $k.'~'.$val;
		if($ind != sizeof($styles) - 1)
			$styles_formated .= '|';
		$ind ++;
	}

    $q = $wpdb->query( $wpdb->prepare(
        "
    UPDATE {$wpdb->prefix}cfg_templates
    SET
        `name` = %s, 
        `styles` = %s
    WHERE
        `id` = %d
    ",
        $name, $styles_formated, $id
    ) );

	
	if($q !== false) {
		if($task == 'save')
			$redirect = "admin.php?page=cfg_templates&act=edit&id=".$id;
		elseif($task == 'save_new')
			$redirect = "admin.php?page=cfg_templates&act=new";
		else
			$redirect = "admin.php?page=cfg_templates";
	}
	else
		$redirect = "admin.php?page=cfg_templates&error=1";
}
header("Location: ".$redirect);
exit();
?>