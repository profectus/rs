<?php

// funkce pro návrat IP adresy návštěvníka
function ip_adresa() { 
	static $ip_address;
	$ip_address = !empty($_SERVER["CLIENT_IP"]) ? $_SERVER["CLIENT_IP"] : ""; 
	$ip_address = !empty($_SERVER["HTTP_X_FORWARDED_FOR"]) && empty($ip_address)? $_SERVER["HTTP_X_FORWARDED_FOR"] : $ip_address; 
	$ip_address = !empty($_SERVER["REMOTE_ADDR"]) && empty($ip_address)? $_SERVER["REMOTE_ADDR"] : $ip_address;
	return ($ip_address);
}

function debug() {
	if (!in_array($_SERVER['REMOTE_ADDR'], $debugArray)) { return false; }
	else { return true; }
}

// funkce pro url alias
function mr_url($string) {  
	$find = Array("Á","Č","Ď","É","Ě","Í","Ň","Ó","Ř","Š","Ť","Ú","Ů","Ý","Ž", "á", "č", "ď", "é", "ě", "í", "ľ", "ň", "ó", "ř", "š", "ť", "ú", "ů", "ý", "ž", "_", " - ", " ", ".", "ü", "ä", "ö");  
	$replace = Array("a","c","d","e","e","i","n","o","r","s","t","u","u","y","z", "a", "c", "d", "e", "e", "i", "l", "n", "o", "r", "s", "t", "u", "u", "y", "z", "", "-", "-", "-", "u", "a", "o");  
	$string = preg_replace("~%[0-9ABCDEF]{2}~", "", urlencode(str_replace($find, $replace, mb_strtolower($string))));  
	return $string;  
}
 
// funkce pro formát datumu
function datum($string,$format) {
	$string = date($format,strtotime($string));
	return $string;
}

// funckce pro vlo6en9 divu class cistic
function clear() { return "\n<div class=\"clear\"></div>"; }

// funkce pro redirect
function redirect($page = null) {
	if ($page == null) { $page = getUrl(); }
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ".str_replace("&amp;", "&", $page));
	header("Connection: close");
	exit();	
}

// funkce pro zjistení aktuální aktivní adresy
function getUrl($pagecode = null) {
	$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
	$host     = $_SERVER['HTTP_HOST'];
	$script   = $_SERVER['SCRIPT_NAME'];
	$params   = $_SERVER['QUERY_STRING'];    
	$url = $protocol . '://' . $host . $script .($params!=""?'?' . $params:"");  
	if ($pagecode != null) { $url = str_replace($_GET['pagecode'], $pagecode, $url, $temp); }
	return $url;
}

// funkce pro předání pouze vybraných součásti POSTu
function pripravPost($arr) {
	$temp_variables = explode(",", $arr);
	foreach ($temp_variables as $key => $value) { if(array_key_exists($value,$_POST)) { $variables[$value] = $_POST[$value]; }}
	return $variables;	
}

function toVelikost($velikost) {
	if($velikost < 1024) {$velikost = ($velikost); $k = " B";}
  if($velikost >= 1024) {$velikost = ($velikost / 1024); $k = " kB";}
  if($velikost >= 1024) {$velikost = ($velikost / 1024); $k = " MB";}
  return str_replace(".",",",round($velikost, 1)).$k;
}


function maxlenght($string,$maxlenght) {
	if (strlen($string) > $maxlenght) {
		$string = mb_substr($string, 0, $maxlenght) . "...";
	}
	return $string;
}

function checknull($data) {
	if(trim($data)=='') {
		return null;
	} else {
		return $data;
	}
}

function geDateFormat($time = null) {
  if ($time == null) { $time = time(); }
	  $format = 'j. F';
	  $m      = array('ledna', 'února', 'března', 'dubna', 'května', 'června', 'července', 'srpna', 'září', 'října', 'listopadu', 'prosince');
	  $date   = preg_replace('#\..+$#', '. ' . $m[date('n', $time) - 1], date($format, $time));        
	  return $date;
	}

?>
