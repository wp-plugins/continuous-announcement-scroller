<?php

/*
Plugin Name: Continuous announcement scroller
Plugin URI: http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/
Description: This plug-in will create a vertical scroll continuous announcement for your wordpress website, <a href="http://www.gopiplus.com/work/" target="_blank">Live demo</a>.
Author: Gopi.R
Version: 4.0
Author URI: http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/
Donate link: http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/
Tags: Continuous, announcement, scroller, message, flash news,
*/


//####################################################################################################
//###### Project   : Continuous announcement scroller  											######
//###### File Name : continuous-announcement-scroller.php                  						######
//###### Purpose   : This is the main page for this plugin.  									######
//###### Created   : Aug 30th 2010                  											######
//###### Modified  : Mar 27th 2011                  											######
//###### Author    : Gopi.R (http://www.gopiplus.com/work/)                       				######
//###### Link      : http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/  ######
//####################################################################################################


global $wpdb, $wp_version;
define("WP_cas_TABLE", $wpdb->prefix . "cas_plugin");

function cas() 
{
	
	global $wpdb;
	
	$num_user = get_option('cas_total_rec');
	$dis_num_user = get_option('cas_dis_count');
	$dis_num_height = get_option('cas_rec_height');
	
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

	$data = $wpdb->get_results("select cas_text,cas_link from ".WP_cas_TABLE." where cas_status='YES' ORDER BY cas_order,cas_date limit 0, $num_user");

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
		<script type="text/javascript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/continuous-announcement-scroller/continuous-announcement-scroller.js"></script>
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
		$sSql = $sSql . "VALUES ('This is simply dummy announcement text. Update this in text management page.','http://www.gopiplus.com/work/', '1', 'YES', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_cas_TABLE . "` (`cas_text`,`cas_link`, `cas_order`, `cas_status`, `cas_date`)"; 
		$sSql = $sSql . "VALUES ('To updae the setting use plugin link under wp setting tab.','http://www.gopiplus.com/work/', '2', 'YES', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_cas_TABLE . "` (`cas_text`,`cas_link`, `cas_order`, `cas_status`, `cas_date`)"; 
		$sSql = $sSql . "VALUES ('Click here to see more help for this wp plugin.','http://www.gopiplus.com/work/', '3', 'YES', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
	}
	
	add_option('cas_title', "Announcement Scroller");
	add_option('cas_total_rec', "10");
	add_option('cas_dis_count', "5");
	add_option('cas_rec_height', "40");
}

function cas_control() 
{
	echo '<p>Continuous announcement scroller.<br> To change the setting/To manage content goto Continuous announcement scroller link under SETTINGS tab.';
	echo ' <a href="options-general.php?page=continuous-announcement-scroller/continuous-announcement-scroller.php">';
	echo 'click here</a></p>';
	?>
	<h2><?php echo wp_specialchars( 'About Plugin!' ); ?></h2>
	Plug-in created by <a target="_blank" href='http://www.gopiplus.com/work/'>Gopi</a>.<br />
	<a target="_blank" href='http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/'>Click here</a> to see More information.<br />
	<?php
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
	?>

	<div class="wrap">
    <h2><?php echo wp_specialchars("Continuous announcement scroller"); ?></h2>
    </div>
	<?php
	$cas_title = get_option('cas_title');
	$cas_total_rec = get_option('cas_total_rec');
	$cas_dis_count = get_option('cas_dis_count');
	$cas_rec_height = get_option('cas_rec_height');
	
	if ($_POST['cas_submit']) 
	{
		$cas_title = stripslashes($_POST['cas_title']);
		$cas_total_rec = stripslashes($_POST['cas_total_rec']);
		$cas_dis_count = stripslashes($_POST['cas_dis_count']);
		$cas_rec_height = stripslashes($_POST['cas_rec_height']);
		
		update_option('cas_title', $cas_title );
		update_option('cas_total_rec', $cas_total_rec );
		update_option('cas_dis_count', $cas_dis_count );
		update_option('cas_rec_height', $cas_rec_height );
	}
	
	?>
	<form name="cas_form" method="post" action="">
	<?php
	echo '<p>Title:<br><input  style="width: 200px;" type="text" value="';
	echo $cas_title . '" name="cas_title" id="cas_title" /></p>';
	
	echo '<p>Each scroller height in scroll:<br><input  style="width: 100px;" type="text" value="';
	echo $cas_rec_height . '" name="cas_rec_height" id="cas_rec_height" /> (default: 30) ';
	echo 'If any overlap in the announcement text at front end, <br>you should arrange(increase/decrease) the above height.</p>';
	
	echo '<p>Display number of record at the same time in scroll:<br><input  style="width: 100px;" type="text" value="';
	echo $cas_dis_count . '" name="cas_dis_count" id="cas_dis_count" /></p>';
	
	echo '<p>Enter max number of record to scroll:<br><input  style="width: 100px;" type="text" value="';
	echo $cas_total_rec . '" name="cas_total_rec" id="cas_total_rec" /></p>';

	echo '<input name="cas_submit" id="cas_submit" lang="publish" class="button-primary" value="Update Setting" type="Submit" />';
	
	?>
	</form>
	  <table width="100%">
		<tr>
		  <td align="right"><input name="text_management" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=continuous-announcement-scroller/content-management.php'" value="Go to - Text Management" type="button" />
			<input name="setting_management" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=continuous-announcement-scroller/continuous-announcement-scroller.php'" value="Go to - Scroller Setting" type="button" />
		  </td>
		</tr>
	  </table>
    <?php include_once("help.php"); ?>
	<?php
}


function cas_add_to_menu() 
{
	//add_options_page('Continuous announcement scroller', 'Continuous announcement scroller', 7, __FILE__, 'cas_admin_options' );
	add_options_page('Continuous announcement scroller', 'Continuous announcement scroller', 'manage_options', __FILE__, 'cas_admin_options' );
	add_options_page('Continuous announcement scroller', 'manage_options', "continuous-announcement-scroller/content-management.php",'' );
}

if (is_admin()) {
add_action('admin_menu', 'cas_add_to_menu');
}

function cas_init()
{
	if(function_exists('register_sidebar_widget')) 
	{
		register_sidebar_widget('Continuous announcement scroller', 'cas_widget');
	}
	
	if(function_exists('register_widget_control')) 
	{
		register_widget_control(array('Continuous announcement scroller', 'widgets'), 'cas_control');
	} 
}

function cas_deactivation() 
{
	delete_option('cas_title');
	delete_option('cas_dis_count');
	delete_option('cas_total_rec');
	delete_option('cas_rec_height');
}

add_action("plugins_loaded", "cas_init");
register_activation_hook(__FILE__, 'cas_install');
register_deactivation_hook(__FILE__, 'cas_deactivation');
add_action('admin_menu', 'cas_add_to_menu');
?>