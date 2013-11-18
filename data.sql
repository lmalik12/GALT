drop table customer cascade constraints;
drop table admin cascade constraints;
drop table login cascade constraints;
drop table court cascade constraints;
drop table reservation cascade constraints;
drop table tennis_centre cascade constraints;
drop table equipment cascade constraints;

create table customer (
    cusID varchar2(15) not null, 
    fname varchar2(20),
    lname varchar2(20),
    phone CHAR(12),
    address VARCHAR2(30),
    PRIMARY KEY(cusID));

Create table login (
    usernameID varchar2 (15) not null,
    password varchar2(15),
    ptype INT,
PRIMARY KEY (usernameID));

Create table tennis_centre (
    TID varchar2(10) not null, 
    address varchar2(30), 
    phone CHAR(12),
PRIMARY KEY (TID));

Create table reservation (
     confirNum CHAR(10) not null, 
     dated CHAR(10), 
     timeslot CHAR(11),
     payment INT,
     court_type CHAR(10),
     cusID varchar2(15),
     TID varchar2(10),
     PRIMARY KEY (confirNum),
     FOREIGN KEY (TID) references tennis_centre ON DELETE CASCADE, 
     FOREIGN KEY (cusID) references customer ON DELETE CASCADE); 

Create table admin (
    adminID varchar2(15) not null,
    TID varchar2(10) not null,
PRIMARY KEY (adminID, TID),
FOREIGN KEY (TID) references tennis_centre ON DELETE CASCADE);

Create table court (
    courtID CHAR(8),
    court_type CHAR(7),
    TID varchar2(10),
PRIMARY KEY (courtID, TID),
FOREIGN KEY (TID) references tennis_centre ON DELETE CASCADE);

Create table equipment (
    EID CHAR(10) not null,
    type varchar2(10),
    confirNum CHAR(10),
PRIMARY KEY (EID),
FOREIGN KEY (confirNum) references reservation ON DELETE CASCADE);

--cusID, fname, lname, phone, address
insert into customer values('woodie', 'Woodie', 'Hassan', '778-333-2222', '7482 EDWARD STREET');
insert into customer values('lovedeep','LoveDeep', 'Malik', '604-222-2222', '37 SHELL AVENUE');
insert into customer values('taranbir', 'Taranbir', 'Bhullar', '604-444-4444', '3829 MADISON STREET');
insert into customer values('arwud', 'Arwud', 'Hassan', '778-381-8233', '111 DATA AVENUE');
insert into customer values('rachel', 'Rachel', 'Pottinger', '604-003-3913', '39 BLUE ROAD');
--no reservation customer
insert into customer values('rochelle', 'Rochelle', 'Lee', '604-003-3913', '39 BLUE ROAD');

--INSIDE LOGIN, CREATE FIELD ptype INT FOR [1-ADMIN][0-CUSTOMER]
--login for admin
--usernameID, password, ptype
insert into login values ('gabrielle', '111', 1);
insert into login values ('erin', '222', 1);
insert into login values ('daniel', '333', 1);
insert into login values ('nik', '444', 1);
insert into login values ('aaron', '555', 1);

--login for customers
--usernameID, password, ptype
insert into login values ('woodie', '666', 0);
insert into login values ('lovedeep', '777', 0);
insert into login values ('taranbir', '888', 0);
insert into login values ('arwud', '999', 0);
insert into login values ('rachel ', '787', 0);
insert into login values ('rochelle', '191', 0);

--TID, address, phone
insert into tennis_centre values ('1212121212', '2205 LOWER MALL', '604-555-6666');
insert into tennis_centre values ('1313131313', '1904 UNIVERSITY BLVD', '604-666-7777');
insert into tennis_centre values ('1414141414', '720 MAINLAND STREET', '604-777-8888');
insert into tennis_centre values ('1515151515', '101 EAST BROADWAY', '604-888-9999');
insert into tennis_centre values ('1616161616', '721 WEST BROADWAY', '604-999-0101');

--confirNum, dated, timeslot 9am-9pm, payment, court_type, cusID, TID
--$10/hour - php code for timeslot
insert into reservation values('1111111111', '01/01/2001', '12:00/13:00', '20', 'IN-DOOR','woodie', '1212121212');
insert into reservation values('2222222222', '02/02/2002', '13:00/14:00', '20', 'OUTDOOR','lovedeep', '1313131313');
insert into reservation values('3333333333', '03/03/2003', '14:30/16:00', '30', 'IN-DOOR','taranbir', '1414141414');
insert into reservation values('4444444444', '04/04/2004', '17:00/18:00', '20', 'OUTDOOR','arwud', '1515151515'); 
--rachel has 2 reservation in outdoor and indoor court and 2 equipment types (same tennis centre)
insert into reservation values('5555555555', '05/05/2013', '19:00/21:00', '40', 'OUTDOOR','rachel', '1616161616');
insert into reservation values('6666666666', '05/06/2013', '14:00/15:30', '50', 'INDOOR', 'rachel', '1616161616');

--adminID, TID
insert into admin values('gabrielle','1212121212');
insert into admin values('erin','1313131313');
insert into admin values('daniel','1414141414');
insert into admin values('nik','1515151515');
insert into admin values('aaron','1616161616');

--courtID, court_type, TID
insert into court values('33708119', 'IN-DOOR','1212121212');
insert into court values('45889032', 'OUTDOOR','1313131313');
insert into court values('22873987', 'IN-DOOR','1414141414');
insert into court values('10092766', 'OUTDOOR','1515151515');

insert into court values('10092766', 'OUTDOOR','1515151515');   
insert into court values('77890374', 'OUTDOOR','1616161616');
insert into court values('77812382', 'IN-DOOR','1616161616');
--PROBLEM: courtID and TID are primary key so you can't have duplicates but what if a customer makes a reservation 
--at the same tennis centre and court

--EID, type, confirNum
insert into equipment values ('122','BALL','1111111111');
insert into equipment values ('225','RACKET','2222222222');
insert into equipment values ('3123', 'TBM','3333333333');
insert into equipment values ('447', 'BALL','4444444444');
insert into equipment values ('3789', 'BALL','5555555555');
insert into equipment values ('3788', 'RACKET','6666666666');


