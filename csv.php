<?php

function read_csv($f,$useHeader = true){
	$row = 1;
	$rows = array();
	$header = false;
	if(!file_exists($f)){return $rows;}
	if(($handle = fopen($f, 'r')) !== false){
		while (($data = fgetcsv($handle, 1000, ',')) !== false){
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