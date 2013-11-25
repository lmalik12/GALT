<html>
        <head>
                <title> Edit Equipment </title>
                <link rel="stylesheet" type= "text/css" href="style.css">
        </head>        
        <body>
                <h1 id= "title"> Edit Equipment </h1>

                <p>
                        <div id= "Body">
                        Don't need some equipment?
                        </div>
                        <br/>
                </p>        
        </body>
</html>

// <?php

//     $success = True;
//     $db_conn = ocilogon("ora_k9e8", "a33807116", "ug");


// function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
//         //echo "<br>running ".$cmdstr."<br>";
//         global $db_conn, $success;
//         $statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

//         if (!$statement) {
//                 echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
//                 $e = OCI_Error($db_conn); // For OCIParse errors pass the       
//                 // connection handle
//                 echo htmlentities($e['message']);
//                 $success = False;
//         }

//         $r = OCIExecute($statement, OCI_DEFAULT);
//         if (!$r) {
//                 echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
//                 $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
//                 echo htmlentities($e['message']);
//                 $success = False;
//         } else {

//         }
//         return $statement;
// }

// function delEquip($equip){
//        echo "<br> My EQUIPMENT: <br>";
//        // echo "<table>";
//           echo " <br> <br> <table>";
//          ?> <html> <table border=1px></html>
//         <?php
       
//         echo "<tr>
//                         <th>NAME</th>
//                         <th>DATE</th>
//                         <th>TIMESLOT</th>
//                         <th>PAYMENT</th>
//                         <th>C-TYPE</th>
//                         <th>E-TYPE</th>
//                         <th>DELETE EQUIPMENT</th>
//                 </tr>";
//                         while($row = OCI_Fetch_Array($equip, OCI_BOTH)){
//                 echo"<tr>
//                                 <td>" . $row["FNAME"] .  " " . $row["LNAME"] . "</td>
//                                 <td>" . $row["DATED"] . "</td>
//                                 <td>" . $row["TIMESLOT"] . "</td>
//                                 <td>" . $row["PAYMENT"] . "</td>
//                                 <td>" . $row["COURT_TYPE"] . "</td>
//                                 <td>" . $row["TYPE"] . "</td>
//                                 <td>" ?> <html>  <button type ="home" > X </button> </html> <?php "</td>
                               
//                         </tr>";
//         } ?> <html></table> </html>

// }

// $equip = executePlainSQL("SELECT c.fname, c.lname, r.dated, r.timeslot, r.payment, r.court_type, co.courtID, e.EID, e.type
//                 FROM reservation r, customer c, court co, equipment e
//                 WHERE (r.cusID=c.cusID and co.confirNum=r.confirNum and e.confirNum=r.confirNum and c.cusID='$name')
//                 ORDER BY r.dated");
//                 print delEquip($equip);


//    OCILogoff($db_conn);
//     $success = False;
// ?>