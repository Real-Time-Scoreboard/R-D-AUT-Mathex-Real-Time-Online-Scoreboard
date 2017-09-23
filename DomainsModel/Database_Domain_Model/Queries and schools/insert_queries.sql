Select * from Competition;

***testing trigger from lower case to upercase***
INSERT INTO Competition (competitionId, startTime, competitionDate)
VALUES ('comp10',CURRENT_TIME,CURRENT_DATE)
;

INSERT INTO Competition (competitionId, startTime, competitionDate)
VALUES ('COMP01',CURRENT_TIME,CURRENT_DATE),
('COMP02',CURRENT_TIME,CURRENT_DATE),
('COMP03',CURRENT_TIME,CURRENT_DATE),
('COMP04',CURRENT_TIME,CURRENT_DATE)
;

INSERT INTO Schools 
VALUES ('AUT','Auckland University of Technology'),
	('AU','Auckland University')	
;

INSERT INTO TeamRecord 
VALUES ('COMP01','AUT')
('COMP01','AU');

INSERT INTO Users 
VALUES ('Marker01','Unknown','password','Marker');
	