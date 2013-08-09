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
	?><div class="error fade"><p><strong>Oops, selected details doesn't exist.</strong></p></div><?php
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
		$cas_errors[] = __('Please enter the link.', cas_UNIQUE_NAME);
		$cas_error_found = TRUE;
	}
	
	$form['cas_text'] = isset($_POST['cas_text']) ? $_POST['cas_text'] : '';
	if ($form['cas_text'] == '')
	{
		$cas_errors[] = __('Please enter the announcement.', cas_UNIQUE_NAME);
		$cas_error_found = TRUE;
	}
	
	$form['cas_order'] = isset($_POST['cas_order']) ? $_POST['cas_order'] : '';
	if ($form['cas_order'] == '')
	{
		$cas_errors[] = __('Please enter the display order, only number.', cas_UNIQUE_NAME);
		$cas_error_found = TRUE;
	}
	
	$form['cas_status'] = isset($_POST['cas_status']) ? $_POST['cas_status'] : '';
	if ($form['cas_status'] == '')
	{
		$cas_errors[] = __('Please select the display status.', cas_UNIQUE_NAME);
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
		
		$cas_success = 'Details was successfully updated.';
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
    <p><strong><?php echo $cas_success; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=continuous-announcement-scroller">Click here</a> to view the details</strong></p>
  </div>
  <?php
}
?>
<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/continuous-announcement-scroller/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php echo cas_order; ?></h2>
	<form name="cas_form" method="post" action="#" onsubmit="return _cas_submit()"  >
      <h3>Update details</h3>
	  
	  	<label for="tag-a">Announcement</label>
		<input name="cas_text" type="text" id="cas_text" value="<?php echo $form['cas_text']; ?>" size="120" />
		<p>Please enter your announcement.</p>
		
		<label for="tag-a">Link</label>
		<input name="cas_link" type="text" id="cas_link" value="<?php echo $form['cas_link']; ?>" size="120"  />
		<p>Enter enter your link. When someone clicks on the announcement, where do you want to send them?</p>
	  
	  	<label for="tag-a">Display order</label>
		<input name="cas_order" type="text" id="cas_order" value="<?php echo $form['cas_order']; ?>" />
		<p>Enter your display order, only number.</p>
		
		<label for="tag-a">Display status</label>
		<select name="cas_status" id="cas_status">
			<option value='YES' <?php if($form['cas_status'] == 'YES') { echo "selected='selected'" ; } ?>>Yes</option>
			<option value='NO' <?php if($form['cas_status'] == 'NO') { echo "selected='selected'" ; } ?>>No</option>
		</select>
		<p>Please select your display status.</p>
	  	  
      <input name="cas_id" id="cas_id" type="hidden" value="<?php echo $form['cas_id']; ?>">
      <input type="hidden" name="cas_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="Update Details" type="submit" />
        <input name="publish" lang="publish" class="button" onclick="_cas_redirect()" value="Cancel" type="button" />
        <input name="Help" lang="publish" class="button" onclick="_cas_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('cas_form_edit'); ?>
    </form>
</div>
<p class="description"><?php echo cas_LINK; ?></p>
</div>