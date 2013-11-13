drop table customer cascade constraints;
drop table admin cascade constraints;
drop table login cascade constraints;
drop table court cascade constraints;
drop table reservation cascade constraints;
drop table tennis_centre cascade constraints;
drop table equipment cascade constraints;

create table customer (
    cusID CHAR(5), 
    name VARCHAR2(20),
    phone CHAR(12),
    address VARCHAR2(30),
    PRIMARY KEY(cusID));

Create table reservation (confirNum CHAR(10), 
     dated CHAR(10), 
     timeslot CHAR(11),
     payment INT,
     court_type CHAR(10),
     cusID CHAR(5),
     PRIMARY KEY (confirNum),
     FOREIGN KEY (cusID) references customer); 


Create table tennis_centre (
    TID CHAR(10), 
    address varchar2(30), 
    phone CHAR(12),
PRIMARY KEY (TID));

Create table admin (adminID CHAR(5),
    TID CHAR(10),
PRIMARY KEY (adminID, TID),
FOREIGN KEY (TID) references tennis_centre);

Create table login (usernameID varchar2 (15) primary KEY,
          password CHAR(6),
          TID CHAR(10),
      FOREIGN KEY (TID) references tennis_centre);

Create table court (courtID CHAR(8),
                court_type CHAR(7),
                TID CHAR(10),
         PRIMARY KEY (courtID, TID),
         FOREIGN KEY (TID) references tennis_centre);

Create table equipment (EID CHAR(10),
   type varchar2(10),
   confirNum CHAR(10),
   PRIMARY KEY (EID),
   FOREIGN KEY (confirNum) references reservation);

insert into tennis_centre values ('1212121212', '2205 lower mall', '604-555-6666');
insert into tennis_centre values ('1313131313', '1904 university blvd', '604-666-7777');
insert into tennis_centre values ('1414141414', '720 Mainland Str', '604-777-8888');
insert into tennis_centre values ('1515151515', '101 East Broadway', '604-888-9999');
insert into tennis_centre values ('1616161616', '721 West Broadway', '604-999-0101');

insert into admin values('12345','1212121212');
insert into admin values('11111','1313131313');
insert into admin values('13434','1414141414');
insert into admin values('15555','1515151515');
insert into admin values('10000','1616161616');

insert into customer values('22222', 'gabrielle', '778-333-2222', '7482 edward street');
insert into customer values('33333','lovedeep', '604-222-2222', '37 shell avenue');
insert into customer values('44444', 'taranbir', '604-444-4444', '3829 madison street');
insert into customer values('55555', 'arwud', '778-381-8233', '111 data ave');
insert into customer values('66666', 'bob', '604-003-3913', '39 blue road');

insert into login values ('gabc', 'd8ekj9', '1212121212');
insert into login values ('lovedeep', 'aa7kk', '1313131313');
insert into login values ('grapessss', 'dd9jjj', '1414141414');
insert into login values ('appleapple', 'aa24aa', '1515151515');
insert into login values ('sheep1', 'bbb3bb', '1616161616');

insert into court values('33708119', 'in-door','1212121212');
insert into court values('45889032', 'outdoor','1313131313');
insert into court values('22873987', 'in-door','1414141414');
insert into court values('10092766', 'outdoor','1515151515');
insert into court values('77890374', 'outdoor','1616161616');

insert into reservation values('1111111111', '01/01/2001', '12:00/13:00', '20', 'in-door','22222');
insert into reservation values('2222222222', '02/02/2002', '13:00/14:00', '20', 'in-door','33333');
insert into reservation values('3333333333', '03/03/2003', '14:30/16:00', '30', 'outdoor','44444');
insert into reservation values('4444444444', '04/04/2004', '17:00/18:00', '20', 'outdoor','55555');
insert into reservation values('5555555555', '05/05/2005', '19:00/21:00', '40', 'outdoor','66666');

insert into equipment values ('122','ball','1111111111');
insert into equipment values ('225','racket','2222222222');
insert into equipment values ('3123', 'tbm','3333333333');
insert into equipment values ('447', 'ball','4444444444');
insert into equipment values ('3789', 'ball','5555555555');
