
CREATE TABLE Competition (
  competitionID VARCHAR(6) PRIMARY KEY,
  startTime TIME,
  active BOOLEAN
);

CREATE OR REPLACE FUNCTION uppercase_compId_on_insert() RETURNS trigger AS $uppercase_compId_on_insert$
BEGIN
NEW.competitionId = UPPER(NEW.competitionId);
RETURN NEW;
END;
$uppercase_compId_on_insert$ LANGUAGE plpgsql;

CREATE TRIGGER uppercase_compId_on_insert_trigger BEFORE INSERT OR UPDATE ON Competition
FOR EACH ROW EXECUTE PROCEDURE uppercase_compId_on_insert();

CREATE TABLE Team (
  teamInitials VARCHAR(10) PRIMARY KEY,
  teamName VARCHAR(100) UNIQUE
);

CREATE TABLE PrivilegedUser (
  userName varchar(10) PRIMARY KEY,
  fullName VARCHAR(25),
  password VARCHAR(10),
  privilege VARCHAR(10)
);

CREATE TABLE TeamRecord (
  competitionID VARCHAR(6),
  teamInitials VARCHAR(10),
  currentQuestion SMALLINT DEFAULT 0,
  totalCorrectQuestions SMALLINT DEFAULT 0,
  totalPasses SMALLINT DEFAULT 0,
  currentScore SMALLINT DEFAULT 0,
  assigned BOOLEAN DEFAULT 'F',
  username VARCHAR(10) REFERENCES PrivilegedUser,
  PRIMARY KEY (competitionID,teamInitials),
  CONSTRAINT TeamRecord_compID_fkey FOREIGN KEY (competitionID)
  REFERENCES Competition (competitionID) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT TeamRecord_schIni_fkey FOREIGN KEY (teamInitials)
  REFERENCES Team (teamInitials) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);
