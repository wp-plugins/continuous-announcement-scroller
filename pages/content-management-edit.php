<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';

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
	$cas_errors = array();
	$cas_success = '';
	$cas_error_found = FALSE;
	
	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".WP_cas_TABLE."`
		WHERE `cas_id` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);
	
	// Preset the form fields
	$form = array(
		'cas_link' => $data['cas_link'],
		'cas_text' => $data['cas_text'],
		'cas_order' => $data['cas_order'],
		'cas_status' => $data['cas_status'],
		'cas_id' => $data['cas_id']
	);
}
// Form submitted, check the data
if (isset($_POST['cas_form_submit']) && $_POST['cas_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('cas_form_edit');
	
	$form['cas_link'] = isset($_POST['cas_link']) ? $_POST['cas_link'] : '';
	if ($form['cas_link'] == '')
	{
		$cas_errors[] = __('Please enter the link.', 'continuous-scroller');
		$cas_error_found = TRUE;
	}
	
	$form['cas_text'] = isset($_POST['cas_text']) ? $_POST['cas_text'] : '';
	if ($form['cas_text'] == '')
	{
		$cas_errors[] = __('Please enter the announcement.', 'continuous-scroller');
		$cas_error_found = TRUE;
	}
	
	$form['cas_order'] = isset($_POST['cas_order']) ? $_POST['cas_order'] : '';
	if ($form['cas_order'] == '')
	{
		$cas_errors[] = __('Please enter the display order, only number.', 'continuous-scroller');
		$cas_error_found = TRUE;
	}
	
	$form['cas_status'] = isset($_POST['cas_status']) ? $_POST['cas_status'] : '';
	if ($form['cas_status'] == '')
	{
		$cas_errors[] = __('Please select the display status.', 'continuous-scroller');
		$cas_error_found = TRUE;
	}

	//	No errors found, we can add this Group to the table
	if ($cas_error_found == FALSE)
	{	
		$sSql = $wpdb->prepare(
				"UPDATE `".WP_cas_TABLE."`
				SET `cas_link` = %s,
				`cas_text` = %s,
				`cas_order` = %s,
				`cas_status` = %s
				WHERE cas_id = %d
				LIMIT 1",
				array($form['cas_link'], $form['cas_text'], $form['cas_order'], $form['cas_status'], $did)
			);
		$wpdb->query($sSql);
		
		$cas_success = __('Details was successfully updated', 'continuous-scroller');
	}
}

if ($cas_error_found == TRUE && isset($cas_errors[0]) == TRUE)
{
?>
  <div class="error fade">
    <p><strong><?php echo $cas_errors[0]; ?></strong></p>
  </div>
  <?php
}
if ($cas_error_found == FALSE && strlen($cas_success) > 0)
{
?>
  <div class="updated fade">
    <p><strong><?php echo $cas_success; ?> <a href="<?php echo WP_cas_ADMIN_URL; ?>"><?php _e('Click here to view the details', 'continuous-scroller'); ?></a></strong></p>
  </div>
  <?php
}
?>
<script language="JavaScript" src="<?php echo WP_cas_PLUGIN_URL; ?>/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e('Continuous announcement scroller', 'continuous-scroller'); ?></h2>
	<form name="cas_form" method="post" action="#" onsubmit="return _cas_submit()"  >
      <h3><?php _e('Update details', 'continuous-scroller'); ?></h3>
	  
	  	<label for="tag-a"><?php _e('Announcement', 'continuous-scroller'); ?></label>
		<input name="cas_text" type="text" id="cas_text" value="<?php echo $form['cas_text']; ?>" size="120" />
		<p><?php _e('Please enter your announcement.', 'continuous-scroller'); ?></p>
		
		<label for="tag-a"><?php _e('Link', 'continuous-scroller'); ?></label>
		<input name="cas_link" type="text" id="cas_link" value="<?php echo $form['cas_link']; ?>" size="120"  />
		<p><?php _e('Enter enter your link. When someone clicks on the announcement, where do you want to send them?', 'continuous-scroller'); ?></p>
	  
	  	<label for="tag-a"><?php _e('Display order', 'continuous-scroller'); ?></label>
		<input name="cas_order" type="text" id="cas_order" value="<?php echo $form['cas_order']; ?>" />
		<p><?php _e('Enter your display order, only number.', 'continuous-scroller'); ?></p>
		
		<label for="tag-a"><?php _e('Display status', 'continuous-scroller'); ?></label>
		<select name="cas_status" id="cas_status">
			<option value='YES' <?php if($form['cas_status'] == 'YES') { echo "selected='selected'" ; } ?>>Yes</option>
			<option value='NO' <?php if($form['cas_status'] == 'NO') { echo "selected='selected'" ; } ?>>No</option>
		</select>
		<p><?php _e('Please select your display status.', 'continuous-scroller'); ?></p>
	  	  
      <input name="cas_id" id="cas_id" type="hidden" value="<?php echo $form['cas_id']; ?>">
      <input type="hidden" name="cas_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="<?php _e('Update Details', 'continuous-scroller'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button" onclick="_cas_redirect()" value="<?php _e('Cancel', 'continuous-scroller'); ?>" type="button" />
        <input name="Help" lang="publish" class="button" onclick="_cas_help()" value="<?php _e('Help', 'continuous-scroller'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('cas_form_edit'); ?>
    </form>
</div>
<p class="description">
	<?php _e('Check official website for more information', 'continuous-scroller'); ?>
	<a target="_blank" href="<?php echo cas_FAV; ?>"><?php _e('click here', 'continuous-scroller'); ?></a>
</p>
</div>