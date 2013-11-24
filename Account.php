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
                                        Telephone: <input type = "text" placeholder ="ex.123-123-1234" 
                                                name = "Tele"   value="<?php echo $_POST["Tele"];?>"/>
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
        $db_conn = OCILogon("ora_k9e8", "a33807116", "ug");


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
        return ($pass == $confPass && $pass != NULL);
}

function userNExist($username){

        $Eusername = executePlainSQL("select usernameID from login where (USERNAMEID = '$username')");
        $Eusername = OCI_Fetch_Array($Eusername , OCI_BOTH);
        echo $username;
        echo $Eusername;
        return $Eusername == NULL;
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
                 if(array_key_exists("createNewACC", $_POST)) {
                       if(userNExist($_POST["user"])){
                               if(samePassword($_POST["pswd"],$_POST["confirmpswd"])) {
                                         $custLogin = array (
                                                ":bind1" => $_POST["user"],
                                                ":bind2" => $_POST["pswd"]
                                        );
                                         $tupleInfo  = array(
                                                ":bind1" => $_POST["user"] , 
                                                ":bind2" => $_POST["Fname"] , 
                                                ":bind3" => $_POST["Lname"] , 
                                                ":bind4" => $_POST["Tele"] , 
                                                ":bind5" => $_POST["Addr"]  
                                                );
                                        $login = array (
                                                 $custLogin
                                        );
                                        $data = array (
                                                 $tupleInfo
                                        );
                                executeBoundSQL("insert into login values (:bind1, :bind2, '0')", $login);
                                executeBoundSQL("insert into customer values (:bind1, :bind2, :bind3, :bind4, :bind5)", $data);
                                OCICommit($db_conn); // Key with boundSql is you have to call commit or it wont work

                                }
                                else { ?>
                                        <html>
                                                <link rel="stylesheet" type= "text/css" href="style.css">
                                                <div id= "Error">
                                                       YOU NEED TO ENTER THE SAME PASSWORD
                                                 </div>
                                        </html>
                               <?php
                               }
                       }
                       else { ?>
                       <html>
                               <link rel="stylesheet" type= "text/css" href="style.css">
                               <div id= "Error">
                                       THIS USERNAME ALREADY EXIST.
                               </div>
                       </html>

                       <?php                   
                       }


               }

               else echo "GG";
       }
       OCILogoff($db_conn);
       $success = False;

?>
