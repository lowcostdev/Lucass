<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$page = (isset($_GET["page"]) ? $_GET["page"] : "index");
require "include/db_config.php";
include "header.php";

if($page==="index") {
	$page="home";
} 
include_once "$page" . ".php";

include "footer.php";

?>
