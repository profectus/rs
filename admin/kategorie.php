<?php
/*
 * stránka pro editaci kategorií
 *  
 * @author Filip Štencl
 * @since 6.7.2013
 *
 */

require("../include/config.php");

$lang = intval($_GET['lang']);
if ($lang == 1) { $adminPage = new adminPage("kategorie_clanky_lang1"); }
elseif ($lang == 2) { $adminPage = new adminPage("kategorie_clanky_lang2"); }
else {redirect("./home.php");}

$adminPage->head();
if(isset($_GET['rodic'])) {				

	$adminPage->button_insert();
	$adminPage->button_back("./kategorie.php?lang=".$lang);
	$adminPage->button_razeni();

	$adminPage->slideHead("Seznam podkategorií");	
		$sql = "SELECT A.*, C.nazev AS typnazev, ifnull(B.pocet,0) AS pocet FROM kategorie A
		LEFT JOIN (SELECT COUNT(idkategorie) AS pocet,idkategorie FROM clanky GROUP BY idkategorie) B ON A.id = B.idkategorie
		LEFT JOIN kategorie_typ C ON C.id = A.typ";
		$table = new table($sql);
		$table
			->setId("seznam_podkategorii")
			->setOrder("A.poradi ASC")
			->where("A.rodic = '".intval($_GET['rodic'])."'")
			->setLimit(25)
			->sortable($adminPage->editUrl())
			->addMainColumn("Název podkategorie")
			->addMainColumn("Typ")
			->addMainColumn("Zobrazovat")
			->addMainColumn("Otevřít v novém okně")
			->addMainColumn("")
			->addMainColumn("")
			->addMainColumn("")
			->search("nazev")
			->pager()
			->tableHead();
		foreach ($table->getResult() as $row) {    
         $table->addRow($row->id);
         $table->addColumn("<td><strong>".$row->nazev."</strong></td>");
         if ($row->typ == 0) {$table->addColumn("<td>Přesměrování | <a href=\"/".$row->presmerovani."\" target=\"_blank\">".$row->presmerovani."</a></td>");}
         else { if(!$row->typnazev) {$row->typnazev="Přesměrování"; } $table->addColumn("<td>".$row->typnazev." | <a href=\"clanky.php?pagecode=".$adminPage->getPageCode()."&amp;lang=".$lang."&amp;rodic=".$row->id."\">editovat (".$row->pocet.")</a></td>"); }
         $table->addColumn("<td>".($row->zobrazit == 1?"ano":"ne")."</td>");
         $table->addColumn("<td>".($row->target_blank == 1?"ano":"ne")."</td>");
         $table->addStaticColumn_presun();
			$table->addStaticColumn_edit($adminPage->editUrl()."&amp;action=udpate&amp;id=".$row->id);
			$table->addStaticColumn_delete($adminPage->editUrl()."&amp;delete=".$row->id);
		}
		$table->writeTable();
	$adminPage->slideFooter();
} else {	// vypsání hlavní úrovně kategorií

	if ($adminPage->admin->getSuperadmin() || kategorie::insertHlavniKategorie) { $adminPage->button_insert(); }
	$adminPage->button_razeni();
	
	$adminPage->slideHead("Seznam hlavních kategorií");	
		$sql = "SELECT A.*, C.nazev AS typnazev, ifnull(B.pocet,0) AS pocet FROM kategorie A
			LEFT JOIN (SELECT COUNT(rodic) AS pocet,rodic FROM kategorie GROUP BY rodic) B ON A.id = B.rodic
			LEFT JOIN kategorie_typ C ON C.id = A.typ";
		$table = new table($sql);
      $table
			->setId("seznam_kategorii")
			->where("A.idlang = '".$lang."' AND A.rodic = 0")
			->setOrder("A.poradi ASC")
			->setLimit(25)
			->sortable($adminPage->editUrl())
			->pager()
			->addMainColumn("Název hlavní kategorie")
			->addMainColumn("Typ")
			->addMainColumn("");
		if ($adminPage->admin->getSuperadmin() || kategorie::insertHlavniKategorie) {
			$table->addMainColumn();
			$table->addMainColumn();
		}	
		$table->tableHead();
		foreach ($table->getResult() as $row) {
			$table->addRow($row->id);    
 			$table->addColumn("<td><strong>".$row->nazev."</strong></td>");
 			if ($row->typ == 0) { $table->addColumn("<td>Přesměrování | <a href=\"/".$row->presmerovani."\" target=\"_blank\" class=\"tooltip\" title=\"přejít na nastavený odkaz\">".$row->presmerovani."</a></td>");}
 			elseif ($row->typ == 1) { $table->addColumn("<td>".$row->typnazev." | <a href=\"clanky.php?lang=".$lang."&amp;rodic=".$row->id."\" class=\"tooltip\" title=\"zobrazit seznam článků\">editovat (".$row->pocet.")</a></td>"); }
			elseif ($row->typ == 2) { $table->addColumn("<td>".$row->typnazev." | <a href=\"kategorie.php?lang=".$lang."&amp;rodic=".$row->id."\" class=\"tooltip\" title=\"zobrazit seznam podkategorií\">editovat (".$row->pocet.")</a></td>"); }			
 			$table->addStaticColumn_presun();			
			if ($adminPage->admin->getSuperadmin() || kategorie::insertHlavniKategorie) {
				$table->addStaticColumn_edit($adminPage->editUrl()."&amp;action=udpate&amp;id=".$row->id);
				$table->addStaticColumn_delete($adminPage->editUrl()."&amp;delete=".$row->id);			
			}
		}
	$table->writeTable();
	$adminPage->slideFooter();
}
$adminPage->footer();
?>