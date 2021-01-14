<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;
use DOMXPath;

/**
*	Checks that all color and background elements have sufficient contrast.
*/
class CssTextHasContrast extends BaseRule
{
	public static $severity = self::SEVERITY_ERROR;
	
    public $default_background = '#ffffff';
    
	public $default_color = '#000000';
    
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


		foreach ($entries as $element) {
            $style = $this->parseCSS($element->getAttribute('style'));
            
			if(isset($style['background-color']) || isset($style['color'])){
				if (!isset($style['background-color'])) {
					$style['background-color'] = $this->default_background;
				}

				if (!isset($style['color'])) {
					$style['color'] = $this->default_color;
				}

				if ((isset($style['background']) || isset($style['background-color'])) && isset($style['color']) && $element->nodeValue) {
					$background = (isset($style['background-color'])) ? $style['background-color'] : $style['background'];
					if (!$background) {
						$background = $this->default_background;
					}

					$style['color'] = '#' . $this->convertColor($style['color']);
					$style['background-color'] = '#' . $this->convertColor($background);

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
					} else if ($element->tagName === "strong") {
						$bold = true;
						$style['font-weight'] = "bold";
					} else {
						$style['font-weight'] = "normal";
					}

					if (isset($style['font-style'])) {
						if($style['font-style'] === "italic") {
							$italic = true;
						}
					} else if ($element->tagName === "em") {
						$italic = true;
						$style['font-style'] = "italic";
					} else {
						$style['font-style'] = "normal";
					}

					if ($element->tagName === 'h1' || $element->tagName === 'h2' || $element->tagName === 'h3' || $element->tagName === 'h4' || $element->tagName === 'h5' || $element->tagName === 'h6' || $font_size >= 18 || $font_size >= 14 && $bold) {
						if ($luminosity < 3) {
							$tagName = $element->tagName;
							$html = $this->outerHTML($element);

							$html = preg_replace('/background:\s*([#a-z0-9]*)\s*;*\s*/', '', $html);
							$html = preg_replace('/background-color:\s*([#a-z0-9]*)\s*;*\s*/', '', $html);
							$html = preg_replace('/color:\s*([#a-z0-9]*)\s*;*\s*/', '', $html);
							$html = preg_replace('/style="/', 'style="background-color: '.$background.'; color: '.$style["color"].';', $html);
							
							$dom = new \DOMDocument('1.0', 'utf-8');
							$dom->loadHTML($html);
							$element = $dom->getElementsByTagName($tagName)[0];
							$this->setIssue($element);
						}
					} else {
						if ($luminosity < 4.5) {
							$tagName = $element->tagName;
							$html = $this->outerHTML($element);

							$html = preg_replace('/background:\s*([#a-z0-9]*)\s*;*\s*/', '', $html);
							$html = preg_replace('/background-color:\s*([#a-z0-9]*)\s*;*\s*/', '', $html);
							$html = preg_replace('/color:\s*([#a-z0-9]*)\s*;*\s*/', '', $html);
							$html = preg_replace('/style="/', 'style="background-color: '.$background.'; color: '.$style["color"].';', $html);
							
							$dom = new \DOMDocument('1.0', 'utf-8');
							$dom->loadHTML($html);
							$element = $dom->getElementsByTagName($tagName)[0];
							$this->setIssue($element);
						}
					}
				}
			}
		}
        
        return count($this->issues);
    }

	public function parseCSS($css) {
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
	public function convertColor($color) {
		$color = trim($color);
		if(strpos($color, ' ') !== false) {
			$colors = explode(' ', $color);
			foreach($colors as $background_part) {
				if(substr(trim($background_part), 0, 1) == '#' ||
					in_array(trim($background_part), array_keys($this->color_names)) ||
					strtolower(substr(trim($background_part), 0, 3)) == 'rgb') {
						$color = $background_part;
					}
			}
		}
		//Normal hex color
		if(substr($color, 0, 1) == '#') {
			if(strlen($color) == 7) {
				return str_replace('#', '', $color);
			}
			elseif (strlen($color) == 4) {
				return substr($color, 1, 1).substr($color, 1, 1).
					   substr($color, 2, 1).substr($color, 2, 1).
					   substr($color, 3, 1).substr($color, 3, 1);
			} else {
				return "000000";
			}
		}
		//Named Color
		if(in_array($color, array_keys($this->color_names))) {
			return $this->color_names[$color];
		}
		//rgb values
		if(strtolower(substr($color, 0, 3)) == 'rgb') {
			$colors = explode(',', trim(str_replace('rgb(', '', $color), '()'));
			if(!count($colors) != 3) {
				return false;
			}
			$r = intval($colors[0]);
			$g = intval($colors[1]);
		    $b = intval($colors[2]);

		    $r = dechex($r<0?0:($r>255?255:$r));
		    $g = dechex($g<0?0:($g>255?255:$g));
		    $b = dechex($b<0?0:($b>255?255:$b));

		    $color = (strlen($r) < 2?'0':'').$r;
		    $color .= (strlen($g) < 2?'0':'').$g;
		    $color .= (strlen($b) < 2?'0':'').$b;
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
	public function getLuminosity($foreground, $background) {
		if($foreground == $background) return 0;
		$fore_rgb = $this->getRGB($foreground);
		$back_rgb = $this->getRGB($background);
		return $this->luminosity($fore_rgb['r'], $back_rgb['r'],
							    $fore_rgb['g'], $back_rgb['g'],
							    $fore_rgb['b'], $back_rgb['b']);
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
	public function luminosity($r,$r2,$g,$g2,$b,$b2) {
		$RsRGB = $r/255;
		$GsRGB = $g/255;
		$BsRGB = $b/255;
		$R = ($RsRGB <= 0.03928) ? $RsRGB/12.92 : pow(($RsRGB+0.055)/1.055, 2.4);
		$G = ($GsRGB <= 0.03928) ? $GsRGB/12.92 : pow(($GsRGB+0.055)/1.055, 2.4);
		$B = ($BsRGB <= 0.03928) ? $BsRGB/12.92 : pow(($BsRGB+0.055)/1.055, 2.4);

		$RsRGB2 = $r2/255;
		$GsRGB2 = $g2/255;
		$BsRGB2 = $b2/255;
		$R2 = ($RsRGB2 <= 0.03928) ? $RsRGB2/12.92 : pow(($RsRGB2+0.055)/1.055, 2.4);
		$G2 = ($GsRGB2 <= 0.03928) ? $GsRGB2/12.92 : pow(($GsRGB2+0.055)/1.055, 2.4);
		$B2 = ($BsRGB2 <= 0.03928) ? $BsRGB2/12.92 : pow(($BsRGB2+0.055)/1.055, 2.4);

		if ($r+$g+$b <= $r2+$g2+$b2) {
		$l2 = (.2126 * $R + 0.7152 * $G + 0.0722 * $B);
		$l1 = (.2126 * $R2 + 0.7152 * $G2 + 0.0722 * $B2);
		} else {
		$l1 = (.2126 * $R + 0.7152 * $G + 0.0722 * $B);
		$l2 = (.2126 * $R2 + 0.7152 * $G2 + 0.0722 * $B2);
		}

		$luminosity = round(($l1 + 0.05)/($l2 + 0.05),2);
		return $luminosity;
	}


	/**
	*	Returns the decimal equivalents for a HEX color
	*	@param string $color The hex color value
	*	@return array An array where 'r' is the Red value, 'g' is Green, and 'b' is Blue
	*/
	function getRGB($color) {
		$color =  $this->convertColor($color);
		$c = str_split($color, 2);
		if(count($c) != 3) {
			return false;
		}
		$results = array('r' => hexdec($c[0]), 'g' => hexdec($c[1]), 'b' => hexdec($c[2]));
		return $results;
	}
}