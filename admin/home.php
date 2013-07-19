<?php
/* 
 * výchozí stránka po přihlášení uživatele do administrace
 * 
 * @author Filip Štencl
 * @since 6.7.2013
 * 
 */

require("../include/config.php");
$adminPage = new adminPage(0);
$adminPage->head();

$adminPage
	->button("změnit heslo")
	->button_set_url("./uzivatele_zmena_hesla.php")
	->button_set_title("změnit heslo uživatele")
	->button_set_modal(true)
	->button_write(); 

$adminPage->slideHead("Poslední aktivita uživatele ".$adminPage->admin->getJmeno_prijmeni());
	$table = new table("SELECT * FROM [admin_logtable]");
	$table
		->setId("posledni_aktivita_uzivatele")
		->where("[idadmin_uzivatele] = ".$_SESSION['admin_id'])
		->setOrder("caszalozeni DESC")
		->setLimit(25)
		->calendar("caszalozeni")
		->search("popis,ip")	
		->addMainColumn("Datum a čas","caszalozeni ASC")
		->addMainColumn("Uživatel")
		->addMainColumn("IP adresa","ip ASC")
		->addMainColumn("Popis aktivity","popis ASC")
		->pager()			  
		->tableHead();
	foreach ($table->getResult() as $row) {
		$table
			->addRow($row->id)
			->addColumn("<td width=\"140\">".datum($row->caszalozeni,"Y-m-d H:i:s")."</td>")
			->addColumn("<td>".$adminPage->admin->getJmeno_prijmeni()."</td>")
			->addColumn("<td>".$row->ip."</td>")
			->addColumn("<td>".$row->popis."</td>");
	}
	$table->writeTable();
$adminPage->slideFooter();

//-------------------------------------------------------------------------------------------------------------------------------
$adminPage->footer();
?>