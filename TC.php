<!-- Tennis Centre -->
<html>
    <head>
        <title> Tennis Centre</title>
        <link rel="stylesheet" type= "text/css" href="style.css">
    </head> 
    <body>
        <h1 id= "title"> Tennis Center </h1>
        <p>
            <div id= "Body">
                <form method= "POST" action= "TC.php">
                    <form class = "sign-in">
                    <h1> Please login </h1>
                    <!-- <p> Please sign in </p> -->
                    Username: <input type = "text" name = "user" placeholder= "Username"/>
                    <br/> <br/>
                    Password: <input type = "password" name = "pswd" placeholder = "Password"/>
                    <br/> <br/>
                    <input type = "submit" value="submit" name ="login">
                    <br/> <br/>
                    <a href="Account.php">Register NOW!</a>
                    </form> 
                </form>
            </div> <br/>
        </p>    
    </body>
</html>


<?php
	//Login into Oracle
	$success = True;
	$db_conn = OCILogon("ora_s5o7", "a70578091", "ug");

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

	if($db_conn && $success){
		if (array_key_exists('login', $_POST)) {
			//populate fields from the input thats given
			$username = $_POST['user']; $password = $_POST["pswd"]; 
			//run the sql query and get the username and permission type form database
			$logonz = executePlainSQL("select USERNAMEID, PTYPE from login where (usernameID= '$username' and 
				password = '$password')");
			//since username primary key (no duplicates) we just fetch the first(only) array
			$logonz = OCI_Fetch_Array($logonz, OCI_BOTH);

			//checks if we have a logon value or not.
			if ($logonz != NULL) {
				if($logonz["PTYPE"] == 1)
					header("Location: http://www.ugrad.cs.ubc.ca/~s5o7/admin.php");

				else if($logonz["PTYPE"] == 0)
					header("Location: http://www.ugrad.cs.ubc.ca/~s5o7/cust.php");
			}
			//if null sends it out error where they sign up or retry
			else {
				header("Location: http://www.ugrad.cs.ubc.ca/~s5o7/Error.php");
			}
		}
	}
	OCILogoff($db_conn);
	$success = False;
?>




