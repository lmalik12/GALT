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
					First Name: <input type = "text" name = "Fname"/>
					<br/> <br/>
					Last Name: <input type = "text" name = "Lname"/>
					<br/> <br/>
					Telephone Number: <input type = "text" name = "Tele"/>
					<br/> <br/>
					Address: <input type = "text" name = "Addr"/>
					<br/> <br/>
					Username: <input type = "text" name = "user"/>
					<br/> <br/>
					Password: <input type = "password" name = "pswd"/>
					<br/> <br/>
					Confirm password: <input type = "password" name = "confirm pswd"/>
					<br/> <br/>
					<input type = "submit" value="submit">
				</form>
			</div>
			<br/>
		</p>	
	</body>
</html>

<?php

?>