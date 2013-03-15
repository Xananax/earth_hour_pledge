<?php

session_start();

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
error_reporting(E_ALL);

include('pfbc/PFBC/Form.php');
include('config.php');
include('classes/CustomButton.php');
include('classes/CustomSelect.php');
include('csv.php');

use PFBC\Form;
use PFBC\Element;
use PFBC\View;

$forms = array();
$records = read_csv($conf['csv_file']);

function l($str,$replacements=null,$asHTML = true,$lngs = array()){
	global $locale;
	if(!$lngs){$lngs=array_keys($locale);}
	if(!is_array($lngs)){$lngs = array($lngs);}
	$ret = '';
	foreach ($lngs as $lng) {
		$ret.=langLocale($str,$lng,$replacements,$asHTML);
	}
	return $asHTML ? '<span class="languages">'.$ret.'</span>' : $ret;
}

function langLocale($str,$lng='en',$replacements=null,$asHTML=true){
	global $locale;
	if(array_key_exists($lng, $locale)){
		$str = array_key_exists($str, $locale[$lng]) ? $locale[$lng][$str] : $str;
	}
	$dir = ($lng == 'ar')?'rtl':'ltr';
	return $asHTML ? "<span class=\"language language-{$lng}\" dir=\"$dir\" lang=\"$lng\">$str</span>" : $str;
}


function createForm($formName,$elements,$addDefaults = false){
	$form_defaults = array(
		'form'	=>	array('Hidden',$formName)
	,	'ok'	=>	array('CustomButton')
	,	'cancel'	=>	array("CustomButton",array("onclick" => "history.go(-1);"))
	);
	$classRoot = '\\PFBC\\Element\\';
	if(!$elements){$elements = array();}
	if($addDefaults){
		foreach($form_defaults as $name => $props){
			if(!array_key_exists($name, $elements)){$elements[$name] = $props;}
		}
	}
	$form = new Form($formName);
	$form->configure(array(
		'prevent'	=>	array('bootstrap','jQuery')
	,	'view' => new View\Vertical,
	));
	$form->addElement(new Element\HTML('<legend>'.l($formName).'</legend>'));
	foreach($elements as $name => $props){
		$className = array_shift($props);
		$label = l($name);
		if($className == 'Button' || $className == 'CustomButton'){
			$className = $classRoot.$className;
			$element = ($name == 'ok' || $name == 'submit' || $name == 'go' || $name == '&rar;') ? 
				new $className($label,'submit',array_shift($props),array_shift($props))
				:
				new $className($label,'button',array_shift($props),array_shift($props))
				;
		}else if($className == 'Hidden' || $className == 'Captcha'){
			$className = $classRoot.$className;
			$element = new $className($name,array_shift($props),array_shift($props),array_shift($props));			
		}else{
			$className = $classRoot.$className;
			$element = new $className($label,$name,array_shift($props),array_shift($props));
		}
		$form->addElement($element);
	}
	return $form;
}

foreach($conf['forms'] as $formName => $fields){
	$forms[$formName] = createForm($formName,$fields,!($formName == 'submitter_type'));
}