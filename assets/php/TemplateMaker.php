<?php
/*
	OBJ
*/
class TemplateMaker{
	/*
		Direct output to screen
	*/
	function Header($title = ''){
		if (substr($title,0,1) == '+') {
			$title = WSL_SITENAME . ' :: ' . substr($title,1);
		}
		if (empty($title)){
			$title = WSL_SITENAME;
		}
		if (!defined('WSL_VERSION')){
			$tcorps = new TableMaker(WSL_PATH_TCORPS);
			$tcorps = array_pop($tcorps->data);
			$version = substr(array_shift($tcorps),1);
			define('WSL_VERSION',$version);
		}

		echo '<!DOCTYPE HTML>' . self::GetTags('comment') . '<html lang="en"><head><title>'.$title.'</title>'. self::GetTags('head') . self::Link( self::GetTags('headlinks') ) .'</head><body class="is-preload"><div id="wrapper">'. self::GetTags('body') . self::GetMenu();
	}
	function Version(){
		echo WSL_VERSION;
	}
	function Footer($asset=''){
		echo self::GetTags('footer') . '</div>' . self::Link( self::GetTags('footerlinks')) . self::Link($asset) . '</body></html>';
		flush();
	}
	function HeroImage($arg=[]){
		extract($arg, EXTR_OVERWRITE);
		echo '<section class="heroimage">'.
		($img?'<span class="image main"><img src="/images/'.$img.'" alt="header_artwork_drones" />'. ($by?'<div style="text-align: right"><sup>Artwork by '.($url?'<a href="'.$url.'" target="_blank">'.$by.'</a>':$by).'</sup></div>':'')	.'</span>':'') . ($title?'<h1>'.$title.'</h1>':'') . ($txt?'<p>'.$txt.'</p>':'') .'</section>';
	}
	function HeroMenu($class='style',$skip=TRUE){
		$menu = '';
		$entries = WSL_MENU;
		$x = 0;
		if ($skip) {
			array_shift($entries);
			$x++;
		}
		foreach( $entries as $m ){
			$menu .= '<article class="'. $class . $x .'"><span class="image"><img src="/images/'.$m['i'].'" alt="'.$m['a'].'"/></span>
			<a href="/'.$m['u'].'"><h2>'.$m['n'].'</h2>'.($m['c']?'<div class="content"><p>'.$m['c'].'</p></div>':'') .'</a></article>';
		$x++;
		}
		echo $menu;
	}
	function Interviews($int){
		$search = 'interviews';
		$dir = WSL_ROOT . $search;
		if (is_dir($dir) && is_array($int)){
			$f = scandir($dir);
			$d = [];
			foreach($f as $e){
				if (strpos($e,'.html') !== FALSE ) {
					$d[] = $e;
				}
			}
			$link = '';
			foreach($d as $e){
				$name = substr($e,0,-5);
				if (isset($int[$name])) {
					$i = $int[$name];
					$title = ($i['n']?$i['n']:ucfirst($name));
					$link .= '<a href="'.$search.'/'.$e.'"><span class="image left"><img class="image avatar" src="/images/'.$name.'.png" alt="'.$name.'"/></span><h2>'.$title.'</h2><blockquote style="display: grid">"'.$i['b'].'"</blockquote></a>';
				}
			}
			echo $link;
		}
	}
	function InterviewHead($name){
		echo '<h1 style="margin-bottom: 0.25em"><span class="image right" style="padding: 0 0 0.75em 1em"><img class="image small" src="/images/'. strtolower($name) .'.png" alt="'.$name.'" /></span>'.$name.'</h1>';
	}
	function DownloadBtns($search, $count=3, $skip=TRUE){
		if ($count>0){
			$f = scandir(WSL_ROOT . WSL_DATA, SCANDIR_SORT_DESCENDING);
			$d = [];
			foreach($f as $e){
				if (strpos($e,$search) !== FALSE ) {
					$d[] = $e;
				}
			}
			if ($skip) {
				array_shift($d);
			}
			$link = '';
			foreach($d as $e) {
				if ($count>0) {
					$link .= self::GetDownload( WSL_DATA . $e, substr(array_pop(explode('_',$e)),0, -4) );
				}
				$count--;
			}
			echo $link;
		}
	}
	/*

		Helper functions with returns

	*/
	function GetTags($tag){
		$t = WSL_HTML;
		if ( isset($t[$tag]) ) {
			if (is_array($t[$tag])){
				return $t[$tag];
			}else{
				return self::ClearTagSpace( $t[$tag] );
			}
		}else{
			return NULL;
		}
	}
	function ClearTagSpace($html){
		return preg_replace('/\>\s+\</m', '><', trim($html));
	}
	function GetMenu(){
		$link = '';
		foreach( WSL_MENU as $li ){
			$link .= '<li><a href="/'. $li['u'] .'">'. $li['n'] .'</a></li>';
		}
		return '<nav id="menu"><h2>Menu</h2><ul>'. $link .'</ul></nav>';
	}
	function GetDownload($link,$name){
		if (file_exists( WSL_ROOT . $link)) {
			return '<a href="./'.$link.'" class="button primary icon solid fa-download">'.$name.'</a>';
		}
		return NULL;
	}
	function GetAsset($asset) {
		$link = '';
		$ext = strtolower(array_pop(explode('.',$asset)));
		if (strpos($asset,'http')===FALSE) {
			$path = '/' . WSL_ASSETS . $ext . '/'. $asset;
		}else{
			$path = $asset;
		}
		if (!empty($asset)){
			if (strpos($asset,'<')===0){
				$link = $asset;
			}elseif ($ext == 'js') {
				$link = '<script src="'. $path .'"></script>';
			}elseif ($ext == 'css') {
				$link = '<link rel="stylesheet" href="'.$path.'" type="text/css" media="all" />';
			}
		}
		return $link;
	}

	function Link($asset){
		$link = '';
		if (is_array($asset)){
			foreach($asset as $a){
				$link .= self::GetAsset($a);
			}
		}else{
			$link = self::GetAsset($asset);
		}
		return $link;
	}

}
