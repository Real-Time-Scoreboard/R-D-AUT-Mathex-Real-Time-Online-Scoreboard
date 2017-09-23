
CREATE TABLE Competition (
 competitionID VARCHAR(6) PRIMARY KEY,
 startTime TIME,
 competitionDate DATE
);

CREATE OR REPLACE FUNCTION uppercase_compId_on_insert() RETURNS trigger AS $uppercase_compId_on_insert$
    BEGIN        
        NEW.competitionId = UPPER(NEW.competitionId);
        RETURN NEW;
    END;
$uppercase_compId_on_insert$ LANGUAGE plpgsql;

CREATE TRIGGER uppercase_compId_on_insert_trigger BEFORE INSERT OR UPDATE ON Competition
    FOR EACH ROW EXECUTE PROCEDURE uppercase_compId_on_insert();

CREATE TABLE Schools (
schoolInitials VARCHAR(10) PRIMARY KEY,
schoolName VARCHAR(100) UNIQUE
);

CREATE TABLE TeamRecord (
competitionID VARCHAR(6),
schoolInitials VARCHAR(10),
assigned BOOLEAN,
currentQuestionNumber SMALLINT DEFAULT 0,
totalCorrectQuestion SMALLINT DEFAULT 0,
totalPasses SMALLINT DEFAULT 0,
currentScore SMALLINT DEFAULT 0,
PRIMARY KEY (competitionID,schoolInitials),
CONSTRAINT TeamRecord_compID_fkey FOREIGN KEY (competitionID)
      REFERENCES Competition (competitionID) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE,
CONSTRAINT TeamRecord_schIni_fkey FOREIGN KEY (schoolInitials)
      REFERENCES Schools (schoolInitials) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE      
);

CREATE TABLE Users (
userName varchar(10) PRIMARY KEY,
name VARCHAR(25),
password VARCHAR(10),
privilege VARCHAR(10)
);
