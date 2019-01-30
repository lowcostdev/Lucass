<?php
include "include/db_config.php";


function fill_services_select_box($pdo) {
    $output = '';
    $query = "SELECT * FROM product_master";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach($result as $row) {
        $output .= '<option value="'.$row["product_id"].'">'.$row["prod_details"].'</option>';
    }
return $output;
}

function fill_employee_select_box($pdo) {
    $output = '';
    $query = "SELECT * FROM employee_master";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach($result as $row) {
        $output .= '<option value="'.$row["specialist_id"].'">'.$row["emp_fname"].'</option>';
    }
return $output;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Remove Select Box Fields Dynamically using jQuery Ajax in PHP</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <br />
    <div class="container">
        <h3 align="center">Add Remove Select Box Fields Dynamically using jQuery Ajax in PHP</h3>
        <br />
        <h4 align="center">Enter Item Details</h4>
        <br />
        <form method="post" id="insert_form">
            <div class="table-repsonsive">
                <span id="error"></span>
                <table class="table table-bordered" id="item_table">
                    <tr>
                        <th>SERVICES</th>
                        <th>STAFF</th>
                        <th>QTY</th>
                        <th>AMOUNT</th>
                        <th>DISCOUNT</th>
                        <th>TOTAL</th>
                        <th><button type="button" name="add" class="btn btn-success btn-sm add"><span class="glyphicon glyphicon-plus"></span></button></th>
                    </tr>
                </table>
                <div align="center">
                    <input type="submit" name="submit" class="btn btn-info" value="Insert" />
                </div>
            </div>
        </form>
    </div>
</body>
</html>
<script>
$(document).ready(function() {

  //iterate through each textboxes and add keyup
  //handler to trigger sum event
  $(".code").each(function() {

    $(this).keyup(function() {
      calculateSum();
    });
  });

});
</script>

<script>
    $(document).ready(function(){
        $(document).on('click', '.add', function(){
            var html = '';
            html += '<tr class="txtMult">';
            html += '<td><select name="services[]" class="form-control services"><option value="">-Services-</option><?php echo fill_services_select_box($pdo); ?></select></td>';
            html += '<td><select name="specialists[]" class="form-control specialists"><option value="">-Select-</option><?php echo fill_employee_select_box($pdo); ?></select></td>';
            html += '<td><input type="text" name="item_quantity[]" class="form-control item_quantity" onkeyup=compute() /></td>';
            html += '<td><input type="text" name="item_amount[]" class="form-control item_amount" /></td>';
            html += '<td><input type="text" name="item_discount[]" class="form-control item_discount" onkeyup=compute() /></td>';
            html += '<td><input type="text" name="item_total[]" class="form-control item_total" /></td>';
            html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
            $('#item_table').append(html);
        });

        $(document).on('click', '.remove', function(){
            $(this).closest('tr').remove();
        });


        $('#insert_form').on('submit', function(event){
            event.preventDefault();
            var error = '';
            $('.services').each(function(){
                var count = 1;
                if($(this).val() == '') {
                    error += "<p>Select Service at "+count+" Row</p>";
                    return false;
                }
                count = count + 1;
            });

            $('.specialists').each(function(){
                var count = 1;

                if($(this).val() == '') {
                    error += "<p>Select Specialist at "+count+" Row</p>";
                    return false;
                }
                count = count + 1;
            });

            $('.item_quantity').each(function(){
                var count = 1;
                if($(this).val() == '') {
                    error += "<p>Enter Item Quantity at "+count+" Row</p>";
                    return false;
                }
                count = count + 1;
            });

            var form_data = $(this).serialize();
            if(error == '') {
                $.ajax({
                    url:"insert.php",
                    method:"POST",
                    data:form_data,
                    success:function(data) {
                        if(data == 'ok') {
                            $('#item_table').find("tr:gt(0)").remove();
                            $('#error').html('<div class="alert alert-success">Item Details Saved</div>');
                        }
                    }
                });
            } else {
                $('#error').html('<div class="alert alert-danger">'+error+'</div>');
            }

        });
     });
</script>
<script>
    function compute() {
        var mult = 0;
        $("tr.txtMult").each(function () { 
            alert('df');
            var $val1 = $('.item_discount', this).val();
            var $val2 = $('.item_quantity', this).val();
            var $total = parseFloat($val1 * 1) * parseFloat($val2 * 1);
               // set total for the row
               $('.item_total', this).val($total);
               mult += $total;
        });
        $("#grandTotal").text(mult);
    }
</script>