drop table customer cascade constraints;
drop table login cascade constraints;
drop table tennis_centre cascade constraints;
drop table reservation cascade constraints;
drop table admin cascade constraints;
drop table court cascade constraints;
drop table equipment cascade constraints;

create table customer (
    cusID varchar2(15) not null, 
    fname varchar2(20),
    lname varchar2(20),
    phone CHAR(10),
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

Create table equipment (
    EID CHAR(2) not null,
    confirNum CHAR(10),
    dated CHAR(10), 
    timeslot CHAR(11),
    TID varchar2(10) not null,
    taken INT,
PRIMARY KEY (EID, TID),
FOREIGN KEY (TID) references tennis_centre);

Create table reservation (
     confirNum CHAR(10) not null, 
     dated CHAR(10) not null, 
     timeslot CHAR(11) not null,
     payment INT,
     court_type CHAR(10),
     cusID varchar2(15),
     TID varchar2(10),
     EID CHAR(2),
     PRIMARY KEY (confirNum, dated, timeslot), 
     FOREIGN KEY (cusID) references customer ON DELETE CASCADE,
     FOREIGN KEY (EID, TID) references equipment); 

Create table admin (
    adminID varchar2(15) not null,
    TID varchar2(10) not null,
PRIMARY KEY (adminID, TID),
FOREIGN KEY (TID) references tennis_centre ON DELETE CASCADE);

Create table court (
    courtID CHAR(8) not null,
    court_type CHAR(7),
    TID varchar2(10) not null,
    dated CHAR(10) not null, 
    timeslot CHAR(11) not null,
    confirNum CHAR(10) not null,
PRIMARY KEY (TID, courtID, confirNum, dated, timeslot),
FOREIGN KEY (TID) references tennis_centre ON DELETE CASCADE,
FOREIGN KEY (confirNum, dated, timeslot) references reservation ON DELETE CASCADE);


--cusID, fname, lname, phone, address
insert into customer values('woodie', 'Woodie', 'Hassan', '7783332222', '7482 EDWARD STREET');
insert into customer values('lovedeep','LoveDeep', 'Malik', '6042222222', '37 SHELL AVENUE');
insert into customer values('taranbir', 'Taranbir', 'Bhullar', '6044444444', '3829 MADISON STREET');
insert into customer values('arwud', 'Arwud', 'Hassan', '7783818233', '111 DATA AVENUE');
insert into customer values('rachel', 'Rachel', 'Pottinger', '6040033913', '39 BLUE ROAD');
--no reservation customer
insert into customer values('rochelle', 'Rochelle', 'Lee', '6040033913', '39 BLUE ROAD');
--EXTRA CUSTOMERS
insert into customer values('bryan', 'Bryan', 'Bob', '6043829302', '748 SILLY STREET');
insert into customer values('alan', 'Alan', 'Man', '7783920016', '3719 UDERGRAD ROAD');
insert into customer values('coco', 'Coco', 'Liam', '6042839302', '12 RICHMOND AVENUE');
insert into customer values('jimhub', 'Jimbo', 'Hub', '6041234567', '789 CHERRY BOMB STREET');

--extra to cover admin
insert into customer values('boom', 'Chow', 'Bo', '7783230016', '374 VITA COO STREET');
insert into customer values('vita', 'Vita', 'Coo', '6041679302', '3847 CPSC ROAD');
insert into customer values('jimbo', 'James', 'Hi', '6048934567', '835902 AGRONOMY ROAD');

--conflict 
--insert into customer values('bob', 'Bob', 'Jim', '7781234567', '789 COKE BOMB STREET');

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
insert into login values ('rachel', '787', 0);
--no reservation
insert into login values ('rochelle', '191', 0);

insert into login values ('bryan', '123', 0);
insert into login values ('alan', '234', 0);
insert into login values ('coco', '345', 0);
insert into login values ('jimhub', '456', 0);

--extra to cover admin
insert into login values ('boom', '184', 0);
insert into login values ('vita', '384', 0);
insert into login values ('jimbo', '384', 0);

--insert into login values ('bob', '656', 0);

--TID, address, phone
insert into tennis_centre values ('1212121212', '2205 LOWER MALL', '604-555-6666');
insert into tennis_centre values ('1313131313', '1904 UNIVERSITY BLVD', '604-666-7777');
insert into tennis_centre values ('1414141414', '720 MAINLAND STREET', '604-777-8888');
insert into tennis_centre values ('1515151515', '101 EAST BROADWAY', '604-888-9999');
insert into tennis_centre values ('1616161616', '721 WEST BROADWAY', '604-999-0101');

--10 equipment per tennis centre
--EID, confirNum, dated, timeslot, taken, TID
insert into equipment values ('21','1111111111', '12/01/2013', '12:00/13:00', '1212121212', 1);
insert into equipment values ('31','2222222222','12/02/2013', '13:00/14:00', '1313131313', 1);
insert into equipment values ('40', '3333333333', '12/03/2013', '14:00/15:00', '1414141414', 1);
--arwud's equipment

insert into equipment values ('51', '4444444444', '12/04/2013', '15:00/16:00', '1515151515', 1);
insert into equipment values ('52', '7777777777', '12/04/2013', '16:00/17:00', '1515151515', 1);
insert into equipment values ('53', '5555555555', '12/05/2013', '17:00/18:00', '1515151515', 1);

insert into equipment values ('60', '6666666666', '12/06/2013', '17:00/18:00', '1616161616', 1);

--bryan
insert into equipment values ('54', '8888888888', '12/04/2013', '15:00/16:00', '1515151515', 1);
insert into equipment values ('55', '1333333333', '12/05/2013', '15:00/16:00', '1515151515', 1);
insert into equipment values ('56', '1111122222', '12/06/2013', '15:00/16:00', '1515151515', 1);
    --bryan reservation w/ confirNum 1111177777 using all equipment available
    insert into equipment values ('57', '1111177777', '12/07/2013', '15:00/16:00', '1515151515', 1);

--other buds equipment
insert into equipment values ('32', '1111133333', '12/12/2013', '12:00/13:00', '1313131313', 1);
insert into equipment values ('33', '1111144444', '12/13/2013', '16:00/17:00', '1313131313', 1);
insert into equipment values ('43', '1111155555', '12/14/2013', '17:00/18:00', '1414141414', 1);
insert into equipment values ('62', '1111166666', '12/15/2013', '13:00/14:00', '1616161616', 1);

--unused equipment
--tennis_centre = '1212121212' = '2205 LOWER MALL'
insert into equipment values ('20', null, null, null, '1212121212', 0);
insert into equipment values ('22', null, null, null, '1212121212', 0);
insert into equipment values ('23', null, null, null, '1212121212', 0);
insert into equipment values ('24', null, null, null, '1212121212', 0);
insert into equipment values ('25', null, null, null, '1212121212', 0);
insert into equipment values ('26', null, null, null, '1212121212', 0);
insert into equipment values ('27', null, null, null, '1212121212', 0);
insert into equipment values ('28', null, null, null, '1212121212', 0);
insert into equipment values ('29', null, null, null, '1212121212', 0);

--tennis_centre = '1313131313' and '1904 UNIVERSITY BLVD'
insert into equipment values ('30', null, null, null, '1212121212', 0);
insert into equipment values ('34', null, null, null, '1313131313', 0);
insert into equipment values ('35', null, null, null, '1313131313', 0);
insert into equipment values ('36', null, null, null, '1212121212', 0);
insert into equipment values ('37', null, null, null, '1212121212', 0);
insert into equipment values ('38', null, null, null, '1212121212', 0);
insert into equipment values ('39', null, null, null, '1212121212', 0);

--tennis_centre = '1414141414' and '720 MAINLAND STREET'
insert into equipment values ('41', null, null, null, '1414141414', 0);
insert into equipment values ('42', null, null, null, '1414141414', 0);
insert into equipment values ('44', null, null, null, '1414141414', 0);
insert into equipment values ('45', null, null, null, '1414141414', 0);
insert into equipment values ('46', null, null, null, '1212121212', 0);
insert into equipment values ('47', null, null, null, '1212121212', 0);
insert into equipment values ('48', null, null, null, '1212121212', 0);
insert into equipment values ('49', null, null, null, '1212121212', 0);

--tennis_centre = '1515151515' and '101 EAST BROADWAY''
insert into equipment values ('50', null, null, null, '1515151515', 0);
insert into equipment values ('58', null, null, null, '1515151515', 0);
insert into equipment values ('59', null, null, null, '1515151515', 0);

--tennis_centre = '1616161616' and '721 WEST BROADWAY'
insert into equipment values ('61', null, null, null, '1616161616', 0);
insert into equipment values ('63', null, null, null, '1616161616', 0);
insert into equipment values ('64', null, null, null, '1616161616', 0);
insert into equipment values ('65', null, null, null, '1616161616', 0);
insert into equipment values ('66', null, null, null, '1616161616', 0);
insert into equipment values ('67', null, null, null, '1616161616', 0);
insert into equipment values ('68', null, null, null, '1616161616', 0);
insert into equipment values ('69', null, null, null, '1616161616', 0);

--confirNum, dated (month/day/year), timeslot 12:00/18:00, payment, court_type, cusID, TID
--CUSTOMER RESERVATION
insert into reservation values('1111111111', '12/01/2013', '12:00/13:00', '10', 'IN-DOOR','woodie', '1212121212', '21');
insert into reservation values('2222222222', '12/02/2013', '13:00/14:00', '10', 'OUTDOOR','lovedeep', '1313131313', '31');
insert into reservation values('3333333333', '12/03/2013', '14:00/15:00', '10', 'IN-DOOR','taranbir', '1414141414', '40');
--arwud has 2 reservations for same tennis centre, same court, same day, diff time, diff equipment
insert into reservation values('4444444444', '12/04/2013', '15:00/16:00', '10', 'OUTDOOR','arwud', '1515151515', '51'); 
insert into reservation values('7777777777', '12/04/2013', '16:00/17:00', '10', 'OUTDOOR','arwud', '1515151515', '52');
--rachel has 2 reservation in outdoor and indoor court 
--(same tennis centre)
insert into reservation values('5555555555', '12/05/2013', '17:00/18:00', '10', 'OUTDOOR','rachel', '1515151515', '53');
insert into reservation values('6666666666', '12/06/2013', '17:00/18:00', '10', 'IN-DOOR', 'rachel', '1616161616', '60');
--bryan has most reservations - all at east broadway, always from 2-3, outdoor, 
insert into reservation values('8888888888', '12/04/2013', '15:00/16:00', '10', 'OUTDOOR', 'bryan', '1515151515', '54'); 
insert into reservation values('1333333333', '12/05/2013', '15:00/16:00', '10', 'OUTDOOR', 'bryan', '1515151515', '55');
insert into reservation values('1111122222', '12/06/2013', '15:00/16:00', '10', 'OUTDOOR', 'bryan', '1515151515', '56');
insert into reservation values('1111177777', '12/07/2013', '15:00/16:00', '10', 'OUTDOOR', 'bryan', '1515151515', '57');

insert into reservation values('1111133333', '12/12/2013', '12:00/13:00', '10', 'IN-DOOR', 'alan', '1313131313', '32'); 
insert into reservation values('1111144444', '12/13/2013', '16:00/17:00', '10', 'OUTDOOR', 'coco', '1313131313', '33');
    insert into reservation values('7777744444', '12/11/2013', '15:00/16:00', '10', 'OUTDOOR', 'coco', '1616161616', null);
insert into reservation values('1111155555', '12/14/2013', '17:00/18:00', '10', 'IN-DOOR', 'jimhub', '1414141414', '43');
insert into reservation values('1111166666', '12/15/2013', '13:00/14:00', '10', 'IN-DOOR', 'jimhub', '1616161616', '62');

--extra to cover admin (NO EQUIPMENT USERS)
insert into reservation values('5555544444', '12/08/2013', '13:00/14:00', '10', 'OUTDOOR', 'boom', '1212121212', null);
insert into reservation values('9999966666', '12/09/2013', '17:00/18:00', '10', 'OUTDOOR', 'vita', '1414141414', null);
insert into reservation values('7798966666', '12/10/2013', '14:00/15:00', '10', 'IN-DOOR', 'jimbo', '1515151515', null);

--                        adminID,       TID
insert into admin values('gabrielle','1212121212');
insert into admin values('erin','1313131313');
insert into admin values('daniel','1414141414');
insert into admin values('nik','1515151515');
insert into admin values('aaron','1616161616');

--for every tennis centre, we need a court thats indoor/outdoor and for everyday from december 1-15
--                         courtID, court_type,    TID (tc)      (dated,      timeslot) ,   confirNum
--1212121212 has 2 courts (1 out/1 in)
--1313131313 has 3 courts (2 out/1 in)
--1414141414 has 3 courts (1 out/2 in)
--1515151515 has 6 courts (5 out/1 in)
--1616161616 has 3 courts (1 out/2 in)
--total courts = 17 courts (10 out/8 in)
insert into court values('33708119', 'IN-DOOR','1212121212', '12/01/2013', '12:00/13:00', '1111111111');
    insert into court values('33799999', 'OUTDOOR','1212121212', '12/08/2013', '13:00/14:00', '5555544444');
insert into court values('45889032', 'OUTDOOR','1313131313', '12/02/2013', '13:00/14:00', '2222222222');
insert into court values('22873987', 'IN-DOOR','1414141414', '12/03/2013', '14:00/15:00', '3333333333');
    insert into court values('88800099', 'OUTDOOR','1414141414', '12/09/2013', '17:00/18:00', '9999966666');
insert into court values('10092766', 'OUTDOOR','1515151515', '12/04/2013', '15:00/16:00', '4444444444'); 
insert into court values('10092766', 'OUTDOOR','1515151515', '12/04/2013', '16:00/17:00', '7777777777'); 
insert into court values('77890374', 'OUTDOOR','1515151515', '12/05/2013', '17:00/18:00', '5555555555');
  insert into court values('17990874', 'IN-DOOR','1515151515', '12/10/2013', '14:00/15:00', '7798966666');  
insert into court values('77812382', 'IN-DOOR','1616161616', '12/06/2013', '17:00/18:00', '6666666666');
        insert into court values('76283901', 'OUTDOOR','1616161616', '12/11/2013', '15:00/16:00', '7777744444');
--bryan
insert into court values('12312312', 'OUTDOOR','1515151515', '12/04/2013', '15:00/16:00', '8888888888'); 
insert into court values('12312312', 'OUTDOOR','1515151515', '12/05/2013', '15:00/16:00', '1333333333'); 
insert into court values('23023023', 'OUTDOOR','1515151515', '12/06/2013', '15:00/16:00', '1111122222');
insert into court values('55566677', 'OUTDOOR','1515151515', '12/07/2013', '15:00/16:00', '1111177777');
--other new buds

insert into court values('12345678', 'IN-DOOR','1313131313', '12/12/2013', '12:00/13:00', '1111133333'); 
insert into court values('23456789', 'OUTDOOR','1313131313', '12/13/2013', '16:00/17:00', '1111144444'); 
insert into court values('34534533', 'IN-DOOR','1414141414', '12/14/2013', '17:00/18:00', '1111155555');
insert into court values('99999777', 'IN-DOOR','1616161616', '12/15/2013', '13:00/14:00', '1111166666');

