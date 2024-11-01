<?php
/*
Plugin Name: WordPress Image Resizer
Plugin URI: http://www.vestaldesign.com/blog/2007/10/wordpress-image-resizer-plugin.html
Description: Finds '.jpg"' and also png, gif, and converts to 'phpThumb.php?src=xxxxx.jpg&w=###
	Then, on-the-fly resizing of .JPG images down to specified width, but only if they exceed that width.
Author: Jeffrey Warren
Version: 0.1
Author URI: http://www.vestaldesign.com
*/

// Supporting function that returns the complete HTML code needed to display a resized .JPG image
// Requires:  Absolute or relative URL where the image file is located
// Returns:  Complete HTML code needed to display the resized .jpg image

function embed_image_tag($link)
{

	$imgSize = 400; # width
	$home = get_bloginfo('home'); # "http://www.environmentalhealthclinic.net"
	$home2 = str_replace("www.", "", $home);

	$link = str_replace($home2, "/", $link);
	$link = str_replace($home, "/", $link);

    $imgTag = "<img src=\"".$home."/wp-content/plugins/wp-image-resizer/thumb/phpThumb.php?fltr=usm&src=$link&w=$imgSize\" />";
	return($imgTag);
}

// Supporting Function that scans the entire body of a post for <img /> tags
// An absolute or relative URL is expected to be found between these tags.

function imgReplace($text)
{
	$tag_pattern = '/(<img[^s]+(st[^s]+src=|src=)["\'](.*?)["\'][^>]+>)/i';
	$images = "<div class='images'>";
	$presskit = "<div class='presskit'><h3>High Resolution Press Images:</h3>";

    if (preg_match_all ($tag_pattern, $text, $matches)) {
        unset($technotags);
        $aplayertags = "";
        for ($m=0; $m<count($matches[0]); $m++) {
            unset($atags);
            $atags = explode(",", $matches[3][$m]);
			if (substr($matches[0][$m],5,19)!='class="custom"') : #if it has 'class="custom"' then don't switch
            	$images = $images."<a href='".$matches[3][$m]."'>".embed_image_tag($matches[3][$m])."</a>";
					# get just the filename:
					$location = explode("/",$matches[3][$m]);
					$filename = end($location);
				$presskit = $presskit."[+] <a href='".get_bloginfo('home')."/wp-content/plugins/wp-image-resizer/thumb/phpThumb.php?src=".$matches[3][$m]."&down=true'>".$filename."</a><br />";
            	$text = str_replace($matches[0][$m],"<!-- IMAGE REMOVED BY wp-image-resizer HERE -->",$text);
			endif;
        }
    }
	if ($presskit != "<div class='presskit'><h3>High Resolution Press Images:</h3>") :
		$text = $images."</div>".$text.$presskit."</div>";
	else :
		$text = $images."</div>".$text;
	endif;
	return($text);
}

add_filter('the_content', 'imgReplace');
?>