SELECT * FROM Competition;

SELECT * FROM Team;

SELECT * FROM User;

SELECT * FROM TeamRecord;

/* get all with a particular competition ID */
SELECT teamInitials, currentScore
FROM TeamRecord
Where competitionID = 'COMP01';

/* order by score */
SELECT teamInitials, currentScore
FROM TeamRecord
Where competitionID = 'COMP01'
ORDER BY
currentScore DESC;

/* order by name */
SELECT teamInitials, currentScore
FROM TeamRecord
Where competitionID = 'COMP01'
ORDER BY
teamInitials DESC;
