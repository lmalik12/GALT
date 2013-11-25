DEMO

TC.php
-sign in login that's not in database
-create that user --> create.php (CUSTOMER)

CREATE.PHP
-SQL: check on sql that user has been added to CUSTOMER & LOGIN

TC.PHP
-sign in login with correct usernameID BUT incorrect password (CUSTOMER)
-try again with correct password (CUSTOMER) --> cust.php
	CUST.PHP
	-you are now signed in as customer
	
	-VIEW MY BOOKINGS BUTTON (CUSTOMER)
		-shows logged in customer's reservation {JOIN, SELECT, PROJ} & # of reservations they have {AGGREGATION}
		-X button OR cusID into button = remove reservation for customer {DELETION w/ CASCADES - case 1}
			-SQL: show that reservation and things attached are deleted
		-EDIT button --> equip.php
			-show reservations with equipment w/ button
			-X button = delete equipment for that reservation (using updates) {DELETION w/o CASCADES - case 2}
				-SQL: show that equipment tuple is now all NULL

				GO BACK
	
	CUST.PHP		
	-MAKE A RESERVATION BUTTON --> reserve.php
		RESERVE.PHP
		-make a reservation that's UNAVAILABLE --> show NO available courts [red]
			-SQL: show reservation & court to see that it HASN"T been inserted
		
		-make a reservation that's AVAILABLE --> show available court [green]
			-SQL: show reservation & court to see that it's been inserted properly

		>>-show equipment available
			-SQL: show equipment added

			GO BACK

	CUST.PHP
	-VIEW MY BOOKINGS BUTTON (CUSTOMER)
		-show logged in customer's bookings with added reservation

		GO BACK TO TC.PHP

TC.php
-sign in login for admin --> admin.php
? can we create a new admin ?

ADMIN.PHP
	-MAKE A RESERVATION BOOKING (same as customer stuff)
	-VIEW CUSTOMER BOOKINGS
		-shows customer's reservation {JOIN, SELECT, PROJ} & # of reservations for all customers {AGGREGATION} &
		 customer with most amount of reservations {NESTED AGGREGATION}
		(*no X button - admin cannot cancel a customer's reservation but may edit for them at tennis centre*)
		-EDIT button --> equip.php
			-show reservations with equipment w/ button
			-X button = delete equipment for that reservation (using updates) {DELETION w/o CASCADES - case 2}
				-SQL: show that equipment tuple is now all NULL

DONE DEMO