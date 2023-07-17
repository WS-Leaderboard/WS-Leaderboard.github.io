<?php
/*

	A very simple css Minifier
		class idea
	source: https://idiallo.com/blog/css-minifier-in-php
		minify engine
	source: https://stackoverflow.com/a/76246966

*/
class CSSminify {

	private $src = '';
	private $dest = '';

	public function __construct($src, $dest){
		$this->src = $src;
		$this->dest = $dest;
		if (!is_file($dest) || filemtime($src) > filemtime($dest)) {
			$this->minify();
		}
	}

	private function minify(){
			$css = file_get_contents($this->src);
			// Remove comments
			$css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
			// Remove spaces before and after selectors, braces, and colons
			$css = preg_replace('/\s*([{}|:;,])\s+/', '$1', $css);
			// Remove remaining spaces and line breaks
			$css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '',$css);
			// Additional space remove
			$css = str_replace(' !important','!important',$css);
			$css = str_replace(';}','}',$css);
			$css = str_replace(' > ','>',$css);
			file_put_contents($this->dest,$css);
	}

}