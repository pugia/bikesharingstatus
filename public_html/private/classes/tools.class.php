<?php

class Tools {
	
	private $db;
	
	public function __construct($db) {
		$this->db = $db;
	}
	
	public function pd($array, $type = 'print') {
		echo '<pre style="background: #fff;">';
		if ($type == 'print') { print_r($array); }
		if ($type == 'dump') { var_dump($array); }
		echo '</pre>';
	}
	
	public function contextualTime($small_ts, $large_ts=false) {
	  if(!$large_ts) $large_ts = time();
	  $n = $large_ts - $small_ts;
	  if($n <= 1) return 'adesso'; // meno di un secondo fa
	  if($n < (60)) return $n . ' secondi fa';
	  if($n < (60*60)) { $minutes = round($n/60); return 'circa ' . $minutes . ' ' . ($minutes > 1 ? 'minuti' : 'minuto') . ' fa'; }
	  if($n < (60*60*16)) { $hours = round($n/(60*60)); return 'circa ' . $hours . ' ' . ($hours > 1 ? 'ore' : 'ora') . ' fa'; }
	  if($n < (time() - strtotime('yesterday'))) return 'ieri';
	  if($n < (60*60*24)) { $hours = round($n/(60*60)); return 'circa ' . $hours . ' ' . ($hours > 1 ? 'ore' : 'ora') . ' fa'; }
	  if($n < (60*60*24*6.5)) return 'circa ' . round($n/(60*60*24)) . ' giorni fa';
	  if($n < (time() - strtotime('last week'))) return 'settimana scorsa';
	  if(round($n/(60*60*24*7))  == 1) return 'circa una settimana fa';
	  if($n < (60*60*24*7*3.5)) return 'circa ' . round($n/(60*60*24*7)) . ' settimane fa';
	  if($n < (time() - strtotime('last month'))) return 'il mese scorso';
	  if(round($n/(60*60*24*7*4))  == 1) return 'circa un mese fa';
	  if($n < (60*60*24*7*4*11.5)) return 'circa ' . round($n/(60*60*24*7*4)) . ' mesi fa';
	  if($n < (time() - strtotime('last year'))) return 'l\'anno scorso';
	  if(round($n/(60*60*24*7*52)) == 1) return 'circa un anno fa';
	  if($n >= (60*60*24*7*4*12)) return 'circa ' . round($n/(60*60*24*7*52)) . ' anni fa'; 
	  return false;
	}
	
	public function str_replace_array($text, $array) {
		foreach ($array as $k=>$v) {
			if (!is_array($v) && !is_numeric($k)) { $text = str_replace("__".strtoupper($k)."__", $v, $text); }
		}
		return $text;
	}
	
	public function bigint($number) {
		if (!is_null($number) && is_numeric($number)) {
			$out = preg_replace('/[^0-9]/','',$number);
			return $out*1;
		} else {
			return false;
		}
	}
		
	public function getRealIpAddr() {
	  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	    $ip=$_SERVER['HTTP_CLIENT_IP'];
	  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	    $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	  } else {
	    $ip=$_SERVER['REMOTE_ADDR'];
	  }
	  return $ip;
	}
	
	// ripulisce una stringa per l'url
	public function cleanString($str, $replace="'", $delimiter='-') {
		if(!empty($replace)) $str = str_replace((array)$replace, ' ', $str);
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
		return $clean;
	}
			
	public function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
	  $sort_col = array();
	  foreach ($arr as $key=> $row) { $sort_col[$key] = $row[$col]; }
	  array_multisort($sort_col, $dir, $arr);
	}
	
	public function array_value2key($array, $key) {
		$out = array();
		foreach ($array as $k => $v) {
			if (!isset($out[$v[$key]])) { $out[$v[$key]] = $v; }
			else { return false; exit(); }
		}
		return $out;
		
	}
	
	public function array_append($array, $append) {
		if (is_array($append)) { foreach ($append as $k => $v) { $array[$k] = $v; } }
		return $array;
	}
	
	public function array_by_key($array, $key) {
		$out = array(); foreach ($array as $a) { $out[] = $a[$key]; }
		return $out;
	}
	
	public function array_in_array($search, $heystack) {
		foreach ($search as $a) { if (in_array($a, $heystack)) { return true; exit(); } }	return false;
	}
	
	public function array_search_in_array($term, $array, $keys = null) {
		$out = array();
		$term = (string)$term;
		foreach ($array as $k=>$v) {
			if (!is_null($keys)) { foreach ($keys as $kk) { if (stripos((string)$v[$kk], $term)!==false) $out[$k] = $v; } }
			else { foreach ($v as $kk=>$vv) { if (!is_array($vv) && stripos((string)$vv, $term)!==false) $out[$k] = $v; } }
		}
		return $out;
		
	}

}