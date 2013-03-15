<?php

use PFBC\Form;

if(isset($_POST["form"])){
	if(Form::isValid('individual') || Form::isValid('company')){
		$data = array_slice($_POST,0);
		$row = array();
		$goTo = '#'.$data['url'];
		foreach($conf['columns'] as $c){
			$row[$c] = array_key_exists($c, $data) ? $data[$c] : '';
		}
		if(isset($row['more_info']) && is_array($row['more_info'])){$row['more_info'] = 1;}
		foreach($records as $rec){
			if($rec['email'] == $row['email']){
				message(l('body_you_already_submitted'));
				return $goTo;
			}
		}
		write_csv($conf['csv_file'],array($row),!file_exists($conf['csv_file']));
		message(l('body_thank_you_for_submitting'));
		return $goTo;
	}
	message(l('body_thank_you_for_submitting'));
	return $goTo;
}

return false;