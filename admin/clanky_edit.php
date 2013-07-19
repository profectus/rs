<?php
/* 
 * stránka pro editaci článků
 * zpracování událostí
 * 
 * @author Filip Štencl
 * @since 7.7.2013
 * 
 */

require("../include/config.php");

$lang = intval($_GET['lang']);
if ($lang == 1) { $adminPage = new adminPage("kategorie_clanky_lang1"); }
elseif ($lang == 2) { $adminPage = new adminPage("kategorie_clanky_lang2"); }
else {redirect("./home.php");}

if (isset($_POST['insert'])) { $clanek = new clanek(); $clanek->create("nazev,idkategorie,anotace,detail,zobrazit"); }
if (isset($_POST['update'])) { $clanek = new clanek($_POST['id']); $clanek->edit("nazev,anotace,detail,zobrazit"); }
if (isset($_GET['delete'])) { $clanek = new clanek($_GET['delete']); $clanek->delete(); }
if (isset($_GET['razeni'])) { $clanek = new clanek($_GET['razeni']); $clanek->razeni($_GET['razeni']); }

if (isset($_GET['action']) && $_GET['action'] == "insert") { 	
	$adminPage->editHead("Přidat nový článek");
	$adminPage->js_ckeditor("detail"); 	
?>
	<form method="post" action="<?php echo getUrl();?>">
		<table class="formular">
			<tr>
				<td width="400">
					<label>Nadpis:</label><input type="text" class="itext validate[required]" name="nazev" />
				</td>
				<td><label>Anotace:</label><textarea class="iarea" name="anotace" rows="4"></textarea></td>
			</tr>
			<tr><td colspan="2"><label>Text:</label><textarea name="detail" ></textarea></td></tr>
			<tr>
				<td><?php $adminPage->anoNe("zobrazit","Zobrazovat na veřejné části");?></td>
				<td><input type="submit" class="isubmit" name="insert" value="Vložit" /></td>
			</tr>
		</table>
		<input type="hidden" name="idlang" value="<?php echo intval($_GET['lang']); ?>" />
		<input type="hidden" name="idkategorie" value="<?php echo intval($_GET['rodic']); ?>" />
	</form> 
<?php	
	$adminPage->editFooter();
} else if (isset($_GET['action']) && $_GET['action'] == "udpate") { 	
	$adminPage->editHead("Přidat nový článek");	
	$adminPage->js_ckeditor("detail"); 
	$clanek = new clanek(intval($_GET['id']))
?>
	<form method="post" action="<?php echo getUrl();?>">				
		<table class="formular">
			<tr>
				<td width="400">
					<label>Nadpis:</label><input type="text" class="itext validate[required]" name="nazev" value="<?php echo $clanek->getNazev(); ?>" />
				</td>
				<td><label>Anotace:</label><textarea class="iarea" name="anotace" rows="4"><?php echo $clanek->getAnotace(); ?></textarea></td>
			</tr>
			<tr><td colspan="2"><label>Text:</label><textarea name="detail" ><?php echo $clanek->getDetail(); ?></textarea></td></tr>
			<tr>
				<td><?php $adminPage->anoNe("zobrazit","Zobrazovat na veřejné části",$clanek->getZobrazit());?></td>
				<td><input type="submit" class="isubmit" name="update" value="Uložit změny" /></td>
			</tr>
		</table>
		<input type="hidden" name="id" value="<?php echo $clanek->getId(); ?>" />		
	</form> 
<?php 
	$adminPage->editFooter();
}
?>
