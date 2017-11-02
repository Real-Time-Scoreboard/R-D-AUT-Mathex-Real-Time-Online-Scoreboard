drop table AllSchools;
drop table AucklandSchools;
Select * from AllSchools;
Select * from AucklandSchools;

Create table AllSchools
(
id Serial Primary Key,
SchoolName varchar(150),
city varchar(30)
);

COPY AllSchools (SchoolName, city)
From 'C:\Users\Everybody''s\Desktop\R&D\R-D-AUT-Mathex-Development Branch\DomainsModel\Database_Domain_Model\Queries and schools\modified_file_csv_comma.csv'
Delimiter ',' CSV HEADER;

Create table AucklandSchools as 
SELECT SchoolName, city  FROM AllSchools where city like 'Auckland';




