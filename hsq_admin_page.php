<?php
/*  Copyright 2009  Clay Lua  (email : clay@hungred.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
global $wpdb;
$error = "";
$table = $wpdb->prefix."hsq_options";

if(isset($_POST['hsq_additional_allowed_format']))
{
//update the database with Replace instead of insert to avoid duplication data in the table
	$query = "REPLACE INTO $table(hsq_option_id, hsq_additional_allowed_format,hsq_enable) 
	VALUES('1', '".addslashes_gpc($_POST['hsq_additional_allowed_format'])."', '".$_POST['hsq_enable']."')";
	$wpdb->query($query);
}

//retrieve new data
$query = "SELECT * FROM `".$table."` WHERE 1 AND `hsq_option_id` = '1' limit 1";
$row = $wpdb->get_row($query,ARRAY_A);


?>
<div class="hsq_wrap">
	<div class="wrap">
	<?php    echo "<h2>" . __( 'Hungred Smart Quotes Configuration' ) . "</h2>"; ?>
	</div>
	<form name="hsq_form" id="hsq_form" class="hsq_admin" onsubmit="return validate()" enctype="multipart/form-data" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<div class="postbox-container" id="hsq_admin">
		<div class="metabox-holder">		
			<div class="meta-box-sortables ui-sortable" >
				<div class='postbox'>	
					<?php    echo "<h3  class='hndle'>" . __( 'Settings' ) . "</h3>"; ?>
					<div class='inside size'>
					<p><div class='label'><?php _e("Enabled Smart Quote" ); ?>
					</div><SELECT id="hsq_enable" name="hsq_enable">
					<?php 
					if($row['hsq_enable'] == "Y"){ ?>
					<option selected value="Y">YES</option>
					<option value="N">NO</option>
					<?php }else{?>
					<option value="Y">YES</option>
					<option selected value="N">NO</option>
					<?php }?>
					</SELECT>
					</p>
					<p><div class='label'><?php _e("Additional Tag" ); ?></div><input type="text" id="hsq_additional_allowed_format" name="hsq_additional_allowed_format" value='<?php echo stripslashes($row['hsq_additional_allowed_format']); ?>' size="20"><?php _e('eg, "[php]", "{php}"' ); ?></p>	
					
					
					<p class="submit">
					<input type="submit" id="submit" value="<?php _e('Update Options' ) ?>" />
					</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	</form>
	
</div>
