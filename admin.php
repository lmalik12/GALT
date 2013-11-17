<html>
        <head>
                <title> Tennis Center </title>
                <link rel = "stylesheet" type = "text/css" href = "style.css">
        </head>        
        <body>
            <div id="container">
                <h1 id = "title"> Tennis Center </h1>
                <p>
                    <div id = "sidebarleft">
                        <p> <a href = "Calendar.php" title="Court"> Make a Reservation </a> </p>
                        <p> <a href = "CustBooks.php" title="CustBooks"> View Customer Bookings </a> </p> 
                        <p> <a href = "Equip.php" title="Rent"> Rent Equipment </a> </p> 
                    </div> 
                </p> 
            </div>     
        </body>
</html>

<?php
    echo ("<br> Hello ". $_COOKIE["user"].", Thank you for signing in <br>");
    echo ("<br> You are the admin <br>");
    echo ("<br> WELCOME TO YOUR OWN SITE OF DATABASES!!");
?>
