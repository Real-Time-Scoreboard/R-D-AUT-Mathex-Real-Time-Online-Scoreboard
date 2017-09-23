SELECT * FROM Competition;

SELECT * FROM Schools;

SELECT * FROM Users;

SELECT * FROM TeamRecord;

*** get all from a compettion ID***
SELECT schoolInitials, currentScore 
FROM TeamRecord
Where competitionID = 'COMP01';

*** by score***
SELECT schoolInitials, currentScore 
FROM TeamRecord
Where competitionID = 'COMP01'
ORDER BY
	currentScore DESC;

***BY Name***
SELECT schoolInitials, currentScore 
FROM TeamRecord
Where competitionID = 'COMP01'
ORDER BY
	schoolInitials DESC;