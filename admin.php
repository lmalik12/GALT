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
                        <form method= "GET">
                            <input type = "submit" value="Signout" name="sout"></input>
                        </form>
                    </div>    
                    

                    <div id="Body">
                       <form method= "GET">

                        <button type="submit" name ="reserve" > Make a Reservation </button>
                        <button type="submit"> View Customer Bookings </button> 
                        <button type="submit"> View Rented Equipment </button>                    
                        </form>

                    </div> 
                    

<div id ="Body">
<?php
    if(array_key_exists('sout', $_GET)){
       header("Location: http://www.ugrad.cs.ubc.ca/~s5o7/TC.php");
    }

    echo ("<br> Hello ". $_COOKIE["user"].", Thank you for signing in <br>");

   

?>



</div>
</body>
</html>   












