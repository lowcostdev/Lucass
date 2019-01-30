
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include 'include/db_config.php';
include 'include/funcs.php';


if(isset($_POST["branch_cd"])) {
    $nextNo = get_nextNo($_POST["branch_cd"]) ?? 1;
    $err = "";
    try {
        $pdo->beginTransaction(); 
        $invoice = $pdo->prepare("INSERT INTO sales_hdr (invoice_no, branch_cd, serv_date, customer, other_amount, user_id) 
                                  VALUES (:invoice_no, :branch_cd, :serv_date, :customer, :other_amount, :user_id)");
        $invoice->execute(
                        array(
                              ':invoice_no' => $nextNo,
                              ':branch_cd' => $_POST["branch_cd"], 
                              ':serv_date' => date("Y-m-d", strtotime($_POST["txtDateTran"])),
                              ':customer' => $_POST["txtCustomer"],  
                              ':other_amount' => $_POST["others_amount"], 
                              ':user_id' => $_POST["user_id"]
                             )
                        );

        for($count = 0; $count < count($_POST["item_srv"]); $count++) {
            $query = "INSERT INTO sales_dtl (invoice_no, branch_cd, product_id, specialist_id, item_amount, item_qty, item_disc) 
                      VALUES (:invoice_no, :branch_cd, :item_srv, :item_emp, :item_amt, :item_qty, :item_disc)";
            $statement = $pdo->prepare($query);
            $statement->execute(
                              array('invoice_no' => $nextNo,
                                    ':branch_cd' => $_POST["branch_cd"], 
                                    ':item_srv'  => $_POST["item_srv"][$count], 
                                    ':item_emp'  => $_POST["item_emp"][$count], 
                                    ':item_amt' => $_POST["item_amt"][$count], 
                                    ':item_qty' => $_POST["item_qty"][$count], 
                                    ':item_disc'  => $_POST["item_disc"][$count]
                                  )
                                );
        } 
        $pdo->commit();
        $result = $statement->fetchAll();
    } catch (Exception $e) {
        throw $e;
    }

    if(isset($result)) {
        echo 'ok';
    } else {
        echo 'Something went wrong..';
    }
}

?>