<?php
	
	
$locale = parse_ini_file('locale.ini',true);

$conf = array(
	'csv_file'	=>	'results.csv'
,	'forms' => array(
		'individual' => array(
			'type'	=>	array('Hidden','individual')
		,	'name_first' => array('Textbox',array(
				'validation'	=>	new PFBC\Validation\Required(l('name_first_error_required'))
			,	'longDesc'	=>	l('name_first_help')
			))
		,	'name_last' => array('Textbox',array(
				'validation'	=>	new PFBC\Validation\Required(l('name_last_error_required'))
			,	'longDesc'	=>	l('name_last_help')
			))
		,	'email' => array('Email',array(
				'validation'	=>	new PFBC\Validation\Required(l('email_error_required'))
			,	'longDesc'	=>	l('email_help')
			))
		,	'phone_home'	=>	array('Phone',array(
				'validation'	=>	new PFBC\Validation\Required(l('phone_home_error_required'))
			,	'longDesc'	=>	l('phone_home_help')
			))
		,	'profession' =>	array('Textbox',array(
				'longDesc'	=>	l('profession_help')
			))
		,	'more_info'	=>	array('Checkbox',array(l('yes_label')),array(
				'longDesc'	=>	l('more_info_help')
			))
		//,	'captcha'	=>	array('Captcha')
		,	'url'	=>	array('Hidden','')
		)
	,	'company' => array(
			'type'	=>	array('Hidden','company')
		,	'company' => array('Textbox',array(
				'validation'	=>	new PFBC\Validation\Required(l('company_error_required'))
			,	'longDesc'	=>	l('company_help')
			))
		,	'website' => array('Textbox',array(
				'validation'	=>	new PFBC\Validation\Required(l('website_error_required'))
			,	'longDesc'	=>	l('website_help')
			))
		,	'contact' => array('Textbox',array(
				'validation'	=>	new PFBC\Validation\Required(l('contact_error_required'))
			,	'longDesc'	=>	l('contact_help')
			))
		,	'position' => array('Textbox',array(
				'validation'	=>	new PFBC\Validation\Required(l('position_error_required'))
			,	'longDesc'	=>	l('position_help')
			))
		,	'email' => array('Email',array(
				'validation'	=>	array(
					new PFBC\Validation\Required(l('email_error_required'))
				,	new PFBC\Validation\Email(l('email_error_malformed'))
				)
			,	'longDesc'	=>	l('email_help')
			))
		,	'phone_office'	=>	array('Phone',array(
				'validation'	=>	new PFBC\Validation\Required(l('phone_office_error_required'))
			,	'longDesc'	=>	l('phone_office_help')
			))
		,	'phone_mobile'	=>	array('Phone',array(
				'longDesc'	=>	l('phone_mobile_help')
			))
		,	'more_info'	=>	array('Checkbox',array(l('yes_label')),array(
				'longDesc'	=>	l('more_info_help')
			))
		//,	'captcha'	=>	array('Captcha')
		,	'url'	=>	array('Hidden','')
		)
	)
,	'columns' => array(
		'type'
	,	'name_first'
	,	'name_last'
	,	'email'
	,	'profession'
	,	'company'
	,	'website'
	,	'contact'
	,	'position'
	,	'phone_home'
	,	'phone_office'
	,	'phone_mobile'
	,	'more_info'
	)
);