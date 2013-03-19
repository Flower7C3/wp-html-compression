<?php
/*
Plugin Name: WP-HTML-Compression
Plugin URI: http://www.svachon.com/blog/html-minify/
Description: Reduce file size by shortening URLs and safely removing all standard comments and unnecessary whitespace from an HTML document.
Version: 0.5.5.1
Author: Steven Vachon
Author URI: http://www.svachon.com/
Author Email: contact@svachon.com
*/

require_once 'libs/html-minify.php';

$wp_html_compression_run = false;



function wp_html_compression_start()
{
	global $wp_html_compression_run;
	
	if (!$wp_html_compression_run && !is_feed() && !is_robots())
	{
		$wp_html_compression_run = true;
		
		ob_start('html_minify_buffer');
	}
}



// Prevents errors when this file is accessed directly
if (function_exists('is_admin'))
{
	if (!is_admin())
	{
		add_action('template_redirect', 'wp_html_compression_start', -1);
		
		// In case above fails (it does sometimes.. ??)
		add_action('get_header', 'wp_html_compression_start');
	}
	else
	{
		// For v0.6
		//require_once dirname(__FILE__) . '/admin.php';
	}
}



?>