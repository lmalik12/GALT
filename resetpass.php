<html>
    <head>
        <title> Tennis Centre</title>
        <link rel="stylesheet" type= "text/css" href="style.css">
    </head> 
    <body>
        <h1 id= "title"> Reset your Password </h1>
        <p>
            <div id= "Body">
                <form method= "POST">
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
	$db_conn = OCILogon("ora_t0f7", "a42358093", "ug");
	
	// $username and $password are cookies that hold the current user's credentials 

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
		$opassword = $_POST['password']; 
		$npassword = $_POST["newpassword"]; 
		$npasswordp = $_POST["newpasswordp"];	
		$cUser = $_COOKIE["user"];
		$cPass = $_COOKIE["paswrd"];
		
		if($cPass == $opassword) {
			if ($npassword == $npasswordp && $npassword!=NULL && strlen($npassword) < 16 && strlen($npassword) > 2) {
				// TODO: update database and send to TC.php					
				if ($npassword!=$cPass) {
					$info = array(
					":bind1" => htmlentities($npassword),
					":bind2" => htmlentities($cUser),
					":bind3" => htmlentities($cPass),
					);
					$gg = array(
					$info
					);
					executeBoundSQL("update login 
									 set password = :bind1
									 where (password = :bind3 and 
									 usernameID = :bind2)", $gg);
					setcookie("paswrd", $npassword );
					OCICommit($db_conn);
					?>
					<html> <link rel="stylesheet" type= "text/css" href="style.css">
					<div class= "Correct">
					PASSWORD CHANGED SUCCESFULLY </div>
					</html>
					<?php
					header('Refresh: 2; URL=http://www.ugrad.cs.ubc.ca/~t0f7/TC.php');	
				}
				else {
					echo ("You cannot use the same password, please choose a new password.");
				}
			}
			else {
				// passwords dont match
				echo ("<br>Woops, ". $cUser. "!<br>");
				echo ("Please enter matching passwords  that are not empty and are between 3 and 15 characters long.");
			}
		}
		else {
			// wrong old password
			echo ("<br> Woops, ". $cUser. ". You've entered the wrong old password!<br>");
			echo ("Please enter your current password in the Old Password field.");
		}
	}
}
OCILogoff($db_conn);
$success = False;
?>