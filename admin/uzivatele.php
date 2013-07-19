<?php
/*
 * stránka pro editaci uživatelů redakčního systému
 *
 *	@author Filip Štencl
 * @since 1.1.2013
 * 
 */

require("../include/config.php");
$adminPage = new adminPage("admin_uzivatele");
$adminPage->head(); 

$adminPage->button_insert();

if ($adminPage->admin->getSuperadmin() == true ) { 
	$adminPage
		->button("Nastavení")
		->button_set_url("admin_nastaveni.php")
		->button_set_class("gray")
		->button_set_title("Upravit strukturu administrace")
		->button_write(); 
} 

$adminPage->slideHead("Seznam uživatelů redakčního systému");
	$sql = "SELECT A.* FROM [admin_uzivatele] A";
	$table = new table($sql);
	$table
		->setId("seznam_uzivatelu")
		->where("A.smazano = 0")
		->setOrder("A.login ASC")
		->setLimit(20)	
		->addMainColumn("Login","A.login DESC")
		->addMainColumn("Jméno a příjmení","A.prijmeni ASC, A.jmeno ASC")
		->addMainColumn("Poslední přihlášení","A.caszmeny ASC")
		->addMainColumn("Kontakt","A.kontakt ASC")
		->addMainColumn("Povolen","A.povolen ASC")
		->addMainColumn("")
		->addMainColumn("")
		->pager()
		->tableHead();
	foreach ($table->getResult() as $row) {
		$table->addRow($row->id);
		$table->addColumn("<td><strong>".$row->login."</strong></td>");
		$table->addColumn( "<td><strong>".$row->jmeno." ".$row->prijmeni."</strong></td>");
		$table->addColumn( "<td>".($row->caszmeny=="0000-00-00 00:00:00"?"doposud nepřihlášen":datum($row->caszmeny,"d.m.Y H:i:s"))."</td>");
		$table->addColumn( "<td><strong>".$row->kontakt."</strong></td>");
		$table->addColumn( "<td><strong>".($row->povolen==true?"ano":"ne")."</strong></td>");		
		if ($adminPage->admin->getSuperadmin() == true || $row->superadmin == false ) { 
		$table->addStaticColumn_edit($adminPage->editUrl()."?action=udpate&amp;id=".$row->id);
		$table->addStaticColumn_delete( $adminPage->editUrl()."?delete=".$row->id);
		} else {
			$table->addStaticColumn( "<td></td>");
			$table->addStaticColumn( "<td></td>");
		}		
	}
	$table->writeTable();
$adminPage->slideFooter();
$adminPage->footer();
?>