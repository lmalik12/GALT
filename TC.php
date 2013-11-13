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
				<select name = dropdown>
					<option value = "customer"> Customer </option>
					<option value = "admin"> Administrator </option>

		 	<!-- <form action= "" link to the customer /admin pages --> 

				</select>
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
		echo "I CONNECT";
		if (array_key_exists('login', $_POST)) {
		//	echo " weare start";
			$result = executePlainSQL("select * from login");
			$logonz;

 			//setcookie("user", $_POST["user"],time()+3600);

				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					if($row["USERNAMEID"] == $_POST['user']){
						$logonz = $row;
						echo "jitgaye";
						break;
					}
					else 
						echo $row["USERNAMEID"];
				}


		echo " GG " . $logonz["USERNAMEID"]. " " .$logonz["PASSWORD"]. "<br/>";
			if($logonz["PASSWORD"] == $_POST['pswd'])	{	
				if($_POST["dropdown"]=='admin'){
					header("Location: http://www.ugrad.cs.ubc.ca/~s5o7/admin.php");
				}

			else{
				header("Location: http://www.ugrad.cs.ubc.ca/~s5o7/cust.php");
				}
			}
}}
OCILogoff($db_conn);
echo "black".$db_conn. "";
// 	}
// }else {
// 	echo "CONNECT PRoblem";
// 	}

?>




