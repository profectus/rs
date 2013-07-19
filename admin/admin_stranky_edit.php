<?php
/* 
 * stránka pro editaci struktury menu v redakčním systému - stránky
 * zpracování událostí
 * 
 * @author Filip Štencl
 * @since 6.7.2013
 * 
 */

require("../include/config.php");
$adminPage = new adminPage("admin_uzivatele");
if (!$adminPage->admin->getSuperadmin()) { redirect("./"); } // musí být superadmin

// zpracování událostí
if (isset($_POST['insert'])) { $clanek = new adminStranky(); $clanek->create("nazev,url,kod,idadmin_kategorie"); } // vložení nové položky
if (isset($_POST['update'])) { $clanek = new adminStranky($_POST['id']); $clanek->edit("nazev,url,kod"); } // úprava položky
if (isset($_GET['delete'])) { $clanek = new adminStranky($_GET['delete']); $clanek->delete(); } // smazání položky
if (isset($_GET['razeni'])) { $clanek = new adminStranky($_GET['razeni']); $clanek->razeni($_GET['razeni']); } // změna seřazení

// formulář pro vložení nové položky
if (isset($_GET['action']) && $_GET['action'] == "insert") { 	
	$adminPage->editHead("Přidat novou položku");
?>
	<form method="post" action="<?php echo getUrl();?>">
		<table class="formular">
			<tr><td width="400"><label>Název strany:</label><input type="text" class="itext validate[required]" name="nazev" /></td></tr>			
			<tr><td width="400"><label>Url odkaz:</label><input type="text" class="itext validate[required]" name="url" /></td></tr>			
			<tr><td width="400"><label>Kód:</label><input type="text" class="itext validate[required]" name="kod" /></td></tr>			
			<tr><td><input type="submit" class="isubmit" name="insert" value="Vložit" /></td></tr>
		</table>
		<input type="hidden" name="idadmin_kategorie" value="<?php echo intval($_GET['kategorie']); ?>" />
	</form> 
<?php	
	$adminPage->editFooter();

// formulář pro úpravu již vložené položky
} elseif (isset($_GET['action']) && $_GET['action'] == "udpate") { 	
	$adminPage->editHead("Upravit položku");	
	$adminStranky = new adminStranky(intval($_GET['id']))
?>
	<form method="post" action="<?php echo getUrl();?>">				
		<table class="formular">
			<tr><td width="400"><label>Název kategorie:</label><input type="text" class="itext validate[required]" name="nazev" value="<?php echo $adminStranky->getNazev(); ?>" /></td></tr>
			<tr><td width="400"><label>Url odkaz:</label><input type="text" class="itext validate[required]" name="url" value="<?php echo $adminStranky->getUrl(); ?>" /></td></tr>			
			<tr><td width="400"><label>Kód:</label><input type="text" class="itext validate[required]" name="kod" value="<?php echo $adminStranky->getKod(); ?>" /></td></tr>	
			<tr><td><input type="submit" class="isubmit" name="update" value="Uložit změny" /></td></tr>
		</table>
		<input type="hidden" name="id" value="<?php echo $adminStranky->getId(); ?>" />		
	</form> 
<?php 
	$adminPage->editFooter();
}
?>
