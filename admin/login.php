<?php
/*
 * kontrola formuláře pro přihlášení uživatele do administrace
 * 
 * @author Filip Štencl
 * @since 22.12.2012
 * 
 */

require("../include/config.php");

if (isset($_SESSION['notification_output']) && $_SESSION['notification_output'] != "") { $_SESSION['notification_output'] = ""; }
if (isset($_SESSION['notification_success']) && $_SESSION['notification_success'] != "") {$_SESSION['notification_success'] = ""; }
if (isset($_SESSION['notification_information']) && $_SESSION['notification_information'] != "") { $_SESSION['notification_information'] = ""; }
if (isset($_SESSION['notification_attention']) && $_SESSION['notification_attention'] != "") { $_SESSION['notification_attention'] = ""; }
if (isset($_SESSION['notification_error']) && $_SESSION['notification_error'] != "") { $_SESSION['notification_error'] = ""; }
if (isset($_SESSION['notification_alert']) && $_SESSION['notification_alert'] != "") { $_SESSION['notification_alert'] = ""; }

if (isset($_POST['login']) && $_POST['login'] <> "" && isset($_POST['heslo']) && $_POST['heslo'] <> "") {
	$login = strtolower(trim($_POST['login']));	 
	$pocet = dibi::query("SELECT ifnull(count(*),0) FROM [admin_uzivatele_log] WHERE [uspech] = 0 AND [caszalozeni] > date_add(NOW(),INTERVAL -5 MINUTE) AND LOWER([login]) = '".$login."'")->fetchSingle();

	if ($pocet < 3) {
		$result = dibi::query("SELECT * FROM [admin_uzivatele] WHERE [smazano] = 0 AND [povolen] = 1 AND LOWER([login]) = '".$login."' AND [heslo] = '".sha1($_POST['heslo'])."'");
		if ($result->count() == 0)  {
			$_SESSION['admin_id'] = "";
			dibi::query("INSERT INTO [admin_uzivatele_log] ([login],[IP],[uspech]) VALUES ('".$login."', '".ip_adresa()."',0)");	    
			$presmerovani = "./?err=1";
		} else {
			$row = $result->fetch();	   				   
			$_SESSION['admin_id'] = $row->id;
			$_SESSION['admin_superadmin'] = $row->superadmin;
			dibi::query("DELETE FROM [admin_nav_history] WHERE [idadmin_uzivatele] = '".intval($row->id)."'");
			dibi::query("DELETE FROM [admin_uzivatele_log] WHERE [login] = '".$login."'");
			dibi::query("UPDATE [admin_uzivatele] SET [caszmeny] = NOW() WHERE [id] = '".intval($row->id)."'");
			notification::infoBox_success("Byl jste přihlášen do systému."); 
			notification::zaloguj("Přihlášení uživatele <strong>".$row->jmeno." ".$row->prijmeni."</strong>",0,0);			
			$presmerovani = "./home.php";
		}	
    } else { $presmerovani = "./?err=2"; }
} else { $presmerovani = "./?err=1"; }

redirect($presmerovani);
?>