<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
<head>
	<title><?php echo PROJECT_NAME; ?></title>
	<meta name='description' content='' />
	<link rel='shortcut icon' href='/favicon.ico' />
	<meta http-equiv='Refresh' content='1500;./logout.php' />
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<meta http-equiv='Content-Language' content='cs-CZ' />
	<meta name='author' content='<?php echo AUTOR_NAME?>, <?php echo AUTOR_DOMAIN?> <?php echo AUTOR_HOTLINE?>' />
	<meta name="keywords" content="" />
	<meta name="robots" content="index, follow" />
	<meta http-equiv='Pragma' content='public' />
	<meta http-equiv='Expires' content='-1' />
	<meta name="viewport" content="width=600, maximum-scale=1.0" />
	<meta name="viewport" content="user-scalable=0" />
	<link rel="apple-touch-icon" href="./pics/ico_ios.png"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<style type='text/css' media='all'>
		@import './css/styles.css';
		@import './css/jquery-ui.css';
		@import './css/lightbox.css';
		@import './css/validationEngine.jquery.css';
		@import './css/colorpicker.css';
	</style>
	<script type='text/javascript' src='./script/jquery.min.js'></script>
	<script type='text/javascript' src='./script/jquery-ui-1.9.2.custom.js'></script>
	<script type='text/javascript' src='./script/lightbox.js'></script>
	<script type='text/javascript' src='./script/facebox.js'></script>
	<script type='text/javascript' src='./script/jquery.validationEngine-cz.js'></script>
	<script type="text/javascript" src='./script/jquery.validationEngine.js'></script>
	<script type='text/javascript' src='./script/jquery.timers.js'></script>
	<script type='text/javascript' src='./script/mbTooltip.js'></script>
	<script type='text/javascript' src='./script/jquery.dropshadow.js'></script>
	<script type="text/javascript" src="./script/colorpicker.js"></script>
	<script type='text/javascript' src='./script/jquery.tablednd.js'></script>
	<script type='text/javascript' src='./script/jquery.hotkeys.js'></script>
	<script type='text/javascript' src='./script/jquery.multiselect.min.js'></script>
	<script type='text/javascript' src='./script/jquery.multiselect.filter.min.js'></script>
	<script type="text/javascript" src="./ckeditor/ckeditor.js"></script>
	<script type='text/javascript' src='./script/script.js'></script>
</head>
<body>
<div id="body-wrapper">		
	<div id="sidebar">
		<div id="sidebar-wrapper">	
			<br />
			<center><img src="./pics/admin-logo.png" /></center>
			<a href="#" id="mobil_link">zobrazit menu</a>			
			<div id="profile-links">	
				Přihlášen <a href="./home.php" class="tooltip" title="Zobrazit poslední aktivitu uživatele"><?php echo $this->admin->getJmeno_prijmeni(); ?></a> | <a href="./logout.php" class="tooltip" title="Odhlásit aktuálně přihlášeného uživatele">Odhlásit</a><br />
				(naposledy online: <?php echo datum($this->admin->getLast_login(),"Y-m-d"); ?>) <br />
			</div>	
			<?php echo $this->getMenu(); ?>
			<p class="taright" style="padding-right: 15px;">
				skrytí levého panelu <span style="font-weight:bold">F2</span><br />
				režim celé obrazovky <span style="font-weight:bold">F11</span>								
			</p>
		</div>
	</div>  
  <div id="main">
<?php
echo $this->vypisNadpis();
?>