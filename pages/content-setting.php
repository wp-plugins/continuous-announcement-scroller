<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php _e('Continuous announcement scroller', 'continuous-scroller'); ?></h2>	
    <?php
	$cas_title = get_option('cas_title');
	$cas_total_rec = get_option('cas_total_rec');
	$cas_dis_count = get_option('cas_dis_count');
	$cas_rec_height = get_option('cas_rec_height');
	$cas_randomorder = get_option('cas_randomorder');
	
	$cas_speed = get_option('cas_speed');
	$cas_waitseconds = get_option('cas_waitseconds');
	
	if (isset($_POST['cas_form_submit']) && $_POST['cas_form_submit'] == 'yes')
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('cas_form_setting');
			
		$cas_title = stripslashes($_POST['cas_title']);
		$cas_total_rec = stripslashes($_POST['cas_total_rec']);
		$cas_dis_count = stripslashes($_POST['cas_dis_count']);
		$cas_rec_height = stripslashes($_POST['cas_rec_height']);
		$cas_randomorder = stripslashes($_POST['cas_randomorder']);
		
		$cas_speed = stripslashes($_POST['cas_speed']);
		$cas_waitseconds = stripslashes($_POST['cas_waitseconds']);
		
		update_option('cas_title', $cas_title );
		update_option('cas_total_rec', $cas_total_rec );
		update_option('cas_dis_count', $cas_dis_count );
		update_option('cas_rec_height', $cas_rec_height );
		update_option('cas_randomorder', $cas_randomorder );
		
		update_option('cas_speed', $cas_speed );
		update_option('cas_waitseconds', $cas_waitseconds );
		?>
		<div class="updated fade">
			<p><strong><?php _e('Details successfully updated.', 'continuous-scroller'); ?></strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo WP_cas_PLUGIN_URL; ?>/pages/setting.js"></script>
    <form name="cas_form" method="post" action="">
        <h3><?php _e('Setting', 'continuous-scroller'); ?></h3>
		
		<label for="tag-width"><?php _e('Widget title', 'continuous-scroller'); ?></label>
		<input name="cas_title" type="text" value="<?php echo $cas_title; ?>"  id="cas_title" size="50" maxlength="100">
		<p><?php _e('Please enter your widget title.', 'continuous-scroller'); ?></p>
		
		<label for="tag-width"><?php _e('Scroll height', 'continuous-scroller'); ?></label>
		<input name="cas_rec_height" type="text" value="<?php echo $cas_rec_height; ?>"  id="cas_rec_height" maxlength="3">
		<p><?php _e('If any overlap in the announcement text at front end, <br>you should arrange(increase/decrease) the height.', 'continuous-scroller'); ?> (Example: 40)</p>
		
		<label for="tag-width"><?php _e('Display record', 'continuous-scroller'); ?></label>
		<input name="cas_dis_count" type="text" value="<?php echo $cas_dis_count; ?>"  id="cas_dis_count" maxlength="3">
		<p><?php _e('Please enter number of records you want to display at the same time in scroll.', 'continuous-scroller'); ?> (Example: 5)</p>

		<label for="tag-width"><?php _e('Record to scroll', 'continuous-scroller'); ?></label>
		<input name="cas_total_rec" type="text" value="<?php echo $cas_total_rec; ?>"  id="cas_total_rec" maxlength="3">
		<p><?php _e('Please enter maximum number of records to scroll.', 'continuous-scroller'); ?> (Example: 10)</p>
		
		<label for="tag-title"><?php _e('Random', 'continuous-scroller'); ?></label>
		<select name="cas_randomorder" id="cas_randomorder">
			<option value='YES' <?php if($cas_randomorder == 'YES') { echo "selected='selected'" ; } ?>>Yes</option>
			<option value='NO' <?php if($cas_randomorder == 'NO') { echo "selected='selected'" ; } ?>>No</option>
		</select>
		<p><?php _e('Please select random display option.', 'continuous-scroller'); ?></p>
		
		<label for="cas_speed"><?php _e( 'Scrolling speed', 'continuous-scroller' ); ?></label>
		<?php _e( 'Slow', 'vertical-scroll-recent-post' ); ?> 
		<input name="cas_speed" type="range" value="<?php echo $cas_speed; ?>"  id="cas_speed" min="1" max="10" /> 
		<?php _e( 'Fast', 'vertical-scroll-recent-post' ); ?> 
		<p><?php _e( 'Set how fast you want to scroll.', 'continuous-scroller' ); ?></p>
		
		<label for="cas_waitseconds"><?php _e( 'Seconds to wait', 'vertical-scroll-recent-post' ); ?></label>
		<input name="cas_waitseconds" type="text" value="<?php echo $cas_waitseconds; ?>" id="cas_waitseconds" maxlength="4" />
		<p><?php _e( 'How many seconds you want the wait to scroll', 'continuous-scroller' ); ?> (<?php _e( 'Example', 'continuous-scroller' ); ?>: 5)</p>
		
		<input type="hidden" name="cas_form_submit" value="yes"/>
		<p class="submit">
		<input name="cas_submit" id="cas_submit" class="button" value="<?php _e('Submit', 'continuous-scroller'); ?>" type="submit" />
		<input name="publish" lang="publish" class="button" onclick="_cas_redirect()" value="<?php _e('Cancel', 'continuous-scroller'); ?>" type="button" />
		<input name="Help" lang="publish" class="button" onclick="_cas_help()" value="<?php _e('Help', 'continuous-scroller'); ?>" type="button" />
		</p>
		<?php wp_nonce_field('cas_form_setting'); ?>
    </form>
  </div>
<p class="description">
	<?php _e('Check official website for more information', 'continuous-scroller'); ?>
	<a target="_blank" href="<?php echo cas_FAV; ?>"><?php _e('click here', 'continuous-scroller'); ?></a>
</p>
</div>