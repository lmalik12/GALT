<html>
        <head>
                <title> Tennis Center </title>
                <link rel = "stylesheet" type = "text/css" href = "style.css">
        </head>        
        <body>
                <h1 id = "title"> Tennis Center </h1>
                <p>
                    <div id = "sidebarleft">
                        <a href = "resetpass.php"> <button type ="home"> Reset Password </button></a>
                        <br/>
						<a href = "admin.php"> <button type ="home"> Home </button></a>
                        <br/>
                        <form method= "GET">
                            <input type = "submit" value="Signout" name="sout"></input>
                        </form>
                    </div>    
                    
                    <div id="Body">
                        <a href = "reserve.php"> <button type="reserve"> Make a Reservation </button> </a>
                        <a href = "Bookings.php"> <button type="book"> View Customer Bookings </button> </a>
                    </div> 
                
<div id ="Body">
<?php
    if(array_key_exists('sout', $_GET)){
       header("Location: http://www.ugrad.cs.ubc.ca/~t0f7/TC.php");
    }
?> 
</div>
</body>
</html>   
