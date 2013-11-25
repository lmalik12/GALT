<!-- Tennis Centre -->
<html>
        <head>
                <title> Bookings </title>
                <link rel="stylesheet" type= "text/css" href="style.css">
        </head>        
        <body>
                <h1 id= "title"> Tennis Center </h1>

                <p>
                        <div id= "Body">
                        Saved Reservations under your name
                        </div>
                        <br/>
                </p>        
        </body>
</html>


<?php

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

function gawk($result){
        echo "<br> RESULTS: <br>";
        echo "<form id = 'form1' method = 'POST' action = 'Bookings.php' >";
        
        echo "<table border = '1' >";
        echo "<tr>
                        <th>NAME</th>
                        <th>DATE</th>
                        <th>TIMESLOT</th>
                        <th>PAYMENT</th>
                        <th>C-TYPE</th>
                        <th>E-TYPE</th>
                        <th>REMOVE</th>
                </tr>";
                //$i = 0;
                        while($row = OCI_Fetch_Array($result, OCI_BOTH)){
                        echo"<tr>
                                <td>" . $row["FNAME"] .  " " . $row["LNAME"] . "</td>
                                <td>" . $row["DATED"] . "</td>
                                <td>" . $row["TIMESLOT"] . "</td>
                                <td>" . $row["PAYMENT"] . "</td>
                                <td>" . $row["COURT_TYPE"] . "</td>
                                <td>" . $row["TYPE"] . "</td>
                                <td> <button form = 'form1'> X </button> </td>
                        </tr>";
                      //  $i = $i+1;
        }
        echo "</table>";
        echo "</form>";

}

    $success = True;
    $db_conn = ocilogon("ora_s5o7", "a70578091", "ug");

   if($db_conn && $success){
         $name = $_COOKIE["user"];
         if($_COOKIE["permission"] == 1){
            //All people
             $result = executePlainSQL("SELECT c.fname, c.lname, r.dated, r.timeslot, r.payment, r.court_type, co.courtID, e.EID, e.type
                FROM reservation r, customer c, court co, equipment e
                WHERE (r.cusID=c.cusID and co.confirNum=r.confirNum and e.confirNum=r.confirNum)
                ORDER BY c.lname");
         }
         else{
            //Since this is the customers the order has to be changed
            //According to date Maybe ? 
            $result = executePlainSQL("SELECT c.fname, c.lname, r.dated, r.timeslot, r.payment, r.court_type, co.courtID, e.EID, e.type
                FROM reservation r, customer c, court co, equipment e
                WHERE (r.cusID=c.cusID and co.confirNum=r.confirNum and e.confirNum=r.confirNum and c.cusID='$name')
                ORDER BY r.dated");
         }

         gawk($result);

    }
    OCILogoff($db_conn);
    $success = False;
?>