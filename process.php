<?php

use PFBC\Form;

if(!isset($_SESSION['lastSiteRequest'])){
	$_SESSION['lastSiteRequest'] = time();
}

if(isset($_POST["form"])){

	$last_session_time = $_SESSION['lastSiteRequest'];
	$current_session_time = time();
	$_SESSION['lastSiteRequest'] = $current_session_time;
	$refresh_delta = $current_session_time - $last_session_time;
	if($refresh_delta < 2){
		refresh();
		return false;
	}

	if(Form::isValid('individual') || Form::isValid('company')){
		$data = array_slice($_POST,0);
		$row = array();
		$goTo = $data['url'] ? '' : '#'.$data['url'];
		if($data['honeypot']){
			return false;
		}
		foreach($conf['columns'] as $c){
			$row[$c] = array_key_exists($c, $data) ? $data[$c] : '';
		}
		if(isset($row['more_info']) && is_array($row['more_info'])){$row['more_info'] = 1;}
		if(isset($row['website']) && $row['website']){
			if (preg_match("#https?://#", $row['website']) === 0) {
    			$row['website'] = 'http://'.$row['website'];
			}
		}
		/**
		foreach($records as $rec){
			if($rec['email'] == $row['email']){
				message(l('body_you_already_submitted'));
				return $goTo;
			}
		}
		**/
		$success = write_csv($conf['csv_file'],array($row),!file_exists($conf['csv_file']));
		if($success){
			message(l('body_thank_you_for_submitting'));
		}else{
			message(l('body_submission_error'));
		}
		return $goTo;
	}
	return $goTo;
}

return false;