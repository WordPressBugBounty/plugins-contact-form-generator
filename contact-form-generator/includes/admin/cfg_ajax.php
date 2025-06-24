<?php
// no direct access!
defined('ABSPATH') or die("No direct access");

global $wpdb;
error_reporting(0);
//header('Content-type: application/json');

$id = isset($_POST['menu_id']) ? absint($_POST['menu_id']) : 0;
$type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';
$name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
$value = isset($_POST['value']) ? sanitize_text_field($_POST['value']) : '';
$selected = isset($_POST['selected']) ? sanitize_text_field($_POST['selected']) : '';


// 2.5.0 fix, security check
if($type != "hide_rate_us") {
	$cfg_token = isset($_REQUEST['cfg_token']) ? sanitize_text_field($_REQUEST['cfg_token']) : '';
	if($cfg_token == "" || $cfg_token != $_SESSION["cfg_token"]) {

		echo "Restricted";
		exit();
	}
}

if($type == 'get_data') {
	//get form configuration
    $query = $wpdb->prepare(
        "SELECT spo.`name`, spo.`value`, spo.`selected`
	 FROM `{$wpdb->prefix}cfg_form_options` spo
	 WHERE spo.id = %d",
        $id
    );
    $option_data = $wpdb->get_row($query);

	$option_name = esc_html($option_data->name);
	$option_value = esc_html($option_data->value);
	$option_selected = $option_data->selected;
	?>
	<form method="post" action="" enctype="multipart/form-data" id="menu_edit_form">
		<div id="menus_info_tabs">
			<ul>
				<li><a href="#tabs-1">Option data</a></li>
			</ul>
			<div id="tabs-1" style="background-color: #fff3d6">
				<table border="0" cellpadding="2" cellspacing="1" style="margin: 8px 2px 3px 2px;padding: 0;width:100%">
					<tr>
						<td style="width: 100px;">
							Name
						</td>
						<td>
							<input type="text" id="new_title" name="new_title" value="<?php echo $option_name;?>"/>
						</td>
					</tr>
					<tr>
						<td style="width: 100px;">
							Value
						</td>
						<td>
							<input type="text" id="new_value" name="new_value" value="<?php echo $option_value;?>"/>
						</td>
					</tr>
					<tr>
						<td style="width: 100px;">
							Selected
						</td>
						<td valign="middle">
							<input type="radio" value="0" <?php if($option_selected == 0) echo 'checked="checked"';?> name="option_selected"  id="check_option_0"/> <label style="display: inline-block;" for="check_option_0">No</label>&nbsp;&nbsp;
							<input type="radio" value="1" <?php if($option_selected == 1) echo 'checked="checked"';?> name="option_selected" id="check_option_1"/> <label style="display: inline-block;" for="check_option_1" >Yes</label>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="right" style="margin-top: 10px;">
							<button id="submit_options_form" class="btn btn-small btn-success"><i class="icon-apply icon-white"></i>Save</button>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</form>
	<?php
}
elseif($type == 'new_option_data') {
	//get form configuration
	?>
	<form method="post" action="" enctype="multipart/form-data" id="menu_edit_form">
		<div id=menus_info_tabs>
			<ul>
				<li><a href="#tabs-1">Option data</a></li>
			</ul>
			<div id="tabs-1" style="background-color: #fff3d6">
				<table border="0" cellpadding="2" cellspacing="1" style="margin: 8px 2px 3px 2px;padding: 0;width:100%">
					<tr>
						<td style="width: 100px;">
							Name
						</td>
						<td>
							<input type="text" id="new_title" name="new_title" value="" placeholder="Option name"/>
						</td>
					</tr>
					<tr>
						<td style="width: 100px;">
							Selected
						</td>
						<td valign="middle">
							<input type="radio" value="0" checked="checked" name="option_selected" id="check_option_0"/> <label style="display: inline-block;" for="check_option_0">No</label>&nbsp;&nbsp;
							<input type="radio" value="1"  name="option_selected" id="check_option_1"/> <label style="display: inline-block;" for="check_option_1" >Yes</label>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="right" style="margin-top: 10px;">
							<button id="submit_new_option_form" class="btn btn-small btn-success"><i class="icon-apply icon-white"></i>Add</button>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</form>
	<?php
}
elseif($type == 'save_data') {
	//get form configuration
    echo $query = $wpdb->prepare(
        "
		UPDATE `{$wpdb->prefix}cfg_form_options`
		SET `name` = %s,
		    `value` = %s,
		    `selected` = %s
		WHERE id = %d
	",
        $name,
        $value,
        $selected,
        $id
    );

    $wpdb->query($query);
}
elseif($type == 'save_new_option_data') {
	//get ordering
    $ordering = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT MAX(`ordering`) as maxorder FROM `{$wpdb->prefix}cfg_form_options` WHERE `id_parent` = %d",
            $id
        )
    );


	$ordering ++;
	$ordering = intval($ordering);

	$query = $wpdb->prepare(
	"
	INSERT INTO 
		`".$wpdb->prefix."cfg_form_options` (`name`,`value`,`selected`,`ordering`,`id_parent`)
	VALUES 
		(%s,%s,%s,%d,%d)",
        $name,
        $value,
        $selected,
        $ordering,
        $id
	);

	$wpdb->query($query);
	$insertid = esc_attr($wpdb->insert_id);
	
	?>
	<li class=" ui-state-default text" id="option_li_<?php echo $insertid;?>">
		<div class="option_item" id="option_<?php echo $insertid;?>"><?php echo esc_html($name);?></div>
		<div class="menu_moove" title="Move option" >&nbsp;</div>
		<div id="edit_<?php echo $insertid;?>" menu_id="<?php echo $insertid;?>" class="edit" title="Edit option" >&nbsp;</div>
		<div id="showrow_<?php echo $insertid;?>" menu_id="<?php echo $insertid;?>" class="hide" title="Unpublish option" >&nbsp;</div>
		<div id="remove_<?php echo $insertid;?>" menu_id="<?php echo $insertid;?>" class="delete" title="Delete option" >&nbsp;</div>
	</li>
	<?php 
}
elseif($type == 'show_unpublish_wrapper') {
	//get form configuration
	?>
	<div style="background-color: #fff3d6;padding: 15px;">
		<div style="margin: 5px 5px 15px 5px;text-align: center">Unpublish option?</div>
		<button id="submit_hide_option" class="btn btn-small btn-success"><i class="icon-apply icon-white"></i>Unpublish</button>
	</div>
	<?php 
}
elseif($type == 'show_publish_wrapper') {
	//get form configuration
	?>
	<div style="background-color: #fff3d6;padding: 15px;">
		<div style="margin: 5px 5px 15px 5px;text-align: center">Publish option?</div>
		<button id="submit_show_option" class="btn btn-small btn-success"><i class="icon-apply icon-white"></i>Publish</button>
	</div>
	<?php 
}
elseif($type == 'show_delete_wrapper') {
	//get form configuration
	?>
	<div style="background-color: #fff3d6;padding: 15px;">
		<div style="margin: 5px 5px 15px 5px;text-align: center">Delete option?</div>
		<button id="submit_delete_option" class="btn btn-small btn-success"><i class="icon-apply icon-white"></i>Delete</button>
	</div>
	<?php 
}
elseif($type == 'unpublish_data') {
	//get form configuration
    $query = $wpdb->prepare(
        "
    UPDATE `{$wpdb->prefix}cfg_form_options`
    SET `showrow` = %d
    WHERE id = %d
    ",
        0,   // showrow = 0
        $id
    );
    $wpdb->query($query);
}
elseif($type == 'delete_data') {
	//get form configuration
    $query = $wpdb->prepare(
        "DELETE FROM `{$wpdb->prefix}cfg_form_options` WHERE id = %d",
        $id
    );
    $wpdb->query($query);
}
elseif($type == 'publish_data') {
	//get form configuration

    $query = $wpdb->prepare(
        "UPDATE `{$wpdb->prefix}cfg_form_options` SET `showrow` = %d WHERE id = %d",
        1,
        $id
    );
    $wpdb->query($query);
}
elseif($type == 'reorder_options') {
	//get form configuration
    $order = sanitize_text_field($_POST['order']);
    $order = str_replace('option_li_', '', $order);
    $order_array = explode(',', $order);
    $order_array = array_filter($order_array, 'is_numeric');

    if (!empty($order_array)) {
        $query = "UPDATE `{$wpdb->prefix}cfg_form_options` SET `ordering` = CASE `id`";
        $ids = [];

        foreach ($order_array as $key => $val) {
            $id = (int) $val;
            $ord = $key + 1;
            $query .= " WHEN {$id} THEN {$ord}";
            $ids[] = $id;
        }

        $id_list = implode(',', array_map('intval', $ids));
        $query .= " END WHERE `id` IN ({$id_list})";

        $wpdb->query($query);
    }
}
elseif($type == 'reorder') {
    $table_name = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['table_name']);
    $order = str_replace('option_li_', '', $_POST['order']);
    $order_array = array_map('intval', explode(',', $order));

    $query = "UPDATE `{$table_name}` SET `ordering` = CASE `id` ";
    foreach ($order_array as $key => $id) {
        $ordering = $key + 1;
        $query .= $wpdb->prepare("WHEN %d THEN %d ", $id, $ordering);
    }

    $ids_placeholder = implode(',', array_fill(0, count($order_array), '%d'));
    $where_in = $wpdb->prepare(" WHERE `id` IN ($ids_placeholder)", ...$order_array);
    $query .= "END" . $where_in;
    $wpdb->query($query);
}
elseif($type == 'reorder_list') {
    // Sanitize table name: allow only letters, numbers, underscores (adjust if needed)
    $table_name = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['table_name']);
    $order = str_replace('option_li_', '', $_POST['order']);
    $order_array = explode(',', $order);
    $order_final_array = [];

    foreach ($order_array as $val) {
        $val_arr = explode('_', $val);

        if (count($val_arr) !== 2) {
            continue; // skip malformed entries
        }
        // Cast to int for safety
        $field_id = intval($val_arr[0]);
        $form_id = intval($val_arr[1]);

        $order_final_array[$form_id][] = $field_id;
    }

    foreach ($order_final_array as $form_id => $ids_array) {
        if (empty($ids_array)) {
            continue;
        }

        $placeholders = implode(',', array_fill(0, count($ids_array), '%d'));
        $query = "UPDATE `{$table_name}` SET `ordering` = CASE `id` ";

        foreach ($ids_array as $key => $id) {
            $ordering = $key + 1;
            // Use prepare to avoid injection
            $query .= $wpdb->prepare("WHEN %d THEN %d ", $id, $ordering);
        }

        $query .= "END WHERE `id` IN ($placeholders)";
        $wpdb->query($wpdb->prepare($query, ...$ids_array));
    }

}
elseif($type == 'hide_rate_us') {
	$_SESSION['wpcfg_rate_us_counter'] = 100;
}

exit();
?>