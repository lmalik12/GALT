
BOOKINGS.PHP - show my (customer) reservation = JOIN, SELECT, PROJECTION
h) What has customerID(rachel) reserved this week?
--show reservations for a specific customer
select c.fname, c.lname, c.phone, c.address, r.dated, r.timeslot, r.payment, r.court_type, co.courtID, e.EID, e.type
from reservation r, customer c, court co, equipment e
where r.cusID=c.cusID and co.confirNum=r.confirNum and e.confirNum=r.confirNum and c.cusID='woodie'
order by c.lname;

BOOKINGS.PHP - show "you have # many reservations" - AGGREGATION
g) list the number of reservations for a specific customer
select count(*)
from reservation r, customer c
where r.cusID=c.cusID 
group by c.cusID
having c.cusID = 'rachel';

CUSTBOOKS.PHP - show all reservations (with equipment) = JOINS, SELECT, PROJECTION
i) show all reservations 
select c.fname, c.lname, c.phone, c.address, r.dated, r.timeslot, r.payment, r.court_type, co.courtID, e.EID, e.type
from reservation r, customer c, court co, equipment e
where r.cusID=c.cusID and co.confirNum=r.confirNum and e.confirNum=r.confirNum
order by c.lname;

CUSTBOOKS.PHP - show "the # of reservations for all customers" - AGGREGATION
m) How many reservations are under each customer's name?
--list the number of reservations for each customer
select c.cusID, count(*)
from reservation r, customer c
where r.cusID=c.cusID 
group by c.cusID;

CUSTBOOKS.PHP - NESTED AGGREGATION
-show query or view
-rerun with a different aggregation

a) which customer has the most bookings
select distinct c.fname, c.lname
from customer c
where c.cusID in (select r.cusID
				  from reservation r
				  group by r.cusID
				  having count(*) >= all (select count(*)
				  						   from reservation r2
				  						   group by r2.cusID));  

RESERVE.PHP - DIVISION
b) What courts are currently (choose a time) available at specific tennis centre (using TID) that's an OUTDOOR court?
--returned available courts in lower mall tennis centre

AVAILABLE EXAMPLE
select distinct (c1.courtID)
from court c1
where (c1.court_type='OUTDOOR' and c1.TID = '1515151515' and c1.courtID 
<> ALL
(select distinct (c.courtID)
from reservation r, court c
where (r.confirNum=c.confirNum and r.dated=c.dated and
r.timeslot=c.timeslot and r.timeslot = '15:00/16:00' and c.TID='1515151515' and c.dated='04/04/2013')));   

UNAVAILABLE EXAMPLE
select distinct (c1.courtID)
from court c1
where (c1.court_type='IN-DOOR' and c1.TID = '1212121212' and c1.courtID 
<> ALL
(select distinct (c.courtID)
from reservation r, court c
where (r.confirNum=c.confirNum and r.dated=c.dated and
r.timeslot=c.timeslot and r.timeslot = '12:00/13:00' and c.TID='1212121212' and c.dated='11/01/2013')));

BOOKINGS.PHP - DELETION
X button - "CANCEL RESERVATION" - DONE AUTOMATICALLY FROM SQL CONSTRAINTS
-case 1: deletion causing cascades (students need to explain policy regarding blocking and show code)
	-customer cancels reservation (on delete cascade)

delete from reservation
where cusID='woodie';

BOOKINGS.PHP/CUSTBOOKS.PHP - DELETION
EDIT button - "NO NEED FOR EQUIPMENT ANYMORE" - CALLS 5 UPDATE QUERIES using confirNum remembered from RESERVATION
DOUBLE CHECK>>>>-case 2: deletion w/o causing cascades
	-customer doesn' want equipment anymore (update reservation to make equipment part null)

>first join r.confirNum = e.confirNum
equipment[-EID,type,-confirNum,-dated,-timeslot] 

update equipment 
set EID = null
where EID = '122';

update equipment 
set type = null
where type = 'BALL';

update equipment 
set confirNum = null
where confirNum = '111111111';

update equipment 
set dated = null
where dated = '11/01/2013';

update equipment 
set timeslot = null
where timeslot = '12:00/13:00';

CUSTOMER - UPDATE
"I NEED A NEW PASSWORD"
CASE 1 "ERROR"-update a value that violate some constraint
CASE 2 "FIX"-correct the value and update again

--update password exceeds
update login 
set password = '111222333444555666'
where password = '111';

--update password allowed
update login 
set password = 'aaa'
where password = '111' and usernameID = 'gabrielle';	 

8) GUI
-type checking
-location of error messages
-look of GUI                     



