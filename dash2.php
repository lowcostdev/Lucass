<html>
    <head>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" />
    </head>
    <body>

  
<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
     <div class="col-xs-m-6 col-sm-offset-1">
         <strong>Find a colleague</strong>
         </div>
   

<script>
function showResult(str) {
          jQuery.ajax({
            url: 'clients.php',
            data: "&q=" + str,
            cache: false,
            success: function(result){
                $("#livesearch").html(result);
            }
        });
        
}
</script>
<div class="col-md-8">
    <input type="text" class="form-control" onkeyup="showResult(this.value)" placeholder="Search by First Name...."><br/><br/><p>
    <h4><div id="livesearch"></div></h4>
</div>

    </body>
</html>