<?php
/* 
 * stránka pro editaci kategorií
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

if (isset($_POST['insert'])) { $kategorie = new kategorie(); $kategorie->setIdlang($lang); $kategorie->create("rodic,nazev,typ,presmerovani,target_blank,zobrazit"); } // zpracování události pro vložení nové položky
if (isset($_POST['update'])) { $kategorie = new kategorie($_POST['id']); $kategorie->edit("nazev,typ,presmerovani,target_blank,zobrazit"); } // zpracování události pro úpravu položky
if(isset($_GET['delete'])) { $kategorie = new kategorie($_GET['delete']); $kategorie->delete(); } // zpracování události pro smazání položky
if(isset($_GET['razeni'])) { $kategorie = new kategorie($_GET['razeni']); $kategorie->razeni($_GET['razeni']); } // řazení

if (isset($_GET['action']) && $_GET['action'] == "insert") { 
	$adminPage->editHead("Přidat novou kategorii");
?>
	<form method="post" action="<?php echo getUrl();?>">
		<table class="formular">
			<tr>
				<td>
					<label>Název:</label><input type="text" class="itext validate[required]" name="nazev" />
					<label>Typ obsahu:</label>
					<select name="typ"class="itext">
						<?php
						if (isset($_GET['rodic']) && $_GET['rodic'] > 0) { $typKat = "Podkat"; } else {$typKat = "Hlkat"; }
						foreach (dibi::query("SELECT id,nazev FROM kategorie_typ WHERE typ".$typKat." = 1 ORDER BY poradi ASC")->fetchAll() as $row) {	
							echo "<option value=\"".$row["id"]."\">".$row["nazev"]."</option>\n";
						}
						?>
						 <option value="0">Přesměrování</option>
					</select>
					<label>Přesměrování:</label>
					<input type="text" class="itext tooltip" name="presmerovani" title="přesměrování je aplikováno pouze, pokud nastaven typ kategorie na hodnotu &bdquo;přesměrování&ldquo;" />
				</td>
				<td width="340">
					<p>
						<label>Přesměrování:</label>
						Přesměrování využijte jen v případě, kdy vyžadujete uživatele přesměrovat na adresu mimo doménu projektu, 
						nebo přímo na dokument ke stažení. V těchto případech doporučujeme také zaškrtnout pole pro otevření do nového okna.<br />
						Přesměrování lze použít také pro podstránky atypického charakteru, jako např. novinky, kontakty a podobné části systému.
					</p>					
				</td>
			</tr>
			<tr>
				<td>
					<?php $adminPage->anoNe("target_blank","Otevřít do nového okna");?>
					<?php $adminPage->anoNe("zobrazit","Zobrazovat na veřejné části");?>				
				</td>
				<td><br /><input type="submit" class="isubmit" name="insert" value="Přidat kategorii" /></td>
			</tr>
		</table>
		<input type="hidden" name="rodic" value="<?php echo intval(@$_GET['rodic'])?>" />
	</form>
<?php	
	$adminPage->editFooter();
}
else if(isset($_GET['action']) && $_GET['action'] == "udpate") { 
	$kategorie = new kategorie(intval($_GET['id']));
	$adminPage->editHead("Upravit kategorii");
?>
	<form method="post" action="<?php echo getUrl();?>">
		<table class="formular">
			<tr>
				<td>
					<label>Název:</label><input type="text" class="itext validate[required]" name="nazev" value="<?php echo $kategorie->getNazev();?>" />
					<label>Typ obsahu:</label>
					<select name="typ" class="itext">
						<?php
						$nalezeno = false;
						if (isset($_GET['rodic']) && $_GET['rodic'] > 0) { $typKat = "Podkat"; } else {$typKat = "Hlkat"; }
						foreach (dibi::query("SELECT id,nazev FROM kategorie_typ WHERE typ".$typKat." = 1 ORDER BY poradi ASC")->fetchAll() as $row) {							
							echo "<option value=\"".$row['id']."\" ".($kategorie->getTyp() == $row['id']?"selected=\"selected\"":"").">".$row['nazev']."</option>\n";
							if ($kategorie->getTyp() == $row['id']) { $nalezeno = true; }
						}
						?>
						 <option value="0" <?php if($nalezeno == false) { echo "selected=\"selected\"";} ?>>Přesměrování</option>
					</select>
					<label>Přesměrování:</label>
					<input type="text" class="itext tooltip" name="presmerovani" title="přesměrování je aplikováno pouze, pokud nastaven typ kategorie na hodnotu &bdquo;přesměrování&ldquo;" value="<?php echo $kategorie->getPresmerovani();?>" />
				</td>
				<td width="340">
					<p>
						<label>Přesměrování:</label>
						Přesměrování využijte jen v případě, kdy vyžadujete uživatele přesměrovat na adresu mimo doménu projektu, 
						nebo přímo na dokument ke stažení. V těchto případech doporučujeme také zaškrtnout pole pro otevření do nového okna.<br />
						Přesměrování lze použít také pro podstránky atypického charakteru, jako např. novinky, kontakty a podobné části systému.
					</p>					
				</td>
			</tr>
			<tr>
				<td>
					<?php $adminPage->anoNe("target_blank","Otevřít do nového okna",$kategorie->getTarget_blank());?>
					<?php $adminPage->anoNe("zobrazit","Zobrazovat na veřejné části",$kategorie->getZobrazit());?>				
				</td>
				<td><br /><input type="submit" class="isubmit" name="update" value="Upravit kategorii" /></td>
			</tr>
		</table>
		<input type="hidden" name="rodic" value="<?php echo intval(@$_GET['rodic'])?>" />
		<input type="hidden" name="id" value="<?php echo intval(@$_GET['id'])?>" />
	</form>
<?php 
	$adminPage->editFooter();
}
?>
