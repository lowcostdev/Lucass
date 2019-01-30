<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">

    <title>Lukkas - Salon System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <style type="text/css">
    .navbar-fixed-left {
  width: 170px;
  position: fixed;
  border-radius: 0;
  height: 100%;
}

.navbar-fixed-left .navbar-nav > li {
  float: none;  /* Cancel default li float: left */
  width: 169px;
}

.navbar-fixed-left + .container {
  padding-left: 170px;
}

/* On using dropdown menu (To right shift popuped) */
.navbar-fixed-left .navbar-nav > li > .dropdown-menu {
  margin-top: -50px;
  margin-left: 120px;
}    </style>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-left">
      <a class="navbar-brand" href="?page=index">Lukkas</a>
      <ul class="nav navbar-nav">
        <li><a href="?page=quicksale"><span class='glyphicon glyphicon-print'/>&nbsp;</span>QUICK SALE</a></li>
	      <li><a href="?page=clients"><span class='glyphicon glyphicon-user'/>&nbsp;</span>CLIENTS</a></li>
	      <li><a href="#"><span class='glyphicon glyphicon-calendar'/>&nbsp;</span>APPOINTMENTS</a></li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='glyphicon glyphicon-plus-sign'/>&nbsp;</span>ADD <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Services</a></li>
            <li><a href="#">Products</a></li>
            <li><a href="#">Packages</a></li>
            <li class="divider"></li>
            <li><a href="#">Staff</a></li>
          </ul>
        </li>
        <li><a href="#"><span class="glyphicon glyphicon-list-alt">&nbsp;</span>REPORTS</a></li>
    	  <li><a href="#"><span class="glyphicon glyphicon-th-list">&nbsp;</span>EXPENDITURES</a></li>
    	  <li><a href="#"><span class="glyphicon glyphicon-cog">&nbsp;</span>SETUP</a></li>
      </ul> 
    </div>
    <div class="container" style='font-size: 0.8em;'>
      