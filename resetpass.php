<html>
    <head>
        <title> Tennis Centre - Password Reset</title>
        <link rel="stylesheet" type= "text/css" href="style.css">
    </head> 
    <body>
        <h1 id= "title"> Reset your Password </h1>
        <p>
            <div id= "Body">
                <form method= "POST" action= "TC.php" class = "sign-in">
                    <h2> Please reset your password </h2>
                    Old Password: <input type = "password" name = "password" placeholder= "old password"/>
                    <br/> <br/>
                    New Password: <input type = "password" name = "newpassword" placeholder = "new password"/>
                    <br/> <br/>
					Retype Password: <input type = "password" name = "newpasswordp" placeholder = "retype new password"/>
                    <br/> <br/>
					<input type = "submit" value="submit" name ="submit">
                    <br/> <br/>
                </form>
            </div> <br/>
        </p>    
    </body>
</html>

<?php
//Login into Oracle
	$success = True;
	$db_conn = OCILogon("ora_s5o7", "a70578091", "ug");

	setcookie("user", $username, time()-3600);

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

if($db_conn && $success){
	if (array_key_exists('submit', $_POST)) {
		//variables
		$opassword = $_POST['password']; $npassword = $_POST["newpassword"]; $npasswordp = $_POST["newpasswordp"];			
		$logonz = executePlainSQL("select USERNAMEID, PASSWORD from login where (usernameID= '$username' and 
								  password = '$password')");
		$logonz = OCI_Fetch_Array($logonz, OCI_BOTH);
		if ($logonz != NULL) {
			setcookie("user", $username);
			if($logonz["PASSWORD"] == $opassword) {
				if ($_POST["newpassword"] == $_POST["newpasswordp"]) {
					// TODO: update database and send to TC.php
					$newpass = $_POST["newpassword"];
					
					$info= array(
					":bind1" => htmlentities($newpass),
					":bind2" => htmlentities($username),
					);

					$gg = array(
					$info
					);
				}
				else {
					// TODO: your passwords don't match, go to NPError.php
					header("Location: http://www.ugrad.cs.ubc.ca/~t0f7/NPError.php");
				}
			}
			else {
				// TODO: you entered the wrong password, go to OPError.php
				header("Location: http://www.ugrad.cs.ubc.ca/~t0f7/OPError.php");
			}
		}
	}
}
OCILogoff($db_conn);
$success = False;
?>