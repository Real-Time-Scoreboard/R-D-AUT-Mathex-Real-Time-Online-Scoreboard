select * from TeamRecord;

UPDATE TeamRecord
SET
assigned = 't',
currentQuestion = 1,
totalCorrectQuestions = 1,
totalPasses = 0,
currentScore = 5
Where
competitionId = 'COMP01'
AND
teamInitials = 'AUT'
;

select * from Competition;

Update Competition
Set
startTime = current_Time
Where
competitionId = 'COMP01';

select * from Team;

Update Team
Set
teamname = 'Auck Uni of Tech'
Where
teamInitials = 'AUT';
