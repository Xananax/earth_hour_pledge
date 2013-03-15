<?php

function csv_convert( $str ) {
    return iconv( "Windows-1252", "UTF-8", $str );
}

function read_csv($f,$useHeader = true){
	$row = 1;
	$rows = array();
	$header = false;
	if(!file_exists($f)){return $rows;}
	if(($handle = fopen($f, 'r')) !== false){
		while (($raw = fgets($handle)) !== false){
			$data = csvstring_to_array($raw, ',', '"', "\n");
			//$data = array_map('csv_convert',$data);
			$num = count($data);
			$row++;
			if(!$header){
				if($useHeader){
					$header = $data;
					continue;
				}
				else{$header = array_fill(0, $num, NULL);}
			}
			$r = array();
			for ($c=0; $c < $num; $c++){
				if(!isset($data[$c])){$data[$c] = '';}
				$title = isset($header[$c]) ? $header[$c] : NULL;
				$r[$title] = $data[$c];
			}
			array_push($rows,$r);
		}
		fclose($handle);
	}
	return $rows;
}

function write_csv($f,$list,$useHeader = true,$append=true){
	$mode = $append ? 'a' : 'w';
	$fp = fopen($f, $mode);
	$retries = 0;
	$max_retries = 100;
	$header = false;
	if(!$fp){return false;}
	do{
		if($retries > 0){usleep(rand(1, 10000)); }
		$retries += 1; 
	}while(!flock($fp, LOCK_EX) and $retries <= $max_retries); 
	if ($retries == $max_retries){return false;}
	foreach($list as $fields){
		if(!$header && $useHeader && !$append){
			$header = array_keys($fields);
			fputcsv($fp, $header);
		}
		fputcsv($fp, $fields);
	}
	flock($fp, LOCK_UN); 
	fclose($fp);
	return true;
}

function array_to_csvstring($items, $CSV_SEPARATOR = ';', $CSV_ENCLOSURE = '"', $CSV_LINEBREAK = "\n") { 
  $string = ''; 
  $o = array(); 

  foreach ($items as $item) { 
    if (stripos($item, $CSV_ENCLOSURE) !== false) { 
      $item = str_replace($CSV_ENCLOSURE, $CSV_ENCLOSURE . $CSV_ENCLOSURE, $item); 
    } 

    if ((stripos($item, $CSV_SEPARATOR) !== false) 
     || (stripos($item, $CSV_ENCLOSURE) !== false) 
     || (stripos($item, $CSV_LINEBREAK !== false))) { 
      $item = $CSV_ENCLOSURE . $item . $CSV_ENCLOSURE; 
    } 

    $o[] = $item; 
  } 

  $string = implode($CSV_SEPARATOR, $o) . $CSV_LINEBREAK; 

  return $string; 
} 

function csvstring_to_array(&$string, $CSV_SEPARATOR = ';', $CSV_ENCLOSURE = '"', $CSV_LINEBREAK = "\n") { 
  $o = array(); 

  $cnt = strlen($string); 
  $esc = false; 
  $escesc = false; 
  $num = 0; 
  $i = 0; 
  while ($i < $cnt) { 
    $s = $string[$i]; 

    if ($s == $CSV_LINEBREAK) { 
      if ($esc) { 
        $o[$num] .= $s; 
      } else { 
        $i++; 
        break; 
      } 
    } elseif ($s == $CSV_SEPARATOR) { 
      if ($esc) { 
        $o[$num] .= $s; 
      } else { 
        $num++; 
        $esc = false; 
        $escesc = false; 
      } 
    } elseif ($s == $CSV_ENCLOSURE) { 
      if ($escesc) { 
        $o[$num] .= $CSV_ENCLOSURE; 
        $escesc = false; 
      } 

      if ($esc) { 
        $esc = false; 
        $escesc = true; 
      } else { 
        $esc = true; 
        $escesc = false; 
      } 
    } else { 
      if ($escesc) { 
        $o[$num] .= $CSV_ENCLOSURE; 
        $escesc = false; 
      } 

      if(!isset($o[$num])){$o[$num] = '';}

      $o[$num] .= $s; 
    } 

    $i++; 
  } 

//  $string = substr($string, $i); 

  return $o; 
} 