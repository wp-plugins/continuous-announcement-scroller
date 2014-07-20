<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$cas_errors = array();
$cas_success = '';
$cas_error_found = FALSE;

// Preset the form fields
$form = array(
	'cas_link' => '',
	'cas_text' => '',
	'cas_order' => '',
	'cas_status' => '',
	'cas_datestart' => '',
	'cas_dateend' => '',
	'cas_id' => ''
);

// Form submitted, check the data
if (isset($_POST['cas_form_submit']) && $_POST['cas_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('cas_form_add');
	
	$form['cas_link'] = isset($_POST['cas_link']) ? $_POST['cas_link'] : '';
	if ($form['cas_link'] == '')
	{
		$cas_errors[] = __('Please enter the link.', 'continuous-scroller');
		$cas_error_found = TRUE;
	}
	
	$form['cas_text'] = isset($_POST['cas_text']) ? $_POST['cas_text'] : '';
	if ($form['cas_link'] == '')
	{
		$cas_errors[] = __('Please enter the announcement.', 'continuous-scroller');
		$cas_error_found = TRUE;
	}
	
	$form['cas_order'] = isset($_POST['cas_order']) ? $_POST['cas_order'] : '';
	if ($form['cas_link'] == '')
	{
		$cas_errors[] = __('Please enter the display order, only number.', 'continuous-scroller');
		$cas_error_found = TRUE;
	}
	
	$form['cas_status'] = isset($_POST['cas_status']) ? $_POST['cas_status'] : '';
	if ($form['cas_link'] == '')
	{
		$cas_errors[] = __('Please select the display status.', 'continuous-scroller');
		$cas_error_found = TRUE;
	}
	
	$form['cas_datestart'] = isset($_POST['cas_datestart']) ? $_POST['cas_datestart'] : '';
	$form['cas_dateend'] = isset($_POST['cas_dateend']) ? $_POST['cas_dateend'] : '';

	//	No errors found, we can add this Group to the table
	if ($cas_error_found == FALSE)
	{
		$sql = $wpdb->prepare(
			"INSERT INTO `".WP_cas_TABLE."`
			(`cas_link`, `cas_text`, `cas_order`, `cas_status`, `cas_datestart`, `cas_dateend`)
			VALUES(%s, %s, %s, %s, %s, %s)",
			array($form['cas_link'], $form['cas_text'], $form['cas_order'], $form['cas_status'], $form['cas_datestart'], $form['cas_dateend'])
		);
		$wpdb->query($sql);
		
		$cas_success = __('New details was successfully added.', 'continuous-scroller');
		
		// Reset the form fields
		$form = array(
			'cas_link' => '',
			'cas_text' => '',
			'cas_order' => '',
			'cas_status' => '',
			'cas_datestart' => '',
			'cas_dateend' => '',
			'cas_id' => ''
		);
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
      <h3><?php _e('Add details', 'continuous-scroller'); ?></h3>
      	
		<label for="tag-a"><?php _e('Announcement', 'continuous-scroller'); ?></label>
		<textarea name="cas_text" cols="88" rows="4" id="cas_text"></textarea>
		<p><?php _e('Please enter your announcement.', 'continuous-scroller'); ?></p>
		
		<label for="tag-a"><?php _e('Link', 'continuous-scroller'); ?></label>
		<input name="cas_link" type="text" id="cas_link" value="" size="90"  />
		<p><?php _e('When someone clicks on the announcement, where do you want to send them?. url must start with either http or https.', 'continuous-scroller'); ?></p>
	  
	  	<label for="tag-a"><?php _e('Display order', 'continuous-scroller'); ?></label>
		<input name="cas_order" type="text" id="cas_order" value="" />
		<p><?php _e('Enter your display order, only number.', 'continuous-scroller'); ?></p>
		
		<label for="tag-a"><?php _e('Display status', 'continuous-scroller'); ?></label>
		<select name="cas_status" id="cas_status">
			<option value='YES' selected="selected">Yes</option>
			<option value='NO'>No</option>
		</select>
		<p><?php _e('Please select your display status.', 'continuous-scroller'); ?></p>
		
	  <label for="tag-display-order"><?php _e('Publish', 'continuous-scroller'); ?></label>
      <input name="cas_datestart" type="text" id="cas_datestart" value="2014-07-01" maxlength="10" />
      <p><?php _e('Please enter the announcement publish date in this format YYYY-MM-DD.', 'continuous-scroller'); ?></p>
	  
	  <label for="tag-display-order"><?php _e('Expiration date', 'continuous-scroller'); ?></label>
      <input name="cas_dateend" type="text" id="cas_dateend" value="9999-12-30" maxlength="10" />
      <p><?php _e('Please enter the expiration date in this format YYYY-MM-DD <br /> 9999-12-30 : Is equal to no expire.', 'continuous-scroller'); ?></p>
		  
      <input name="cas_id" id="cas_id" type="hidden" value="">
      <input type="hidden" name="cas_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="<?php _e('Submit', 'continuous-scroller'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button" onclick="_cas_redirect()" value="<?php _e('Cancel', 'continuous-scroller'); ?>" type="button" />
        <input name="Help" lang="publish" class="button" onclick="_cas_help()" value="<?php _e('Help', 'continuous-scroller'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('cas_form_add'); ?>
    </form>
</div>
<p class="description">
	<?php _e('Check official website for more information', 'continuous-scroller'); ?>
	<a target="_blank" href="<?php echo cas_FAV; ?>"><?php _e('click here', 'continuous-scroller'); ?></a>
</p>
</div>