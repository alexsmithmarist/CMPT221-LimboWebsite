# Limbo Database (Assignment 2)
# Lab Partners: Alex Smith and John Litts
# Version 1.0

CREATE Database if not exists limbo_db;
use limbo_db;

#Used to reset the tables when debugging code.
DROP TABLE users;
DROP TABLE stuff;
DROP TABLE locations;

SET @now = NOW() ;

#Creating the users table
create table if not exists users (
user_id INT UNSIGNED NOT NULL AUTO_INCREMENT , 
user_name VARCHAR(20) NOT NULL , 
email VARCHAR(60) NOT NULL , 
pass VARCHAR(255) NOT NULL , 
reg_date DATETIME NOT NULL , 
PRIMARY KEY (user_id) , 
UNIQUE ( email ));


#Creating an admin user
insert into users (user_name, email, pass, reg_date)
values ( 'admin' , 'admin@gmail.com' , '$2y$10$Ir/oz.lMJ3TcWng7fuguouisBwbKW/PX7huzclNxoAgHV/zgb/yaq' , @now ) ;

#To see if the table is created correctly
#explain users;
#SELECT * FROM users;

#Creating the locations table
create table if not exists locations (
id INT AUTO_INCREMENT PRIMARY KEY ,
create_date DATETIME NOT NULL ,
update_date DATETIME NOT NULL ,
name TEXT NOT NULL 
) ;

#Creating the stuff table
create table if not exists stuff (
id INT AUTO_INCREMENT PRIMARY KEY ,
item_name TEXT NOT NULL,
location_id INT NOT NULL ,
description TEXT NOT NULL ,
create_date DATETIME NOT NULL ,
update_date DATETIME  ,
contact_fname text NOT NULL,
contact_lname text NOT NULL,
contact_email text ,
photo_link text ,
contact_phone text NOT NULL,
item_status SET("found", "lost", "claimed") NOT NULL ,
FOREIGN KEY (location_id) REFERENCES locations(id)
);




#checking if table is created correct
#explain stuff;

#populate locations table
insert into locations (name, create_date, update_date) 
values ( 'Foy Townhouses' , NOW() , NOW()) ,
('New Gartland',  NOW(), NOW()) ,
('Byrne House',  NOW(), NOW()) ,
('Library',  NOW(), NOW()) ,
('Champagnat Hall',  NOW(), NOW()) ,
('Chapel',  NOW(), NOW()) ,
('Cornell Boathouse',  NOW(), NOW()) ,
('Donnelly Hall',  NOW(), NOW()) ,
('Dyson Center',  NOW(), NOW()) ,
('Fern Tor',  NOW(), NOW()) ,
('Fontaine Hall',  NOW(), NOW()) ,
('Upper Fulton Street Townhouses',  NOW(), NOW()) ,
('Greystone Hall',  NOW(), NOW()) ,
('Hancock Center',  NOW(), NOW()) ,
('Kieran Gatehouse',  NOW(), NOW()) ,
('Kirk House',  NOW(), NOW()) ,
('Leo Hall',  NOW(), NOW()) ,
('Longview Park',  NOW(), NOW()) ,
('Lowell Thomas Communications Center',  NOW(), NOW()) ,
('Lower Townhouses',  NOW(), NOW()) ,
('Marian Hall',  NOW(), NOW()) ,
('Marist Boathouse',  NOW(), NOW()) ,
('McCann Center',  NOW(), NOW()) ,
('MidRise Hall',  NOW(), NOW()) ,
('North Campus Housing Complex',  NOW(), NOW()) ,
('St. Ann\'s Hermitage',  NOW(), NOW()) ,
('St. Peter\'s',  NOW(), NOW()) ,
('Science and Allied Health Building',  NOW(), NOW()) ,
('Sheahan Hall',  NOW(), NOW()) ,
('Steel Plant Studios and Gallery',  NOW(), NOW()) ,
('Student Center/ Music Building',  NOW(), NOW()) ,
('Lower West Cedar Townhouses',  NOW(), NOW()) ,
('Upper West Cedar Townhouses',  NOW(), NOW()) ,
('Lower Fulton Street Townhouses',  NOW(), NOW()) ;




#checking locations table
#explain locations;
#SELECT * FROM locations;

#Pre-Populate data into limbo
insert into stuff (item_name, location_id, description, create_date, item_status, contact_fname, contact_lname, contact_email, contact_phone, photo_link)
values ('Iphone', 4, 'Iphone 7 with a bright red snap-on case', NOW(), 'lost', 'Bob', 'Nob', 'BobNob@gmail.com', '555-5555', 'uploads/iphone.jpg') ,
('Purse', 1, 'Green Leather Designer purse', '2017-10-10 15:43:01', 'lost', 'Mary', 'Sue', 'MarySue@gmail.com', '775-5555','') ,
 ('Pen', 16, 'Silver fountain pen with gold ink', '2016-05-05 11:12:43', 'lost', 'Jim', 'Boe', 'JimBoe@gmail.com', '885-5555','uploads/pen.jpg') ,
 ('Ipad', 7, 'Ipad Air with elephant stickers on the back', '2016-07-14 09:56:32', 'found', 'Sally', 'Sim', 'SallySim@gmail.com', '995-5555','') ,
 ('Thermos', 15, 'Shiny Thermos. Empty with initials AB on top', '2016-12-23 10:17:22', 'found', 'Nah', 'Mei', 'NahMei@gmail.com', '105-5555', 'uploads/thermos.jpg') ,
 ('Watch', 20, 'Black metallic watch with mickey mouse on the inside', '2017-02-02 08:43:12', 'found', 'Li', 'Bo', 'LiBo@gmail.com', '115-5555','uploads/watch.jpg') ;

#Check if everything is inserted correctly.
SELECT create_date, item_status, item_name FROM stuff;
SELECT * FROM users;

