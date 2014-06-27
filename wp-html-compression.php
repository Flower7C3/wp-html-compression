<?php

/*
  Plugin Name: Content Compression
  Description: Reduce file size by shortening URLs and safely removing all standard comments and unnecessary whitespace from an HTML document.
  Version: 0.1
  Author: Bartłomiej Jakub Kwiatek
  Author URI: http://kwiatek.pro/
  Origin Plugin Name: WP-HTML-Compression
  Origin Plugin URI: http://www.svachon.com/blog/html-minify/
  Origin Description: Reduce file size by shortening URLs and safely removing all standard comments and unnecessary whitespace from an HTML document.
  Origin Version: 0.5.8
  Origin Author: Steven Vachon
  Origin Author URI: http://www.svachon.com/
  Origin Author Email: contact@svachon.com
 */

/* config */
$compress_css = true;
$compress_js = true;
$info_comment = false;
$remove_comments = true;
$shorten_urls = true;

/* libs */
require_once 'libs/html-minify.php';
if (!function_exists('absolute_to_relative_url')) {
    require_once 'libs/absolute-to-relative-urls.php';
}

$wp_html_compression_run = false;

function wp_html_compression_start() {
    global $wp_html_compression_run;
    if (!$wp_html_compression_run) {
        $wp_html_compression_run = true;
        // "Humans TXT" plugin support
        $is_humans = (!function_exists('is_humans')) ? false : is_humans();
        if (!$is_humans && !is_feed() && !is_robots()) {
            ob_start('html_minify_buffer');
        }
    }
}

// Prevents errors when this file is accessed directly
if (function_exists('is_admin')) {
    if (!is_admin()) {
        add_action('template_redirect', 'wp_html_compression_start', -1);
        // In case above fails (it does sometimes.. ??)
        add_action('get_header', 'wp_html_compression_start');
    } else {
        // For v0.6
        //require_once dirname(__FILE__) . '/admin.php';
    }
}

function html_minify_buffer($html) {
    global $compress_css, $compress_js, $info_comment, $remove_comments, $shorten_urls;
    return new HTML_Minify($html, $compress_css, $compress_js, $info_comment, $remove_comments, $shorten_urls);
}
