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

function executeBoundSQL($cmdstr, $list) {
        /* Sometimes a same statement will be excuted for severl times, only
         the value of variables need to be changed.
         In this case you don't need to create the statement several times; 
         using bind variables can make the statement be shared and just 
         parsed once. This is also very useful in protecting against SQL injection. See example code below for       how this functions is used */

        global $db_conn, $success;
        $statement = OCIParse($db_conn, $cmdstr);

        if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
        }

        foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                        //echo $val;
                        //echo "<br>".$bind."<br>";
                        OCIBindByName($statement, $bind, $val);
                        unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype

                }
                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                        echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                        $e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
                        echo htmlentities($e['message']);
                        echo "<br>";
                        $success = False;
                }
        }
}

function gawk($result){ ?>
    <html> <center> <table border = "1" cellpadding="4"> </center ></html>
    <?php
		$tempResult = $result;
        echo "<tr> 
                    <th>NAME</th>
                    <th>DATE</th>
                    <th>TIMESLOT</th>
                    <th>PAYMENT</th>
                    <th>C-TYPE</th>
                    <th>EQUIP</th>
                    <th>CONFIRM #</th>
                </tr>";
                        while($row = OCI_Fetch_Array($tempResult, OCI_BOTH)){
                echo"<tr>
                                <td>" . $row["FNAME"] .  " " . $row["LNAME"] . "</td>
                                <td>" . $row["DATED"] . "</td>
                                <td>" . $row["TIMESLOT"] . "</td>
                                <td>" . $row["PAYMENT"] . "</td>
                                <td>" . $row["COURT_TYPE"] . "</td>
                                <td>" . $row["EID"] . "</td>
                                <td>" . $row["CONFIRNUM"] . "</td>

                        </tr>";
        } ?>
        <html> </table> </html> <?php
}

function choice($result2) {
		
		$tempResult2 = $result2;
		if ($_COOKIE["permission"] == 0) {
			
			?>
				<html>
				<br> <br> <br>
				<font size ='4'>Pick a reservation: </font>
				<br/> <br/>
				<form method= "POST" action="Bookings.php">
			<?php
			
			echo ('<select name = "confirDrop">');
			while($row2 = OCI_FETCH_ARRAY($tempResult2, OCI_BOTH)){
				echo ( '<option value = "' .$row2["CONFIRNUM"]. '">' ); //<option>
				echo($row2["CONFIRNUM"]); //inside option
				echo( '</option>' ) ;
			}
			echo("</select>");
			
			?>
				<br>
				<br>
				<input type='submit' name="delR" value="Delete Reservation">
				<input type='submit' name="delE" value="Remove Equipment">
				<br><br>
				<input type='checkbox' name="conf" value="conf"> Confirm
				</form>
			</html>
			<?php
		}
}

function countReserve($count) { ?>
	<html> <table border = "1" cellpadding= "4"> <br/> <br/></html>
	<?php
	echo "<tr>
		  <th># OF BOOKINGS</th>
		  <th>CUSTOMER ID</th>
		  </tr>";
		   
	while ($row = OCI_Fetch_Array($count, OCI_BOTH)) {
		echo"<tr>
			 <td>" . $row["COUNT(*)"] . "</td>
			 <td>" . $row["CUSID"] . "</td>
			 </tr>";
	}
	echo "</table>";
}

$success = True;
$db_conn = ocilogon("ora_t0f7", "a42358093", "ug");

	if($db_conn && $success) {
		$name = $_COOKIE["user"];
		if($_COOKIE["permission"] == 1){
			//All people
			$result = executePlainSQL("SELECT c.fname, c.lname, r.dated, r.timeslot, r.payment, r.court_type, co.courtID, e.EID, r.confirNum
									   FROM reservation r, customer c, court co, equipment e
									   WHERE (r.cusID=c.cusID and co.confirNum=r.confirNum and e.confirNum=r.confirNum)
									   ORDER BY c.lname");
		 }
		 else {
			//Since this is the customers the order has to be changed
			//According to date Maybe ? 
			$result = executePlainSQL("SELECT c.fname, c.lname, r.dated, r.timeslot, r.payment, r.court_type, co.courtID, r.EID, r.confirNum
				FROM reservation r, customer c, court co
				WHERE (r.cusID=c.cusID and co.confirNum=r.confirNum and c.cusID='$name')
				ORDER BY r.dated");
			$result2 = executePlainSQL("SELECT c.fname, c.lname, r.dated, r.timeslot, r.payment, r.court_type, co.courtID, r.EID, r.confirNum
				FROM reservation r, customer c, court co
				WHERE (r.cusID=c.cusID and co.confirNum=r.confirNum and c.cusID='$name')
				ORDER BY r.dated");
			
		 }
		
		
		gawk($result);
		$ID = $_COOKIE["user"];
		$count = executePlainSQL("select count(*), c.cusID 
								  from reservation r, customer c 
								  where r.cusID=c.cusID
								  group by c.cusID
								  having (c.cusID='$ID')");					 
		countReserve($count);
		choice($result2);	
		
		// if a delete button was pushed
		if (array_key_exists('delR',$_POST)) {
			$confirmNumber = $_POST["confirDrop"];
			if ($_POST["conf"] != "conf") { //confirm box not ticked, do nothing
				?>
					<html> 
					<link rel="stylesheet" type= "text/css" href="style.css">
					<div class= "Error">
					Please tick the confirm checkbox. </div>
					</html>
				<?php
				header('Refresh: 3; URL=http://www.ugrad.cs.ubc.ca/~t0f7/Bookings.php');
			}
			
			else { //confirm box ticked, delete reservation
				executePlainSQL("DELETE from reservation where confirNum = '$confirmNumber'");
				?>
					<html> <link rel="stylesheet" type= "text/css" href="style.css">
					<div class= "Correct">
					BOOKING DELETED SUCCESSFULLY </div>
					</html>
				<?php
				OCICommit($db_conn);
				header('Refresh: 3; URL=http://www.ugrad.cs.ubc.ca/~t0f7/Bookings.php');
			}	
		}
		
		if (array_key_exists('delE',$_POST)) {
			$confirmNumber = $_POST["confirDrop"];
			if ($_POST["conf"] != "conf") { //confirm box not ticked, do nothing
				?>
					<html> 
					<link rel="stylesheet" type= "text/css" href="style.css">
					<div class= "Error">
					Please tick the confirm checkbox. </div>
					</html>
				<?php
				header('Refresh: 3; URL=http://www.ugrad.cs.ubc.ca/~t0f7/Bookings.php');
			}
			
			else   { //confirm box ticked, delete reservation
				echo($confirmNumber); echo("   ");
				$currentEID = executePlainSQL("select r.EID from reservation r where r.confirNum = '$confirmNumber'");
				$currentEID = OCI_FETCH_ARRAY($currentEID, OCI_BOTH);
				$currentEID = $currentEID["EID"];
				echo($currentEID);
				executePlainSQL("update reservation r set r.EID = null where r.confirNum = '$confirmNumber'");
				executePlainSQL("update equipment e set e.dated = null where e.EID = '$currentEID'");
				executePlainSQL("update equipment e set e.timeslot = null where e.EID = '$currentEID'");
				executePlainSQL("update equipment e set e.confirNum = null where e.EID = '$currentEID'");
				executePlainSQL("update equipment e set e.taken = '0' where e.EID = '$currentEID'");
				OCICommit($db_conn);
				?>
					<html> <link rel="stylesheet" type= "text/css" href="style.css">
					<div class= "Correct">
					EQUIPMENT REMOVED SUCCESSFULLY </div>
					</html>
				<?php
				header('Refresh: 3; URL=http://www.ugrad.cs.ubc.ca/~t0f7/Bookings.php');
			}	
		}
	}

OCILogoff($db_conn);
$success = False;
?>