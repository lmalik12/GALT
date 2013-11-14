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
				<h1> Login in </h1>
				<p> Please sign in </p>
				Username: <input type = "text" name = "user"/>
				<br/> <br/>
				Password: <input type = "password" name = "pswd"/>
				<br/> <br/>
				<input type = "submit" value="submit" name ="login">
				<br>
				<a href="Account.php">Register NOW!</a>

				</form>
			</div>
			<br/>
		</p>	
	</body>
</html>



<?php
	echo "ISTART";
	$success = True;
	$db_conn = OCILogon("ora_s5o7", "a70578091", "ug");

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

	if($db_conn && $success){
		if (array_key_exists('login', $_POST)) {
			$username = $_POST['user']; $password = $_POST["pswd"]; 
			$logonz = executePlainSQL("select * from login where (usernameID= '$username' and 
				password = '$password')");
			$logonz = OCI_Fetch_Array($logonz, OCI_BOTH);
			echo ("IT IS what  " .$logonz['USERNAMEID']. "/ " .$logonz['PASSWORD']. "<br>");

 			//setcookie("user", $_POST["user"],time()+3600);

			// 	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
			// 		if($row["USERNAMEID"] == $_POST['user'] && $row["PASSWORD"] == $_POST['pswd'] ){
			// 			$logonz = $row;
			// 			break;
			// 		}
			// 		else 
			// 			echo "<br/> you are not" .$row["USERNAMEID"]. "<br>" .$row["PASSWORD"];
			// 			echo "<br/> plz attempt to sign in again <br/>";
			// 	}

			if ($logonz != NULL) {
				if($logonz["PTYPE"] == 1)
					header("Location: http://www.ugrad.cs.ubc.ca/~s5o7/admin.php");

				else if($logonz["PTYPE"] == 0)
					header("Location: http://www.ugrad.cs.ubc.ca/~s5o7/cust.php");
			}
			else {

			}
	}
}
	OCILogoff($db_conn);
	$success = False;
?>




