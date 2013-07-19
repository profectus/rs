<?php
/*
* odhlášení z administrace
*/


require("../include/config.php");

$admin = new adminUser();
$admin->logout();
redirect("./?logout=1");

?>
