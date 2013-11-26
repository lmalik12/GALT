A description of how your final schema you turned in.  If the final schema different, why? Note that turning 
in a final schema that's different from what you planned is fine, we just want to know what changed and why?

Almost all our entire schema changed because we did not plan our ER diagram thinking about how we would code this; 
we all did not have any PHP/JDBC experience prior to this project. This posed a learning curve for us as we got began 
to implement code/write queries.  There were many inconsistencies and table-relation problems (foreign keys).  

One of the main problems we faced was that we did not include attributes that a relation referenced from another table.  
For example, we forgot to include the primary keys of reservation in court since court was a foreign key that
referenced reservation.  

Another main issue was the fact that we had 3 sub-entities for our equipment entitiy. We wanted to model racket, ball and ballmachine
rentals but we found that it would be very difficult to dynamically keep track and post those if we wanted to edit them 
or disassociate a piece of equipment with a reservation. To solve this we ended up only modeling rackets and populating our
database with a finite number of rackets for each of our tennis centres. This allows us to represent rackets as ID's and link
each reservation with a racket if it has one. Each equipment now had an attribute that specified if it was linked to a reservation
and an attirbute linking it to the tennis centre that it belongs to. We could do things like give the user the ability to attempt
to rent rackets when they made their reservation.

We also had an issue with primary keys particularly in court.  We initially had courtID as the only primary in court and realized that 
we could not populate another reservation that had a reservation for the same court as another reservation even though they would
be on a separate day and time.  To adjust to this problem, we made TID, courtID, confirNum, dated, and timeslot. 