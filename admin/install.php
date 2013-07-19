<?php

/**
 * SOUBOR PRO ZAVEDENÍ POTŘEBNÝCH TABULEK
 * 
 * @author Filip Štencl
 * @since 7.7.2013 
 * 
 */

require("../include/config.php");

$install = new install();
$install
//->admin_tables()  	
//->kategorie_clanky()
->novinky()
//->staticky_text()		  
//->test()
->run();
redirect('./index.php?install=1');


?>
