=== WordPress Image Resizer ===
Contributors: jeferonix
Donate link: http://vestaldesign.com/
Tags: images, resizing, imagemagick
Requires at least: Unknown
Tested up to: 2.1
Stable tag: trunk

Parses img tags out of the_content and aggregates resized versions of the images in an "images" div.  Also links to full-quality versions.

== Description ==

Finds img tags in the post content, parses them out, and aggregates web-sized versions of the images in an "images" div which is echoed *before* the post content.  It also generates a "presskit" div *after* the post content which has links to full-quality versions, under a forced-download.

== Installation ==

REQUIRES: PHP 4+
OPTIONAL BUT HIGHLY RECOMMENDED: ImageMagick

TO INSTALL: drop the wp-image-resizer folder into wp-plugins.  Then:

1) If you want to use ImageMagick (HIGHLY recommended, it won't resize images over 800k or so otherwise) open /thumb/phpThumb.config.php and on line 132:

$PHPTHUMB_CONFIG['imagemagick_path'] = '/your/imagemagick/directory/ImageMagick-6.3.6/bin/convert';

2) change the first line of embed_image_tag() in this file to your desired width:

$imgSize = 400; # desired width

3) read /thumb/docs/phpthumb.readme.txt for other manipulation options.  This currently does an "unsharp mask" (fltr=usm) to make the smaller versions nice and sharp.

4) Go to /wp-admin/plugins.php and enable "WordPress Image Resizer"

== Frequently Asked Questions ==

=Why is this not working? or Why aren't the resized versions being generated?=

For more efficient loading we use relative paths to access the image.  If you have the images stored somewhere crazy, or if you do hard .htaccess redirects, you may want to comment out the following lines in embed_image_tag() :
	
`
////// RELATIVE IMAGE PATHS ////////
	$exploded = explode("/",$home);
	$base_url = $exploded[0]."//".$exploded[2]; # cut off anything up to ".com" or ".net" etc... so if your blog is at http://poop.com/blog/, $base_url will yield only "http://poop.com"
	$link = str_replace($base_url, "/", $link);
	$link = str_replace("//", "/", $link); # Sometimes get_bloginfo('home') has a trailing slash (this may be unnecessary)
////////////////////////////////////
`

== Screenshots ==

1. No screenshots.

== Usage Instructions ==

1) Just upload your original, huge, gonzo-gigantic images normally in the WordPress Upload form when writing a post or page.  This script will find 'em and do its stuff.

2) To "exempt" images from this script, write 'class="custom"' EXACTLY LIKE THIS:

<img class="custom" ...

It looks for the string '<img class="custom"' and skips those.  I would have made it smarter (regex) but might as well save on horsepower by not using regex.

3) Write to us at webdesign@vestaldesign.com with suggestions and improvements!
