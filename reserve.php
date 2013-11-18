<!-- Tennis Centre -->
<html>
	<head>
		<title> Calendar </title>
		<link rel="stylesheet" type= "text/css" href="style.css">
	</head>	
	<body>
		<h1 id= "title"> Tennis Center </h1>

		<p>
			<div id= "Body">
			<h1> Make a reservation </h1>
			</br></br>
			Tennis Center Location:<select name= dropdown>
					<option value = "1212121212"> 2205 Lower Mall </option>				
					<option value = "1313131313"> 1904 University Blvd </option>
					<option value = "1414141414"> 720 Mainland Street </option>
					<option value = "1515151515"> 101 East Broadway </option>
					<option value = "1616161616"> 721 West Broadway </option> </select>
				</br> </br>
			Type of Court: <select name = dropdown>
					<option value = "Indoor"> Indoor </option>
					<option value = "Outdoor"> Outdoor </option> </select>
				</br></br>
			Date: <input type = "text" placeholder= "dd/mm/yyyy">
				</br></br>
			Timeslot: <select name = dropdown> <!-- Open from 10am-6pm -->
				<option value = "10:00/11:00pm"> 10:00am - 11:00am </option>
				<option value = "11:00/12:00pm"> 11:00am - 12:00pm </option>
				<option value = "12:00/13:00pm"> 12:00pm - 1:00pm </option>
				<option value = "13:00/14:00pm"> 1:00pm - 2:00pm </option>
				<option value = "14:00/15:00pm"> 2:00pm - 3:00pm </option>
				<option value = "15:00/16:00pm"> 3:00pm - 4:00pm </option>
				<option value = "16:00/17:00pm"> 4:00pm - 5:00pm </option>
				<option value = "17:00/18:00pm"> 5:00pm - 6:00pm </option> </select>
			</br></br>
				<input type = "submit" value= "submit" name="newReserve">
			</div>
			<br/>
		</p>	
	</body>
</html>
