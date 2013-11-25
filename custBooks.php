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
       echo " <br> <br> <table>";
       echo "<br> RESERVATIONS: <br>";
       // echo "<table>";
    ?> <html> <table border=1px></html>
        <?php
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
                        <th>REMOVE</th>
                </tr>"; 
                
               // <!--  <html> <button> X </button>  <button> edit </button> </html>  -->
                //header("Location: http://www.ugrad.cs.ubc.ca/~k9e8/EquipEdit.php");
       
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
         <td>" ?> <html> <a href = "EquipEdit.php"> <button type ="home" > Edit Equipment</button></a> </html> <?php "</td>

        </tr>";
            

       }
       
       echo "</table>";

}

 $reservation = executePlainSQL("select c.cusID, c.fname, c.lname, c.phone, c.address, r.dated, r.timeslot, 
                                                r.payment, r.court_type, co.courtID, e.EID, e.type
                                         from reservation r, customer c, court co, equipment e
                                         where (r.cusID=c.cusID and co.confirNum=r.confirNum and 
                                                  e.confirNum=r.confirNum)
                                         order by r.dated");
                                print showAllReserve($reservation);

//select c.fname, c.lname, c.phone, c.address, r.dated, r.timeslot, r.payment, r.court_type, co.courtID, e.EID, e.type
//from reservation r, customer c, court co, equipment e
//where r.cusID=c.cusID and co.confirNum=r.confirNum and e.confirNum=r.confirNum
//order by c.lname;

function countReserve($count) {
     echo " <br> <br> <table>";
     echo "<br> # of RESERVATIONS: <br>";
     
       ?> <html> <table border=1px></html>
        <?php echo "<tr>
                        <th># OF BOOKINGS</th>
                        <th>CUSTOMER ID</th>
                      
            </tr>";
       
    while ($row = OCI_Fetch_Array($count, OCI_BOTH)){
    echo"<tr>
        <td>" . $row["COUNT(*)"] . "</td>
        <td>" . $row["CUSID"] . "</td>
        </tr>";

       }
       
       echo "</table>";
}

//$ID = $_COOKIE["user"];
//having (c.cusID='$ID')
$count = executePlainSQL("select count(*), c.cusID 
                         from reservation r, customer c 
                         where r.cusID=c.cusID
                         group by c.cusID");
                         
                        print countReserve($count);

//  select count(*)
// from reservation r, customer c
// where r.cusID=c.cusID 
// group by c.cusID
// having c.cusID = 'rachel';  

function mostReserveCust($most) {
      echo " <br> <br> <table>";
      echo "<br> MOST RESERVATIONS: <br>";
     
       ?> <html> <table border=1px></html>
        <?php echo "<tr>
                        <th>FIRST NAME</th>
                        <th>LAST NAME</th>
                      
            </tr>";
       
    while ($row = OCI_Fetch_Array($most, OCI_BOTH)){
    echo"<tr>
        <td>" . $row["FNAME"] . "</td>
        <td>" . $row["LNAME"] . "</td>
        </tr>";

       }
       
       echo "</table>";
}

//$ID = $_COOKIE["user"];
//having (c.cusID='$ID')
$most = executePlainSQL("select distinct (c.fname), c.lname
                         from customer c
                        where c.cusID in (select r.cusID
                                            from reservation r
                                            group by r.cusID
                                             having count(*) >= all (select count(*)
                                                                    from reservation r2
                                                                    group by r2.cusID))");
                         
                        print mostReserveCust($most);


       OCILogoff($db_conn);
       $success = False;
?>

