Select * from Competition;

/* testing trigger from lower case to uppercase */
INSERT INTO Competition (competitionId, startTime, active)
VALUES ('comp10',CURRENT_TIME,true)
;

INSERT INTO Competition (competitionId, startTime, active)
VALUES ('COMP01',CURRENT_TIME,false),
('COMP02',CURRENT_TIME,false),
('COMP03',CURRENT_TIME,false),
('COMP04',CURRENT_TIME,false)
;

INSERT INTO Team
VALUES ('AUT','Auckland University of Technology'),
('UOA','Auckland University')
;

INSERT INTO TeamRecord
VALUES ('COMP01','AUT'),
('COMP01','UOA')
;

INSERT INTO PrivilegedUser
VALUES ('marker01','John Doe','password','Marker'),
('admin01','Jane Doe','password','Admin');
;
