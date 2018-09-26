<?php
class i3geek_mip_standard{
	function reform($content){
		$content = self::style($content);
		$content = self::img($content);
		$content = self::script($content);
		$content = self::forbidden($content);
		return $content;
	}
	function style($content){
		preg_match_all('/ style=\".*?\"/', $content, $style);
		if(!is_null($style)) {
			foreach($style[0] as $index => $value){
				$mip_style = preg_replace('/ style=\".*?\"/', '',$style[0][$index]);
				$content = str_replace($style[0][$index], $mip_style, $content);
			}
		}
		$content=preg_replace("/<(style.*?)>(.*?)<(\/style.*?)>/si","",$content); 
		$content=preg_replace("/<(\/?style.*?)>/si","",$content); 
		return $content;
	}
	function img($content){
		preg_match_all('/<img (.*?)\>/', $content, $images);
		if(!is_null($images)) {
			foreach($images[1] as $index => $value){
				$mip_img = str_replace('<img', '<mip-img', $images[0][$index]);
				$mip_img = str_replace('>', '></mip-img>', $mip_img);
				$mip_img = preg_replace('/(width|height)="\d*"\s/', '', $mip_img );
				$mip_img = preg_replace('/ srcset=\".*?\"/', '',$mip_img);
				$content = str_replace($images[0][$index], $mip_img, $content);
			}
		}
		return $content;
	}
	function script($content){
		$content=preg_replace("/<(script.*?)>(.*?)<(\/script.*?)>/si","",$content);
		$content=preg_replace("/<(\/?script.*?)>/si","",$content); 
		return $content;
	}
	function forbidden($content){
		$forbidden_html = array("frame","param","form","input","textarea","select","option");
		for ($i = 0; $i < sizeof($forbidden_html); $i++) { 
			$content = preg_replace("/<".$forbidden_html[$i]."[^>]*>(.*?)<\/".$forbidden_html[$i].">/is", "", $content);
		}
		return $content;
	}

}
?>