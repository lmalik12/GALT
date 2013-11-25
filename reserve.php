<!-- Tennis Centre -->
<html>
	<head>
		<title> Reservation </title>
		<link rel="stylesheet" type= "text/css" href="style.css">
	</head>	
	<body>
		<h1 id= "title"> Tennis Center </h1>

		<p>
			<div id= "Body">
				<form method = "POST" action= "reserve.php">
			<h1> Make a reservation </h1>
			</br></br>
			Tennis Center Location:<select name= location>
					<option value = ""> - </option>
					<option value = "1212121212" > 2205 Lower Mall </option>				
					<option value = "1313131313"> 1904 University Blvd </option>
					<option value = "1414141414"> 720 Mainland Street </option>
					<option value = "1515151515"> 101 East Broadway </option>
					<option value = "1616161616"> 721 West Broadway </option> </select>
				</br> </br>
			Type of Court: <select name = type>
					<option value = ""> - </option>
					<option value = "IN-DOOR"> IN-DOOR </option>
					<option value = "OUTDOOR"> OUTDOOR </option> </select>
				</br></br>
			Date: <input type = "text" name= "date" >
				</br></br>
			Timeslot: <select name = time> <!-- Open from 10am-6pm -->
				<option value = "" > - </option>
				<option value = "10:00/11:00"> 10:00am - 11:00am </option>
				<option value = "11:00/12:00"> 11:00am - 12:00pm </option>
				<option value = "12:00/13:00"> 12:00pm - 1:00pm </option>
				<option value = "13:00/14:00"> 1:00pm - 2:00pm </option>
				<option value = "14:00/15:00"> 2:00pm - 3:00pm </option>
				<option value = "15:00/16:00"> 3:00pm - 4:00pm </option>
				<option value = "16:00/17:00"> 4:00pm - 5:00pm </option>
				<option value = "17:00/18:00"> 5:00pm - 6:00pm </option> </select>
			</br></br>
				<input type = "submit" value= "submit" name="newReserve" >
			</form>
			</div>
			<br/>
		</p>	

	</body>
</html>

<?php
		//Login into Oracle
    	$success = True;
    	$db_conn = OCILogon("ora_k9e8", "a33807116", "ug");

function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
    // Taken from the oracle-test.php from the exmaple.
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
	
if ($db_conn && $success) 
{
	if (array_key_exists('newReserve', $_POST)) 
	{
		
		
		if ($_POST["location"] != NULL  && ($_POST["type"]) != NULL
		 && ($_POST["date"]) != NULL && ($_POST["time"]) != NULL) 
		{
			$location = $_POST["location"];
			$type = $_POST["type"];
			$date = $_POST["date"];
			$time = $_POST["time"];
			
			
			$info= array(
				":bind1" => htmlentities($_POST["location"]),
				":bind2" => htmlentities($_POST["type"]),
				":bind3" => htmlentities($_POST["date"]),
				":bind4" => htmlentities($_POST["time"]),
				":bind5" => htmlentities(rand(1000000898,1999999989)),
				":bind6" => $_COOKIE["user"],
				":bind7" => "",
			);

			$gg = array(
				$info
				);

			// check to see if the  bookings are available
			  $result = executePlainSQL("select distinct (c1.courtID)
										from court c1
										where (c1.court_type='$type' and c1.TID='$location' and c1.courtID 
										<> ALL
										(select distinct (c.courtID)
										from reservation r, court c
										where (r.confirNum=c.confirNum and r.dated=c.dated and
										r.timeslot=c.timeslot and r.timeslot = '$time' and c.TID='$location' and c.dated = '$date')))");  
										
				$result = OCI_FETCH_ARRAY($result, OCI_BOTH);

				if( $result == NULL )
				{
					?>
					<html> <link rel="stylesheet" type= "text/css" href="style.css">
					<div class= "Error">
					SPECIFIED BOOKING UNAVAILABLE </div>
					</html>
					<?php
					header('Refresh: 6; URL=http://www.ugrad.cs.ubc.ca/~k9e8/reserve.php');					
				} 
					//--confirNum, dated (month/day/year), timeslot 12:00/18:00, payment, court_type, cusID, TID
				else 
				{
				?>
					<html> <link rel="stylesheet" type= "text/css" href="style.css">
					<div class= "Correct">
					BOOKING ADDED SUCCESFULLY </div>
					</html>
				<?php
				$info[":bind7"] = $result["COURTID"];
				
				$gg = array(
					$info
				);

				executeBoundSQL("insert into reservation values (:bind5, :bind3, :bind4, '10', :bind2, :bind6, :bind1)", $gg);
				executeBoundSQL("insert into court values (:bind7, :bind2, :bind1, :bind3, :bind4, :bind5)", $gg);
				OCICommit($db_conn); // Key with boundSql is you have to call commit or it wont work
				header('Refresh: 6; URL=http://www.ugrad.cs.ubc.ca/~k9e8/Bookings.php');
				}				
		}
		else 
		{
			?>
			<html> <link rel="stylesheet" type= "text/css" href="style.css">
			<div class= "Error">
			PLEASE FILL IN ALL FIELDS </div>
			</html>
			<?php
		}
	}
}
OCILogoff($db_conn);
$success = False;
?>
