<?php
/*
 * stránka pro editaci uživatelů redakčního systému
 * zpracování událostí
 *
 *	@author Filip Štencl
 * @since 1.1.2013
 * 
 */

require("../include/config.php");
$adminPage = new adminPage(0);

if (isset($_POST['update'])) { $adminUser = new adminUser($adminPage->admin->getId()); $adminUser->editPass("heslo_old,heslo,heslo2");	redirect("home.php"); }  // zpracování události pro úpravu položky


$adminPage->editHead("Upravit heslo uživatele ".$adminPage->admin->getJmeno_prijmeni()." ?");
?>
	<script>
		$(document).ready(function() {$("#upravitzaznam").validationEngine("attach");});
		function passwordStrength(password) {
			var desc = new Array();
			desc[0] = "Velmi snadné heslo";
			desc[1] = "Snadné heslo";
			desc[2] = "Lepší heslo";
			desc[3] = "Dobré heslo";
			desc[4] = "Silné heslo";
			desc[5] = "Hustodémonsky krutopřísné heslo";
			var score   = 0;
			if (password.length > 5) score++;
			if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;
			if (password.match(/\d+/)) score++;
			if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) )	score++;
			if (password.length > 12) score++;
			 document.getElementById("passwordDescription").innerHTML = desc[score];
			 document.getElementById("passwordStrength").className = "strength" + score;
		}
	</script>
	<form method="post" id="upravitzaznam" action="<?php echo getUrl();?>">	
		<table class="formular">
			<tr>
				<td>
					<label>Původní heslo:</label><input type="password" class="itext validate[required]" name="heslo_old" />
					<label>Nové heslo:</label><input type="password" class="itext validate[required,minSize[<?php echo CONST_MIN_CHAR_LOGIN_PASSWORD; ?>]]" name="heslo" id="heslo" onkeyup="passwordStrength(this.value)" />
					<label>Nové heslo (kontrola):</label><input type="password" class="itext validate[required,equals[heslo],minSize[<?php echo CONST_MIN_CHAR_LOGIN_PASSWORD; ?>]]" name="heslo2" />
				</td>	
				<td align="center">
					<br /><br />
					<label class="tacenter">Heslo musí obsahovat nejméně 5 znaků</label>
					<label class="tacenter" for="passwordStrength">Síla zvoleného hesla:</label>
					<div id="passwordDescription">Heslo nebylo vyplněno</div>
					<div id="passwordStrength_wrapper"><div id="passwordStrength" class="strength0"></div></div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" class="isubmit" name="update" value="Uložit" /></td>
			</tr>
		</table>
	</form>
<?php  
$adminPage->editFooter();
?>