select * from TeamRecord;

UPDATE TeamRecord
SET 
	assigned = 't',
	currentQuestionNumber = 1,
	totalCorrectQuestion = 1,
	totalPasses = 0,
	currentScore = 5
Where
competitionId = 'COMP01'
AND
schoolInitials = 'AUT'
;

select * from Competition;

Update Competition
Set 
startTime = current_Time,
competitionDate =  current_Date
WHERE
competitionId = 'COMP01';

select * from Schools;

Update Schools
SET
Schoolname = 'AUT'
Where
schoolInitials = 'AUT';