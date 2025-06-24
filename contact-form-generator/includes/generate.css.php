<?php
// no direct access!
defined('ABSPATH') or die("No direct access");

header('Content-Type: text/css');
// error_reporting(0);

global $wpdb;

$id_form = isset($_GET['id_form']) ? (int)$_GET['id_form'] : 0;

$query = $wpdb->prepare(
    "SELECT st.styles 
     FROM {$wpdb->prefix}cfg_forms sp
     LEFT JOIN {$wpdb->prefix}cfg_templates st ON st.id = sp.id_template
     WHERE sp.published = %d AND sp.id = %d",
    1,
    $id_form
);


$styles_value = $wpdb->get_var($query);

if(!isset($styles_value))
	exit;

$styles_array = explode('|',$styles_value);
$styles = array();
foreach ($styles_array as $val) {
	$arr = explode('~',$val);
	$styles[$arr[0]] = esc_attr($arr[1]);
}


?>
.cfg_form_<?php echo $id_form; ?>,
.cfg_form_<?php echo $id_form; ?> h1,
.cfg_form_<?php echo $id_form; ?> h2,
.cfg_form_<?php echo $id_form; ?> h3 {

	<?php 

		$cfg_googlefont = 'cfg-googlewebfont-';
		$cfg_font_rule = $styles[131];
		if (strpos($cfg_font_rule,$cfg_googlefont) !== false) {
			$cfg_font_rule = str_replace($cfg_googlefont, '', $cfg_font_rule);
			$cfg_font_rule .= ', sans-serif';
		}
	?>
	font-family: <?php echo esc_attr($cfg_font_rule);?>
}
.cfg_form_<?php echo $id_form;?>.contactformgenerator_wrapper {
    <?php
    // Escape and sanitize values before outputting CSS
    $border_width = intval($styles[2]);
    $border_style = esc_attr($styles[3]);
    $border_color = esc_attr($styles[1]);

    $bg_start = esc_attr($styles[0]);
    $bg_end =  esc_attr($styles[130]);

    $use_gradient = (isset($styles[627]) && $styles[627] === '1');

    $box_shadow_inset = esc_attr($styles[9]);
    $box_shadow_x = intval($styles[10]);
    $box_shadow_y = intval($styles[11]);
    $box_shadow_blur = intval($styles[12]);
    $box_shadow_spread = intval($styles[13]);
    $box_shadow_color = esc_attr($styles[8]);

    $border_radius = [];
    for ($i = 4; $i <= 7; $i++) {
    $border_radius[$i] = isset($styles[$i]) ? intval($styles[$i]) : 0;
    }

    $text_color = isset($styles[587]) ? esc_attr($styles[587]) : '#000';
    $font_size = isset($styles[588]) ? intval($styles[588]) : 14;
    ?>


    border: <?php echo $border_width; ?>px <?php echo $border_style; ?> <?php echo $border_color; ?>;
    background-color: <?php echo $bg_start; ?>;
    <?php if ($use_gradient) : ?>
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $bg_start; ?>', endColorstr='<?php echo $bg_end; ?>'); /* for IE */
        background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $bg_start; ?>), to(<?php echo $bg_end; ?>)); /* Safari 4-5, Chrome 1-9 */
        background: -webkit-linear-gradient(top, <?php echo $bg_start; ?>, <?php echo $bg_end; ?>); /* Safari 5.1, Chrome 10+ */
        background: -moz-linear-gradient(top, <?php echo $bg_start; ?>, <?php echo $bg_end; ?>); /* Firefox 3.6+ */
        background: -ms-linear-gradient(top, <?php echo $bg_start; ?>, <?php echo $bg_end; ?>); /* IE 10 */
        background: -o-linear-gradient(top, <?php echo $bg_start; ?>, <?php echo $bg_end; ?>); /* Opera 11.10+ */
    <?php endif; ?>

    -moz-box-shadow: <?php echo $box_shadow_inset; ?> <?php echo $box_shadow_x; ?>px <?php echo $box_shadow_y; ?>px <?php echo $box_shadow_blur; ?>px <?php echo $box_shadow_spread; ?>px <?php echo $box_shadow_color; ?>;
    -webkit-box-shadow: <?php echo $box_shadow_inset; ?> <?php echo $box_shadow_x; ?>px <?php echo $box_shadow_y; ?>px <?php echo $box_shadow_blur; ?>px <?php echo $box_shadow_spread; ?>px <?php echo $box_shadow_color; ?>;
    box-shadow: <?php echo $box_shadow_inset; ?> <?php echo $box_shadow_x; ?>px <?php echo $box_shadow_y; ?>px <?php echo $box_shadow_blur; ?>px <?php echo $box_shadow_spread; ?>px <?php echo $box_shadow_color; ?>;

    -webkit-border-top-left-radius: <?php echo $border_radius[4]; ?>px;
    -moz-border-radius-topleft: <?php echo $border_radius[4]; ?>px;
    border-top-left-radius: <?php echo $border_radius[4]; ?>px;

    -webkit-border-top-right-radius: <?php echo $border_radius[5]; ?>px;
    -moz-border-radius-topright: <?php echo $border_radius[5]; ?>px;
    border-top-right-radius: <?php echo $border_radius[5]; ?>px;

    -webkit-border-bottom-left-radius: <?php echo $border_radius[6]; ?>px;
    -moz-border-radius-bottomleft: <?php echo $border_radius[6]; ?>px;
    border-bottom-left-radius: <?php echo $border_radius[6]; ?>px;

    -webkit-border-bottom-right-radius: <?php echo $border_radius[7]; ?>px;
    -moz-border-radius-bottomright: <?php echo $border_radius[7]; ?>px;
    border-bottom-right-radius: <?php echo $border_radius[7]; ?>px;

    color: <?php echo $text_color; ?>;
    font-size: <?php echo $font_size; ?>px;

}
.cfg_form_<?php echo $id_form;?> .contactformgenerator_header {
	-webkit-border-top-left-radius: <?php echo $border_radius[4];?>px;
	-moz-border-radius-topleft: <?php echo $border_radius[4];?>px;
	border-top-left-radius: <?php echo $border_radius[4];?>px;
	
	-webkit-border-top-right-radius: <?php echo $styles[5];?>px;
	-moz-border-radius-topright: <?php echo $styles[5];?>px;
	border-top-right-radius: <?php echo $styles[5];?>px;
}
.cfg_form_<?php echo $id_form;?> .contactformgenerator_footer {
	-webkit-border-bottom-left-radius: <?php echo $border_radius[6];?>px;
	-moz-border-radius-bottomleft: <?php echo $border_radius[6];?>px;
	border-bottom-left-radius: <?php echo $border_radius[6];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $border_radius[7];?>px;
	-moz-border-radius-bottomright: <?php echo $border_radius[7];?>px;
	border-bottom-right-radius: <?php echo $border_radius[7];?>px;
}
.cfg_form_<?php echo $id_form;?> .contactformgenerator_loading_wrapper {
	-webkit-border-top-left-radius: <?php echo $border_radius[4];?>px;
	-moz-border-radius-topleft: <?php echo $border_radius[4];?>px;
	border-top-left-radius: <?php echo $border_radius[4];?>px;
	
	-webkit-border-top-right-radius: <?php echo $border_radius[5];?>px;
	-moz-border-radius-topright: <?php echo $border_radius[5];?>px;
	border-top-right-radius: <?php echo $border_radius[5];?>px;
	
	-webkit-border-bottom-left-radius: <?php echo $border_radius[6];?>px;
	-moz-border-radius-bottomleft: <?php echo $border_radius[6];?>px;
	border-bottom-left-radius: <?php echo $border_radius[6];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $border_radius[7];?>px;
	-moz-border-radius-bottomright: <?php echo $border_radius[7];?>px;
	border-bottom-right-radius: <?php echo $border_radius[7];?>px;
}
.cfg_form_<?php echo $id_form;?>.contactformgenerator_wrapper:hover {
    -moz-box-shadow: <?php echo esc_attr($styles[15]); ?> <?php echo intval($styles[16]); ?>px <?php echo intval($styles[17]); ?>px <?php echo intval($styles[18]); ?>px <?php echo intval($styles[19]); ?>px <?php echo esc_attr($styles[14]); ?>;
    -webkit-box-shadow: <?php echo esc_attr($styles[15]); ?> <?php echo intval($styles[16]); ?>px <?php echo intval($styles[17]); ?>px <?php echo intval($styles[18]); ?>px <?php echo intval($styles[19]); ?>px <?php echo esc_attr($styles[14]); ?>;
    box-shadow: <?php echo esc_attr($styles[15]); ?> <?php echo intval($styles[16]); ?>px <?php echo intval($styles[17]); ?>px <?php echo intval($styles[18]); ?>px <?php echo intval($styles[19]); ?>px <?php echo esc_attr($styles[14]); ?>;

}
.cfg_form_<?php echo $id_form;?> .contactformgenerator_header {
    <?php
    $padding_top = intval($styles[603]);
    $padding_right = intval($styles[604]);
    $padding_bottom = intval($styles[605]);
    $padding_left = intval($styles[606]);

    $border_width = intval($styles[607]);
    $border_style = esc_attr($styles[608]);
    $border_color = esc_attr($styles[609]);

    $use_gradient = ($styles[600] === '1');

    $bg_color_start = esc_attr($styles[601]);
    $bg_color_end = esc_attr($styles[602]);
    ?>

        padding: <?php echo $padding_top; ?>px <?php echo $padding_right; ?>px <?php echo $padding_bottom; ?>px <?php echo $padding_left; ?>px;
        border-bottom: <?php echo $border_width; ?>px <?php echo $border_style; ?> <?php echo $border_color; ?>;

    <?php if ($use_gradient) { ?>
        background-color: <?php echo $bg_color_start; ?>;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $bg_color_start; ?>', endColorstr='<?php echo $bg_color_end; ?>'); /* for IE */
        background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $bg_color_start; ?>), to(<?php echo $bg_color_end; ?>)); /* Safari 4-5, Chrome 1-9 */
        background: -webkit-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>); /* Safari 5.1, Chrome 10+ */
        background: -moz-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>); /* Firefox 3.6+ */
        background: -ms-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>); /* IE 10 */
        background: -o-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>); /* Opera 11.10+ */
    <?php } ?>


}
.cfg_form_<?php echo $id_form;?> .contactformgenerator_body {
    <?php
    $padding_top = intval($styles[613]);
    $padding_right = intval($styles[614]);
    $padding_bottom = intval($styles[615]);
    $padding_left = intval($styles[616]);

    $use_gradient = ($styles[610] === '1');

    $bg_color_start = esc_attr($styles[611]);
    $bg_color_end = esc_attr($styles[612]);
    ?>

        padding: <?php echo $padding_top; ?>px <?php echo $padding_right; ?>px <?php echo $padding_bottom; ?>px <?php echo $padding_left; ?>px;

    <?php if ($use_gradient) { ?>
        background-color: <?php echo $bg_color_start; ?>;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $bg_color_start; ?>', endColorstr='<?php echo $bg_color_end; ?>'); /* for IE */
        background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $bg_color_start; ?>), to(<?php echo $bg_color_end; ?>)); /* Safari 4-5, Chrome 1-9 */
        background: -webkit-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>); /* Safari 5.1, Chrome 10+ */
        background: -moz-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>); /* Firefox 3.6+ */
        background: -ms-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>); /* IE 10 */
        background: -o-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>); /* Opera 11.10+ */
    <?php } ?>

}
.cfg_form_<?php echo $id_form;?> .contactformgenerator_footer {
    <?php
    $padding_top = intval($styles[620]);
    $padding_right = intval($styles[621]);
    $padding_bottom = intval($styles[622]);
    $padding_left = intval($styles[623]);

    $border_width = intval($styles[624]);
    $border_style = esc_attr($styles[625]);
    $border_color = esc_attr($styles[626]);

    $use_gradient = ($styles[617] === '1');
    $bg_color_start = esc_attr($styles[618]);
    $bg_color_end = esc_attr($styles[619]);
    ?>

        padding: <?php echo $padding_top; ?>px <?php echo $padding_right; ?>px <?php echo $padding_bottom; ?>px <?php echo $padding_left; ?>px;
        border-top: <?php echo $border_width; ?>px <?php echo $border_style; ?> <?php echo $border_color; ?>;

    <?php if ($use_gradient) { ?>
        background-color: <?php echo $bg_color_start; ?>;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $bg_color_start; ?>', endColorstr='<?php echo $bg_color_end; ?>'); /* for IE */
        background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $bg_color_start; ?>), to(<?php echo $bg_color_end; ?>)); /* Safari 4-5, Chrome 1-9 */
        background: -webkit-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>); /* Safari 5.1, Chrome 10+ */
        background: -moz-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>); /* Firefox 3.6+ */
        background: -ms-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>); /* IE 10 */
        background: -o-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>); /* Opera 11.10+ */
    <?php } ?>

}


.cfg_form_<?php echo $id_form;?> .contactformgenerator_title {
    color: <?php echo esc_attr($styles[20]); ?>;
    font-size: <?php echo intval($styles[21]); ?>px;
    font-style: <?php echo esc_attr($styles[23]); ?>;
    font-weight: <?php echo esc_attr($styles[22]); ?>;
    text-align: <?php echo esc_attr($styles[25]); ?>;
    text-decoration: <?php echo esc_attr($styles[24]); ?>;
    text-shadow: <?php
        echo intval($styles[28]).'px '.intval($styles[29]).'px '.intval($styles[30]).'px '.esc_attr($styles[27]);
    ?>;

<?php

    $cfg_googlefont = 'cfg-googlewebfont-';
    $cfg_font_rule = $styles[506];
    if (strpos($cfg_font_rule,$cfg_googlefont) !== false) {
        $cfg_font_rule = str_replace($cfg_googlefont, '', $cfg_font_rule);
        $cfg_font_rule .= ', sans-serif';
    }
?>
	font-family: <?php echo esc_attr($cfg_font_rule);?>
}

<?php
   $font_color = esc_attr($styles[31]);
   $font_size = intval($styles[32]);
   $font_style = esc_attr($styles[34]);
   $font_weight = esc_attr($styles[33]);
   $text_align = esc_attr($styles[36]);
   $text_decoration = esc_attr($styles[35]);
?>
.cfg_form_<?php echo $id_form;?> .contactformgenerator_field_name {
    color: <?php echo $font_color;?>;
    font-size: <?php echo $font_size;?>px;
    font-style: <?php echo $font_style;?>;
    font-weight: <?php echo $font_weight;?>;
    text-align: <?php echo $text_align; ?>;
    text-decoration: <?php echo $text_decoration; ?>;
    text-shadow: <?php
        echo intval($styles[38]) . 'px ' . intval($styles[39]) . 'px ' . intval($styles[40]) . 'px ' . esc_attr($styles[37]);
    ?>;
    margin: <?php
        echo intval($styles[215]) . 'px ' . intval($styles[216]) . 'px ' . intval($styles[217]) . 'px ' . intval($styles[218]) . 'px';
    ?>;

<?php

    $cfg_googlefont = 'cfg-googlewebfont-';
    $cfg_font_rule = $styles[507];
    if (strpos($cfg_font_rule,$cfg_googlefont) !== false) {
        $cfg_font_rule = str_replace($cfg_googlefont, '', $cfg_font_rule);
        $cfg_font_rule .= ', sans-serif';
    }
?>
	font-family: <?php echo esc_attr($cfg_font_rule);?>
}

.cfg_form_<?php echo $id_form;?> .answer_name label {
    color: <?php echo $font_color; ?>;
    font-size: <?php echo max(0, $font_size - 1); ?>px;
    font-style: <?php echo $font_style; ?>;
    font-weight: <?php echo $font_weight; ?>;
    text-decoration: <?php echo $text_decoration; ?>;
    text-shadow: <?php
    echo intval($styles[38]) . 'px ' . intval($styles[39]) . 'px ' . intval($styles[40]) . 'px ' . esc_attr($styles[37]);
?>;

}
.cfg_form_<?php echo $id_form;?> .answer_name label.without_parent_label {
	font-size: <?php echo $font_size;?>px;
}

.cfg_form_<?php echo $id_form;?> .cfg_uploaded_file {
	color: <?php echo $font_color;?>;
	font-size: <?php echo $font_size - 1;?>px;
	font-style: <?php echo $font_style;?>;
	font-weight: <?php echo $font_weight;?>;
	text-decoration: <?php echo $text_decoration;?>;
	text-shadow: <?php
    echo intval($styles[38]) . 'px ' . intval($styles[39]) . 'px ' . intval($styles[40]) . 'px ' . esc_attr($styles[37]);
?>;
}

.cfg_form_<?php echo $id_form;?> .contactformgenerator_field_required {
    color: <?php echo esc_attr($styles[41]); ?>;
    font-size: <?php echo intval($styles[42]); ?>px;
    font-style: <?php echo esc_attr($styles[44]); ?>;
    font-weight: <?php echo esc_attr($styles[43]); ?>;
    text-shadow: <?php
        echo intval($styles[47]) . 'px ' . intval($styles[48]) . 'px ' . intval($styles[49]) . 'px ' . esc_attr($styles[46]);
    ?>;

}

.cfg_form_<?php echo $id_form;?> .contactformgenerator_send,
.cfg_form_<?php echo $id_form;?> .contactformgenerator_send_new,
.cfg_form_<?php echo $id_form;?> .cfg_fileupload
 {
<?php
$bg_color_start = esc_attr($styles[91]);
$bg_color_end = esc_attr($styles[50]);

$padding_top = intval($styles[92]);
$padding_right = intval($styles[93]);

$box_shadow_color = esc_attr($styles[95]);
$box_shadow_h_offset = intval($styles[96]);
$box_shadow_v_offset = intval($styles[97]);
$box_shadow_blur = intval($styles[98]);
$box_shadow_spread = intval($styles[99]);
$box_shadow_extra_color = esc_attr($styles[94]);

$border_style = esc_attr($styles[127]);
$border_width = intval($styles[101]);
$border_color = esc_attr($styles[100]);

$border_radius_top_left = intval($styles[102]);
$border_radius_top_right = intval($styles[103]);
$border_radius_bottom_left = intval($styles[104]);
$border_radius_bottom_right = intval($styles[105]);

$float_dir = esc_attr($styles[212]);

$font_size = intval($styles[107]);
$font_color = esc_attr($styles[106]);
$font_style = esc_attr($styles[109]);
$font_weight = esc_attr($styles[108]);
$text_decoration = esc_attr($styles[110]);

$text_shadow_h = intval($styles[114]);
$text_shadow_v = intval($styles[115]);
$text_shadow_blur = intval($styles[116]);
$text_shadow_color = esc_attr($styles[113]);
?>

    background-color: <?php echo $bg_color_start; ?>;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $bg_color_start; ?>', endColorstr='<?php echo $bg_color_end; ?>'); /* for IE */
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $bg_color_start; ?>), to(<?php echo $bg_color_end; ?>));/* Safari 4-5, Chrome 1-9 */
    background: -webkit-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>); /* Safari 5.1, Chrome 10+ */
    background: -moz-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>);/* Firefox 3.6+ */
    background: -ms-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>);/* IE 10 */
    background: -o-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>);/* Opera 11.10+ */

    padding: <?php echo $padding_top; ?>px <?php echo $padding_right; ?>px;

    -moz-box-shadow: <?php echo $box_shadow_color; ?> <?php echo $box_shadow_h_offset; ?>px <?php echo $box_shadow_v_offset; ?>px <?php echo $box_shadow_blur; ?>px <?php echo $box_shadow_spread; ?>px <?php echo $box_shadow_extra_color; ?>;
    -webkit-box-shadow: <?php echo $box_shadow_color; ?> <?php echo $box_shadow_h_offset; ?>px <?php echo $box_shadow_v_offset; ?>px <?php echo $box_shadow_blur; ?>px <?php echo $box_shadow_spread; ?>px <?php echo $box_shadow_extra_color; ?>;
    box-shadow: <?php echo $box_shadow_color; ?> <?php echo $box_shadow_h_offset; ?>px <?php echo $box_shadow_v_offset; ?>px <?php echo $box_shadow_blur; ?>px <?php echo $box_shadow_spread; ?>px <?php echo $box_shadow_extra_color; ?>;

    border-style: <?php echo $border_style; ?>;
    border-width: <?php echo $border_width; ?>px;
    border-color: <?php echo $border_color; ?>;

    -webkit-border-top-left-radius: <?php echo $border_radius_top_left; ?>px;
    -moz-border-radius-topleft: <?php echo $border_radius_top_left; ?>px;
    border-top-left-radius: <?php echo $border_radius_top_left; ?>px;

    -webkit-border-top-right-radius: <?php echo $border_radius_top_right; ?>px;
    -moz-border-radius-topright: <?php echo $border_radius_top_right; ?>px;
    border-top-right-radius: <?php echo $border_radius_top_right; ?>px;

    -webkit-border-bottom-left-radius: <?php echo $border_radius_bottom_left; ?>px;
    -moz-border-radius-bottomleft: <?php echo $border_radius_bottom_left; ?>px;
    border-bottom-left-radius: <?php echo $border_radius_bottom_left; ?>px;

    -webkit-border-bottom-right-radius: <?php echo $border_radius_bottom_right; ?>px;
    -moz-border-radius-bottomright: <?php echo $border_radius_bottom_right; ?>px;
    border-bottom-right-radius: <?php echo $border_radius_bottom_right; ?>px;

    float: <?php echo $float_dir; ?>;

    font-size: <?php echo $font_size; ?>px;
    color: <?php echo $font_color; ?>;
    font-style: <?php echo $font_style; ?>;
    font-weight: <?php echo $font_weight; ?>;
    text-decoration: <?php echo $text_decoration; ?>;
    text-shadow: <?php echo $text_shadow_h; ?>px <?php echo $text_shadow_v; ?>px <?php echo $text_shadow_blur; ?>px <?php echo $text_shadow_color; ?>;
	<?php 

		$cfg_googlefont = 'cfg-googlewebfont-';
		$cfg_font_rule = $styles[112];
		if (strpos($cfg_font_rule,$cfg_googlefont) !== false) {
			$cfg_font_rule = str_replace($cfg_googlefont, '', $cfg_font_rule);
			$cfg_font_rule .= ', sans-serif';
		}
	?>
	font-family: <?php echo esc_attr($cfg_font_rule);?>
}

.cfg_form_<?php echo $id_form;?> .cfg_fileupload
{
padding: <?php echo intval($styles[597]);?>px <?php echo intval($styles[598]);?>px;
}

.cfg_form_<?php echo $id_form;?> .contactformgenerator_send:hover,.cfg_form_<?php echo $id_form;?> .contactformgenerator_send_new:hover, 
.cfg_form_<?php echo $id_form;?> .contactformgenerator_send:active,.cfg_form_<?php echo $id_form;?> .contactformgenerator_send_new:active, 
.cfg_form_<?php echo $id_form;?> .contactformgenerator_send:focus,.cfg_form_<?php echo $id_form;?> .contactformgenerator_send_new:focus,

.cfg_form_<?php echo $id_form;?> .cfg_fileupload:hover,.cfg_form_<?php echo $id_form;?> .cfg_fileupload:hover, 
.cfg_form_<?php echo $id_form;?> .cfg_fileupload:active,.cfg_form_<?php echo $id_form;?> .cfg_fileupload:active, 
.cfg_form_<?php echo $id_form;?> .cfg_fileupload:focus,.cfg_form_<?php echo $id_form;?> .cfg_fileupload:focus

{
    <?php
    $bg_start = esc_attr($styles[51]);
    $bg_end = esc_attr($styles[52]);

    $color = esc_attr($styles[124]);

    $text_shadow_h = intval($styles[114]);
    $text_shadow_v = intval($styles[115]);
    $text_shadow_blur = intval($styles[116]);
    $text_shadow_color = esc_attr($styles[125]);

    $box_shadow_color = esc_attr($styles[118]);
    $box_shadow_h = intval($styles[119]);
    $box_shadow_v = intval($styles[120]);
    $box_shadow_blur = intval($styles[121]);
    $box_shadow_spread = intval($styles[122]);
    $box_shadow_extra = esc_attr($styles[117]);

    $border_style = esc_attr($styles[127]);
    $border_width = intval($styles[101]);
    $border_color = esc_attr($styles[126]);
    ?>

    background-color: <?php echo $bg_start; ?>;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $bg_start; ?>', endColorstr='<?php echo $bg_end; ?>'); /* for IE */
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $bg_start; ?>), to(<?php echo $bg_end; ?>)); /* Safari 4-5, Chrome 1-9 */
    background: -webkit-linear-gradient(top, <?php echo $bg_start; ?>, <?php echo $bg_end; ?>); /* Safari 5.1, Chrome 10+ */
    background: -moz-linear-gradient(top, <?php echo $bg_start; ?>, <?php echo $bg_end; ?>); /* Firefox 3.6+ */
    background: -ms-linear-gradient(top, <?php echo $bg_start; ?>, <?php echo $bg_end; ?>); /* IE 10 */
    background: -o-linear-gradient(top, <?php echo $bg_start; ?>, <?php echo $bg_end; ?>); /* Opera 11.10+ */

    color: <?php echo $color; ?>;
    text-shadow: <?php echo $text_shadow_h; ?>px <?php echo $text_shadow_v; ?>px <?php echo $text_shadow_blur; ?>px <?php echo $text_shadow_color; ?>;

    -moz-box-shadow: <?php echo $box_shadow_color; ?> <?php echo $box_shadow_h; ?>px <?php echo $box_shadow_v; ?>px <?php echo $box_shadow_blur; ?>px <?php echo $box_shadow_spread; ?>px <?php echo $box_shadow_extra; ?>;
    -webkit-box-shadow: <?php echo $box_shadow_color; ?> <?php echo $box_shadow_h; ?>px <?php echo $box_shadow_v; ?>px <?php echo $box_shadow_blur; ?>px <?php echo $box_shadow_spread; ?>px <?php echo $box_shadow_extra; ?>;
    box-shadow: <?php echo $box_shadow_color; ?> <?php echo $box_shadow_h; ?>px <?php echo $box_shadow_v; ?>px <?php echo $box_shadow_blur; ?>px <?php echo $box_shadow_spread; ?>px <?php echo $box_shadow_extra; ?>;

    border-style: <?php echo $border_style; ?>;
    border-width: <?php echo $border_width; ?>px;
    border-color: <?php echo $border_color; ?>;

}
		        	
.cfg_form_<?php echo $id_form;?> .contactformgenerator_submit_wrapper {
	width: 	<?php echo intval($styles[209]);?>%;
}

.cfg_form_<?php echo $id_form;?> .contactformgenerator_input_element input,.cfg_form_<?php echo $id_form;?> .contactformgenerator_input_element textarea,.cfg_form_<?php echo $id_form;?> .contactformgenerator_input_element{
    font-size: <?php echo intval($styles[148]); ?>px;
    color: <?php echo esc_attr($styles[147]); ?>;
    font-style: <?php echo esc_attr($styles[150]); ?>;
    font-weight: <?php echo esc_attr($styles[149]); ?>;
    text-decoration: <?php echo esc_attr($styles[151]); ?>;
    text-shadow: <?php echo intval($styles[154]); ?>px <?php echo intval($styles[155]); ?>px <?php echo intval($styles[156]); ?>px <?php echo esc_attr($styles[153]); ?>;
    text-align: <?php echo esc_attr($styles[500]); ?>;

<?php

    $cfg_googlefont = 'cfg-googlewebfont-';
    $cfg_font_rule = $styles[152];
    if (strpos($cfg_font_rule,$cfg_googlefont) !== false) {
        $cfg_font_rule = str_replace($cfg_googlefont, '', $cfg_font_rule);
        $cfg_font_rule .= ', sans-serif';
    }
?>
	font-family: <?php echo esc_attr($cfg_font_rule);?>
}

.cfg_form_<?php echo $id_form;?> .contactformgenerator_input_element:hover,.cfg_form_<?php echo $id_form;?> .contactformgenerator_input_element:focus,.cfg_form_<?php echo $id_form;?> .contactformgenerator_input_element.focused {
    <?php
        $bgColorStart = esc_attr($styles[157]);
        $bgColorEnd = esc_attr($styles[158]);

        $boxShadowStyle = esc_attr($styles[163]);
        $boxShadowX = intval($styles[164]);
        $boxShadowY = intval($styles[165]);
        $boxShadowBlur = intval($styles[166]);
        $boxShadowSpread = intval($styles[167]);
        $boxShadowColor = esc_attr($styles[162]);

        $borderStyle = esc_attr($styles[136]);
        $borderWidth = intval($styles[135]);
        $borderColor = esc_attr($styles[161]);
    ?>

    background-color: <?php echo $bgColorStart; ?>;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $bgColorStart; ?>', endColorstr='<?php echo $bgColorEnd; ?>'); /* for IE */
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $bgColorStart; ?>), to(<?php echo $bgColorEnd; ?>)); /* Safari 4-5, Chrome 1-9 */
    background: -webkit-linear-gradient(top, <?php echo $bgColorStart; ?>, <?php echo $bgColorEnd; ?>); /* Safari 5.1, Chrome 10+ */
    background: -moz-linear-gradient(top, <?php echo $bgColorStart; ?>, <?php echo $bgColorEnd; ?>); /* Firefox 3.6+ */
    background: -ms-linear-gradient(top, <?php echo $bgColorStart; ?>, <?php echo $bgColorEnd; ?>); /* IE 10 */
    background: -o-linear-gradient(top, <?php echo $bgColorStart; ?>, <?php echo $bgColorEnd; ?>); /* Opera 11.10+ */

    -moz-box-shadow: <?php echo $boxShadowStyle; ?> <?php echo $boxShadowX; ?>px <?php echo $boxShadowY; ?>px <?php echo $boxShadowBlur; ?>px <?php echo $boxShadowSpread; ?>px <?php echo $boxShadowColor; ?>;
    -webkit-box-shadow: <?php echo $boxShadowStyle; ?> <?php echo $boxShadowX; ?>px <?php echo $boxShadowY; ?>px <?php echo $boxShadowBlur; ?>px <?php echo $boxShadowSpread; ?>px <?php echo $boxShadowColor; ?>;
    box-shadow: <?php echo $boxShadowStyle; ?> <?php echo $boxShadowX; ?>px <?php echo $boxShadowY; ?>px <?php echo $boxShadowBlur; ?>px <?php echo $boxShadowSpread; ?>px <?php echo $boxShadowColor; ?>;

    border-style: <?php echo $borderStyle; ?>;
    border-width: <?php echo $borderWidth; ?>px;
    border-color: <?php echo $borderColor; ?>;

}
.cfg_form_<?php echo $id_form;?> .contactformgenerator_input_element,.cfg_form_<?php echo $id_form;?> .contactformgenerator_input_element.closed:hover {
<?php
$bgColorStart = esc_attr($styles[132]);
$bgColorEnd = esc_attr($styles[133]);

$boxShadowStyle = esc_attr($styles[142]);
$boxShadowX = intval($styles[143]);
$boxShadowY = intval($styles[144]);
$boxShadowBlur = intval($styles[145]);
$boxShadowSpread = intval($styles[146]);
$boxShadowColor = esc_attr($styles[141]);

$borderStyle = esc_attr($styles[136]);
$borderWidth = intval($styles[135]);
$borderColor = esc_attr($styles[134]);

$borderRadiusTopLeft = intval($styles[137]);
$borderRadiusTopRight = intval($styles[138]);
$borderRadiusBottomLeft = intval($styles[139]);
$borderRadiusBottomRight = intval($styles[140]);
?>

    background-color: <?php echo $bgColorStart; ?>;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $bgColorStart; ?>', endColorstr='<?php echo $bgColorEnd; ?>'); /* for IE */
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $bgColorStart; ?>), to(<?php echo $bgColorEnd; ?>)); /* Safari 4-5, Chrome 1-9 */
    background: -webkit-linear-gradient(top, <?php echo $bgColorStart; ?>, <?php echo $bgColorEnd; ?>); /* Safari 5.1, Chrome 10+ */
    background: -moz-linear-gradient(top, <?php echo $bgColorStart; ?>, <?php echo $bgColorEnd; ?>); /* Firefox 3.6+ */
    background: -ms-linear-gradient(top, <?php echo $bgColorStart; ?>, <?php echo $bgColorEnd; ?>); /* IE 10 */
    background: -o-linear-gradient(top, <?php echo $bgColorStart; ?>, <?php echo $bgColorEnd; ?>); /* Opera 11.10+ */

    -moz-box-shadow: <?php echo $boxShadowStyle; ?> <?php echo $boxShadowX; ?>px <?php echo $boxShadowY; ?>px <?php echo $boxShadowBlur; ?>px <?php echo $boxShadowSpread; ?>px <?php echo $boxShadowColor; ?>;
    -webkit-box-shadow: <?php echo $boxShadowStyle; ?> <?php echo $boxShadowX; ?>px <?php echo $boxShadowY; ?>px <?php echo $boxShadowBlur; ?>px <?php echo $boxShadowSpread; ?>px <?php echo $boxShadowColor; ?>;
    box-shadow: <?php echo $boxShadowStyle; ?> <?php echo $boxShadowX; ?>px <?php echo $boxShadowY; ?>px <?php echo $boxShadowBlur; ?>px <?php echo $boxShadowSpread; ?>px <?php echo $boxShadowColor; ?>;

    border-style: <?php echo $borderStyle; ?>;
    border-width: <?php echo $borderWidth; ?>px;
    border-color: <?php echo $borderColor; ?>;

    -webkit-border-top-left-radius: <?php echo $borderRadiusTopLeft; ?>px;
    -moz-border-radius-topleft: <?php echo $borderRadiusTopLeft; ?>px;
    border-top-left-radius: <?php echo $borderRadiusTopLeft; ?>px;

    -webkit-border-top-right-radius: <?php echo $borderRadiusTopRight; ?>px;
    -moz-border-radius-topright: <?php echo $borderRadiusTopRight; ?>px;
    border-top-right-radius: <?php echo $borderRadiusTopRight; ?>px;

    -webkit-border-bottom-left-radius: <?php echo $borderRadiusBottomLeft; ?>px;
    -moz-border-radius-bottomleft: <?php echo $borderRadiusBottomLeft; ?>px;
    border-bottom-left-radius: <?php echo $borderRadiusBottomLeft; ?>px;

    -webkit-border-bottom-right-radius: <?php echo $borderRadiusBottomRight; ?>px;
    -moz-border-radius-bottomright: <?php echo $borderRadiusBottomRight; ?>px;
    border-bottom-right-radius: <?php echo $borderRadiusBottomRight; ?>px;


}
.cfg_form_<?php echo $id_form;?> .contactformgenerator_input_element input:hover,.cfg_form_<?php echo $id_form;?> .contactformgenerator_input_element input:focus,.cfg_form_<?php echo $id_form;?> .contactformgenerator_input_element textarea:hover,.cfg_form_<?php echo $id_form;?> .contactformgenerator_input_element textarea:focus,.cfg_form_<?php echo $id_form;?> .contactformgenerator_input_element.focused input,.cfg_form_<?php echo $id_form;?> .contactformgenerator_input_element.focused textarea {
    color: <?php echo esc_attr($styles[159]); ?>;
    text-shadow: <?php echo intval($styles[154]); ?>px <?php echo intval($styles[155]); ?>px <?php echo intval($styles[156]); ?>px <?php echo esc_attr($styles[160]); ?>;

}


.cfg_form_<?php echo $id_form;?> .contactformgenerator_error .contactformgenerator_field_name,.cfg_form_<?php echo $id_form;?> .contactformgenerator_error .contactformgenerator_field_name:hover {
    color: <?php echo esc_attr($styles[171]); ?>;
    text-shadow: <?php echo intval($styles[173]); ?>px <?php echo intval($styles[174]); ?>px <?php echo intval($styles[175]); ?>px <?php echo esc_attr($styles[172]); ?>;
}
.cfg_form_<?php echo $id_form;?> .contactformgenerator_error .contactformgenerator_input_element,.cfg_form_<?php echo $id_form;?> .contactformgenerator_error .contactformgenerator_input_element:hover {
    <?php
        $bg_start = esc_attr($styles[176]);
        $bg_end = esc_attr($styles[177]);
        $box_shadow_color = esc_attr($styles[184]);
        $box_shadow_h_offset = intval($styles[186]);
        $box_shadow_v_offset = intval($styles[187]);
        $box_shadow_blur = intval($styles[188]);
        $box_shadow_spread = intval($styles[189]);
        $box_shadow_style = esc_attr($styles[185]);
        $border_color = esc_attr($styles[178]);
    ?>

    background-color: <?php echo $bg_start; ?>;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $bg_start; ?>', endColorstr='<?php echo $bg_end; ?>'); /* for IE */
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $bg_start; ?>), to(<?php echo $bg_end; ?>)); /* Safari 4-5, Chrome 1-9 */
    background: -webkit-linear-gradient(top, <?php echo $bg_start; ?>, <?php echo $bg_end; ?>); /* Safari 5.1, Chrome 10+ */
    background: -moz-linear-gradient(top, <?php echo $bg_start; ?>, <?php echo $bg_end; ?>); /* Firefox 3.6+ */
    background: -ms-linear-gradient(top, <?php echo $bg_start; ?>, <?php echo $bg_end; ?>); /* IE 10 */
    background: -o-linear-gradient(top, <?php echo $bg_start; ?>, <?php echo $bg_end; ?>); /* Opera 11.10+ */

    -moz-box-shadow: <?php echo $box_shadow_style . ' ' . $box_shadow_h_offset; ?>px <?php echo $box_shadow_v_offset; ?>px <?php echo $box_shadow_blur; ?>px <?php echo $box_shadow_spread; ?>px <?php echo $box_shadow_color; ?>;
    -webkit-box-shadow: <?php echo $box_shadow_style . ' ' . $box_shadow_h_offset; ?>px <?php echo $box_shadow_v_offset; ?>px <?php echo $box_shadow_blur; ?>px <?php echo $box_shadow_spread; ?>px <?php echo $box_shadow_color; ?>;
    box-shadow: <?php echo $box_shadow_style . ' ' . $box_shadow_h_offset; ?>px <?php echo $box_shadow_v_offset; ?>px <?php echo $box_shadow_blur; ?>px <?php echo $box_shadow_spread; ?>px <?php echo $box_shadow_color; ?>;

    border-color: <?php echo $border_color; ?>;


}
.cfg_form_<?php echo $id_form;?> .contactformgenerator_error input,.cfg_form_<?php echo $id_form;?> .contactformgenerator_error .cfg_input_dummy_wrapper,.cfg_form_<?php echo $id_form;?> .contactformgenerator_error input:hover,.cfg_form_<?php echo $id_form;?> .contactformgenerator_error .focused input:hover,.cfg_form_<?php echo $id_form;?> .contactformgenerator_error .focused input,.cfg_form_<?php echo $id_form;?> .contactformgenerator_error .focused textarea,.cfg_form_<?php echo $id_form;?> .contactformgenerator_error textarea,.cfg_form_<?php echo $id_form;?> .contactformgenerator_error textarea:hover {
    color: <?php echo esc_attr($styles[179]); ?>;
    text-shadow: <?php echo intval($styles[181]); ?>px <?php echo intval($styles[182]); ?>px <?php echo intval($styles[183]); ?>px <?php echo esc_attr($styles[180]); ?>;

}

.cfg_form_<?php echo $id_form;?> .contactformgenerator_pre_text {
	margin-top: <?php echo intval($styles[190]);?>px;
	margin-bottom: <?php echo esc_attr($styles[191]);?>;
	<?php $mr =$styles[502] == 'right' ? '0' : ($styles[502] == 'center' ? 'auto' : '0');?>
	<?php $ml = $styles[502] == 'right' ? 'auto' : ($styles[502] == 'center' ? 'auto' : '0');?>
    margin-right: <?php echo esc_attr($mr); ?>;
    margin-left: <?php echo esc_attr($ml); ?>;
    padding: <?php echo intval($styles[193]); ?>px 0 0 0;
    width: <?php echo intval($styles[192]); ?>%;

    font-size: <?php echo intval($styles[198]); ?>px;
    color: <?php echo esc_attr($styles[197]); ?>;
    font-style: <?php echo esc_attr($styles[200]); ?>;
    font-weight: <?php echo esc_attr($styles[199]); ?>;
    text-decoration: <?php echo esc_attr($styles[201]); ?>;
    text-shadow: <?php echo intval($styles[204]); ?>px <?php echo intval($styles[205]); ?>px <?php echo intval($styles[206]); ?>px <?php echo esc_attr($styles[203]); ?>;
    text-align: <?php echo esc_attr($styles[502]); ?>;

    border-top: <?php echo intval($styles[194]); ?>px <?php echo esc_attr($styles[196]); ?> <?php echo esc_attr($styles[195]); ?>;

<?php

    $cfg_googlefont = 'cfg-googlewebfont-';
    $cfg_font_rule = $styles[202];
    if (strpos($cfg_font_rule,$cfg_googlefont) !== false) {
        $cfg_font_rule = str_replace($cfg_googlefont, '', $cfg_font_rule);
        $cfg_font_rule .= ', sans-serif';
    }
?>
	font-family: <?php echo esc_attr($cfg_font_rule);?>
}


.cfg_form_<?php echo $id_form;?> .contactformgenerator_field_box_textarea_inner {
	<?php $box_margin = $styles[501] == 'right' ? '0 0 0 auto' : ($styles[501] == 'center' ? '0 auto' : '0');  ?>
	margin: <?php echo esc_attr($box_margin);?>;
}
.cfg_form_<?php echo $id_form;?> .contactformgenerator_field_box_inner {
	<?php $box_margin = $styles[501] == 'right' ? '0 0 0 auto' : ($styles[501] == 'center' ? '0 auto' : '0');  ?>
	margin: <?php echo esc_attr($box_margin);?>;
}

.cfg_form_<?php echo $id_form;?>.contactformgenerator_wrapper .tooltip_inner {
	<?php 

		$cfg_googlefont = 'cfg-googlewebfont-';
		$cfg_font_rule = $styles[508];
		if (strpos($cfg_font_rule,$cfg_googlefont) !== false) {
			$cfg_font_rule = str_replace($cfg_googlefont, '', $cfg_font_rule);
			$cfg_font_rule .= ', sans-serif';
		}
	?>
	font-family: <?php echo esc_attr($cfg_font_rule);?>
}
.cfg_form_<?php echo $id_form;?>.contactformgenerator_wrapper .contactformgenerator_field_required {
	<?php 

		$cfg_googlefont = 'cfg-googlewebfont-';
		$cfg_font_rule = $styles[509];
		if (strpos($cfg_font_rule,$cfg_googlefont) !== false) {
			$cfg_font_rule = str_replace($cfg_googlefont, '', $cfg_font_rule);
			$cfg_font_rule .= ', sans-serif';
		}
	?>
	font-family: <?php echo esc_attr($cfg_font_rule);?>
}

/*************************************************RTL rules*******************************************************************************************/

<?php
if($styles[501] == 'right') {?>
.cfg_form_<?php echo $id_form;?>.contactformgenerator_wrapper .answer_name {
	float: right!important;
	text-align: right !important;
}
.cfg_form_<?php echo $id_form;?>.contactformgenerator_wrapper .answer_name label {
	margin: 6px 33px 0 0px;
}
.cfg_form_<?php echo $id_form;?> .answer_input {
	float: right !important;
	margin-right: -100%;
}
.cfg_form_<?php echo $id_form;?> .contactformgenerator_field_required {
	left: -12px !important;
}
.cfg_form_<?php echo $id_form;?> .the-tooltip.right > .tooltip_inner {
left: 0 !important;
padding: 3px 16px 4px 8px;
text-align: right;
}
.cfg_form_<?php echo $id_form;?> .the-tooltip.right > .tooltip_inner:after,.cfg_form_<?php echo $id_form;?> .the-tooltip.right > .tooltip_inner:before {
	left: 0;
}
.cfg_form_<?php echo $id_form;?> .cfg_input_dummy_wrapper img.ui-datepicker-trigger {
	left: -29px;
}

/***fileupload**/
.cfg_form_<?php echo $id_form;?> .cfg_progress .bar {
float: right;
}
.cfg_form_<?php echo $id_form;?> .cfg_fileupload_wrapper {
	text-align: right;
}
.cfg_form_<?php echo $id_form;?> .cfg_uploaded_file {
	float: right;	
}
.cfg_form_<?php echo $id_form;?> .cfg_remove_uploaded {
	float: right;	
}
.cfg_form_<?php echo $id_form;?> .cfg_uploaded_icon {
	float: right;
}
/***captcha**/
.cfg_form_<?php echo $id_form;?> img.cfg_captcha{
	float: right;
	margin: 3px 0px 5px 5px !important;
}
.cfg_form_<?php echo $id_form;?> .reload_cfg_captcha {
	float: right;
}
.cfg_form_<?php echo $id_form;?> .cfg_timing_captcha  {
	text-align: right;
}
<?php }
else { ?>
.cfg_form_<?php echo $id_form;?>.contactformgenerator_wrapper .answer_name {
	float: left!important;
	text-align: left !important;
}
.cfg_form_<?php echo $id_form;?>.contactformgenerator_wrapper .answer_name label {
	margin: 6px 0px 0 33px;
}
.cfg_form_<?php echo $id_form;?> .answer_input {
	float: left !important;
	margin-left: -100%;
}
.cfg_form_<?php echo $id_form;?> .contactformgenerator_field_required {
	right: -12px !important;
}
.cfg_form_<?php echo $id_form;?> .the-tooltip.right > .tooltip_inner {
right: 0 !important;
padding: 3px 16px 4px 8px;
text-align: left;
}
.cfg_form_<?php echo $id_form;?> .the-tooltip.right > .tooltip_inner:after,.cfg_form_<?php echo $id_form;?> .the-tooltip.right > .tooltip_inner:before {
	right: 0;
}
.cfg_form_<?php echo $id_form;?> .cfg_input_dummy_wrapper img.ui-datepicker-trigger {
	right: -29px;
}
/***fileupload**/
.cfg_form_<?php echo $id_form;?> .cfg_progress .bar {
float: left;
}
.cfg_form_<?php echo $id_form;?> .cfg_fileupload_wrapper {
	text-align: left;
}
.cfg_uploaded_file {
	float: left;	
}
.cfg_form_<?php echo $id_form;?> .cfg_remove_uploaded {
	float: left;	
}
.cfg_form_<?php echo $id_form;?> .cfg_uploaded_icon {
	float: left;
}
/***captcha**/
.cfg_form_<?php echo $id_form;?> img.cfg_captcha{
	float: left;
	margin: 3px 5px 5px 0px !important;
}
.cfg_form_<?php echo $id_form;?> .reload_cfg_captcha {
	float: left;
}
.cfg_form_<?php echo $id_form;?> .cfg_timing_captcha  {
	text-align: left;
}
/****************************Multiple Columns***************************/
.cfg_form_<?php echo $id_form;?> .cfg_field_box_wrapper_1 {
	width:<?php echo intval($styles[517]);?>%;
}
.cfg_form_<?php echo $id_form;?> .cfg_field_box_wrapper_2 {
	width:<?php echo intval($styles[518]);?>%;
}
.cfg_form_<?php echo $id_form;?> .cfg_field_box_wrapper_0 .contactformgenerator_field_box_inner {
	width:<?php echo intval($styles[168]);?>%;
}

.cfg_form_<?php echo $id_form;?> .cfg_field_box_wrapper_1 .contactformgenerator_field_box_inner {
	width:<?php echo intval($styles[519]);?>%;
}
.cfg_form_<?php echo $id_form;?> .cfg_field_box_wrapper_2 .contactformgenerator_field_box_inner {
	width:<?php echo intval($styles[520]);?>%;
}
.cfg_form_<?php echo $id_form;?> .cfg_field_box_wrapper_0 .contactformgenerator_field_box_textarea_inner {
	width:<?php echo intval($styles[169]);?>%;
}
.cfg_form_<?php echo $id_form;?> .cfg_field_box_wrapper_1 .contactformgenerator_field_box_textarea_inner {
	width:<?php echo intval($styles[521]);?>%;
}
.cfg_form_<?php echo $id_form;?> .cfg_field_box_wrapper_2 .contactformgenerator_field_box_textarea_inner {
	width:<?php echo intval($styles[522]);?>%;
}

.cfg_form_<?php echo $id_form;?> .cfg_field_box_wrapper_0 .cfg_textarea_wrapper {
	height:<?php echo intval($styles[170]);?>px;
}
.cfg_form_<?php echo $id_form;?> .cfg_field_box_wrapper_1 .cfg_textarea_wrapper,
.cfg_form_<?php echo $id_form;?> .cfg_field_box_wrapper_2 .cfg_textarea_wrapper {
	height:<?php echo intval($styles[523]);?>px;
}
.cfg_form_<?php echo $id_form;?> .contactformgenerator_heading {
	overflow: hidden;

    <?php
        $margin_top = intval($styles[539]);
        $margin_bottom = intval($styles[540]);

        $border_top_width = intval($styles[543]);
        $border_right_width = intval($styles[544]);
        $border_bottom_width = intval($styles[545]);
        $border_left_width = intval($styles[546]);

        $border_style = esc_attr($styles[547]);

        $border_top_color = esc_attr($styles[548]);
        $border_right_color = esc_attr($styles[549]);
        $border_bottom_color = esc_attr($styles[550]);
        $border_left_color = esc_attr($styles[551]);

        $bg_color_start = esc_attr($styles[541]);
        $bg_color_end = esc_attr($styles[542]);
    ?>

    margin: <?php echo $margin_top; ?>px 0 <?php echo $margin_bottom; ?>px 0;

    border-top: <?php echo $border_top_width; ?>px <?php echo $border_style; ?> <?php echo $border_top_color; ?>;
    border-right: <?php echo $border_right_width; ?>px <?php echo $border_style; ?> <?php echo $border_right_color; ?>;
    border-bottom: <?php echo $border_bottom_width; ?>px <?php echo $border_style; ?> <?php echo $border_bottom_color; ?>;
    border-left: <?php echo $border_left_width; ?>px <?php echo $border_style; ?> <?php echo $border_left_color; ?>;

    background-color: <?php echo $bg_color_start; ?>;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $bg_color_start; ?>', endColorstr='<?php echo $bg_color_end; ?>'); /* for IE */
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $bg_color_start; ?>), to(<?php echo $bg_color_end; ?>));/* Safari 4-5, Chrome 1-9 */
    background: -webkit-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>); /* Safari 5.1, Chrome 10+ */
    background: -moz-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>);/* Firefox 3.6+ */
    background: -ms-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>);/* IE 10 */
    background: -o-linear-gradient(top, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>);/* Opera 11.10+ */

<?php

    $cfg_googlefont = 'cfg-googlewebfont-';
    $cfg_font_rule = $styles[529];
    if (strpos($cfg_font_rule,$cfg_googlefont) !== false) {
        $cfg_font_rule = str_replace($cfg_googlefont, '', $cfg_font_rule);
        $cfg_font_rule .= ', sans-serif';
    }
?>
	font-family: <?php echo esc_attr($cfg_font_rule);?>

}
.cfg_form_<?php echo $id_form;?> .contactformgenerator_heading_inner {
    margin: <?php echo esc_attr($styles[535]); ?>px <?php echo esc_attr($styles[536]); ?>px <?php echo esc_attr($styles[537]); ?>px <?php echo esc_attr($styles[538]); ?>px;
    line-height: 1.2;
    font-size: <?php echo esc_attr($styles[525]); ?>px;
    color: <?php echo esc_attr($styles[524]); ?> !important;
    font-style: <?php echo esc_attr($styles[527]); ?>;
    font-weight: <?php echo esc_attr($styles[526]); ?>;
    text-decoration: <?php echo esc_attr($styles[528]); ?>;
    text-shadow: <?php echo esc_attr($styles[532]); ?>px <?php echo esc_attr($styles[533]); ?>px <?php echo esc_attr($styles[534]); ?>px <?php echo esc_attr($styles[531]); ?> !important;
}

/****************************Sections, Links, Popups***************************/
.cfg_form_<?php echo $id_form;?> .cfg_content_element_label {
    font-size: <?php echo esc_attr($styles[554]); ?>px !important;
    color: <?php echo esc_attr($styles[553]); ?> !important;
    font-style: <?php echo esc_attr($styles[556]); ?> !important;
    font-weight: <?php echo esc_attr($styles[555]); ?> !important;
    text-shadow: <?php echo esc_attr($styles[559]); ?>px <?php echo esc_attr($styles[560]); ?>px <?php echo esc_attr($styles[561]); ?>px <?php echo esc_attr($styles[558]); ?> !important;
    border-bottom: <?php echo esc_attr($styles[590]); ?>px <?php echo esc_attr($styles[591]); ?> <?php echo esc_attr($styles[592]); ?> !important;
    text-decoration: <?php echo esc_attr($styles[596]); ?> !important;

}
.cfg_form_<?php echo $id_form;?> a,
.cfg_form_<?php echo $id_form;?> .cfg_popup_link
 {
    color: <?php echo esc_attr($styles[564]); ?> !important;
    font-style: <?php echo esc_attr($styles[566]); ?> !important;
    font-weight: <?php echo esc_attr($styles[565]); ?> !important;
    text-shadow: <?php echo esc_attr($styles[571]); ?>px <?php echo esc_attr($styles[572]); ?>px <?php echo esc_attr($styles[573]); ?>px <?php echo esc_attr($styles[570]); ?> !important;
    border-bottom: <?php echo esc_attr($styles[567]); ?>px <?php echo esc_attr($styles[568]); ?> <?php echo esc_attr($styles[569]); ?> !important;
    text-decoration: <?php echo esc_attr($styles[594]); ?> !important;

}
.cfg_form_<?php echo $id_form;?> a:hover,
.cfg_form_<?php echo $id_form;?> .cfg_popup_link:hover
 {
    color: <?php echo esc_attr($styles[574]); ?> !important;
    text-shadow: <?php echo intval($styles[577]); ?>px <?php echo intval($styles[578]); ?>px <?php echo intval($styles[579]); ?>px <?php echo esc_attr($styles[576]); ?> !important;
    border-bottom: <?php echo intval($styles[567]); ?>px <?php echo esc_attr($styles[568]); ?> <?php echo esc_attr($styles[575]); ?> !important;

    font-style: <?php echo esc_attr($styles[566]); ?> !important;
    font-weight: <?php echo esc_attr($styles[565]); ?> !important;
    text-decoration: <?php echo esc_attr($styles[595]); ?> !important;

}

.cfg_form_<?php echo $id_form;?> .cfg_content_styling {
    color: <?php echo esc_attr($styles[580]); ?> !important;
    font-style: <?php echo esc_attr($styles[582]); ?> !important;
    font-weight: <?php echo esc_attr($styles[581]); ?> !important;
    text-shadow: <?php echo intval($styles[584]); ?>px <?php echo intval($styles[585]); ?>px <?php echo intval($styles[586]); ?>px <?php echo esc_attr($styles[583]); ?> !important;
    text-decoration: <?php echo esc_attr($styles[593]); ?> !important;

}

/*Custom Temaple Styles*/
<?php 
$custom_styles = str_replace('cfg_img_path',WPCFG_PLUGIN_PATH . '/includes/assets/images/bg_images',$styles[599]);
$custom_styles = str_replace('FORM_ID',$id_form,$custom_styles);
echo $custom_styles;

?>
<?php }?>
