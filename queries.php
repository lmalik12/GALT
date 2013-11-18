--queries

1) if customer/admin forgets username or password
--show username and password for customer
select l.usernameID, l.password
from login l, customer c
where l.usernameID=c.cusID

--show username and password for admin
select l.usernameID, l.password
from login l, admin a
where l.usernameID=a.adminID

2) show the admin of a tennis centre
select a.adminID
from tennis_centre tc, admin a
where a.TID=tc.TID and tc.TID=1212121212;

3) location of all courts
select tc.address
from tennis_centre tc, court c
where c.TID=tc.TID 

?>>4) which customer has the most bookings
select c.name, c.cusID
from customer c, reservation r
where c.cusID=r.cusID 
group by c.cusID
having count(*) >= all (select count(*)
                        from customer c1, reservation r1
                        where c1.cusID=r1.cusID and c1.cusID=c.cusID
                        group by c1.cusID);

?>>5) which customers have more than 1 booking
select c.name, c.cusID
from customer c, reservation r
where c.cusID=r.cusID 
group by c.cusID
having count(*)>1;

6) how many courts are at a given tennis centre(TID)
select count(*)
from court c, tennis_centre tc
where c.TID=tc.TID and tc.TID='1313131313';

7) how many indoor/outdoor courts are there?
select count(*)
from court c, tennis_centre tc
where c.TID=tc.TID 
group by c.court_type
having c.court_type='OUTDOOR';

8) count how many courts are available (indoor court and outdoor)
select count(*)
from reservation r, court c, customer cu, tennis_centre tc
where cu.cusID=r.cusID and r.TID=tc.TID and c.TID=tc.TID;

9) how many indoor courts are available
select count(*)
from reservation r, court c, customer cu, tennis_centre tc
where cu.cusID=r.cusID and r.TID=tc.TID and c.TID=tc.TID
group by c.court_type
having c.court_type='IN-DOOR';

10) find customers who have reservations at specific tennis centre 
select c.name
from customer c, reservation r, tennis_centre tc
where c.cusID=r.cusID and tc.TID=r.TID and tc.address='101 EAST BROADWAY';

>>>11) available equipment not reserved

12) All tennis centres with a free court from 12-1pm.  
select tc.address
from reservation r, court c, customer cu, tennis_centre tc
where cu.cusID=r.cusID and r.TID=tc.TID and c.TID=tc.TID and r.timeslot='12:00/13:00';

>>>13) DIVISION QUERY

14) What is the schedule for a court?
select r.timeslot
from reservation r, court c, customer cu, tennis_centre tc
where cu.cusID=r.cusID and r.TID=tc.TID and c.TID=tc.TID and c.courtID='22873987';

>>>>>15) Has a customer paid for their reservation?

16) How many customers are playing in this court?
select count(*)
from reservation r, court c, customer cu, tennis_centre tc
where cu.cusID=r.cusID and r.TID=tc.TID and c.TID=tc.TID and c.courtID='33708119';

17) What has customerID(rachel) reserved this week?
--show reservations for a specific customer
select * 
from reservation r, customer c
where c.cusID = 'lovedeep' and c.cusID=r.cusID;

18) show all reservations for customers
(or select *)
select c.name, c.phone, c.address, r.dated, r.timeslot, r.payment, r.court_type
from reservation r, customer c
where r.cusID=c.cusID
order by c.name;

DC>>19) What courts are currently available?
select c1.courtID
from court c1
where c1.courtID not in (select c.courtID
                        from reservation r, court c, customer cu, tennis_centre tc
                        where cu.cusID=r.cusID and r.TID=tc.TID and c.TID=tc.TID);

DC>>20) What courts are currently available at specific tennis centre?
--returned courts not in lower mall tennis centre
select c1.courtID
from court c1, tennis_centre tc1
where c1.TID=tc1.TID and c1.courtID not in (select c.courtID
                        from reservation r, court c, customer cu, tennis_centre tc
                        where cu.cusID=r.cusID and r.TID=tc.TID and c.TID=tc.TID and tc.TID=tc1.TID and 
                              tc.address='2205 LOWER MALL');


21) What is the total cost for making a reservation?
--cost for reservation under rachel
select r.payment
from reservation r, customer c
where c.cusID=r.cusID and c.cusID='rachel';

22) What tennis centres are near me?
--tennis centre around broadway
select address
from tennis_centre tc
where address LIKE '%BROADWAY%';

23) How many reservations are under my name?
--list the number of reservations for each customer
select c.cusID, count(*)
from reservation r, customer c
where r.cusID=c.cusID 
group by c.cusID;

24)--list the number of reservations for a specific customer
select count(*)
from reservation r, customer c
where r.cusID=c.cusID 
group by c.cusID
having c.cusID = 'rachel';

25) What time is my reservation at today?
--time reserved by specific customer
select r.timeslot
from reservation r, customer c
where r.cusID=c.cusID and c.cusID='rachel';

26) What equipment have I booked?
--what is the reserved equipment for a reservation for specific customer
select e.EID, e.type 
from customer c, equipment e, reservation r
where c.cusID=r.cusID and r.confirNum=e.confirNum and c.cusID='lovedeep';

27) show all reserved equipment by customers
select e.EID, e.type 
from customer c, equipment e, reservation r
where c.cusID=r.cusID and r.confirNum=e.confirNum;

?PARENS>>28) find the names of customers who reserved specific court
select DISTINCT cu.name
from customer cu, reservation r, tennis_centre tc, court c
where cu.cusID=r.cusID and r.TID=tc.TID and tc.TID=c.TID and c.courtID='22873987';

>>select DISTINCT cu.name
from customer cu
where cu.cusID in (select r.cusID
                   from reservation r, tennis_centre tc, court c
                   where r.TID=tc.TID and tc.TID=c.TID and c.courtID='22873987');

???>>29) find the names of customers who reserved an indoor and outdoor court
select DISTINCT cu.name
from customer cu, reservation r, tennis_centre tc, court c
where cu.cusID=r.cusID and r.TID=tc.TID and tc.TID=c.TID and c.court_type='OUTDOOR'
INTERSECT
select DISTINCT cu.name
from customer cu, reservation r, tennis_centre tc, court c
where cu.cusID=r.cusID and r.TID=tc.TID and tc.TID=c.TID and c.court_type='IN-DOOR';

??PARENS>>30) find the names of customers who have not reserved a court
select DISTINCT cu.name
from customer cu
where cu.cusID not in (select r.cusID
					   from reservation r
					   where r.TID in (select tc.TID
					   				   from tennis_centre tc
					   				   where tc.TID in (select c.TID
					   				   					from court c);

31) TRIGGER: when user creates new account (PHP), insert into customer table
32) TRIGGER: when user cancels reservation (PHP), delete reservation tuple (not customer tuple)		
33) TRIGGER reservation - tennis centre info updated
34) TRIGGER reservation - customer info updated
35) TRIGGER admin - tennis centre info updated
36) TRIGGER	court - tennis centre info updated
37) TRIGGER equipment - reservation info updated		   				   					
					   				   					
