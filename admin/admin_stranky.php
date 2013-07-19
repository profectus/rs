<?php
/*
 * stránka pro editaci struktury menu v redakčním systému - stránky
 *
 *	@author Filip Štencl
 * @since 6.7.2013
 * 
 */

require("../include/config.php");
$adminPage = new adminPage("admin_uzivatele");
if (!$adminPage->admin->getSuperadmin()) { redirect("./"); } // musí být superadmin
if (!isset($_GET['kategorie']) || intval($_GET['kategorie']) == 0) { redirect("./"); }
$idkategorie = intval($_GET['kategorie']);
$adminPage->setNadpis("Nastavení redakčního systému");
$adminPage->head(); 

$adminPage->button_insert();
$adminPage->button_back();
$adminPage->button_razeni();
			

$kategorie = new adminKategorie($idkategorie);

$adminPage->slideHead("Položky kategorie <strong>".$kategorie->getNazev()."</strong>");
	$sql = "
		SELECT A.*, B.nazev AS kategorie FROM [admin_stranky] A
		LEFT OUTER JOIN [admin_kategorie] B ON A.idadmin_kategorie = B.id
		";
	$table = new table($sql);
	$table
		->setId("admin_kategorie")
		->where("A.idadmin_kategorie = $idkategorie")
		->sortable($adminPage->editUrl())
		->setOrder("A.poradi ASC")
		->addMainColumn("Název")
	   ->addMainColumn("Kategorie")
		->addMainColumn("kód")
		->addMainColumn("url")
		->addMainColumn("")
		->addMainColumn("")
		->addMainColumn("")
		->tableHead();
	foreach ($table->getResult() as $row) {
		$table
			->addRow($row->id)
			->addColumn("<td><strong>".$row->nazev."</strong></td>")
			->addColumn("<td>".$row->kategorie."</td>")
			->addColumn("<td>".$row->kod."</td>")
			->addColumn("<td>".$row->url."</td>")
			->addStaticColumn_presun()				 
			->addStaticColumn_edit($adminPage->editUrl()."&amp;action=udpate&amp;id=".$row->id)
			->addStaticColumn_delete($adminPage->editUrl()."&amp;delete=".$row->id);
	}
	$table->writeTable();
$adminPage->slideFooter();
$adminPage->footer();
?>