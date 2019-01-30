<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script>
	$( function() {
		$( "#datetran" ).datepicker();
  	} );
</script>

<?php

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
<div class="container" style="background-color:#f2f2f2">
	<h3>Invoice</h3>
	<br>
</div>

<form method="post" id="insert_form">
    <?php
    echo "<input type='hidden' name='user_id' value='max'>";
    echo "<input type='hidden' name='branch_cd' value='01'>";
    ?>
	<div class="table-repsonsive">
        <div class="form-group col-md-4">
            <label for="customer">Customer</label>
            <input class="form-control input-sm" placeholder="Search by Name" name="txtCustomer" size=8 id="customer" required>

        </div>
        <div class="form-group col-md-2">
            <label for="datetran">Date</label>
            <input class="form-control input-sm" name="txtDateTran" id="datetran" required>
        </div>
        <div class="form-group col-md-6">&nbsp;</div>

		<div class="form-group col-md-12"><span id="error"></span></div>
		<table class="table table-stripped">
            <tr>

            </tr>
			<tr>
				<th>SERVICES</th>
				<th>STAFF</th>
				<th>QTY</th>
				<th>AMOUNT</th>
				<th>DISCOUNT</th>
				<th>TOTAL</th>
			</tr>
            <tr>
                <td width="15%">
                    <select name="services[]" id="services" name="services" class="form-control Services" onchange="get_service_cost()">
                        <option value="">-Services-</option>
                        <?php echo fill_services_select_box($pdo); ?>
                    </select>
                </td>
                <td width="15%">
                    <select name="specialists[]" class="form-control specialists">
                        <option value="">-Select-</option>
                        <?php echo fill_employee_select_box($pdo); ?>
                    </select>
                </td>
                <td>
                    <input type="number" min=0 max=10 value=0 name="item_quantity[]" class="form-control item_quantity" onkeyup=compute_sales() />
                </td>
                <td>
                    <input type="text" name="item_amount[]" class="form-control item_amount" id=item_amount readonly="readonly"/>
                </td>
                <td>
                    <input type="number" min="0"  value=0.00 step="0.01" name="item_discount[]" class="form-control item_discount" onkeyup=compute_sales() />
                </td>
                <td>
                    <input type="text" name="item_total[]" class="form-control item_total" readonly="readonly"/>
                </td>
                <td>
                    <button type="button" name="add" class="btn btn-success btn-sm add">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Add Service
                    </button>
                </td>
            </tr>
        </table>
        <table class="table table-stripped" id="item_table">
            <tr><tr>
		</table>
	</div>
	<div class="form-group col-md-9"></div>
	<div class="form-group col-md-3">
		<input type="submit" class="btn btn-default" value="Close" />
		<input type="submit" name="submit" class="btn btn-info" value="Save" />
	</div>
    <div class="form-group col-md-3">
        <label for="extra">Extra Charges/ Other(s)</label>
        <input type="number" step="0.5" class="form-control input-sm others_amount" id="others_amount" name="others_amount" value="0.00" onkeyup="compute_total()">
    </div>
</form>

<hr class="col-xs-12">
<div class="form-group col-md-7">&nbsp;</div>
<div class="form-group col-md-2">
	<label for="extra">Grand Total</label>
</div>
<div class="form-group col-md-3">
	<input class="form-control input-lg grand_total" name="grand_total" style="text-align:right;" readonly="readonly">
</div>
<div class="form-group col-md-7">&nbsp;</div>
<div class="form-group col-md-2">
	<label for="extra">Paying Now</label>
</div>
<div class="form-group col-md-3">
	<input class="form-control input-lg payment_amount" style="text-align:right;" type="number" step="0.1" name="payment_amount" value="0.00" onkeyup="compute_total();">
</div>
<div class="form-group col-md-7">&nbsp;</div>
<div class="form-group col-md-2">
	<label for="extra">Due Amount/Change</label>
</div>
<div class="form-group col-md-3">
	<input class="form-control input-lg due_amount" style="text-align:right;" readonly="readonly">
</div>

<script>
    $(document).ready(function() {
        $(document).on('click', '.add', function(event){
            event.preventDefault();
            var error = '';
            
            if($("#services :selected").val() === '') {
                error += "<p>Select Services </p>";
            }

            if($(".specialists :selected").val() === '') {
                error += "<p>Select Specialist </p>";
            }

            if($('.item_quantity').val() === '' ||  $('.item_quantity').val()<= 0) {
                error += "<p>Input a Quantity</p>";
            }

            if(error == '') {    
                var html = '';
                html += '<tr class="txtMult">';
                html += '<td><label>'+ $("#services :selected").text(); + '</label></td>';
                html += '<td><label>'+ $('.specialists :selected').text(); + '</label></td>';
                html += '<td><label>'+ $('.item_quantity').val(); + '</label></td>';
                html += '<td><label>'+ $('.item_amount').val(); + '</label></td>';
                html += '<td><label>'+ $('.item_discount').val(); + '</label></td>';
                html += '<td><label>'+ $('.item_total').val(); + '</label></td>';
                html += '<input type="hidden" name="item_srv[]" value='+ $("#services :selected").val() + ' />';
                html += '<input type="hidden" name="item_emp[]" value='+ $('.specialists :selected').text() + ' />';
                html += '<input type="hidden" name="item_qty[]" value='+ $('.item_quantity').val() + ' />';
                html += '<input type="hidden" name="item_amt[]" value='+ $('.item_amount').val() + ' />';
                html += '<input type="hidden" name="item_disc[]" value='+ $('.item_discount').val() + ' />';
                html += '<input type="hidden" name="total1[]" class="sum" value='+ $('.item_total').val() + ' />';
                html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove" onclick=compute_total() ><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
                $('#item_table').append(html);
                $('#error').html('<div></div>');
                compute_total();
            } else {
                $('#error').html('<div class="alert alert-danger">'+error+'</div>');
            }
        });

        $(document).on('click', '.remove', function(){
            $(this).closest('tr').remove();
            compute_sales();
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

            $('.due_amount').each(function(){
                if($(this).val() > 0) {
                    error += "<p>Amount due must be equal to zero</p>";
                    return false;
                }
            });

            var form_data = $(this).serialize();
            if(error == '') {
                $.ajax({
                    url:"insert_sales.php",
                    method:"POST",
                    data:form_data,
                    success:function(data) {
                        alert(data);
                        if(data.trim() == 'ok') {
                             $('#error').html('<div class="alert alert-success">Item Details Saved</div>');
                            $('#item_table').find("tr:gt(0)").remove();
                            //$('#error').html('<div class="alert alert-success">Item Details Saved</div>');
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

</script>
<script>
    function compute_sales() {
        var mult = 0;
        var payment = 0;
        var due = 0;
        var amount_res = 0;

        var $val1 = $('.item_discount').val();
        var $val2 = $('.item_quantity').val();
        var $val3 = $('.item_amount').val();

        var $total = parseFloat($val1 * 1) + (parseFloat($val2 * 1) * parseFloat($val3 * 1)) ;

        // set total for the row
        $('.item_total').val($total);
      
        
    }
</script>

<script type="text/javascript">
function get_service_cost() {
    var dataString = "product_id="+ $("#services :selected").val(); /* STORE THAT TO A DATA STRING */

    $.ajax({ /* THEN THE AJAX CALL */
        type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
        url: "ajax/prodinfo.php", /* PAGE WHERE WE WILL PASS THE DATA */
        data: dataString, /* THE DATA WE WILL BE PASSING */
        success: function(result){ /* GET THE TO BE RETURNED DATA */
            $(".item_amount").val(result);
        }
    });
    compute_sales();
};



</script>

    <script type='text/javascript' >
    $( function() {
  
        $( "#customer" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "gethint.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#customer').val(ui.item.label); // display the selected text
                //$('#selectuser_id').val(ui.item.value); // save selected id to input
                return false;
            }
        });

    });

    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }

    </script>
<script>
    function compute_total() {
        var total = 0;
        $("tr.txtMult").each(function () {
            var row_total = parseFloat($('.sum', this).val());
            //total += parseFloat($('.sum', this).val() * 1);
            total += row_total;
        });
//            alert(total);
        payment =parseFloat($('.payment_amount').val() * 1);
        others  = parseFloat($('.others_amount').val() * 1);
        due = (total + others) - parseFloat(payment) 

        $(".grand_total").val(total);
        $(".due_amount").val(due);
   
    }
</script>