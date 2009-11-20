=== WP-HTML-Compression ===
Author: Steven Vachon
URL: http://www.svachon.com/
Contact: prometh@gmail.com
Contributors: prometh, mandar-marathe
Tags: comment, comments, compress, compression, html, minify, space, template
Requires at least: 2.8.4
Tested up to: 2.9
Stable tag: trunk

Reduce file size by safely removing all standard comments and unnecessary white space from an HTML document.


== Description ==

Combining HTML compression with cache and HTTP compression will cut down your bandwidth and ensure near-immediate content delivery.

With this plugin, you can compress your HTML by removing standard comments, new lines, carriage returns, tabs and excess spaces. More importantly, all this can be done without &lt;pre&gt;, &lt;textarea&gt; and &lt;script&gt; tag issues.

Development of this plugin started with the intent of updating **[WP-Compress-HTML](http://wordpress.org/extend/plugins/wp-compress-html/)**. Although it was soon realized that to achieve what was required, the whole thing needed to be rewritten. Backwards compatibility with WP-Compress-HTML's compression override was also broken. The WP-Compress-HTML developer was included as a co-author for this plugin because a couple of his ideas were used.


== Installation ==

1. Download the plugin (zip file).
2. Upload and activate the plugin through the "Plugins" menu in the WordPress admin.


== Frequently Asked Questions ==

= Will this plugin slow my page loading times? =

Yes, slightly. Use **[WP Super Cache](http://wordpress.org/extend/plugins/wp-super-cache/)**.

= Will Internet Explorer conditional comments be removed? =

No. :-)

= How do I mark areas that should not be compressed? =

While &lt;pre&gt;, &lt;textarea&gt; and &lt;script&gt; tags are automatically left uncompressed, you can designate any code to be exempted from compression. Simply drop your content between a pair of &lt;!--wp-html-compression no compression--&gt; comment tags. A picture is worth a thousand words— check the **[screenshots](http://wordpress.org/extend/plugins/wp-html-compression/screenshots/)**.

= I'd like to compress the contents of &lt;script&gt; tags. Can I do this? =

Until a settings page is created, you'll have to edit the file from the "Plugins" menu in the WordPress admin. Look for the $compress_js variable and set it to true.

= Are you or have you thought of using HTML Tidy? =

Since not every WordPress server supports the installation of PHP extensions, this plugin does not currently make use of HTML Tidy. However, future releases might.

= Will this work for WordPress version x.x.x? =

This plugin has only been tested with versions of WordPress as early as 2.8.4. For anything older, you'll have to see for yourself.


== Screenshots ==

1. This is what the XHTML looks like after being compressed with WP-HTML-Compression.
2. This is what the same XHTML from the above screenshot looked like prior to compression.
3. This is an example of how to use the compression override.


== Changelog ==

= 0.3 =
* Comments in &lt;textarea&gt; are no longer removed. Browsers seem to display such text
* Removes excess spacing within &lt;br/&gt;, &lt;hr/&gt;, &lt;img/&gt; and &lt;input/&gt; tags
* Speed optimizations

= 0.2 =
* Fixed compression override

= 0.1 =
* Initial release