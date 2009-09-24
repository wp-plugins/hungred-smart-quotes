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
	<?php    echo "<h1>" . __( 'Hungred Smart Quotes' ) . "</h1>"; ?>
	
	<form name="hsq_form" id="hsq_form" class="hsq_admin" onsubmit="return validate()" enctype="multipart/form-data" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<?php    echo "<h4>" . __( 'Settings' ) . "</h4>"; ?>
		<p><div class='label'><?php _e("Enabled Smart Quote On Wordpress: " ); ?>
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
		</div><input type="submit" id="submit" value="<?php _e('Update Options' ) ?>" />
		</p>

		<hr />
		<h2><?php _e("Support" ); ?></h2>
		<p>
		Please visit <a href="http://hungred.com/2009/09/24/useful-information/wordpress-plugin-hungred-smart-quotes/">hungred.com</a> for any support enquiry or email <a href='clay@hungred.com'>clay@hungred.com</a>. You can also show your appreciation by saying 'Thanks' on the <a href='http://hungred.com/2009/09/24/useful-information/wordpress-plugin-hungred-smart-quotes/'>plugin page</a> or visits our sponsors on <a href="http://hungred.com/2009/09/24/useful-information/wordpress-plugin-hungred-smart-quotes/">hungred.com</a> to help us keep up with the maintanance. If you like this plugin, you can buy me a <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=i_ah_yong%40hotmail%2ecom&lc=MY&item_name=Coffee&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted">coffee</a>! You can also support this development with the donation button. Thanks!
		<p>
<a href='http://www.pledgie.com/campaigns/6187'><img alt='Click here to lend your support to: Hungred Wordpress Development and make a donation at www.pledgie.com !' src='http://www.pledgie.com/campaigns/6187.png?skin_name=chrome' border='0' /></a>
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="ppbutton" onclick="window.open('https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=i_ah_yong%40hotmail%2ecom&lc=MY&item_name=Support%20Hungred%20Smart%20Quote%20Development&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest');return false;">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</p>
		</p>
	</form>
</div>
