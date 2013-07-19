<?php
require("../include/config.php");
@session_start();
if(isset($_SESSION["admin_id"]) && intval($_SESSION["admin_id"]) > 0) { redirect("./home.php"); }

// pokud tabulka neexistuje presmeruj na _install.php
try { dibi::query("SELECT 1 FROM [admin_uzivatele]")->fetchSingle(); } catch (Exception $e) { redirect('./install.php');}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
<head>
<title>CMS <?php echo PROJECT_NAME; ?></title>
<meta name='description' content='' />
<link rel='shortcut icon' href='/favicon.ico' />
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta http-equiv='Content-Language' content='cs-CZ' />
<meta name='author' content='ESMEDIA a.s., Palachovo nám. 1, Olomouc 77200, email: info@esmedia.cz, tel.: +420 585 242 025, fax: +420 585 242 026' />
<meta http-equiv='Cache-Control' content='must-revalidate, post-check=0, pre-check=0' />
<meta name="keywords" content="" />
<meta name="robots" content="index, follow" />
<meta http-equiv='Pragma' content='public' />
<meta http-equiv='Cache-Control' content='no-cache' />
<meta http-equiv='Pragma' content='no-cache' />
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="apple-touch-icon" href="./pics/ico_ios.png"/>
<meta name="viewport" content="width=600, maximum-scale=1.0" />
	<meta name="viewport" content="user-scalable=0" />
<style type='text/css' media='all'> 
	html,body,ul,ol,li,p,h1,h2,h3,h4,h5,h6,form {padding:0; margin:0; list-style:none;}
	html { background: #f0f0f0 url("./pics/login_bg.gif") repeat-x left top;}
	body { font-family:Arial, Helvetica, sans-serif; color:#555; font-size: 12px; background: url("./pics/logo_login.gif") no-repeat center top; padding: 250px 0 0 0; margin: 0; position: relative;}
	h1 {padding: 0; margin: 0 0 40px 0; text-shadow:1px 1px 1px #444; text-align: center; color: #c2c2c2; font-size: 30px;}
	p#copy { text-align:center; padding-top: 30px;}
	p#copy a { color: #555; text-decoration: none;}
	p#copy a:hover {text-decoration: underline;}
	#login {border: 1px solid #cccccc; border-radius: 10px; margin: 0 auto; width: 430px;}
	#login form {border: 1px solid #fff; border-radius: 10px; padding: 20px; }
	th {text-align: right; padding-right: 10px; font-size: 14px; width: 90px;}
	input.itext {border: 1px solid #cccccc; border-radius: 5px; background-color: #fff; padding: 8px; font-size: 14px; width: 200px;}
	input.isubmit {border: 1px solid #a49587; border-radius: 5px; background-color: #A4A4A4; padding: 8px; font-size: 14px; color: #fff; text-shadow:1px 1px 1px #444; font-weight: bold; cursor: pointer;}
	input.isubmit:hover {background-color: #FD812F;}
	.nofitication_wrapper {position: fixed; width: 400px; left: -402px; bottom: 10px; margin: 0; padding: 0;}
	.notification {position: relative; width: 400px; margin: 0 0 10px 0; padding: 0; border: 1px solid; background-position: 10px 11px !important; background-repeat: no-repeat !important; font-family: Arial, Helvetica, sans-serif; -moz-border-top-right-radius: 6px; -webkit-border-top-right-radius: 6px; border-top-right-radius: 6px; -moz-border-bottom-right-radius: 6px; -webkit-border-bottom-right-radius: 6px; border-bottom-right-radius: 6px; text-align: left;}
	.attention {background: #fffbcc url("./pics/exclamation.png") 10px 11px no-repeat; border-color: #e6db55; color: #666452;}
	.information {background: #dbe3ff url("./pics/information.png"); border-color: #a2b4ee; color: #585b66;}
	.success {background: #d5ffce url("./pics/tick_circle.png"); border-color: #9adf8f; color: #556652;}
	.error {background: #ffcece url("./pics/cross_circle.png"); border-color: #df8f8f; color: #665252;}
	.notification div {display: block; font-style: normal; padding: 10px 10px 10px 36px; line-height: 140%;}
</style>
  <script type='text/javascript' src='./script/jquery.min.js'></script>
</head>
<body>  
	<h1><?php echo PROJECT_NAME; ?></h1>  
  <div id="login">
    <form action="login.php" method="post">
      <table cellspading="0" cellpadding="2" border="0">
        <tr><th>Login</th><td><input type="text" class="itext" name="login" /></td></tr>
        <tr><th>Heslo</th><td><input type="password" class="itext" name="heslo" /></td></tr>
        <tr><th></th><td><input type="submit" name="odeslat" class="isubmit" value="Přihlásit se &raquo;" /></td></tr>
      </table>
    </form>
  </div>
		<?php 
		if(isset($_GET["err"]) && $_GET["err"] == "1") { echo "<div class=\"nofitication_wrapper\"><div class=\"notification error\"><div>Neplatný login nebo heslo</div></div></div>"; }
		if(isset($_GET["err"]) && $_GET["err"] == "2") { echo "<div class=\"nofitication_wrapper\"><div class=\"notification error\"><div>Několikanásobný neplatný pokus o přihlášení.<br />Systém je pro další pokusy o přihlášení pod stejným loginem na 5 minut deaktivován</div></div></div>"; }
		if(isset($_GET["logout"]) && $_GET["logout"] == "1") { echo "<div class=\"nofitication_wrapper\"><div class=\"notification success\"><div>Byl jste odhlášen ze systému</div></div></div>"; }
		if(isset($_GET["install"]) && $_GET["install"] == "1") { echo "<div class=\"nofitication_wrapper\"><div class=\"notification success\"><div>Instalace databáze byla dokončena, nyní je možné se přihlásit</div></div></div>"; }
		?>
</body>
</html>     
<?php
if(isset($_GET["err"]) || isset($_GET["logout"]) || isset($_GET["install"]))
{
?>
<script language="javascript">
		$('.nofitication_wrapper').animate({opacity: 1,left: '-2'}, 500, function() {}).delay(($('.nofitication_wrapper').html()).length * 30).animate({opacity: 0,left: '-402'}, 500, function() {});
	</script>  
<?php
}
?>
</body>
</html>  