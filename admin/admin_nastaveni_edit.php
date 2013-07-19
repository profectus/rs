<?php
/* 
 * stránka pro editaci struktury menu v redakčním systému - kategorie
 * zpracování událostí
 * 
 * @author Filip Štencl
 * @since 5.7.2013
 * 
 */

require("../include/config.php");
$adminPage = new adminPage("admin_uzivatele");
if (!$adminPage->admin->getSuperadmin()) { redirect("./"); } // musí být superadmin

// zpracování událostí
if (isset($_POST['insert'])) { $clanek = new adminKategorie(); $clanek->create("nazev"); } // vložení nové položky
if (isset($_POST['update'])) { $clanek = new adminKategorie($_POST['id']); $clanek->edit("nazev"); } // úprava položky
if (isset($_GET['delete'])) { $clanek = new adminKategorie($_GET['delete']); $clanek->delete(); } // smazání položky
if (isset($_GET['razeni'])) { $clanek = new adminKategorie($_GET['razeni']); $clanek->razeni($_GET['razeni']); } // změna seřazení

// formulář pro vložení nové položky
if (isset($_GET['action']) && $_GET['action'] == "insert") { 	
	$adminPage->editHead("Přidat novou položku");
?>
	<form method="post" action="<?php echo getUrl();?>">
		<table class="formular">
			<tr><td width="400"><label>Název kategorie:</label><input type="text" class="itext validate[required]" name="nazev" /></td></tr>			
			<tr><td><input type="submit" class="isubmit" name="insert" value="Vložit" /></td></tr>
		</table>
	</form> 
<?php	
	$adminPage->editFooter();

// formulář pro úpravu již vložené položky
} else if (isset($_GET['action']) && $_GET['action'] == "udpate") { 	
	$adminPage->editHead("Upravit položku");	
	$adminKategorie = new adminKategorie(intval($_GET['id']))
?>
	<form method="post" action="<?php echo getUrl();?>">				
		<table class="formular">
			<tr><td width="400"><label>Název kategorie:</label><input type="text" class="itext validate[required]" name="nazev" value="<?php echo $adminKategorie->getNazev(); ?>" /></td></tr>
			<tr><td><input type="submit" class="isubmit" name="update" value="Uložit změny" /></td></tr>
		</table>
		<input type="hidden" name="id" value="<?php echo $adminKategorie->getId(); ?>" />		
	</form> 
<?php 
	$adminPage->editFooter();
}
?>
