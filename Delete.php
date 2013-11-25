<html>
        <head>
                <title> Delete Reservation </title>
                <link rel="stylesheet" type= "text/css" href="style.css">
        </head>        
        <body>
                <h1 id= "title"> Tennis Center </h1>
               <p>

                <div id = "sidebarleft">
                        <!-- <a href = "cust.php"> <button type ="home"> Home </button></a> -->
                        <a href = "profile.php"> <button value ="profile"> Profile </button></a>
                        <br/>
                        <a href = "TC.php"> <button name ="sout">Signout </button></a>
                    </div> </p>

        </body>
</html> 


<?php
  if(array_key_exists('sout', $_GET)){
       header("Location: http://www.ugrad.cs.ubc.ca/~f7n8/TC.php");
    }echo ("<br> Would you like to delete a reservation, ". $_COOKIE["user"]."? <br>");

function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
        //echo "<br>running ".$cmdstr."<br>";
        global $db_conn, $success;
        $statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

        if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the       
                // connection handle
                echo htmlentities($e['message']);
                $success = False;
        }

        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
        } else {

        }
        return $statement;
}
   

function table($result){ ?>
    <html> <center> <table border = "1" cellpadding="4"> </center ></html>
    <?php
        echo "<tr> 
                    <th>NAME</th>
                    <th>DATE</th>
                    <th>TIMESLOT</th>
                    <th>PAYMENT</th>
                    <th>C-TYPE</th>
                    <th>E-TYPE</th>
                    <th>  </th>
                </tr>";
        while($row = OCI_Fetch_Array($result, OCI_BOTH)){
        echo"<tr>
                <td>" . $row["FNAME"] .  " " . $row["LNAME"] . "</td>
                <td>" . $row["DATED"] . "</td>
                <td>" . $row["TIMESLOT"] . "</td>
                <td>" . $row["PAYMENT"] . "</td>
                <td>" . $row["COURT_TYPE"] . "</td>
                <td>" . $row["TYPE"] . "</td>
                <td>" ?> <html> 
                        <a href = "Delete.php"> 
                                <button type ="submit" name="delete"> Delete </button>
                        </a> 
                        </html> <?php "</td>
                    </tr>";
        } ?> <html> </table> </html> <?php
}

function gone($result){ ?>
    <html> <center> <table border = "1" cellpadding="4"> </center ></html>
    <?php
        echo "<tr> 
                    <th>NAME</th>
                    <th>DATE</th>
                    <th>TIMESLOT</th>
                    <th>PAYMENT</th>
                    <th>C-TYPE</th>
                    <th>E-TYPE</th>
                    <th>  </th>
                </tr>";
        while($row = OCI_Fetch_Array($result, OCI_BOTH)){
        echo"<tr>
                <td>" . $row["FNAME"] .  " " . $row["LNAME"] . "</td>
                <td>" . $row["DATED"] . "</td>
                <td>" . $row["TIMESLOT"] . "</td>
                <td>" . $row["PAYMENT"] . "</td>
                <td>" . $row["COURT_TYPE"] . "</td>
                <td>" . $row["TYPE"] . "</td>
                <td>" ?> <html> 
                        <a href = "Delete.php"> 
                                <button type ="submit" name="delete"> Delete </button>
                        </a> 
                        </html> <?php "</td>
                    </tr>";
        } ?> <html> </table> </html> <?php
}

    $success = True;
    $db_conn = OCILogon("ora_f7n8", "a21218128", "ug");
    $conNum = $_COOKIE["confirNum"];

 if($db_conn && $success){
             $result = executePlainSQL("SELECT from reservation
                                        where confirNum ='$conNUM';");
         }
         table($result);

        if(array_key_exists("delete", $_GET)) {
            $delete = executePlainSQL("DELETE from reservation
                                        where confirNum ='$conNUM';");
            }
        gone($delete);

    OCILogoff($db_conn);
    $success = False;
?>

