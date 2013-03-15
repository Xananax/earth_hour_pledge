<?php

use PFBC\Form;

if(isset($_POST["form"])){
	if(Form::isValid('individual') || Form::isValid('company')){
		$data = array_slice($_POST,0);
		$row = array();
		foreach($conf['columns'] as $c){
			$row[$c] = array_key_exists($c, $data) ? $data[$c] : '';
		}
		if(isset($row['more_info']) && is_array($row['more_info'])){$row['more_info'] = 1;}
		write_csv($conf['csv_file'],array($row),!file_exists($conf['csv_file']));
		return true;
	}else{
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		header("Location: http://$host$uri/");
		exit;
	}
}

return false;