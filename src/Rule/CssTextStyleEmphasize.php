<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;
use DOMXPath;

/**
 *	Checks that all color and background elements are also bold or italicized
 */
class CssTextStyleEmphasize extends BaseRule
{
	public $color_names = array(
		'aliceblue' => 'f0f8ff',
		'antiquewhite' => 'faebd7',
		'aqua' => '00ffff',
		'aquamarine' => '7fffd4',
		'azure' => 'f0ffff',
		'beige' => 'f5f5dc',
		'bisque' => 'ffe4c4',
		'black' => '000000',
		'blanchedalmond' => 'ffebcd',
		'blue' => '0000ff',
		'blueviolet' => '8a2be2',
		'brown' => 'a52a2a',
		'burlywood' => 'deb887',
		'cadetblue' => '5f9ea0',
		'chartreuse' => '7fff00',
		'chocolate' => 'd2691e',
		'coral' => 'ff7f50',
		'cornflowerblue' => '6495ed',
		'cornsilk' => 'fff8dc',
		'crimson' => 'dc143c',
		'cyan' => '00ffff',
		'darkblue' => '00008b',
		'darkcyan' => '008b8b',
		'darkgoldenrod' => 'b8860b',
		'darkgray' => 'a9a9a9',
		'darkgreen' => '006400',
		'darkkhaki' => 'bdb76b',
		'darkmagenta' => '8b008b',
		'darkolivegreen' => '556b2f',
		'darkorange' => 'ff8c00',
		'darkorchid' => '9932cc',
		'darkred' => '8b0000',
		'darksalmon' => 'e9967a',
		'darkseagreen' => '8fbc8f',
		'darkslateblue' => '483d8b',
		'darkslategray' => '2f4f4f',
		'darkturquoise' => '00ced1',
		'darkviolet' => '9400d3',
		'deeppink' => 'ff1493',
		'deepskyblue' => '00bfff',
		'dimgray' => '696969',
		'dodgerblue' => '1e90ff',
		'firebrick' => 'b22222',
		'floralwhite' => 'fffaf0',
		'forestgreen' => '228b22',
		'fuchsia' => 'ff00ff',
		'gainsboro' => 'dcdcdc',
		'ghostwhite' => 'f8f8ff',
		'gold' => 'ffd700',
		'goldenrod' => 'daa520',
		'gray' => '808080',
		'green' => '008000',
		'greenyellow' => 'adff2f',
		'grey' => '808080',
		'honeydew' => 'f0fff0',
		'hotpink' => 'ff69b4',
		'indianred' => 'cd5c5c',
		'indigo' => '4b0082',
		'ivory' => 'fffff0',
		'khaki' => 'f0e68c',
		'lavender' => 'e6e6fa',
		'lavenderblush' => 'fff0f5',
		'lawngreen' => '7cfc00',
		'lemonchiffon' => 'fffacd',
		'lightblue' => 'add8e6',
		'lightcoral' => 'f08080',
		'lightcyan' => 'e0ffff',
		'lightgoldenrodyellow' => 'fafad2',
		'lightgrey' => 'd3d3d3',
		'lightgreen' => '90ee90',
		'lightpink' => 'ffb6c1',
		'lightsalmon' => 'ffa07a',
		'lightseagreen' => '20b2aa',
		'lightskyblue' => '87cefa',
		'lightslategray' => '778899',
		'lightsteelblue' => 'b0c4de',
		'lightyellow' => 'ffffe0',
		'lime' => '00ff00',
		'limegreen' => '32cd32',
		'linen' => 'faf0e6',
		'magenta' => 'ff00ff',
		'maroon' => '800000',
		'mediumaquamarine' => '66cdaa',
		'mediumblue' => '0000cd',
		'mediumorchid' => 'ba55d3',
		'mediumpurple' => '9370d8',
		'mediumseagreen' => '3cb371',
		'mediumslateblue' => '7b68ee',
		'mediumspringgreen' => '00fa9a',
		'mediumturquoise' => '48d1cc',
		'mediumvioletred' => 'c71585',
		'midnightblue' => '191970',
		'mintcream' => 'f5fffa',
		'mistyrose' => 'ffe4e1',
		'moccasin' => 'ffe4b5',
		'navajowhite' => 'ffdead',
		'navy' => '000080',
		'oldlace' => 'fdf5e6',
		'olive' => '808000',
		'olivedrab' => '6b8e23',
		'orange' => 'ffa500',
		'orangered' => 'ff4500',
		'orchid' => 'da70d6',
		'palegoldenrod' => 'eee8aa',
		'palegreen' => '98fb98',
		'paleturquoise' => 'afeeee',
		'palevioletred' => 'd87093',
		'papayawhip' => 'ffefd5',
		'peachpuff' => 'ffdab9',
		'peru' => 'cd853f',
		'pink' => 'ffc0cb',
		'plum' => 'dda0dd',
		'powderblue' => 'b0e0e6',
		'purple' => '800080',
		'red' => 'ff0000',
		'rosybrown' => 'bc8f8f',
		'royalblue' => '4169e1',
		'saddlebrown' => '8b4513',
		'salmon' => 'fa8072',
		'sandybrown' => 'f4a460',
		'seagreen' => '2e8b57',
		'seashell' => 'fff5ee',
		'sienna' => 'a0522d',
		'silver' => 'c0c0c0',
		'skyblue' => '87ceeb',
		'slateblue' => '6a5acd',
		'slategray' => '708090',
		'snow' => 'fffafa',
		'springgreen' => '00ff7f',
		'steelblue' => '4682b4',
		'tan' => 'd2b48c',
		'teal' => '008080',
		'thistle' => 'd8bfd8',
		'tomato' => 'ff6347',
		'turquoise' => '40e0d0',
		'violet' => 'ee82ee',
		'wheat' => 'f5deb3',
		'white' => 'ffffff',
		'whitesmoke' => 'f5f5f5',
		'yellow' => 'ffff00',
		'yellowgreen' => '9acd32'
		);

	public $message = array(
		'backgroundColor' => '',
		'color' => '',
		'fontStyle' => '',
		'fontWeight' => '',
	);

	public function id()
	{
		return self::class;
	}

	public function check()
	{
		$xpath   = new DOMXPath($this->dom);
		/**
		 * Selects all nodes that have a style attribute OR 'strong' OR 'em' elements that:
		 * Contain only the text in their text nodes
		 * OR 	 Have text nodes AND text nodes that are not equal to the string-value of the context node
		 * OR 	 Have a text node descendant that equals the string-value of the context node and has no style attributes
		 */
		$entries = $xpath->query('//*[(text() = . or ( ./*[text() != .]) or (.//*[text() = . and not(@style)])) and ((@style) or (name() = "strong") or (name() = "em"))]');

		$options = $this->getOptions();
		$default_background = $options['backgroundColor'];
		$default_color = $options['textColor'];

		foreach ($entries as $element) { 
			if ($element->nodeType !== XML_ELEMENT_NODE) {
				continue;
			}

			$style = $this->getStyle($element);

			if (!isset($style['background-color'])) {
				$style['background-color'] = $this->default_background;
			}

			if ((isset($style['background']) || isset($style['background-color'])) && isset($style['color']) && $element->nodeValue) {
				$background = (isset($style['background-color'])) ? $style['background-color'] : $style['background'];

				if (!$background) {
					$background = $this->default_background;
				}

				if(strtolower(substr($style['color'], 0, 3)) == 'rgb') {
					// Explode the match (0,0,0 for example) into an array
					$style['color'] = substr($style['color'], 4, -1);
					$colors = explode(',', $style['color']);
					// Use sprintf for the conversion
					$style['color'] = sprintf("#%02x%02x%02x", $colors[0], $colors[1], $colors[2]);
				} else {
					$style['color'] = '#' . $this->convertColor($style['color']);
				}

				if(strtolower(substr($background, 0, 3)) == 'rgb') {
					// Explode the match (0,0,0 for example) into an array
					$background = substr($background, 4, -1);
					$colors = explode(',', $background);
					// Use sprintf for the conversion
					$background = sprintf("#%02x%02x%02x", $colors[0], $colors[1], $colors[2]);
				} else {
					$background = '#' . $this->convertColor($background);
				}

				$luminosity = $this->getLuminosity($style['color'], $background);
				$font_size = 0;
				$bold = false;
				$italic = false;

				if (isset($style['font-size'])) {
					preg_match_all('!\d+!', $style['font-size'], $matches);
					$font_size = $matches[0][0];
				}

				if (isset($style['font-weight'])) {
					preg_match_all('!\d+!', $style['font-weight'], $matches);

					if (count($matches) > 0) {
						if ($matches >= 700) {
							$bold = true;
						} else {
							if ($style['font-weight'] === 'bold' || $style['font-weight'] === 'bolder') {
								$bold = true;
							}
						}
					}
				} else if (
					$element->tagName === "strong"
					|| $this->getElementAncestor($element, 'strong')
					|| (isset($element->nodeValue)
						&& isset($element->firstChild->nodeValue)
						&& $element->nodeValue == $element->firstChild->nodeValue
						&& is_object($element->firstChild)
						&& property_exists($element->firstChild, 'tagName')
						&& $element->firstChild->tagName === 'strong')
				) {
					$bold = true;
					$style['font-weight'] = "bold";
				} else {
					$style['font-weight'] = "normal";
				}

				if (isset($style['font-style'])) {
					if ($style['font-style'] === "italic") {
						$italic = true;
					}
				} else if ($element->tagName === "em") {
					$italic = true;
					$style['font-style'] = "italic";
				} else {
					$style['font-style'] = "normal";
				}

				if ($element->tagName === 'h1' || $element->tagName === 'h2' || $element->tagName === 'h3' || $element->tagName === 'h4' || $element->tagName === 'h5' || $element->tagName === 'h6' || $font_size >= 18 || $font_size >= 14 && $bold) {
					if ($luminosity >= 3 && !$bold && !$italic) {
						$this->message["backgroundColor"] = $background;
						$this->message["color"] = $style["color"];
						$this->message["fontStyle"] = $style["font-style"];
						$this->message["fontWeight"] = $style["font-weight"];
						$this->setIssue($element, null, json_encode($this->message));
					}
				} else {
					if ($luminosity >= 4.5 && !$bold && !$italic) {
						$this->message["backgroundColor"] = $background;
						$this->message["color"] = $style["color"];
						$this->message["fontStyle"] = $style["font-style"];
						$this->message["fontWeight"] = $style["font-weight"];
						$this->setIssue($element, null, json_encode($this->message));
					}
				}
			}
		}

		return count($this->issues);
	}

	// Helpers

	/**
	 *	Returns the first ancestor reached of a tag, or false if it hits
	 *	the document root or a given tag.
	 *	@param object $element A DOMElement object
	 *	@param string $ancestor_tag The name of the tag we are looking for
	 *	@param string $limit_tag Where to stop searching
	 */
	function getElementAncestor($element, $ancestor_tag, $limit_tag = 'body')
	{
		while (property_exists($element->parentNode, 'tagName')) {
			if ($element->parentNode->tagName == $ancestor_tag) {
				return $element->parentNode;
			}
			if ($element->parentNode->tagName == $limit_tag) {
				return false;
			}
			$element = $element->parentNode;
		}
		return false;
	}

	// CSS Helpers

	public function parseCSS($css)
	{
		$results = array();
		preg_match_all("/([\w-]+)\s*:\s*([^;]+)\s*;?/", $css, $matches, PREG_SET_ORDER);
		foreach ($matches as $match) {
			$results[$match[1]] = $match[2];
		}

		return $results;
	}

	/**
	 *	Converts multiple color or background styles into a simple hex string
	 *	@param string $color The color attribute to convert (this can also be a multi-value css background value)
	 *	@return string A standard CSS hex value for the color
	 */
	public function convertColor($color)
	{
		$color = trim($color);
		if (strpos($color, ' ') !== false) {
			$colors = explode(' ', $color);
			foreach ($colors as $background_part) {
				if (
					substr(trim($background_part), 0, 1) == '#' ||
					in_array(trim($background_part), array_keys($this->color_names)) ||
					strtolower(substr(trim($background_part), 0, 3)) == 'rgb'
				) {
					$color = $background_part;
				}
			}
		}
		//Normal hex color
		if (substr($color, 0, 1) == '#') {
			if (strlen($color) == 7) {
				return str_replace('#', '', $color);
			} elseif (strlen($color) == 4) {
				return substr($color, 1, 1) . substr($color, 1, 1) .
					substr($color, 2, 1) . substr($color, 2, 1) .
					substr($color, 3, 1) . substr($color, 3, 1);
			} else {
				return "000000";
			}
		}
		//Named Color
		if (in_array($color, array_keys($this->color_names))) {
			return $this->color_names[$color];
		}
		//rgb values
		if (strtolower(substr($color, 0, 3)) == 'rgb') {
			$colors = explode(',', trim(str_replace('rgb(', '', $color), '()'));
			if (!count($colors) != 3) {
				return false;
			}
			$r = intval($colors[0]);
			$g = intval($colors[1]);
			$b = intval($colors[2]);

			$r = dechex($r < 0 ? 0 : ($r > 255 ? 255 : $r));
			$g = dechex($g < 0 ? 0 : ($g > 255 ? 255 : $g));
			$b = dechex($b < 0 ? 0 : ($b > 255 ? 255 : $b));

			$color = (strlen($r) < 2 ? '0' : '') . $r;
			$color .= (strlen($g) < 2 ? '0' : '') . $g;
			$color .= (strlen($b) < 2 ? '0' : '') . $b;
			return $color;
		}
	}

	/**
	 *	Helper method that finds the luminosity between the provided
	 *	foreground and background parameters.
	 *	@param string $foreground The HEX value of the foreground color
	 *	@param string $background The HEX value of the background color
	 *	@return float The luminosity contrast ratio between the colors
	 */
	public function getLuminosity($foreground, $background)
	{
		if ($foreground == $background) return 0;
		$fore_rgb = $this->getRGB($foreground);
		$back_rgb = $this->getRGB($background);
		return $this->luminosity(
			$fore_rgb['r'],
			$back_rgb['r'],
			$fore_rgb['g'],
			$back_rgb['g'],
			$fore_rgb['b'],
			$back_rgb['b']
		);
	}

	/**
	 *	Returns the luminosity between two colors
	 *	@param string $r The first Red value
	 *	@param string $r2 The second Red value
	 *	@param string $g The first Green value
	 *	@param string $g2 The second Green value
	 *	@param string $b The first Blue value
	 *	@param string $b2 The second Blue value
	 *	@return float The luminosity contrast ratio between the colors
	 */
	public function luminosity($r, $r2, $g, $g2, $b, $b2)
	{
		$RsRGB = $r / 255;
		$GsRGB = $g / 255;
		$BsRGB = $b / 255;
		$R = ($RsRGB <= 0.03928) ? $RsRGB / 12.92 : pow(($RsRGB + 0.055) / 1.055, 2.4);
		$G = ($GsRGB <= 0.03928) ? $GsRGB / 12.92 : pow(($GsRGB + 0.055) / 1.055, 2.4);
		$B = ($BsRGB <= 0.03928) ? $BsRGB / 12.92 : pow(($BsRGB + 0.055) / 1.055, 2.4);

		$RsRGB2 = $r2 / 255;
		$GsRGB2 = $g2 / 255;
		$BsRGB2 = $b2 / 255;
		$R2 = ($RsRGB2 <= 0.03928) ? $RsRGB2 / 12.92 : pow(($RsRGB2 + 0.055) / 1.055, 2.4);
		$G2 = ($GsRGB2 <= 0.03928) ? $GsRGB2 / 12.92 : pow(($GsRGB2 + 0.055) / 1.055, 2.4);
		$B2 = ($BsRGB2 <= 0.03928) ? $BsRGB2 / 12.92 : pow(($BsRGB2 + 0.055) / 1.055, 2.4);

		if ($r + $g + $b <= $r2 + $g2 + $b2) {
			$l2 = (.2126 * $R + 0.7152 * $G + 0.0722 * $B);
			$l1 = (.2126 * $R2 + 0.7152 * $G2 + 0.0722 * $B2);
		} else {
			$l1 = (.2126 * $R + 0.7152 * $G + 0.0722 * $B);
			$l2 = (.2126 * $R2 + 0.7152 * $G2 + 0.0722 * $B2);
		}

		$luminosity = round(($l1 + 0.05) / ($l2 + 0.05), 2);
		return $luminosity;
	}


	/**
	 *	Returns the decimal equivalents for a HEX color
	 *	@param string $color The hex color value
	 *	@return array An array where 'r' is the Red value, 'g' is Green, and 'b' is Blue
	 */
	function getRGB($color)
	{
		$color =  $this->convertColor($color);
		$c = str_split($color, 2);
		if (count($c) != 3) {
			return false;
		}
		$results = array('r' => hexdec($c[0]), 'g' => hexdec($c[1]), 'b' => hexdec($c[2]));
		return $results;
	}


}
