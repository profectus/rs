<?php

/**
 * Soubor vypisující informace o přiložených souborech a obrázcích z tabulky files
 * 
 * @author Filip Štencl
 * @since 6.7.2013 
 * 
 */


require("../include/config.php");
$adminPage = new adminPage();
$adminPage->head(); 

$adminPage->button_insert();
$adminPage->button_back();
$adminPage->button_razeni();

	if (isset($_GET['typ']) && intval($_GET['typ']) == "1") { $nadpis = "Seznam fotografií k vybrané položce"; $typ = 1; }
	else { $nadpis = "Seznam dokumentů ke stažení k vybrané položce"; $typ = 2; }
	$adminPage->slideHead($nadpis);	
	
	$sql = " SELECT A.* FROM files A";	
	$table = new table($sql);
	$table->setId("seznam_prilozenych_souboru".$typ);
	$table->sortable($adminPage->editUrl());
   $table->where("A.pomid = '".intval($_GET['pomid'])."' AND cesta = '".trim(strip_tags($_GET['cesta']))."' AND typ = ".intval($_GET['typ']));
	$table->setOrder("A.poradi ASC");	
	if ($typ == 1) { $table->addMainColumn("Náhled"); }
	$table->addMainColumn("Soubor");
	$table->addMainColumn("Velikost souboru");
	if ($typ == 1) { $table->addMainColumn("Hlavní"); }
	$table->addMainColumn("");
	$table->addMainColumn("");
	$table->addMainColumn("");
	$table->tableHead();
	foreach ($table->getResult() as $row) {
		$table->addRow($row->id);
		if ($typ == 1) { $table->addColumn("<td width=\"100\"><a href=\"../data/".$row->cesta."/".$row->pomid."/foto/".($row->typ == 1 ? "":"dokumenty/")."".$row->soubor."\" title=\"soubor: ".$row->soubor."\"  target=\"_blank\"".($row->typ == 1 ? " rel='lightbox'":"")."><img src=\"../images-crop/100x100/".$row->cesta."/".$row->pomid."/".$row->soubor."\"></a></td>"); } 
		$table->addColumn("<td><strong><a href=\"../data/".$row->cesta."/".$row->pomid."/foto/".($row->typ == 1 ? "":"dokumenty/")."".$row->soubor."\" title=\"soubor: ".$row->soubor."\" target=\"_blank\"".($row->typ == 1 ? " rel='lightbox'":"").">".$row->soubor."</a></strong><br />".$row->popis."</td>");		
		$table->addColumn("<td>".toVelikost($row->velikost)."</td>");
		if ($typ == 1) { $table->addColumn("<td><strong>".($row->hlavni==true?"ano":"ne")."</strong></td>"); }
		$table->addStaticColumn("<td class=\"presun\" width=\"20\"><a class=\"tooltip\" title=\"Přesunout tento záznam\">".table::ico_presun."</a></td>");
		$table->addStaticColumn("<td width=\"20\"><a href=\"".$adminPage->editUrl()."&amp;action=udpate&amp;id=".$row->id."\" rel=\"modal\" class=\"tooltip\" title=\"Editovat tento záznam\">".table::ico_edit."</a></td>");
		$table->addStaticColumn("<td width=\"20\"><a href=\"".$adminPage->editUrl()."&amp;delete=".$row->id."\" onclick=\"return confirm('Opravdu smazat tuto položku?');\" class=\"tooltip\" title=\"Smazat tento záznam\">".table::ico_delete."</a></td>");	
	}
	$table->writeTable();
	$adminPage->slideFooter();
$adminPage->footer();

?>
