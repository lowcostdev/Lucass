<?php
//include 'db_config.php';


function get_nextNo($branch_code) {
//$branch_code = "01";

	include 'db_config.php';
    $next_no = $pdo->prepare("SELECT (COUNT(*) + 1) next_no FROM sales_hdr WHERE branch_cd = :branch_cd GROUP BY branch_cd");
    $next_no->execute(
    					array(':branch_cd' => $branch_code)
    				);
    $result = $next_no->fetch();
    return $result["next_no"];
}


function create_assured($assured_name) {
//$branch_code = "01";

	include 'db_config.php';
    $next_no = $pdo->prepare("SELECT COUNT(*) AS isfound FROM customers WHERE cust_name = :cust_name");
    $next_no->execute(
    					array(':cust_name' => $assured_name)
    				);
    $result = $next_no->fetch();
    return $result["isfound"];
}

function get_nextNo_Service($branch_code) {
//$branch_code = "01";

    include 'db_config.php';
    $next_no = $pdo->prepare("SELECT (COUNT(*) + 1) nextno FROM product_master WHERE branch_cd = :branch_cd GROUP BY branch_cd");
    $next_no->execute(
                        array(':branch_cd' => $branch_code)
                    );
    $result = $next_no->fetch();
    return $result["nextno"];
}

function get_nextNo_Staff($branch_code) {
//$branch_code = "01";

    include 'db_config.php';
    $next_no = $pdo->prepare("SELECT (COUNT(*) + 1) nextno FROM employee_master WHERE branch_cd = :branch_cd GROUP BY branch_cd");
    $next_no->execute(
                        array(':branch_cd' => $branch_code)
                    );
    $result = $next_no->fetch();
    return $result["nextno"];
}


?>