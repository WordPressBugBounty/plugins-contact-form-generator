<?php 
// no direct access!
defined('ABSPATH') or die("No direct access");

global $wpdb;

// 2.7.0 fix
global $session_cfg_token;

$task = isset($_REQUEST['task']) ? sanitize_text_field($_REQUEST['task']) : '';
$ids = isset($_REQUEST['ids']) && is_array($_REQUEST['ids']) ? array_map('sanitize_text_field', $_REQUEST['ids']) : array();
$filter_state = isset($_REQUEST['filter_state']) ? intval($_REQUEST['filter_state']) : 2;
$filter_type = isset($_REQUEST['filter_type']) ? intval($_REQUEST['filter_type']) : 0;
$filter_search = isset($_REQUEST['filter_search']) ? sanitize_text_field($_REQUEST['filter_search']) : '';

$form_id_first = $wpdb->get_var(
    $wpdb->prepare(
        "SELECT MIN(id) FROM {$wpdb->prefix}cfg_forms"
    )
);

$filter_form = (isset($_REQUEST['filter_form']) && (int) $_REQUEST['filter_form'] != 0) ? (int) $_REQUEST['filter_form'] : $form_id_first;

// 2.5.0 fix security check
$cfg_token = isset($_REQUEST['cfg_token']) ? sanitize_text_field($_REQUEST['cfg_token']) : '';
$tokens_validated = true;
if($task != "") {
	if($cfg_token == "" || $cfg_token != $_SESSION["cfg_token"]) {
		$tokens_validated = false;
	}
}

// 2.7.0 fix
$session_cfg_token = isset($_SESSION["cfg_token"]) ? sanitize_text_field($_SESSION["cfg_token"]) : '';

if($tokens_validated) {
	//unpublish task
	if($task == 'unpublish') {
		if(is_array($ids)) {
			foreach($ids as $id) {
				$idk = (int)$id;
				if($idk != 0) {
                    $wpdb->query(
                        $wpdb->prepare(
                            "UPDATE {$wpdb->prefix}cfg_fields SET `published` = %d WHERE `id` = %d",
                            0,
                            $idk
                        )
                    );
				}
			}
		}
	}
	//publish task
	if($task == 'publish') {
		if(is_array($ids)) {
			foreach($ids as $id) {
				$idk = (int)$id;
				if($idk != 0) {
                    $wpdb->query(
                        $wpdb->prepare(
                            "UPDATE {$wpdb->prefix}cfg_fields SET `published` = %d WHERE `id` = %d",
                            1,
                            $idk
                        )
                    );
				}
			}
		}
	}
	//delete task
	if($task == 'delete') {
		if(is_array($ids)) {
			foreach($ids as $id) {
				$idk = (int)$id;
				if($idk != 0) {
					$wpdb->query(
                        $wpdb->prepare(
                            "DELETE FROM {$wpdb->prefix}cfg_fields WHERE `id` = %d",
                            $idk
                        )
                    );
					// delete options
					$wpdb->query(
                        $wpdb->prepare(
                            "DELETE FROM {$wpdb->prefix}cfg_form_options WHERE `id_parent` = %d",
                            $idk
                        )
                    );
                }
			}
		}
	}
}

//get the rows
$where = "WHERE 1=1";
$params = [];

if ($filter_state === 1) {
    $where .= " AND sp.published = %d";
    $params[] = 1;
} elseif ($filter_state === 0) {
    $where .= " AND sp.published = %d";
    $params[] = 0;
}

if (!empty($filter_search)) {
    if (stripos($filter_search, 'id:') === 0) {
        $search_id = (int) substr($filter_search, 3);
        $where .= " AND sp.id = %d";
        $params[] = $search_id;
    } else {
        $where .= " AND sp.name LIKE %s";
        $params[] = '%' . $wpdb->esc_like($filter_search) . '%';
    }
}

if (!empty($filter_type)) {
    $where .= " AND sp.id_type = %d";
    $params[] = (int) $filter_type;
}

if (!empty($filter_form)) {
    $where .= " AND sp.id_form = %d";
    $params[] = (int) $filter_form;
}

$sql = "
    SELECT 
        sp.id,
        sp.name,
        sp.published,
        sp.ordering,
        sp.column_type,
        sf.name AS form, 
        sf.id AS form_id, 
        sf.id_template as id_template,
        st.name AS type, 
        st.id AS type_id
    FROM {$wpdb->prefix}cfg_fields sp
    LEFT JOIN {$wpdb->prefix}cfg_forms AS sf ON sf.id = sp.id_form
    LEFT JOIN {$wpdb->prefix}cfg_field_types AS st ON st.id = sp.id_type
    $where
    ORDER BY form_id, ordering, id ASC
";

$prepared_sql = $wpdb->prepare($sql, $params);
$rows = $wpdb->get_results($prepared_sql);

// Get types
$types_sql = $wpdb->prepare("SELECT `id`, `name` FROM `{$wpdb->prefix}cfg_field_types`");
$type_rows = $wpdb->get_results($types_sql);

// Get forms
$forms_sql = "SELECT `id`, `name`, `id_template` FROM `{$wpdb->prefix}cfg_forms` ORDER BY `ordering`, `id`";
$forms_rows = $wpdb->get_results($forms_sql);

?>
<form action="admin.php?page=cfg_fields" method="post" id="wpcfg_form">
<div style="overflow: hidden;margin: 0 0 10px 0;">
	<div style="float: left;">
        <select id="wpcfg_filter_form" class="wpcfg_select" name="filter_form" style="font-size: 12px;width: 150px;">
            <option value="0"><?php esc_html__('Select Form'); ?></option>
            <?php foreach ($forms_rows as $form) : ?>
                <option value="<?php echo intval($form->id); ?>" <?php selected($filter_form, $form->id); ?>>
                    <?php echo esc_html($form->name); ?>
                </option>
            <?php endforeach; ?>
        </select>

		<select id="wpcfg_filter_state" class="wpcfg_select" name="filter_state" style="font-size: 12px;width: 102px;">
			<option value="2" <?php if($filter_state == 2) echo 'selected="selected"';?> >Select Status</option>
			<option value="1"<?php if($filter_state == 1) echo 'selected="selected"';?> >Published</option>
			<option value="0"<?php if($filter_state == 0) echo 'selected="selected"';?> >Unpublished</option>
		</select>
        <select id="wpcfg_filter_type" class="wpcfg_select" name="filter_type" style="font-size: 12px; width: 95px;">
            <option value="0"><?php esc_html__('Select Type'); ?></option>
            <?php foreach ($type_rows as $type) : ?>
                <option value="<?php echo intval($type->id); ?>" <?php selected($filter_type, $type->id); ?>>
                    <?php echo esc_html($type->name); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="search" placeholder="Filter..." value="<?php echo esc_attr($filter_search); ?>" id="wpcfg_filter_search" name="filter_search" style="font-size: 12px;width: 95px;">
		<button id="wpcfg_filter_search_submit" class="button-primary">Search</button>
		<a href="admin.php?page=cfg_fields"  class="button">Reset</a>
	</div>
	<div class="col_info_wrapper" style="width: 420px;font-size: 12px !important;margin-top: 6px;float: left;margin-left: 15px;">
		<span class="col_0_preview"></span><span class="col_pr_name">Both Columns</span>
		<span class="col_1_preview"></span><span class="col_pr_name">Left Column</span>
		<span class="col_2_preview"></span><span class="col_pr_name">Right Column</span>
		<span class="col_none_preview"></span><span class="col_pr_name">Popup</span>
	</div>
	<div style="float:right;">
		<a href="admin.php?page=cfg_fields&act=new&filter_form=<?php echo esc_attr($filter_form); ?>" id="wpcfg_add" class="button-primary">New</a>
		<button id="wpcfg_edit" class="button button-disabled wpcfg_disabled" title="Please make a selection from the list, to activate this button">Edit</button>
		<button id="wpcfg_publish_list" class="button button-disabled wpcfg_disabled" title="Please make a selection from the list, to activate this button">Publish</button>
		<button id="wpcfg_unpublish_list" class="button button-disabled wpcfg_disabled" title="Please make a selection from the list, to activate this button">Unpublish</button>
		<button id="wpcfg_delete" class="button button-disabled wpcfg_disabled" title="Please make a selection from the list, to activate this button">Delete</button>
	</div>
</div>
<table class="widefat" >
	<thead>
		<tr>
			<th nowrap align="center" style="width: 30px;text-align: center;"><input type="checkbox" name="toggle" value="" id="wpcfg_check_all" /></th>
			<th nowrap align="center" style="width: 30px;text-align: center;">Order</th>
			<th nowrap align="center" style="width: 30px;text-align: center;">Status</th>
			<th nowrap align="left" style="text-align: left;padding-left: 22px;">Name</th>
			<th nowrap align="left" style="text-align: left;">Type</th>
			<th nowrap align="left" style="text-align: left;">Form</th>
			<th nowrap align="center" style="width: 30px;text-align: center;">Id</th>
		</tr>
	</thead>
    <tbody id="wpcfg_sortable"
           table_name="<?php echo esc_attr( $wpdb->prefix . 'cfg_fields' ); ?>"
           reorder_type="reorder">
    <?php
    $k = 0;
    for ( $i = 0; $i < count( $rows ); $i++ ) {
        $row = $rows[ $i ];
        $col_color = ( $row->type !== 'Creative Popup' ) ? $row->column_type : 'none';
        ?>
        <tr class="cfg_column_<?php echo esc_attr( $col_color ); ?> ui-state-default" id="option_li_<?php echo esc_attr( $row->id ); ?>">
            <td nowrap valign="middle" align="center" style="vertical-align: middle;width: 30px;">
                <input style="margin-left: 8px;" type="checkbox" id="cb<?php echo esc_attr( $i ); ?>" class="wpcfg_row_ch" name="ids[]" value="<?php echo esc_attr( $row->id ); ?>" />
            </td>
            <td valign="middle" align="center" style="vertical-align: middle;width: 30px;">
                <div class="wpcfg_reorder"></div>
            </td>
            <td valign="middle" align="center" style="vertical-align: middle;width: 30px;">
                <?php if ( $row->published == 1 ) { ?>
                    <a href="#" class="wpcfg_unpublish" wpcfg_id="<?php echo esc_attr( $row->id ); ?>">
                        <img src="<?php echo esc_url( plugins_url( '../images/published.png', __FILE__ ) ); ?>" alt="Published" border="0" title="Published" />
                    </a>
                <?php } else { ?>
                    <a href="#" class="wpcfg_publish" wpcfg_id="<?php echo esc_attr( $row->id ); ?>">
                        <img src="<?php echo esc_url( plugins_url( '../images/unpublished.png', __FILE__ ) ); ?>" alt="Unpublished" border="0" title="Unpublished" />
                    </a>
                <?php } ?>
            </td>
            <td valign="middle" align="left" style="vertical-align: middle;padding-left: 22px;" now_w="1">
                <a href="admin.php?page=cfg_fields&act=edit&id=<?php echo esc_attr( $row->id ); ?>"><?php echo esc_html( $row->name ); ?></a>
            </td>
            <td valign="middle" align="left" style="vertical-align: middle;" now_w="1">
                <?php echo esc_html( $row->type ); ?>
            </td>
            <td valign="middle" align="left" style="vertical-align: middle;" now_w="1">
                <a href="admin.php?page=cfg_forms&act=edit&id=<?php echo intval( $row->form_id ); ?>"><?php echo esc_html( $row->form ); ?></a>
            </td>
            <td valign="middle" align="center" style="vertical-align: middle;width: 30px;">
                <?php echo intval( $row->id ); ?>
            </td>
        </tr>
        <?php
        $k = 1 - $k;
    } // for
    ?>
</tbody>
</table>
<input type="hidden" name="task" value="" id="wpcfg_task" />
<input type="hidden" name="ids[]" value="" id="wpcfg_def_id" />
<input type="hidden" name="cfg_token" value="<?php echo esc_attr($session_cfg_token);?>" id="cfg_token" />
</form>

<style>
th {
	border-bottom: none !important;
}
td {
	border-top: 1px solid #C2C2C2;
}
tr:first-child td { 
   border-top: 1px solid rgba(194, 194, 194, 0.67);
}
tr.cfg_column_0 td {
	background-color: rgba(255, 199, 135, 0.46) !important;
}
tr.cfg_column_1 td {
	background-color: rgba(121, 210, 255, 0.35) !important;
}
tr.cfg_column_2 td {
	background-color: rgba(127, 255, 138, 0.53) !important;
}
tr.cfg_column_none td {
	background-color: rgba(0, 0, 0, 0.2) !important;
}
.col_info_wrapper {
	font-size: 12px !important;
	margin-top: 6px;
}
.col_0_preview {
	display: inline-block;
	width: 20px;
	height: 18px;
	margin-top: -1px;
	padding: 0 5px 0 5px;
	background-color: rgba(255, 199, 135, 0.46) !important;
	border: 1px solid #C2C2C2 !important;
	float: left;
	cursor: pointer;
	transition: all 0.2s ease-out 0s;
	-webkit-transition: all 0.2s ease-out 0s;
	-moz-transition: all 0.2s ease-out 0s;
}
.col_1_preview {
	display: inline-block;
	width: 20px;
	height: 18px;
	margin-top: -1px;
	padding: 0 5px 0 5px;
	background-color: rgba(121, 210, 255, 0.35) !important;
	border: 1px solid #C2C2C2 !important;
	float: left;
	margin-left: 5px;
	cursor: pointer;
	transition: all 0.2s ease-out 0s;
	-webkit-transition: all 0.2s ease-out 0s;
	-moz-transition: all 0.2s ease-out 0s;
}
.col_2_preview {
	display: inline-block;
	width: 20px;
	height: 18px;
	margin-top: -1px;
	padding: 0 5px 0 5px;
	background-color: rgba(127, 255, 138, 0.53) !important;
	border: 1px solid #C2C2C2 !important;
	float: left;
	margin-left: 5px;
	cursor: pointer;
	transition: all 0.2s ease-out 0s;
	-webkit-transition: all 0.2s ease-out 0s;
	-moz-transition: all 0.2s ease-out 0s;
}
.col_none_preview {
	display: inline-block;
	width: 20px;
	height: 18px;
	margin-top: -1px;
	padding: 0 5px 0 5px;
	background-color: rgba(0, 0, 0, 0.2) !important;
	border: 1px solid #A8A8A8 !important;
	float: left;
	margin-left: 5px;
	cursor: pointer;
	transition: all 0.2s ease-out 0s;
	-webkit-transition: all 0.2s ease-out 0s;
	-moz-transition: all 0.2s ease-out 0s;
}
.col_0_preview:hover,
.col_1_preview:hover,
.col_2_preview:hover,
.col_none_preview:hover {
	transform: scale(1.2,1.2);
	-webkit-transform: scale(1.2,1.2);
	-moz-transform: scale(1.2,1.2);
}
.col_pr_name {
	display: inline-block;
	float: left;
	margin-left: 3px;
}
</style>

