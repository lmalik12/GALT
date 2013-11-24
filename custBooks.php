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
                        All Customer Reservations
                        </div>
                        <br/>
                </p>        
        </body>
</html>

<?php

        $success = True;
        $db_conn = OCILogon("ora_k9e8", "a33807116", "ug");

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


//echo "testing testing";

function showAllReserve($reservation) {
      // echo "<br> RESULTS: <br>";
        echo "<table>";
        echo "<tr>
                        <th>CUSTOMER ID</th>
                        <th>FIRST NAME</th>
                        <th>LAST NAME</th>
                        <th>PHONE</th>
                        <th>ADDRESS</th>
                        <th>DATE</th>
                        <th>TIMESLOT</th>
                        <th>PAYMENT</th>
                        <th>COURTTYPE</th>
                        <th>COURTID</th>
                        <th>EID</th>
                        <th>EQUIPMENT</th>
                </tr>";
       
    while ($row = OCI_Fetch_Array($reservation, OCI_BOTH)){
    echo"<tr>
        <td>" . $row["CUSID"] . "</td>
        <td>" . $row["FNAME"] . "</td>
        <td>" . $row["LNAME"] . "</td> 
        <td>" . $row["PHONE"] . "</td>
        <td>" . $row["ADDRESS"] . "</td>
        <td>" . $row["DATED"] . "</td>
        <td>" . $row["TIMESLOT"] . "</td>
        <td>" . $row["PAYMENT"] . "</td>
        <td>" . $row["COURT_TYPE"] . "</td>
        <td>" . $row["COURTID"] . "</td>
        <td>" . $row["EID"] . "</td>
        <td>" . $row["TYPE"] . "</td>
        </tr>";

       }
       
       echo "</table>";

}

// $reservation = executePlainSQL("SELECT *
//     FROM reservation r, customer c, court co, equipment e");

 $reservation = executePlainSQL("select c.cusID, c.fname, c.lname, c.phone, c.address, r.dated, r.timeslot, 
                                                r.payment, r.court_type, co.courtID, e.EID, e.type
                                         from reservation r, customer c, court co, equipment e
                                         where (r.cusID=c.cusID and co.confirNum=r.confirNum and 
                                                  e.confirNum=r.confirNum)
                                         order by c.lname");
                                print showAllReserve($reservation);

//select c.fname, c.lname, c.phone, c.address, r.dated, r.timeslot, r.payment, r.court_type, co.courtID, e.EID, e.type
//from reservation r, customer c, court co, equipment e
//where r.cusID=c.cusID and co.confirNum=r.confirNum and e.confirNum=r.confirNum
//order by c.lname;

$count = executePlainSQL("select count(*) 
                         from reservation r, customer c 
                         where r.cusID=c.cusID
                         group by c.cusID
                         having c.cusID=[CUSID]");

//  select count(*)
// from reservation r, customer c
// where r.cusID=c.cusID 
// group by c.cusID
// having c.cusID = 'rachel';                               

       OCILogoff($db_conn);
       $success = False;
?>


