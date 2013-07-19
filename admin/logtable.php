<?php
/*
 * stránka s přehledem všech změn redakčního systému
 *
 *	@author Filip Štencl
 * @since 6.7.2013
 * 
 */

require("../include/config.php");
$adminPage = new adminPage("admin_logtable");
$adminPage->head();
//-------------------------------------------------------------------------------------------------------------------------------
$adminPage->slideHead("Aktivita uživatelů v systému");
	$sql = "
		SELECT A.*, B.id AS id, B.jmeno AS jmeno, B.prijmeni AS prijmeni FROM admin_logtable A
		LEFT JOIN admin_uzivatele B ON A.idadmin_uzivatele = B.id";
	$table = new table($sql);
	$table
		->setId("aktivita_uzivatelu")
		->setOrder("caszalozeni DESC")	
		->setLimit(50)
		->addMainColumn("Datum a čas","caszalozeni ASC")
		->addMainColumn("Uživatel","B.prijmeni ASC, B.jmeno ASC")
		->addMainColumn("IP adresa","ip ASC")
		->addMainColumn("Popis aktivity","popis ASC")
		->search("A.ip,B.jmeno,B.prijmeni,A.popis")
		->calendar("A.caszalozeni")
		->pager()
		->tableHead();
	foreach ($table->getResult() as $row) {
		$table
			->addRow($row->id)
			->addColumn("<td>".datum($row->caszalozeni,"Y-m-d H:i:s")."</td>")
			->addColumn("<td>".$row->jmeno." ".$row->prijmeni."</td>")
			->addColumn("<td>".$row->ip."</td>")
			->addColumn("<td>".$row->popis."</td>");
	}
	$table->writeTable();
$adminPage->slideFooter();
//-------------------------------------------------------------------------------------------------------------------------------
$adminPage->footer();
?>