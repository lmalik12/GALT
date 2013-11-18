--queries
--change name to fname/lname****

CHECKLIST
	1) project and selection (user must be able to specify selection constant)
-rerun with another constant

a) What tennis centres are near me?
--tennis centre around broadway
select address
from tennis_centre tc
where address LIKE '%BROADWAY%';

	2) JOIN
a) if customer/admin forgets username or password
--show username and password for customer
select l.usernameID, l.password
from login l, customer c
where l.usernameID=c.cusID

b)show username and password for admin
select l.usernameID, l.password
from login l, admin a
where l.usernameID=a.adminID

c) show the admin of a tennis centre
select a.adminID
from tennis_centre tc, admin a
where a.TID=tc.TID and tc.TID=1212121212;

d) location of all courts
select tc.address
from tennis_centre tc, court c
where c.TID=tc.TID 

e) find customers who have reservations at specific tennis centre 
select c.fname, c.lname
from customer c, reservation r, tennis_centre tc
where c.cusID=r.cusID and tc.TID=r.TID and tc.address='101 EAST BROADWAY';

f) All tennis centres with a free court from 12-1pm.  
select tc.address
from reservation r, court c, customer cu, tennis_centre tc
where cu.cusID=r.cusID and r.TID=tc.TID and c.TID=tc.TID and r.timeslot='12:00/13:00';

g) What is the schedule for a court?
select r.timeslot
from reservation r, court c, customer cu, tennis_centre tc
where cu.cusID=r.cusID and r.TID=tc.TID and c.TID=tc.TID and c.courtID='22873987';

h) What has customerID(rachel) reserved this week?
--show reservations for a specific customer
select * 
from reservation r, customer c
where c.cusID = 'lovedeep' and c.cusID=r.cusID;

i) show all reservations for customers
(or select *)
select c.name, c.phone, c.address, r.dated, r.timeslot, r.payment, r.court_type
from reservation r, customer c
where r.cusID=c.cusID
order by c.name;

DC>>j) What courts are currently available?
select c1.courtID
from court c1
where c1.courtID not in (select c.courtID
                        from reservation r, court c, customer cu, tennis_centre tc
                        where cu.cusID=r.cusID and r.TID=tc.TID and c.TID=tc.TID);

DC>>k) What courts are currently available at specific tennis centre?
--returned courts not in lower mall tennis centre
select c1.courtID
from court c1, tennis_centre tc1
where c1.TID=tc1.TID and c1.courtID not in (select c.courtID
                        from reservation r, court c, customer cu, tennis_centre tc
                        where cu.cusID=r.cusID and r.TID=tc.TID and c.TID=tc.TID and tc.TID=tc1.TID and 
                              tc.address='2205 LOWER MALL');

l) What is the total cost for making a reservation?
--cost for reservation under rachel
select r.payment
from reservation r, customer c
where c.cusID=r.cusID and c.cusID='rachel';

m) How many reservations are under my name?
--list the number of reservations for each customer
select c.cusID, count(*)
from reservation r, customer c
where r.cusID=c.cusID 
group by c.cusID;

n) What time is my reservation at today?
--time reserved by specific customer
select r.timeslot
from reservation r, customer c
where r.cusID=c.cusID and c.cusID='rachel';

o) What equipment have I booked?
--what is the reserved equipment for a reservation for specific customer
select e.EID, e.type 
from customer c, equipment e, reservation r
where c.cusID=r.cusID and r.confirNum=e.confirNum and c.cusID='lovedeep';

p) show all reserved equipment by customers
select e.EID, e.type 
from customer c, equipment e, reservation r
where c.cusID=r.cusID and r.confirNum=e.confirNum;

?>>q) find the names of customers who reserved specific court
>>select DISTINCT cu.fname, DISTINCT cu.lname << how to distinct both
from customer cu
where (cu.cusID in (select r.cusID
                   from reservation r, tennis_centre tc, court c
                   where r.TID=tc.TID and tc.TID=c.TID and c.courtID='22873987'));

???>>r) find the names of customers who reserved an indoor and outdoor court
select DISTINCT cu.name
from customer cu, reservation r, tennis_centre tc, court c
where cu.cusID=r.cusID and r.TID=tc.TID and tc.TID=c.TID and c.court_type='OUTDOOR'
INTERSECT
select DISTINCT cu.name
from customer cu, reservation r, tennis_centre tc, court c
where cu.cusID=r.cusID and r.TID=tc.TID and tc.TID=c.TID and c.court_type='IN-DOOR';

??>>s) find the names of customers who have not reserved a court
>>select DISTINCT (cu.fname), DISTINCT (cu.lname) << how to distinct both
from customer cu
where (cu.cusID not in (select r.cusID
					   from reservation r
					   where (r.TID in (select tc.TID
					   				   from tennis_centre tc
					   				   where (tc.TID in (select c.TID
					   				   					from court c))))));
			   			
	3) DIVISION
-insert a new tuple and rerun

	4) AGGREGATION
-rerun with a different aggregation

?>>a) which customers have more than 1 booking
select c.fname, c.lname, c.cusID
from customer c, reservation r
where c.cusID=r.cusID 
group by c.cusID
having count(*)>1;

b) how many courts are at a given tennis centre(TID)
select count(*)
from court c, tennis_centre tc
where c.TID=tc.TID and tc.TID='1313131313';

c) how many indoor/outdoor courts are there?
select count(*)
from court c, tennis_centre tc
where c.TID=tc.TID 
group by c.court_type
having c.court_type='OUTDOOR';

d) count how many courts are available (indoor court and outdoor)
select count(*)
from reservation r, court c, customer cu, tennis_centre tc
where cu.cusID=r.cusID and r.TID=tc.TID and c.TID=tc.TID;

e) how many indoor courts are available
select count(*)
from reservation r, court c, customer cu, tennis_centre tc
where cu.cusID=r.cusID and r.TID=tc.TID and c.TID=tc.TID
group by c.court_type
having c.court_type='IN-DOOR';

f) How many customers are playing in this court?
select count(*)
from reservation r, court c, customer cu, tennis_centre tc
where cu.cusID=r.cusID and r.TID=tc.TID and c.TID=tc.TID and c.courtID='33708119';

g)--list the number of reservations for a specific customer
select count(*)
from reservation r, customer c
where r.cusID=c.cusID 
group by c.cusID
having c.cusID = 'rachel';

	5) NESTED AGGREGATION
-show query or view
-rerun with a different aggregation

??>>a) which customer has the most bookings
select c.fname, c.lname, c.cusID
from customer c, reservation r
where c.cusID=r.cusID 
group by c.cusID
having count(*) >= all (select count(*)
                        from customer c1, reservation r1
                        where c1.cusID=r1.cusID and c1.cusID=c.cusID
                        group by c1.cusID);


	6) deletion
-case 1: deletion causing cascades (students need to explain policy regarding blocking and show code)
-case 2: deletion w/o causing cascades
AND
	7) update
-update a value that violate some constraint
-correct the value and update again

33) TRIGGER reservation - tennis centre info updated
CREATE TRIGGER updateTC
AFTER UPDATE OF tennis_centre ON reservation
BEGIN
INSERT INTO 
END;
34) TRIGGER reservation - customer info updated
35) TRIGGER admin - tennis centre info updated
36) TRIGGER	court - tennis centre info updated
37) TRIGGER	court - dated info updated
38) TRIGGER	court - timeslot info updated
39) TRIGGER equipment - reservation info updated

8) GUI
-type checking
-location of error messages
-look of GUI

???????? QUESTIONABLE ONES ??????????? or not done...
>>>11) available equipment not reserved
>>>15) Has a customer paid for their reservation?
>>>40) how many reservations are there in a day/week	
31) TRIGGER: when user creates new account (PHP), insert into customer table
32) TRIGGER: when user cancels reservation (PHP), delete reservation tuple (not customer tuple)		
	 				   							
