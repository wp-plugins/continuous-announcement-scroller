<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php echo cas_TITLE; ?></h2>	
    <?php
	$cas_title = get_option('cas_title');
	$cas_total_rec = get_option('cas_total_rec');
	$cas_dis_count = get_option('cas_dis_count');
	$cas_rec_height = get_option('cas_rec_height');
	$cas_randomorder = get_option('cas_randomorder');
	
	if (isset($_POST['cas_form_submit']) && $_POST['cas_form_submit'] == 'yes')
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('cas_form_setting');
			
		$cas_title = stripslashes($_POST['cas_title']);
		$cas_total_rec = stripslashes($_POST['cas_total_rec']);
		$cas_dis_count = stripslashes($_POST['cas_dis_count']);
		$cas_rec_height = stripslashes($_POST['cas_rec_height']);
		$cas_randomorder = stripslashes($_POST['cas_randomorder']);
		
		update_option('cas_title', $cas_title );
		update_option('cas_total_rec', $cas_total_rec );
		update_option('cas_dis_count', $cas_dis_count );
		update_option('cas_rec_height', $cas_rec_height );
		update_option('cas_randomorder', $cas_randomorder );
		
		?>
		<div class="updated fade">
			<p><strong>Details successfully updated.</strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/continuous-announcement-scroller/pages/setting.js"></script>
    <form name="cas_form" method="post" action="">
        <h3>Setting</h3>
		
		<label for="tag-width">Widget title</label>
		<input name="cas_title" type="text" value="<?php echo $cas_title; ?>"  id="cas_title" size="70" maxlength="100">
		<p>Please enter your widget title.</p>
		
		<label for="tag-width">Scroll height</label>
		<input name="cas_rec_height" type="text" value="<?php echo $cas_rec_height; ?>"  id="cas_rec_height" maxlength="3">
		<p>If any overlap in the announcement text at front end, you should arrange(increase/decrease) the height. (Example: 40)</p>
		
		<label for="tag-width">Display record</label>
		<input name="cas_dis_count" type="text" value="<?php echo $cas_dis_count; ?>"  id="cas_dis_count" maxlength="3">
		<p>Please enter number of records you want to display at the same time in scroll. (Example: 5)</p>

		<label for="tag-width">Record to scroll</label>
		<input name="cas_total_rec" type="text" value="<?php echo $cas_total_rec; ?>"  id="cas_total_rec" maxlength="3">
		<p>Please enter maximum number of records to scroll. (Example: 10)</p>
		
		<label for="tag-title">Random</label>
		<select name="cas_randomorder" id="cas_randomorder">
			<option value='YES' <?php if($cas_randomorder == 'YES') { echo "selected='selected'" ; } ?>>Yes</option>
			<option value='NO' <?php if($cas_randomorder == 'NO') { echo "selected='selected'" ; } ?>>No</option>
		</select>
		<p>Please select random display option.</p>
		
		
		
		<input type="hidden" name="cas_form_submit" value="yes"/>
		<p class="submit">
		<input name="cas_submit" id="cas_submit" class="button" value="Submit" type="submit" />
		<input name="publish" lang="publish" class="button" onclick="_cas_redirect()" value="Cancel" type="button" />
		<input name="Help" lang="publish" class="button" onclick="_cas_help()" value="Help" type="button" />
		</p>
		<?php wp_nonce_field('cas_form_setting'); ?>
    </form>
  </div>
  <p class="description"><?php echo cas_LINK; ?></p>
</div>
