<?php
/* 
 * skript pro uložení session pro sort a návrat zpět na původní stránku
 * 
 * @author Filip Štencl
 * @since 26.6.2013
 * 
 */

require("../include/config.php");


// nastavení tabulky - zapnutí sloupců a změna počtu výsledků na stranu
if (isset($_POST['nazev'])) {
	$sloupce = "";
	$pocetSloupcu = intval($_POST['pocetSloupcu']) - 1;
	if ($pocetSloupcu > 0) {
		for ($citac = 1;$citac <= $pocetSloupcu;$citac++) { if ($_POST['sloupce'.$citac] == "1") { $sloupce .= $citac . ", "; } }
		$sloupce = substr($sloupce,0,-2);
	}
	if ($sloupce == "") { notification::infoBox_error("Alespoň 1 sloupec tabulky musí zůstat aktvní");} 
	else {		
		$limit = (isset($_POST['limit'])?intval($_POST['limit']):NULL);		
		$arr = array('count' => $limit, 'sloupce' => $sloupce );		
		dibi::query("UPDATE [admin_nastaveni] SET ",$arr," WHERE idadmin_uzivatele = %i AND table_id = %s",intval($_SESSION['id']),$_POST['nazev']);
	}
}





// řazení sloupců
if (isset($_GET['name']) && isset($_GET['what']) && $_GET['name'] != "" && $_GET['what'] != "") {	
	$sort = str_replace("__"," ",str_replace("-",",",trim($_GET['what'])));
	if (isset($_SESSION['admin_sort_'.trim($_GET['name'])]) && $_SESSION['admin_sort_'.trim($_GET['name'])] == $sort) {
		if (strrpos($sort,"DESC") == TRUE) { $sort = str_replace("DESC","ASC",$sort); }
		else $sort = str_replace("ASC","DESC",$sort);		
	} 
	$_SESSION['admin_sort_'.trim($_GET['name'])] = $sort;
}

// parametr pro vyhledávání řetězců
if (isset($_GET['name']) && isset($_GET['search']) && $_GET['name'] != "" && $_GET['search'] != "") {	
	$_SESSION['admin_search_'.trim($_GET['name'])] = $_GET['search'];
}

// parametr pro vyhledávání OD termínu
if (isset($_GET['name']) && isset($_GET['datefiltr_od']) && $_GET['name'] != "" && $_GET['datefiltr_od'] != "") {	
	$_SESSION['admin_datefiltr_od_'.trim($_GET['name'])] = $_GET['datefiltr_od'];
}

// parametr pro vyhledávání DO termínu
if (isset($_GET['name']) && isset($_GET['datefiltr_do']) && $_GET['name'] != "" && $_GET['datefiltr_do'] != "") {	
	$_SESSION['admin_datefiltr_do_'.trim($_GET['name'])] = $_GET['datefiltr_do'];
}

// parametr pro vyhledávání OD-DO termínu PODLE PARAMETRU
if (isset($_GET['name']) && isset($_GET['datefiltr_omezeni']) && $_GET['name'] != "" && $_GET['datefiltr_omezeni'] != "") {	
	$_SESSION['admin_datefiltr_omezeni_'.trim($_GET['name'])] = $_GET['datefiltr_omezeni'];
}

// parametr pro vypnutí vybraných termínů v session
if (isset($_GET['name']) && isset($_GET['reset']) && $_GET['name'] != "" && $_GET['reset'] == "datefiltr") {	
	unset ($_SESSION['admin_datefiltr_od_'.trim($_GET['name'])]);	
	unset ($_SESSION['admin_datefiltr_do_'.trim($_GET['name'])]);	
	unset ($_SESSION['admin_datefiltr_omezeni_'.trim($_GET['name'])]);	
}

// parametr pro vypnutí vybraných session
if (isset($_GET['name']) && isset($_GET['reset']) && $_GET['name'] != "" && $_GET['reset'] != "") {	
	unset ($_SESSION['admin_'.$_GET['reset'].'_'.trim($_GET['name'])]);	
}

// parametr pro návrat poslední hodnoty
if (strrpos($_SESSION['admin_last_url'],"offset") == TRUE) {
	$_SESSION['admin_last_url'] = preg_replace('/\?offset=\d+/', '',$_SESSION['admin_last_url']);
}

redirect($_SESSION['admin_last_url']);
?>
