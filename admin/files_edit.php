<?php

/**
 * Soubor vypisující informace o přiložených souborech a obrázcích z tabulky files
 * Zpracování událostí
 * 
 * @author Filip Štencl
 * @since 6.7.2013 
 */

require("../include/config.php");
$adminPage = new adminPage(0);


if (isset($_POST['insert'])) { // zpracování události pro vložení nové položky
	foreach ($_FILES['soubor']['error'] as $k => $error) {
		if ($_FILES['soubor']['tmp_name'][$k] > '') {
			$files = new files();
			$files->setTempFile($_FILES['soubor']['tmp_name'][$k]);
			$files->setSoubor($_FILES['soubor']['name'][$k]);
			$files->setVelikost($_FILES['soubor']['size'][$k]);
			$files->create("popis,pomid,cesta,typ,hlavni");
		}
	} redirect($adminPage->returnBack());	
}
if (isset($_POST['update'])) { $files = new files($_POST['id']); $files->edit("popis,hlavni"); } // zpracování události pro úpravu položky
if (isset($_GET['delete'])) { $files = new files($_GET['delete']);  $files->delete(); } // zpracování události pro smazání položky
if(isset($_GET['razeni'])) { $files = new files($_GET['razeni']); $files->razeni($_GET['razeni']); } // řazení

if (isset($_GET['action']) && $_GET['action'] == "insert") { 
	$adminPage->editHead("Přidat nový soubor");
?>
		<form method="post" enctype="multipart/form-data" action="<?php echo getUrl();?>">
			<div class="info">
				Pomocí klávesy CTRL můžete vybrat více souborů najednout.<br />Tato funkce je povolena ve všech internetových prohlížečích až na IE8 a jeho předchůdce.
			</div>			
			<table class="formular">
				<tr>
					<td><label>Nahrát soubory:</label><input type="file" name="soubor[]" multiple="multiple" /></td>
					<td><label>Popis:</label><input type="text" class="itext1" name="popis" /></td>
				</tr>		
				<tr>
					<td>
						<?php if (isset($_GET['typ']) && intval($_GET['typ']) == 1) { ?>
						<input type="checkbox" name="hlavni" value="1" id="checkbox1" />nastavit jako hlavní obrázek
						<?php } ?>	
					</td>
					<td><input type="submit" class="isubmit" name="insert" value="Nahrát soubory" /></td>
				</tr>
			</table>
			<input type="hidden" name="pomid" value="<?php echo intval($_GET['pomid']); ?>" />
			<input type="hidden" name="cesta" value="<?php echo trim(strip_tags($_GET['cesta'])); ?>" />
			<input type="hidden" name="typ" value="<?php echo intval($_GET['typ']); ?>" />
		</form>
<?php	
	$adminPage->editFooter();
} 
elseif (isset($_GET['action']) && $_GET['action'] == "udpate") { 
	$files = new files(intval($_GET['id']));
	$adminPage->editHead("Upravit soubor");
?>
		<form method="post" enctype="multipart/form-data" action="<?php echo getUrl();?>">
			<table class="formular">
				<tr><th><label>Popis:</label><input type="text" class="itext1" name="popis" value="<?php echo $files->getPopis(); ?>" /></th></tr>
				<tr>
					<th>
						<?php if (isset($_GET['typ']) && intval($_GET['typ']) == 1) { ?>
						<input type="checkbox" name="hlavni" value="1" <?php if ($files->getHlavni() == true) { echo "checked=\"checked\""; } ?>>nastavit jako hlavní obrázek
						<?php } ?>	
					</th>
					<td><input type="submit" class="isubmit" name="update" value="Uložit změny" /></td>
				</tr>
			</table>
			<input type="hidden" name="id" value="<?php echo $files->getId(); ?>" />
		</form> 
<?php  
	$adminPage->editFooter();
}
?>
