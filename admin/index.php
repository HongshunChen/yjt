<?php
$t1 = microtime();

define("YI_JIANGTANG",'1.0');
require "lib/init.cls.php";

$ginkgo = new ginkgo;
$ginkgo->run();
$t1 = explode(" ",$t1);
$t1= $t1[1]+$t1[0];   

$t2 = microtime();
$t2 = explode(" ",$t2);


?>