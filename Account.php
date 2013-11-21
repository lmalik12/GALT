<!-- Tennis Centre -->
<html>
        <head>
                <title> Account </title>
                <link rel="stylesheet" type= "text/css" href="style.css">
        </head>        
        <body>
                <h1 id= "title"> Tennis Center </h1>

                <p>
                        <div id= "Body">
                                <form method= "POST" action= "Account.php" >
                                        <h1> Please create an account </h1>
                                        First Name: <input type = "text" name = "Fname" 
                                                                value="<?php echo $_POST["Fname"];?>"/>
                                        <br/> <br/>
                                        Last Name: <input type = "text" name = "Lname" 
                                                                value="<?php echo $_POST["Lname"];?>"/>
                                        <br/> <br/>
                                        Telephone: <input type = "text" placeholder ="ex.123-123-1234" name = "Tele" 
                                                                value="<?php echo $_POST["Tele"];?>"/>
                                        <br/> <br/>
                                        Address: <input type = "text" name = "Addr" 
                                                                value="<?php echo $_POST["Addr"];?>"/>
                                        <br/> <br/>
                                        Username: <input type = "text" name = "user" 
                                                                value="<?php echo $_POST["user"];?>"/>
                                        <br/> <br/>
                                        Password: <input type = "password" name = "pswd"/>
                                        <br/> <br/>
                                        Confirm password: <input type = "password" name = "confirmpswd"/>
                                        <br/> <br/>
                                        <input type = "submit" value="submit" name="createNewACC">
                                </form>
                        </div>
                        <br/>
                </p>        
        </body>
</html>

<?php

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

function samePassword($pass, $confPass){
        return ($pass == $confirmpswd && $pass != NULL);
}

function userNExist($username){

        $Eusername = executePlainSQL("select usernameID from login where (USERNAMEID = '$username')");
        $Eusername = OCI_Fetch_Array($Eusername , OCI_BOTH);
        echo $username;
        echo $Eusername;
        return $Eusername == NULL;
}

        if($db_conn && $success){
                if(array_key_exists("createNewACC", $_POST)) {
                        if(userNExist($_POST["user"]) && samePassword($_POST["pswd"] , $_POST["confirmpswd"])){
                                $info = $_POST;
                                echo $info;
                                header("Location: http://www.ugrad.cs.ubc.ca/~s5o7/admin.php");
                        }



                }

                else echo "GG";
        }
        OCILogoff($db_conn);
        $success = False;

?>
