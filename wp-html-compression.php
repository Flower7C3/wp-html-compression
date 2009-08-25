<?php
/*
Plugin Name: WP-HTML-Compression
Plugin URI: http://www.svachon.com/wp-html-compression/
Description: Reduce file size by safely removing all standard comments and unnecessary white space from an HTML document.
Version: 0.1
Author: Steven Vachon
Author URI: http://www.svachon.com/
Author Email: prometh@gmail.com
*/

function wp_html_compression()
{
	function wp_html_compression_main($buffer)
	{
		$compress_css = true;
		$compress_js = false;
		$remove_comments = true;
		
		$initial = strlen($buffer);
		
		$pattern = '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
		
		preg_match_all($pattern, $buffer, $len, PREG_SET_ORDER);
		
		$overriding = false;
		$raw_tag = false;
		
		foreach ($len as $token)
		{
			$tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;
			
			$content = $token[0];
			
			if (is_null($tag))
			{
				if ($token['script'] != '')
				{
					$strip = $compress_js;
				}
				else if ($token['style'] != '')
				{
					$strip = $compress_css;
				}
				else if ($content == '<!--wp-compress-html no compression-->')
				{
					$overriding = !$overriding;
					
					// Don't print the comment
					continue;
				}
			}
			else
			{
				if ($tag == 'pre' || $tag == 'textarea')
				{
					$raw_tag = true;
				}
				else if ($tag == '/pre' || $tag == '/textarea')
				{
					$raw_tag = false;
				}
				else
				{
					if ($raw_tag || $overriding)
					{
						$strip = false;
					}
					else
					{
						$strip = true;
					}
				}
			}
			
			if ($strip)
			{
				$content = str_replace("\t", ' ', $content);
				$content = str_replace("\n",  '', $content);
				$content = str_replace("\r",  '', $content);
				
				while (stristr($content, '  '))
				{
					$content = str_replace('  ', ' ', $content);
				}
			}
			
			$buffer_out .= $content;
		}
		
		// Remove all HTML comments, except MSIE conditional comments
		$buffer_out = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/', '', $buffer_out);
		
		$final = strlen($buffer_out);
		$savings = ($initial-$final)/$initial*100;
		$savings = round($savings, 2);
		$buffer_out .= "\n<!--WP-HTML-Compression crunched this document by $savings%. The file was $initial bytes, but is now $final bytes-->";
		
		return $buffer_out;
	}
	
	ob_start('wp_html_compression_main');
}

add_action('get_header', 'wp_html_compression');
?>