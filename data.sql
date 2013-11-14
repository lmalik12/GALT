drop table customer cascade constraints;
drop table admin cascade constraints;
drop table login cascade constraints;
drop table court cascade constraints;
drop table reservation cascade constraints;
drop table tennis_centre cascade constraints;
drop table equipment cascade constraints;

create table customer (
    cusID varchar2(15) not null, 
    name varchar2(20),
    phone CHAR(12),
    address VARCHAR2(30),
    PRIMARY KEY(cusID));

Create table reservation (
     confirNum CHAR(10) not null, 
     dated CHAR(10), 
     timeslot CHAR(11),
     payment INT,
     court_type CHAR(10),
     cusID CHAR(5),
     PRIMARY KEY (confirNum),
     FOREIGN KEY (cusID) references customer); 

Create table tennis_centre (
    TID CHAR(10) not null, 
    address varchar2(30), 
    phone CHAR(12),
PRIMARY KEY (TID));

Create table admin (
    adminID varchar2(15) not null,
    TID CHAR(10) not null,
PRIMARY KEY (adminID, TID),
FOREIGN KEY (TID) references tennis_centre);

Create table login (
    usernameID varchar2 (15) not null,
    password CHAR(8),
    ptype INT,
PRIMARY KEY (usernameID));

Create table court (
    courtID CHAR(8),
    court_type CHAR(7),
    TID CHAR(10),
PRIMARY KEY (courtID, TID),
FOREIGN KEY (TID) references tennis_centre);

Create table equipment (
    EID CHAR(10) not null,
    type varchar2(10),
    confirNum CHAR(10),
PRIMARY KEY (EID),
FOREIGN KEY (confirNum) references reservation);

insert into tennis_centre values ('1212121212', '2205 LOWER MALL', '604-555-6666');
insert into tennis_centre values ('1313131313', '1904 UNIVERSITY BLVD', '604-666-7777');
insert into tennis_centre values ('1414141414', '720 MAINLAND STREET', '604-777-8888');
insert into tennis_centre values ('1515151515', '101 EAST BROADWAY', '604-888-9999');
insert into tennis_centre values ('1616161616', '721 WEST BROADWAY', '604-999-0101');

insert into admin values('Gabrielle','1212121212');
insert into admin values('Erin','1313131313');
insert into admin values('Daniel','1414141414');
insert into admin values('Nik','1515151515');
insert into admin values('Aaron','1616161616');

insert into customer values('22222', 'Woodie', '778-333-2222', '7482 EDWARD STREET');
insert into customer values('33333','LoveDeep', '604-222-2222', '37 SHELL AVENUE');
insert into customer values('44444', 'Taranbir', '604-444-4444', '3829 MADISON STREET');
insert into customer values('55555', 'Arwud', '778-381-8233', '111 DATA AVENUE');
insert into customer values('66666', 'Rachel', '604-003-3913', '39 BLUE ROAD');

--INSIDE LOGIN, CREATE FIELD ptype INT FOR [1-ADMIN][0-CUSTOMER]
--login for admin
insert into login values ('Gabrielle', 'D8EKJ9fe', 1);
insert into login values ('Erin', 'AA7KKkeE', 1);
insert into login values ('Daniel', 'DD9jjJDD', 1);
insert into login values ('Nik', 'AA24AasD', 1);
insert into login values ('Aaron', 'BBb3BBAS', 1);

--login for customers
insert into login values ('Woodie', 'fjei19fk', 0);
insert into login values ('LoveDeep', 'ejx83kd7', 0);
insert into login values ('Taranbir', 'DD83kdi3', 0);
insert into login values ('Arwud', 'A92kfuD9', 0);
insert into login values ('Rachel ', 'grapes93', 0);

insert into court values('33708119', 'IN-DOOR','1212121212');
insert into court values('45889032', 'OUTDOOR','1313131313');
insert into court values('22873987', 'IN-DOOR','1414141414');
insert into court values('10092766', 'OUTDOOR','1515151515');
insert into court values('77890374', 'OUTDOOR','1616161616');

insert into reservation values('1111111111', '01/01/2001', '12:00/13:00', '20', 'IN-DOOR','22222');
insert into reservation values('2222222222', '02/02/2002', '13:00/14:00', '20', 'IN-DOOR','33333');
insert into reservation values('3333333333', '03/03/2003', '14:30/16:00', '30', 'OUTDOOR','44444');
insert into reservation values('4444444444', '04/04/2004', '17:00/18:00', '20', 'OUTDOOR','55555');
insert into reservation values('5555555555', '05/05/2005', '19:00/21:00', '40', 'OUTDOOR','66666');

insert into equipment values ('122','BALL','1111111111');
insert into equipment values ('225','RACKET','2222222222');
insert into equipment values ('3123', 'TBM','3333333333');
insert into equipment values ('447', 'BALL','4444444444');
insert into equipment values ('3789', 'BALL','5555555555');
