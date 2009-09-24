<?php
/*
Plugin Name: Hungred Smart Quotes
Plugin URI: 
Description: This plugin remove and update any formatted tag to its original text due to wordpress smart quotes capability
Author: Clay lua
Version: 0.3
Author URI: http://hungred.com
*/

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


/*
Structure of the plugin
*/
/*
Name: add_hsq_to_admin_panel_actions
Usage: use to add an options on the Setting section of Wordpress
Parameter: 	NONE
Description: this method depend on hsq_admin for the interface to be produce when the option is created
			 on the Setting section of Wordpress
*/
function add_hsq_to_admin_panel_actions() {
    $plugin_page = add_options_page("Hungred Smart Quotes", "Hungred Smart Quotes", 10, "Hungred Smart Quotes", "hsq_admin");  
	add_action( 'admin_head-'. $plugin_page, 'hsq_admin_header' );

}
/*
Name: hsq_admin_header
Usage: stop hif admin page from caching
Parameter: 	NONE
Description: this method is to stop hif admin page from caching so that the preview is shown.
*/
function hsq_admin_header()
{
nocache_headers();
}
/*
Name: hsq_admin
Usage: provide the GUI of the admin page
Parameter: 	NONE
Description: this method depend on hsq_admin_page.php to display all the relevant information on our admin page
*/
function hsq_admin(){
	include('hsq_admin_page.php');  
}

add_action('admin_menu', 'add_hsq_to_admin_panel_actions');

/*
Name: hsq_loadcss
Usage: load the relevant CSS external files into Wordpress post section
Parameter: 	NONE
Description: uses wp_enqueue_style for safe printing of CSS style sheets
*/
function hsq_loadcss()
{
	wp_enqueue_style('hsq_ini',WP_PLUGIN_URL.'/hungred-smart-quotes/css/hsq_ini.css');
}
add_action('admin_print_styles', 'hsq_loadcss');
function hsq_id()
{
	echo "
	<!-- This site is power up by Hungred Smart Quotes -->
	";
}
add_action('wp_head', 'hsq_id');
/*
Name: hsq_install
Usage: upload all the table required by this plugin upon activation for the first time
Parameter: 	NONE
Description: the structure of our Wordpress plugin
*/
function hsq_install()
{
	global $wpdb;
	
    $table = $wpdb->prefix."hsq_options";
    $structure = "CREATE TABLE IF NOT EXISTS `".$table."` (
		hsq_option_id DOUBLE NOT NULL AUTO_INCREMENT ,
        hsq_additional_allowed_format varchar(254) NOT NULL DEFAULT '\"[php]\"',
		hsq_enable varchar(1) NOT NULL DEFAULT 'Y',
		UNIQUE KEY id (hsq_option_id)
    );";
    $wpdb->query($structure);
	$wpdb->query("INSERT INTO $table(hsq_option_id)
	VALUES('1')");
}
if ( function_exists('register_activation_hook') )
	register_activation_hook('hungred-smart-quotes/hungred-smart-quotes.php', 'hsq_install');
	
/*
Name: hsq_uninstall
Usage: delete hif table
Parameter: 	NONE
Description: the structure of our Wordpress plugin
*/
function hsq_uninstall()
{
	global $wpdb;
	$table = $wpdb->prefix."hsq_options";
	$structure = "DROP TABLE `".$table."`";
	$wpdb->query($structure);
}
if ( function_exists('register_uninstall_hook') )
    register_uninstall_hook(__FILE__, 'hsq_uninstall');
	
function hsq_return_format($text)
{
	//required 3 decode to fully properly decode the text, especially when text too long in a page. bug in PHP
	$text = @htmlspecialchars_decode ($text);
	$text = @htmlspecialchars_decode ($text);
	$text = @htmlspecialchars_decode ($text);

	$text = hsq_wp_specialchars_decode($text);

	$text = str_replace( '&#039;', "'", $text );

	return $text;
}
function hsq_wp_specialchars_decode( $string, $quote_style = ENT_NOQUOTES ) {
	$string = (string) $string;

	if ( 0 === strlen( $string ) ) {
		return '';
	}

	// Don't bother if there are no entities - saves a lot of processing
	// if ( strpos( $string, '&' ) === false ) {
		// return $string;
	// }

	// Match the previous behaviour of _wp_specialchars() when the $quote_style is not an accepted value
	if ( empty( $quote_style ) ) {
		$quote_style = ENT_NOQUOTES;
	} elseif ( !in_array( $quote_style, array( 0, 2, 3, 'single', 'double' ), true ) ) {
		$quote_style = ENT_QUOTES;
	}

	// More complete than get_html_translation_table( HTML_SPECIALCHARS )
	$single = array( '&#039;'  => '\'', '&#x27;' => '\'' );
	$single_preg = array( '/&#0*39;/'  => '&#039;', '/&#x0*27;/i' => '&#x27;' );
	$double = array( '&quot;' => '"', '&#034;'  => '"', '&#x22;' => '"' );
	$double_preg = array( '/&#0*34;/'  => '&#034;', '/&#x0*22;/i' => '&#x22;' );
	$others = array( '&lt;'   => '<', '&#060;'  => '<', '&gt;'   => '>', '&#062;'  => '>', '&amp;'  => '&', '&#038;'  => '&', '&#x26;' => '&' );
	$others_preg = array( '/&#0*60;/'  => '&#060;', '/&#0*62;/'  => '&#062;', '/&#0*38;/'  => '&#038;', '/&#x0*26;/i' => '&#x26;' );

	if ( $quote_style === ENT_QUOTES ) {
		$translation = array_merge( $single, $double, $others );
		$translation_preg = array_merge( $single_preg, $double_preg, $others_preg );
	} elseif ( $quote_style === ENT_COMPAT || $quote_style === 'double' ) {
		$translation = array_merge( $double, $others );
		$translation_preg = array_merge( $double_preg, $others_preg );
	} elseif ( $quote_style === 'single' ) {
		$translation = array_merge( $single, $others );
		$translation_preg = array_merge( $single_preg, $others_preg );
	} elseif ( $quote_style === ENT_NOQUOTES ) {
		$translation = $others;
		$translation_preg = $others_preg;
	}

	// Remove zero padding on numeric entities
	$string = preg_replace( array_keys( $translation_preg ), array_values( $translation_preg ), $string );
	$important = array( '<!'   => '&lt;!', '<?'  => '&lt;?', '<head'   => '&lt;head', '<body'  => '&lt;body', 
	'<meta'  => '&lt;meta', '<title'  => '&lt;title', '<html' => '&lt;html', '</html' => '&lt;/html', 
	'</body' => '&lt;/body', '</head' => '&lt;/head', '</title' => '&lt;/title', '</style' => '&lt;/style', 
	'</script' => '&lt;/script', '<style' => '&lt;style', '<script' => '&lt;script' , '<link' => '&lt;link');
	$string = strtr (strtr( $string, $translation ), $important);
	
	// Replace characters according to translation table
	return hsq_encode("<pre",'<\/pre', $string);
}

function hsq_encode($find, $stop, &$src)
{
	$rex = '/'.$find.'[\S\w\W]*?'.$stop.'/i';
	preg_match_all($rex, $src, $matches);

	if($matches[0] != NULL)
	foreach($matches[0] as $e){
		$start = strpos($e, $find);
		if($start !== FALSE)
		{
			
			$start = strpos($e, ">", $start)+1;
			$end = strrpos($e, $stop, $start);	
			$value = substring($e, $start, $end);
			$encoded_value = str_replace('<', '&lt;', $value);
			$new_e = str_replace($value, $encoded_value, $e);	
			$src = str_replace($e, $new_e, $src);	
		}
	}
	
	return $src;
}
function substring($str,$start,$end){
   return substr($str,$start,($end-$start));
}
function hsq_wptexturize($text) {
	global $wp_cockneyreplace;
	$output = '';
	$curl = '';
	$textarr = preg_split('/(<.*>|\[.*\])/Us', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
	$stop = count($textarr);
	
	/* translators: opening curly quote */
	$opening_quote = _x('&#8220;', 'opening curly quote');
	/* translators: closing curly quote */
	$closing_quote = _x('&#8221;', 'closing curly quote');
	
	global $wpdb;
	$table = $wpdb->prefix."hsq_options";
	//retrieve new data
	$query = "SELECT `hsq_additional_allowed_format` FROM `".$table."` WHERE 1 AND `hsq_option_id` = '1' limit 1";
	$row = $wpdb->get_row($query,ARRAY_A);
	$no_texturize_tags = apply_filters('no_texturize_tags', array('pre', 'code', 'kbd', 'style', 'script', 'tt', stripcslashes($row['hsq_additional_allowed_format'])));
	$no_texturize_shortcodes = apply_filters('no_texturize_shortcodes', array('code'));
	$no_texturize_tags_stack = array();
	$no_texturize_shortcodes_stack = array();

	// if a plugin has provided an autocorrect array, use it
	if ( isset($wp_cockneyreplace) ) {
		$cockney = array_keys($wp_cockneyreplace);
		$cockneyreplace = array_values($wp_cockneyreplace);
	} else {
		$cockney = array("'tain't","'twere","'twas","'tis","'twill","'til","'bout","'nuff","'round","'cause");
		$cockneyreplace = array("&#8217;tain&#8217;t","&#8217;twere","&#8217;twas","&#8217;tis","&#8217;twill","&#8217;til","&#8217;bout","&#8217;nuff","&#8217;round","&#8217;cause");
	}

	$static_characters = array_merge(array('---', ' -- ', '--', ' - ', 'xn&#8211;', '...', '``', '\'s', '\'\'', ' (tm)'), $cockney);
	$static_replacements = array_merge(array('&#8212;', ' &#8212; ', '&#8211;', ' &#8211; ', 'xn--', '&#8230;', $opening_quote, '&#8217;s', $closing_quote, ' &#8482;'), $cockneyreplace);

	$dynamic_characters = array('/\'(\d\d(?:&#8217;|\')?s)/', '/(\s|\A|")\'/', '/(\d+)"/', '/(\d+)\'/', '/(\S)\'([^\'\s])/', '/(\s|\A)"(?!\s)/', '/"(\s|\S|\Z)/', '/\'([\s.]|\Z)/', '/(\d+)x(\d+)/');
	$dynamic_replacements = array('&#8217;$1','$1&#8216;', '$1&#8243;', '$1&#8242;', '$1&#8217;$2', '$1' . $opening_quote . '$2', $closing_quote . '$1', '&#8217;$1', '$1&#215;$2');

	for ( $i = 0; $i < $stop; $i++ ) {
		$curl = $textarr[$i];

		if ( !empty($curl) && '<' != $curl{0} && '[' != $curl{0}
				&& empty($no_texturize_shortcodes_stack) && empty($no_texturize_tags_stack)) { // If it's not a tag
			// static strings
			$curl = str_replace($static_characters, $static_replacements, $curl);
			// regular expressions
			$curl = preg_replace($dynamic_characters, $dynamic_replacements, $curl);
		} else {
			wptexturize_pushpop_element($curl, $no_texturize_tags_stack, $no_texturize_tags, '<', '>');
			wptexturize_pushpop_element($curl, $no_texturize_shortcodes_stack, $no_texturize_shortcodes, '[', ']');
		}

		$curl = preg_replace('/&([^#])(?![a-zA-Z1-4]{1,8};)/', '&#038;$1', $curl);
		$output .= $curl;
	}

	return $output;
}

global $wpdb;
$table = $wpdb->prefix."hsq_options";
//retrieve new data
$query = "SELECT `hsq_enable` FROM `".$table."` WHERE 1 AND `hsq_option_id` = '1' limit 1";
$row = $wpdb->get_row($query,ARRAY_A);
if($row['hsq_enable'] == 'Y')
{
	add_filter('the_content', 'hsq_return_format');
	add_filter('the_excerpt', 'hsq_return_format');
	add_filter('comment_text', 'hsq_return_format');
	add_filter('the_rss_content', 'hsq_return_format');
	add_filter('the_rss_content', 'hsq_wptexturize');
	add_filter('the_content', 'hsq_wptexturize');
	add_filter('the_excerpt', 'hsq_wptexturize');
	add_filter('comment_text', 'hsq_wptexturize');
	remove_filter('comment_text', 'wptexturize');
	remove_filter('the_excerpt', 'wptexturize');
	remove_filter('the_content', 'wptexturize');
	remove_filter('the_rss_content', 'wptexturize');
}
else
{
	remove_filter('comment_text', 'wptexturize');
	remove_filter('the_excerpt', 'wptexturize');
	remove_filter('the_content', 'wptexturize');
	remove_filter('the_rss_content', 'wptexturize');
}
?>