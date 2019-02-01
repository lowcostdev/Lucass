<?php
//include 'db_config.php';


function get_nextNo($branch_code) {
//$branch_code = "01";

	$pdo = new PDO('mysql:host=localhost;dbname=salon1',"Lucassadmin", "a48170806a");
    $next_no = $pdo->prepare("SELECT (COUNT(*) + 1) next_no FROM sales_hdr WHERE branch_cd = :branch_cd GROUP BY branch_cd");
    $next_no->execute(
    					array(':branch_cd' => $branch_code)
    				);
    $result = $next_no->fetch();
    return $result["next_no"];
}

?>