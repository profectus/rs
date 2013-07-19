<?php
/* 
 * stránka pro editaci článků
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
if (!isset($_GET['rodic']) || intval($_GET['rodic']) == 0) { redirect("./kategorie.php?lang=".$lang);}

$kategorie = new kategorie(intval($_GET['rodic']));

$adminPage->head(); 

$adminPage->button_insert();
$adminPage->button_back("./kategorie.php?lang=".$lang."&amp;rodic=".intval($kategorie->getRodic()));
$adminPage->button_razeni();


$nazevKategorie = dibi::query("SELECT nazev FROM kategorie WHERE id=".intval($_GET['rodic']))->fetchSingle();	
$adminPage->slideHead("Seznam článků kategorie: ".$nazevKategorie);	
	
	$sql = "SELECT A.*, ifnull(B.pocet,0) AS pocetF, ifnull(C.pocet,0) AS pocetD FROM [clanky] A
		LEFT JOIN (SELECT COUNT(pomid) AS pocet,pomid FROM [files] WHERE typ = 1 AND cesta = 'clanky' GROUP BY pomid) B ON A.id = B.pomid
		LEFT JOIN (SELECT COUNT(pomid) AS pocet,pomid FROM [files] WHERE typ = 2 AND cesta = 'clanky' GROUP BY pomid) C ON A.id = C.pomid
		";	
	$table = new table($sql);	
	$table
		->setId("seznam_clanku")
		->sortable($adminPage->editUrl())
		->where("A.idkategorie = '".intval($_GET['rodic'])."'")
		->setOrder("poradi")
		->search("nazev,detail,anotace")
		->addMainColumn("název")
		->addMainColumn("zobrazovat")
		->addMainColumn("fotografie")
		->addMainColumn("dokumenty")
		->addMainColumn()
		->addMainColumn()
		->addMainColumn()
		->tableHead();
	foreach ($table->getResult() as $row) {
		$table->addRow($row->id);
		$table->addColumn("<td><strong>".$row->nazev."</strong></td>");
		$table->addColumn("<td><strong>".($row->zobrazit==true?"ano":"ne")."</strong></td>");
		$table->addColumn("<td><a href=\"files.php?pagecode=".$adminPage->getPageCode()."&amp;cesta=clanky&amp;typ=1&amp;pomid=".$row->id."\">fotografie (".$row->pocetF.")</a></td>");
		$table->addColumn("<td><a href=\"files.php?pagecode=".$adminPage->getPageCode()."&amp;cesta=clanky&amp;typ=2&amp;pomid=".$row->id."\">dokumenty (".$row->pocetD.")</a></td>");
		$table->addStaticColumn_presun();
		$table->addStaticColumn_edit($adminPage->editUrl()."&amp;action=udpate&amp;id=".$row->id);
		$table->addStaticColumn_delete($adminPage->editUrl()."&amp;delete=".$row->id);		
	}
	$table->writeTable();
$adminPage->slideFooter();	
$adminPage->footer();
?>