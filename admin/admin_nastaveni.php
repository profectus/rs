<?php
/*
 * stránka pro editaci struktury menu v redakčním systému - kategorie
 *
 *	@author Filip Štencl
 * @since 6.7.2013
 * 
 */

require("../include/config.php");
$adminPage = new adminPage("admin_uzivatele");
if (!$adminPage->admin->getSuperadmin()) { redirect("./"); } // musí být superadmin
$adminPage->setNadpis("Nastavení redakčního systému");
$adminPage->head(); 

$adminPage->button_insert();
$adminPage->button_razeni();

$adminPage->slideHead("Kategorie redakčního systému");
	$sql = "
		SELECT A.*, ifnull(B.pocet,0) AS pocet FROM [admin_kategorie] A 
		LEFT OUTER JOIN ( SELECT COUNT(id) as pocet, idadmin_kategorie FROM[admin_stranky] GROUP BY idadmin_kategorie) B ON A.id = B.idadmin_kategorie";
	$table = new table($sql);
	$table
		->setId("admin_kategorie")
		->sortable($adminPage->editUrl())
		->setOrder("A.poradi ASC")
		->addMainColumn("Název")
		->addMainColumn("Podkategorie")
		->addMainColumn("")
		->addMainColumn("")
		->addMainColumn("")
		->tableHead();
	foreach ($table->getResult() as $row) {
		$table
			->addRow($row->id)
			->addColumn("<td><strong>".$row->nazev."</strong></td>")
			->addColumn("<td><a href=\"admin_stranky.php?pagecode=".$adminPage->getPageCode()."&amp;kategorie=".$row->id."\">upravit podkategorie: ".$row->pocet."</a></td>")
			->addStaticColumn_presun()				 
			->addStaticColumn_edit($adminPage->editUrl()."?action=udpate&amp;id=".$row->id)
			->addStaticColumn_delete($adminPage->editUrl()."?delete=".$row->id);
	}
	$table->writeTable();
$adminPage->slideFooter();
$adminPage->footer();
?>