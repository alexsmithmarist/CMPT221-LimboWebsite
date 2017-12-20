# Presidents of the United States
# Authors: Jake Litts and Alex Smith

CREATE DATABASE IF NOT EXISTS site_db;
USE site_db;

#Deletes the table if it exists
DROP TABLE IF EXISTS presidents; 

#Creates table and modifies the fields
CREATE TABLE IF NOT EXISTS presidents(
    id INT PRIMARY KEY AUTO_INCREMENT,
    fname TEXT NOT NULL,
    lname TEXT NOT NULL,
    num INT NOT NULL   
    );

    

#Inserts data into the presidents table    
INSERT INTO presidents (fname, lname, num) 
VALUES ( "George", "Washington", 1 ) ,
( "William", "McKinley", 25) ,
( "Calvin", "Coolidge", 30) , 
("Herbet", "Hoover", 31) ,
("Theodore", "Roosevelt", 26) ;

#Displays all fields from an unsorted presidents table
SELECT * FROM presidents;

#Displays all fields except id and fname from presidents table, sorted by num ascending
(SELECT lname, num
 FROM presidents
 ORDER BY num ASC);
 
 #Displays all fields except id and fname from presidents table, sorted by lname ascending
 (SELECT lname, num
 FROM presidents
 ORDER BY lname ASC);
 
 #Displays all fields except id and fname from presidents table, sorted by dob descending
 (SELECT lname, num
 FROM presidents
 ORDER BY num DESC);
 
 

