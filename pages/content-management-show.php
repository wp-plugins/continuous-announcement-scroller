<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_cas_display']) && $_POST['frm_cas_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }
	
	$cas_success = '';
	$cas_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$sSql = $wpdb->prepare(
		"SELECT COUNT(*) AS `count` FROM ".WP_cas_TABLE."
		WHERE `cas_id` = %d",
		array($did)
	);
	$result = '0';
	$result = $wpdb->get_var($sSql);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'continuous-scroller'); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('cas_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".WP_cas_TABLE."`
					WHERE `cas_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$cas_success_msg = TRUE;
			$cas_success = __('Selected record was successfully deleted.', 'continuous-scroller');
		}
	}
	
	if ($cas_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $cas_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e('Continuous announcement scroller', 'continuous-scroller'); ?>
	<a class="add-new-h2" href="<?php echo WP_cas_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'continuous-scroller'); ?></a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".WP_cas_TABLE."` order by cas_id desc";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo WP_cas_PLUGIN_URL; ?>/pages/setting.js"></script>
		<form name="frm_cas_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="col" style="padding: 8px 2px;"><input type="checkbox" name="cas_group_item[]" /></th>
			<th scope="col"><?php _e('Id', 'continuous-scroller'); ?></th>
			<th scope="col"><?php _e('Text', 'continuous-scroller'); ?></th>
            <th scope="col"><?php _e('Order', 'continuous-scroller'); ?></th>
			<th scope="col"><?php _e('Display', 'continuous-scroller'); ?></th>
			<th scope="col"><?php _e('Publish', 'continuous-scroller'); ?></th>
			<th scope="col"><?php _e('Expiration', 'continuous-scroller'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="col" style="padding: 8px 2px;"><input type="checkbox" name="cas_group_item[]" /></th>
			<th scope="col"><?php _e('Id', 'continuous-scroller'); ?></th>
			<th scope="col"><?php _e('Text', 'continuous-scroller'); ?></th>
            <th scope="col"><?php _e('Order', 'continuous-scroller'); ?></th>
			<th scope="col"><?php _e('Display', 'continuous-scroller'); ?></th>
			<th scope="col"><?php _e('Publish', 'continuous-scroller'); ?></th>
			<th scope="col"><?php _e('Expiration', 'continuous-scroller'); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td align="left"><input type="checkbox" value="<?php echo $data['cas_id']; ?>" name="cas_group_item[]"></td>
						<td><?php echo $data['cas_id']; ?></td>
						<td>
						<a target="_blank" href="<?php echo $data['cas_link']; ?>"><?php echo stripslashes($data['cas_text']); ?></a>
						<div class="row-actions">
							<span class="edit">
							<a title="Edit" href="<?php echo WP_cas_ADMIN_URL; ?>&amp;ac=edit&amp;did=<?php echo $data['cas_id']; ?>">
							<?php _e('Edit', 'continuous-scroller'); ?></a> | </span>
							<span class="trash">
							<a onClick="javascript:_cas_delete('<?php echo $data['cas_id']; ?>')" href="javascript:void(0);">
							<?php _e('Delete', 'continuous-scroller'); ?></a></span> 
						</div>
						</td>
						<td><?php echo $data['cas_order']; ?></td>
						<td><?php echo $data['cas_status']; ?></td>
						<td><?php echo substr($data['cas_datestart'],0,10); ?></td>
						<td><?php echo substr($data['cas_dateend'],0,10); ?></td>
					</tr>
					<?php 
					$i = $i+1; 
				} 	
			}
			else
			{
				?><tr><td colspan="7" align="center"><?php _e('No records available.', 'continuous-scroller'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('cas_form_show'); ?>
		<input type="hidden" name="frm_cas_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo WP_cas_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'continuous-scroller'); ?></a>
	  <a class="button add-new-h2" href="<?php echo WP_cas_ADMIN_URL; ?>&amp;ac=set"><?php _e('Setting Management', 'continuous-scroller'); ?></a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo cas_FAV; ?>"><?php _e('Help', 'continuous-scroller'); ?></a>
	  </h2>
	  </div>
	  <div style="height:5px"></div>
	<h3><?php _e('Plugin configuration option', 'continuous-scroller'); ?></h3>
	<ol>
		<li><?php _e('Add directly in to the theme using PHP code.', 'continuous-scroller'); ?></li>
		<li><?php _e('Drag and drop the widget to your sidebar.', 'continuous-scroller'); ?></li>
	</ol>
	<p class="description">
		<?php _e('Check official website for more information', 'continuous-scroller'); ?>
		<a target="_blank" href="<?php echo cas_FAV; ?>"><?php _e('click here', 'continuous-scroller'); ?></a>
	</p>
	</div>
</div>