<!--
/**
 *     Continuous announcement scroller
 *     Copyright (C) 2012  www.gopiplus.com
 *     http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
-->

<div class="wrap">
  <?php
  	global $wpdb;
    $mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=continuous-announcement-scroller/content-management.php";
    $DID=@$_GET["DID"];
    $AC=@$_GET["AC"];
    $submittext = "Insert Message";
	if($AC <> "DEL" and trim(@$_POST['cas_text']) <>"")
    {
			if(@$_POST['cas_id'] == "" )
			{
					$sql = "insert into ".WP_cas_TABLE.""
					. " set `cas_text` = '" . mysql_real_escape_string(trim($_POST['cas_text']))
					. "', `cas_link` = '" . $_POST['cas_link']
					. "', `cas_order` = '" . $_POST['cas_order']
					. "', `cas_status` = '" . $_POST['cas_status']
					. "'";	
			}
			else
			{
					$sql = "update ".WP_cas_TABLE.""
					. " set `cas_text` = '" . mysql_real_escape_string(trim($_POST['cas_text']))
					. "', `cas_link` = '" . $_POST['cas_link']
					. "', `cas_order` = '" . $_POST['cas_order']
					. "', `cas_status` = '" . $_POST['cas_status']
					. "' where `cas_id` = '" . $_POST['cas_id'] 
					. "'";	
			}
			$wpdb->get_results($sql);
    }
    
    if($AC=="DEL" && $DID > 0)
    {
        $wpdb->get_results("delete from ".WP_cas_TABLE." where cas_id=".$DID);
    }
    
    if($DID<>"" and $AC <> "DEL")
    {
        $data = $wpdb->get_results("select * from ".WP_cas_TABLE." where cas_id=$DID limit 1");
        if ( empty($data) ) 
        {
           echo "<div id='message' class='error'><p>No data available! use below form to create!</p></div>";
           return;
        }
        $data = $data[0];
        if ( !empty($data) ) $cas_id_x = htmlspecialchars(stripslashes($data->cas_id)); 
        if ( !empty($data) ) $cas_text_x = htmlspecialchars(stripslashes($data->cas_text));
		if ( !empty($data) ) $cas_link_x = htmlspecialchars(stripslashes($data->cas_link));
        if ( !empty($data) ) $cas_status_x = htmlspecialchars(stripslashes($data->cas_status));
		if ( !empty($data) ) $cas_order_x = htmlspecialchars(stripslashes($data->cas_order));
        $submittext = "Update Message";
    }
    ?>
  <h2>Continuous announcement scroller</h2>
  <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/continuous-announcement-scroller/setting.js"></script>
  <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/continuous-announcement-scroller/noenter.js"></script>
  <form name="form_mt" method="post" action="<?php echo @$mainurl; ?>" onsubmit="return cas_submit()"  >
    <table width="100%">
      <tr>
        <td colspan="2" align="left" valign="middle">Enter the message:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="cas_text" type="text" id="cas_text" value="<?php echo @$cas_text_x; ?>" size="125" /></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">Enter Link </td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="cas_link" type="text" id="cas_link" value="<?php echo @$cas_link_x; ?>" size="125" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Display Status:</td>
        <td align="left" valign="middle">Display Order:</td>
      </tr>
      <tr>
        <td width="22%" align="left" valign="middle"><select name="cas_status" id="cas_status">
            <option value="">Select</option>
            <option value='YES' <?php if(@$cas_status_x=='YES') { echo 'selected' ; } ?>>Yes</option>
            <option value='NO' <?php if(@$cas_status_x=='NO') { echo 'selected' ; } ?>>No</option>
          </select>
        </td>
        <td width="78%" align="left" valign="middle"><input name="cas_order" type="text" id="cas_order" size="10" value="<?php echo @$cas_order_x; ?>" maxlength="3" /></td>
      </tr>
      <tr>
        <td height="35" colspan="2" align="left" valign="bottom"><table width="100%">
            <tr>
              <td width="50%" align="left"><input name="publish" lang="publish" class="button-primary" value="<?php echo @$submittext?>" type="submit" />
                <input name="publish" lang="publish" class="button-primary" onclick="_cas_redirect()" value="Cancel" type="button" />
              </td>
              <td width="50%" align="right">
			  <input name="text_management1" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=continuous-announcement-scroller/content-management.php'" value="Go to - Text Management" type="button" />
        	  <input name="setting_management1" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=continuous-announcement-scroller/continuous-announcement-scroller.php'" value="Go to - Scroller Setting" type="button" />
			  <input name="Help1" lang="publish" class="button-primary" onclick="_cas_help()" value="Help" type="button" />
			  </td>
            </tr>
          </table></td>
      </tr>
      <input name="cas_id" id="cas_id" type="hidden" value="<?php echo @$cas_id_x; ?>">
    </table>
  </form>
  <div class="tool-box">
    <?php
	$data = $wpdb->get_results("select * from ".WP_cas_TABLE." order by cas_order");
	if ( empty($data) ) 
	{ 
		echo "<div id='message' class='error'>No data available! use below form to create!</div>";
		return;
	}
	?>
    <form name="frm_hsa" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="4%" align="left" scope="col">ID
              </td>
            <th width="68%" align="left" scope="col">Message
              </td>
            <th width="8%" align="left" scope="col"> Order
              </td>
            <th width="7%" align="left" scope="col">Display
              </td>
            <th width="13%" align="left" scope="col">Action
              </td>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $data as $data ) { 
		if($data->cas_status=='YES') { $displayisthere="True"; }
        ?>
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
            <td align="left" valign="middle"><?php echo(stripslashes($data->cas_id)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->cas_text)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->cas_order)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->cas_status)); ?></td>
            <td align="left" valign="middle"><a href="options-general.php?page=continuous-announcement-scroller/content-management.php&DID=<?php echo($data->cas_id); ?>">Edit</a> &nbsp; <a onClick="javascript:_cas_delete('<?php echo($data->cas_id); ?>')" href="javascript:void(0);">Delete</a> </td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
        <?php if($displayisthere<>"True") { ?>
        <tr>
          <td colspan="5" align="center" style="color:#FF0000" valign="middle">No message available with display status 'Yes'!' </td>
        </tr>
        <?php } ?>
      </table>
    </form>
  </div>
  <table width="100%">
    <tr>
      <td align="right"><input name="text_management" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=continuous-announcement-scroller/content-management.php'" value="Go to - Text Management" type="button" />
        <input name="setting_management" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=continuous-announcement-scroller/continuous-announcement-scroller.php'" value="Go to - Scroller Setting" type="button" />
		<input name="Help" lang="publish" class="button-primary" onclick="_cas_help()" value="Help" type="button" />
      </td>
    </tr>
  </table>
  <?php include_once("help.php"); ?>
</div>
