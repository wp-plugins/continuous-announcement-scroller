<?php

/*
Plugin Name: Continuous announcement scroller
Plugin URI: http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/
Description: This plug-in will create a vertical scroll continuous announcement for your wordpress website, <a href="http://www.gopiplus.com/work/" target="_blank">Live demo</a>.
Author: Gopi.R
Version: 11.1
Author URI: http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/
Donate link: http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/
Tags: Continuous, announcement, scroller, message
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

global $wpdb, $wp_version;
define("WP_cas_TABLE", $wpdb->prefix . "cas_plugin");
define("cas_UNIQUE_NAME", "continuous-announcement-scroller");
define("cas_TITLE", "Continuous announcement scroller");
define('cas_FAV', 'http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/');
define('cas_LINK', 'Check official website for more information <a target="_blank" href="'.cas_FAV.'">click here</a>');

function cas() 
{
	global $wpdb;
	$cas_html = "";
	$cas_x = "";

	$num_user = get_option('cas_total_rec');
	$dis_num_user = get_option('cas_dis_count');
	$dis_num_height = get_option('cas_rec_height');
	$cas_randomorder = get_option('cas_randomorder');
	
	if(!is_numeric($num_user))
	{
		$num_user = 5;
	} 
	if(!is_numeric($dis_num_height))
	{
		$dis_num_height = 30;
	}
	if(!is_numeric($dis_num_user))
	{
		$dis_num_user = 5;
	}

	$sSql = "select cas_text,cas_link from ".WP_cas_TABLE." where cas_status='YES'"; 
	if(trim($cas_randomorder) == "YES")
	{
		$sSql = $sSql . " ORDER BY rand()";
	}
	else
	{
		$sSql = $sSql . " ORDER BY cas_order,cas_date";
	}
	$sSql = $sSql . " limit 0, $num_user";

	$data = $wpdb->get_results($sSql);

	$cas_data = $data;
	
	if ( ! empty($cas_data) ) 
	{
		$cas_count = 0;
		foreach ( $cas_data as $cas_data ) 
		{
			$cas_post_title = $cas_data->cas_text;
			
			$get_permalink = $cas_data->cas_link;
			
			//$cas_post_title = substr($cas_post_title, 0, 50);

			$dis_height = $dis_num_height."px";
			$cas_html = $cas_html . "<div class='cas_div' style='height:$dis_height;padding:2px 0px 2px 0px;'>"; 
			$cas_html = $cas_html . "<a href='$get_permalink'>$cas_post_title</a>";
			$cas_html = $cas_html . "</div>";
			
			$cas_post_title = trim($cas_post_title);
			$get_permalink = $get_permalink;
			$cas_x = $cas_x . "cas_array[$cas_count] = '<div class=\'cas_div\' style=\'height:$dis_height;padding:2px 0px 2px 0px;\'><a href=\'$get_permalink\'>$cas_post_title</a></div>'; ";	
			$cas_count++;
			
		}
		$dis_num_height = $dis_num_height + 4;
		if($cas_count >= $dis_num_user)
		{
			$cas_count = $dis_num_user;
			$cas_height = ($dis_num_height * $dis_num_user);
		}
		else
		{
			$cas_count = $cas_count;
			$cas_height = ($cas_count*$dis_num_height);
		}
		$cas_height1 = $dis_num_height."px";
		?>	
		<div style="padding-top:8px;padding-bottom:8px;">
			<div style="text-align:left;vertical-align:middle;text-decoration: none;overflow: hidden; position: relative; margin-left: 1px; height: <?php echo $cas_height1; ?>;" id="cas_Holder">
				<?php echo $cas_html; ?>
			</div>
		</div>
		<script type="text/javascript">
		var cas_array	= new Array();
		var cas_obj	= '';
		var cas_scrollPos 	= '';
		var cas_numScrolls	= '';
		var cas_heightOfElm = '<?php echo $dis_num_height; ?>'; // Height of each element (px)
		var cas_numberOfElm = '<?php echo $cas_count; ?>';
		var cas_scrollOn 	= 'true';
		function cas_createscroll() 
		{
			<?php echo $cas_x; ?>
			cas_obj	= document.getElementById('cas_Holder');
			cas_obj.style.height = (cas_numberOfElm * cas_heightOfElm) + 'px'; // Set height of DIV
			cas_content();
		}
		</script>
		<script type="text/javascript">
		cas_createscroll();
		</script>
		<?php
	}
	else
	{
		echo "<div style='padding-bottom:5px;padding-top:5px;'>No data available!</div>";
	}
}

function cas_install() 
{
	global $wpdb;
	
	if($wpdb->get_var("show tables like '". WP_cas_TABLE . "'") != WP_cas_TABLE) 
	{
		$wpdb->query("
			CREATE TABLE IF NOT EXISTS `". WP_cas_TABLE . "` (
			  `cas_id` int(11) NOT NULL auto_increment,
			  `cas_text` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
			  `cas_link` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
			  `cas_order` int(11) NOT NULL default '0',
			  `cas_status` char(3) NOT NULL default 'No',
			  `cas_date` datetime NOT NULL default '0000-00-00 00:00:00',
			  PRIMARY KEY  (`cas_id`) )
			");
		$sSql = "INSERT INTO `". WP_cas_TABLE . "` (`cas_text`,`cas_link`, `cas_order`, `cas_status`, `cas_date`)"; 
		$sSql = $sSql . "VALUES ('This is simply dummy announcement text.','http://www.gopiplus.com/work/', '1', 'YES', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_cas_TABLE . "` (`cas_text`,`cas_link`, `cas_order`, `cas_status`, `cas_date`)"; 
		$sSql = $sSql . "VALUES ('This is simply dummy announcement text.','http://www.gopiplus.com/work/', '2', 'YES', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_cas_TABLE . "` (`cas_text`,`cas_link`, `cas_order`, `cas_status`, `cas_date`)"; 
		$sSql = $sSql . "VALUES ('This is simply dummy announcement text.','http://www.gopiplus.com/work/', '3', 'YES', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
	}
	
	add_option('cas_title', "Announcement Scroller");
	add_option('cas_total_rec', "10");
	add_option('cas_dis_count', "5");
	add_option('cas_rec_height', "40");
	add_option('cas_randomorder', "YES");
}

function cas_control() 
{
	echo '<p>Continuous announcement scroller. <a href="options-general.php?page=continuous-announcement-scroller">click here</a> to update announcement</p>';
	echo cas_LINK;
}

function cas_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('cas_title');
	echo $after_title;
	cas();
	echo $after_widget;
}

function cas_admin_options() 
{
	global $wpdb;
	$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
	switch($current_page)
	{
		case 'edit':
			include('pages/content-management-edit.php');
			break;
		case 'add':
			include('pages/content-management-add.php');
			break;
		case 'set':
			include('pages/content-setting.php');
			break;
		default:
			include('pages/content-management-show.php');
			break;
	}
}

function cas_add_to_menu() 
{
	add_options_page('Continuous announcement scroller', 'Continuous announcement scroller', 'manage_options', 'continuous-announcement-scroller', 'cas_admin_options' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'cas_add_to_menu');
}

function cas_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget('continuous-announcement-scroller', 'Continuous announcement scroller', 'cas_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control('continuous-announcement-scroller', array('Continuous announcement scroller', 'widgets'), 'cas_control');
	} 
}

function cas_deactivation() 
{
	delete_option('cas_title');
	delete_option('cas_dis_count');
	delete_option('cas_total_rec');
	delete_option('cas_rec_height');
}

function cas_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'continuous-announcement-scroller', get_option('siteurl').'/wp-content/plugins/continuous-announcement-scroller/continuous-announcement-scroller.js');
	}	
}

add_action('init', 'cas_add_javascript_files');
add_action("plugins_loaded", "cas_init");
register_activation_hook(__FILE__, 'cas_install');
register_deactivation_hook(__FILE__, 'cas_deactivation');
?>