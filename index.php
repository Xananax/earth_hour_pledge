<?php
	include('bootstrap.php');
	$is_processed = require('process.php');
	if($is_processed){refresh($is_processed);}
	$is_processed = has_messages();
	$messages = $is_processed ? get_messages():false;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
		<title><?php echo $locale['en']['title']; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/bootswatch/2.3.0/cerulean/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="font-awesome.min.css">
		<link href="style.css" rel="stylesheet">
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script type="text/javascript" src="script.js"></script>
		<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.1/js/bootstrap.min.js"></script>
		<link rel="icon" href="/favicon.ico?v=2">
		<link rel="shortcut icon" href="http://http://omanearthhour.org/favicon.ico?v=2" />
	</head>
	<body class="language-en">
		<div id="Header">
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container-fluid">
						<a class="brand" href="#"><?php echo l('title') ?></a>
						<div id="Language-Chooser" class="state-editor state-lang navbar-text pull-right" dir="ltr">
							<?php echo l('body_please_choose_your_language') ?>
							<div class="btn-group">
								<a href="#lang-en" class="btn active" lang="en" dir="ltr">English</a>
								<a href="#lang-ar" class="btn" lang="ar" dir="rtl">العربية</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="Main" class="container-fluid">
			<div class="row-fluid">
				<div id="Form-Chooser" class="state-editor state-form hero-unit">
					<?php if(!$is_processed): ?>
						<p><?php echo l('body_form_please_fill') ?></p>
						<h2><?php echo l('body_form_type') ?></h2>
						<div>
							<a href="#form-individual" class="btn btn-large btn-success">
								<?php echo l('body_form_individual_button') ?>
							</a>
							<a href="#form-company" class="btn btn-large btn-success">
								<?php echo l('body_form_company_button') ?>
							</a>
						</div>
					<?php else: ?>
						<div id="Messages">
							<?php foreach($messages as $message): ?>
								<h3><?php echo $message; ?></h3>
							<?php endforeach; ?>
						</div>				
					<?php endif; ?>
				</div>
				<div class="hero-unit texts">
					<?php require('chunks/body.php'); ?>
				</div>
			</div>
			<div class="row-fluid" id="Forms">
				<?php require('chunks/forms.php'); ?>
			</div>
			<div class="row-fluid" id="Records">
				<div class="span6">
					<h2><?php echo l('records_count',array('%count%'=>count($records))); ?></h2>
					<h3><?php echo l('body_list_title') ?></h3>
					<?php require('chunks/records.php'); ?>
				</div>
				<div class="span6">
					<h3><?php echo l('body_comments') ?></h3>
					<div class="disqus" id="disqus_thread">
						<?php require('chunks/disqus.php'); ?>
					</div>
				</div>
			</div>
		</div>
		<div id="Footer" class="navbar navbar-inverse">
			<div class="navbar-inner">
				<div class="container-fluid">
		 			<a title="website" href="http://www.eso.org.om" target="_blank" data-toggle="tooltip"><i class="icon-link white"></i></a>
		 			<a title="facebook" href="www.facebook.com/EnvironmentSocietyOfOman" target="_blank" data-toggle="tooltip"><i class="icon-facebook white"></i></a>
		 			<a title="twitter" href="www.twitter.com/ESO_Oman_" target="_blank" data-toggle="tooltip"><i class="icon-twitter white"></i></a>
		 			<a title="email" href="mailto:admin@eso.org.om" data-toggle="tooltip"><i class="icon-envelope white"></i> <span>admin@eso.org.om</span></a>
		 			<a title="phone" href="tel:+968 24790945" data-toggle="tooltip"><i class="icon-phone white"></i> <span>+968 24790945</span></a>
		 		</div>
		 	</div>
		</div>
	</body>
</html>