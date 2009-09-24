=== Plugin Name ===
Contributors: Clay Lua
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=i_ah_yong%40hotmail%2ecom&lc=MY&item_name=Coffee&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: hungred, smart, quotes, quote, formatted, text, unformat, format, remover, remove, encode, decode, syntaxhigher evolved
Requires at least: 2.7
Tested up to: 2.8.4
Stable tag: 0.3

This plugin is created by Clay Lua. Please visit the plugin page for more information.

== Description ==
This is a small plugin that replace the smart quotes function in Wordpress that format/encode the code in Wordpress. Hence, most symbols will be formatted/encoded
 by Wordpress texturize function.
Example, 
'&' (ampersand) becomes '&amp;'
'"' (double quote) becomes '&quot;' 
''' (single quote) becomes '&#039;' 
'<' (less than) becomes '&lt;'
'>' (greater than) becomes '&gt;'

The plugin will help solve the above problem and produce the result below,

Example, 
'&amp;' (ampersand) becomes '&'
'&quot;' (double quote) becomes '"' 
'&#039;' (single quote) becomes ''' 
'&lt;' (less than) becomes '<'
'&gt;' (greater than) becomes '>'

A control panel is also provided in this plugin to add in special tag for your code or disable smart quote in Wordpress.
This problem is due to external code format plugin that required special tag such as [php] in syntaxhigher evolved.
Upon, activate, all existing article that was previously formatted will be decoded by this plugin while future article will be protected by
the replaced texturize function for Wordpress (so that the plugin tells Wordpress texturize function to include your special tag from encode/format).

Hence, this plugin still provides you with the functionality of smart quote with the additional add on features to ease your life. Please visit hungred.com for more information and screenshot

== Installation ==

   1. Download the latest version of the Hungred Image Fit to your computer.
   2. With an FTP program, access your site¡¯s server.
   3. Upload (copy) the Plugin file(s) or folder to the /wp-content/plugins folder.
   4. In your WordPress Administration Panels, click on Plugins from the menu.
   5. You should see your Hungred Post Thumbnal Plugin listed. If not, with your FTP program, check the folder to see if it is installed. If it isn¡¯t, upload the file(s) again. If it is, delete the files and upload them again.
   6. To turn the WordPress Plugin on, click Activate which is located around the Hungred Post Thumbnail Plugin.
   7. Check your Administration Panels or WordPress blog to see if the Plugin is working.

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==
= 0.1 =
* initial version
= 0.2 =
* Fixed some character wasn't decode problem
* Added options to stop Wordpress smart quotes
= 0.3 =
* Fixed some important character get recognized as code problem
