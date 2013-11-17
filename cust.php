<html>
        <head>
                <title> Tennis Center </title>
                <link rel="stylesheet" type= "text/css" href="style.css">
        </head>        
        <body>
                <h1 id= "title"> Tennis Center </h1>
               <p>
                    <div class = "navlinks">
                    <ul>
                        <li> <a href = "Calendar.php" title="Court"> Make a Reservation </a> </li> 
                        <br/> 
                        <li> <a href = "CustBooks.php" title="CustBooks"> View my Bookings </a> </li> 
                        <br/>
                        <li> <a href = "Equip.php" title="Rent"> Rent Equipment </a> </li> 
                        <br/>
                    </ul>
                    </div> <br/>
                </p>
        </body>
</html>

<?php
    echo ("<br> Hello ". $_COOKIE["user"].", Thank you for signing in <br>");
    echo ("<br> You are a customer <br>");
    echo ("<br> WELCOME TO YOUR OWN SITE OF DATABASES!!");
?>


