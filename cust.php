<html>
        <head>
                <title> Tennis Center </title>
                <link rel="stylesheet" type= "text/css" href="style.css">
        </head>        
        <body>
                <h1 id= "title"> Tennis Center </h1>
               <p>

                <div id = "sidebarleft">
                        <a href = "resetpass.php"> <button type ="home"> Reset Password </button></a>
                        <br/>
                        <a href = "cust.php"> <button type ="account"> Home </button></a>
                        <br/>
                        <a href = "Sout.php"> <button type ="signout">Signout </button></a>
                    </div>    
                    
                    <div id = "Body">
                        <a href = "reserve.php"> <button type="button"> Make a Reservation </button> </a>
                        <a href = "Bookings.php"> <button type="button"> View my Bookings </button> </a>
                     
                
                    </div> <br/>
                </p>

<div id ="Body">
<?php
    echo ("<br> Hello ". $_COOKIE["user"].", Thank you for signing in <br>");
  

?>
</div>
</body>
</html>  


