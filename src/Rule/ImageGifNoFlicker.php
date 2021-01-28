<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  All img elements have associated images that do not flicker.
*  This error is generated for all img elements that contain a src attribute value that ends with ".gif" (case insensitive). and have a width and height larger than 25.
*/
class ImageGifNoFlicker extends BaseRule
{
    
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        $gif_control_extension = "/21f904[0-9a-f]{2}([0-9a-f]{4})[0-9a-f]{2}00/";

        // foreach ($this->getAllElements('img') as $img) {

		// 	if (substr($img->getAttribute('src'), -4, 4) == '.gif') {
		// 		$file = $this->getImageContent($this->getPath($img->getAttribute('src')));
		// 		if ($file) {
		// 			  $file = bin2hex($file);

		// 			  // sum all frame delays
		// 			  $total_delay = 0;
		// 			  preg_match_all($this->gif_control_extension, $file, $matches);
		// 			  foreach ($matches[1] as $match) {
		// 			    // convert little-endian hex unsigned ints to decimals
		// 			    $delay = hexdec(substr($match,-2) . substr($match, 0, 2));
		// 			    if ($delay == 0) $delay = 1;
		// 			    $total_delay += $delay;
		// 			  }

		// 			  // delays are stored as hundredths of a second, lets convert to seconds


		// 			 if ($total_delay > 0)
		// 			 	$this->setIssue($img);
		// 		}
		// 	}
		// }
        
        return count($this->issues);
    }

}