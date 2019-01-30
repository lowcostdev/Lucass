<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- jQuery UI -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<SCRIPT>


$( function() {

 // Single Select
 $( "#autocomplete" ).autocomplete({
  source: function( request, response ) {
   // Fetch data
   $.ajax({
    url: "fetchData.php",
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
   // Set selection
   $('#autocomplete').val(ui.item.label); // display the selected text
   $('#selectuser_id').val(ui.item.value); // save selected id to input
   return false;
  }
 });

 // Multiple select
 $( "#multi_autocomplete" ).autocomplete({
    source: function( request, response ) {
                
      var searchText = extractLast(request.term);
      $.ajax({
         url: "fetchData.php",
         type: 'post',
         dataType: "json",
         data: {
           search: searchText
         },
         success: function( data ) {
           response( data );
         }
       });
    },
    select: function( event, ui ) {
        var terms = split( $('#multi_autocomplete').val() );
                
        terms.pop();
                
        terms.push( ui.item.label );
                
        terms.push( "" );
        $('#multi_autocomplete').val(terms.join( ", " ));

        // Id
        terms = split( $('#selectuser_ids').val() );
                
        terms.pop();
                
        terms.push( ui.item.value );
                
        terms.push( "" );
        $('#selectuser_ids').val(terms.join( ", " ));

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
</SCRIPT>

<table>
  <tr>
    <td>Single selection</td>
    <td><input type='text' id='autocomplete' ></td>
  </tr>

  <tr>
    <td>Selected User id</td>
    <td><input type='text' id='selectuser_id' /></td>
  </tr>

  <tr>
    <td>Multiple Selection</td>
    <td><input type='text' id='multi_autocomplete' ></td>
  </tr>

  <tr>
    <td>Selected User ids</td>
    <td><input type='text' id='selectuser_ids' /></td>
  </tr>

</table>