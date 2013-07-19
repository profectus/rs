<?php
/*
 * stránka pro editaci uživatelů redakčního systému
 * zpracování událostí
 *
 *	@author Filip Štencl
 * @since 6.7.2013
 * 
 */

require("../include/config.php");
$adminPage = new adminPage("admin_uzivatele");

if (isset($_POST['insert'])) { $adminUser = new adminUser(); $adminUser->create("login,jmeno,prijmeni,kontakt,heslo,heslo2,stranky,povolen"); } // zpracování události pro vložení nové položky	
if (isset($_POST['update'])) { $adminUser = new adminUser($_POST['id']); $adminUser->edit("jmeno,prijmeni,kontakt,stranky,povolen"); } // zpracování události pro úpravu položky
if (isset($_GET['delete'])) { $adminUser = new adminUser($_GET['delete']); $adminUser->delete(); } // zpracování události pro smazání položky

if (isset($_GET['action']) && $_GET['action'] == "insert") { 
	$adminPage->editHead("Přidat nového uživatele");
?>
	<form method="post" action="<?php echo getUrl();?>">	
		<table class="formular">
			<tr>
				<td>
					<label>Login:</label><input type="text" class="itext validate[required]" name="login" />
					<label>Jméno:</label><input type="text" class="itext validate[required]" name="jmeno" />
					<label>Příjmení:</label><input type="text" class="itext validate[required]" name="prijmeni" />
					<label>Kontakt:</label><input type="text" class="itext" name="kontakt" />
					<label>Heslo:</label><input type="password" class="itext validate[required,minSize[<?php echo CONST_MIN_CHAR_LOGIN_PASSWORD; ?>]]" name="heslo" id="heslo" />
					<label>Heslo (kontrola):</label><input type="password" class="itext validate[required,equals[heslo],minSize[<?php echo CONST_MIN_CHAR_LOGIN_PASSWORD; ?>]]" name="heslo2" />
				</td>
				<td width="370">
					<label>Nastavení oprávnění:</label>
					<?php
					$result = dibi::query("SELECT A.*, B.nazev AS kategorie FROM admin_stranky A LEFT OUTER JOIN admin_kategorie B ON A.idadmin_kategorie = B.id ORDER BY B.poradi, A.poradi");
					foreach ($result->fetchall() as $row) {
						echo "<input type=\"checkbox\" name=\"stranky[]\" value=\"".$row->id."\" id=\"checkbox".$row->id."\" />".$row->kategorie." - ".$row->nazev."<br/>\n";
					}
					?>
				</td>
			<tr>
				<td><?php $adminPage->anoNe("povolen","Povolit přihlášení uživatele");?></td>
				<td><input type="submit" class="isubmit" name="insert" value="Vložit" /></td>
			</tr>
		</table>
	</form>
<?php	
	$adminPage->editFooter();
}
else if (isset($_GET['action']) && $_GET['action'] == "udpate") { 
	$admin_form = new adminUser(intval($_GET['id']));
	$adminPage->editHead("Upravit uživatele ".$admin_form->getLogin());
?>
	<form method="post" action="<?php echo getUrl();?>">	
		<table class="formular">
			<tr>
				<td>
					<label>Jméno:</label><input type="text" class="itext validate[required]" name="jmeno" value="<?php echo $admin_form->getJmeno(); ?>" />
					<label>Příjmení:</label><input type="text" class="itext validate[required]" name="prijmeni" value="<?php echo $admin_form->getPrijmeni(); ?>" />
					<label>Kontakt:</label><input type="text" class="itext" name="kontakt" value="<?php echo $admin_form->getKontakt(); ?>" />
				</td>
				<td width="370">
					<label>Nastavení oprávnění:</label>
					<?php
					$result = dibi::query("SELECT A.*, B.nazev AS kategorie FROM admin_stranky A LEFT OUTER JOIN admin_kategorie B ON A.idadmin_kategorie = B.id ORDER BY B.poradi, A.poradi");
					foreach ($result->fetchall() as $row) {
						echo "<input type=\"checkbox\" name=\"stranky[]\" value=\"".$row->kod."\" id=\"checkbox".$row->id."\" ".(in_array($row->kod,$admin_form->getStranky())?"checked=\"checked\"":"")." />".$row->kategorie." - ".$row->nazev."<br/>\n";
					}
					?>
				</td>
			</tr>
			<tr>
				<td><?php $adminPage->anoNe("povolen","Povolit přihlášení uživatele",$admin_form->getPovolen());?></td>
				<td><input type="submit" class="isubmit" name="update" value="Uložit" /></td>
			</tr>
		</table>
		<input type="hidden" name="id" value="<?php echo $admin_form->getId(); ?>" />
	</form>
<?php  
	$adminPage->editFooter();
}
?>
