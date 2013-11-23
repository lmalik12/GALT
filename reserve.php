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
					<option value = "1212121212"> 2205 Lower Mall </option>				
					<option value = "1313131313"> 1904 University Blvd </option>
					<option value = "1414141414"> 720 Mainland Street </option>
					<option value = "1515151515"> 101 East Broadway </option>
					<option value = "1616161616"> 721 West Broadway </option> </select>
				</br> </br>
			Type of Court: <select name = type>
					<option value = ""> - </option>
					<option value = "Indoor"> Indoor </option>
					<option value = "Outdoor"> Outdoor </option> </select>
				</br></br>
			Date: <input type = "text" name= "date" >
				</br></br>
			Timeslot: <select name = time> <!-- Open from 10am-6pm -->
				<option> - </option>
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
			</div>
			<br/>
		</p>	

	</body>
</html>

<?php
		//Login into Oracle
    	$success = True;
    	$db_conn = OCILogon("ora_f7n8", "a21218128", "ug");

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
	if ($db_conn && success){
		//echo "basic";
	if (array_key_exists('newReserve', $_POST)) {
		echo $_POST["location"];
		if ($_POST["location"] != NULL  && ($_POST["type"]) != NULL
		 && ($_POST["date"]) != NULL && ($_POST["time"]) != NULL){
		 	$info= array(
				":bind1" = $_POST["location"],
				":bind2" = $_POST["type"],
				":bind3" = $_POST["date"],
				":bind4" = $_POST["time"],
				":bind5" = rand(1000000000,1999999999)
			);

		 	$gg = array(
		 		$info
		 		);

		 	// Reservation confirNum char(10), dated char(10), timeslot, payment int, court_type, cusID varchar(15), TID varchar(10); 
		executeBoundSQL("INSERT INTO reservation VALUES (:bind5, :bind3, :bind4, 10, :bind2, 'cust1id', 'tennis1id')", $gg);
		OCICommit($db_conn); // Key with boundSql is you have to call commit or it wont work

			//if (!empty($location) && !empty($type) && !empty($date) && !empty($time))

		}
		else {
			?>
		<html> <link rel="stylesheet" type= "text/css" href="style.css">
            <div id= "Error">
            PLEASE FILL IN ALL FIELDS </div>
        </html>
			<?php
					}
	}
}
	OCILogoff($db_conn);
        $success = False;
?>

