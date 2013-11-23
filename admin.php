<html>
        <head>
                <title> Tennis Center </title>
                <link rel = "stylesheet" type = "text/css" href = "style.css">
        </head>        
        <body>
                <h1 id = "title"> Tennis Center </h1>
                <p>
                    <div id = "sidebarleft">
                        <a href = "admin.php"> <button type ="home"> Home </button></a>
                        <br/>
                        <a href = "Sout.php"> <button type ="signout">Signout </button></a>
                    </div>    
                    

                    <div id="Body">
                        <a href = "reserve.php"> <button type="reserve"> Make a Reservation </button> </a>
                        <a href = "CustBooks.php"> <button type="book"> View Customer Bookings </button> </a>
                        <a href = "Equip.php"><button type="equip"> View Rented Equipment </button> </a>

                    </div> 
                    

<div id ="Body">
    <?php
    echo ("<br> Hello ". $_COOKIE["user"].", Thank you for signing in <br>");
    echo ("<br> You are the admin <br>");
    echo ("<br> WELCOME TO YOUR OWN SITE OF DATABASES!!");
?> 
</div>
</body>
</html>   












