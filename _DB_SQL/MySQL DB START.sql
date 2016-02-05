-- ------------------ DROP AND RECREATE SCHEMA --------------------
DROP DATABASE IF EXISTS acit2910project;
CREATE DATABASE acit2910project;
USE acit2910project;

-- ------------------ TABLE DEFINITIONS --------------------

-- News Table
CREATE TABLE News
 (
	NewsID				INT				AUTO_INCREMENT	NOT NULL,
	NewsSubject			VARCHAR(200)					NOT NULL,
	NewsBody			TEXT							NOT NULL,
	StartDate			DATE							NOT NULL,
	EndDate				DATE							NOT NULL,
	PublicView			TINYINT(1),
	StudentView			TINYINT(1),
	CoachView			TINYINT(1),
	AdminView			TINYINT(1),
	CONSTRAINT News_pk
		PRIMARY KEY (NewsID)
 );

-- Admin Profile Table
CREATE TABLE AdminProfile
	(
	AdminID				INT				AUTO_INCREMENT	NOT NULL,
	Name				VARCHAR(100)					NOT NULL,
	Email				VARCHAR(250),
	Phone				VARCHAR(25),
	Notes				TEXT,
	PublicDisplay		TINYINT(1),
	DisplayOrder		INT,
	CONSTRAINT AdminProfile_pk
		PRIMARY KEY (AdminID)
	);

-- Homeroom Table - Domain Table / Constraint Data
CREATE TABLE Homeroom
	(
	Homeroom			VARCHAR(2)						NOT NULL,
	H_Description		VARCHAR(50),
	CONSTRAINT Homeroom_pk
		PRIMARY KEY (Homeroom)
	);

-- User Group ROLES
CREATE TABLE GroupRole
	(
	RoleID				INT								NOT NULL,
	GroupName			VARCHAR(30)						NOT NULL,
	CONSTRAINT GroupRole_pk
		PRIMARY KEY (RoleID)
	);
	
-- User Access Table DB Login users
-- Password use PHP password_hash() and password_verify()

CREATE TABLE UserAccess
	(
	Username		VARCHAR(30)					            		NOT NULL,
	UserPW			VARCHAR(255)				            		NOT NULL,
    FirstName       VARCHAR(30),
    LastName        VARCHAR(30),
	UserGroup		INT								                NOT NULL,
	GrantAccess		TINYINT(1)		DEFAULT     '1'			        NOT NULL,
	DateRegistered	TIMESTAMP		DEFAULT     CURRENT_TIMESTAMP   NOT NULL,
	LastUpdated		DATETIME,
	CONSTRAINT UserAccess_pk
		PRIMARY KEY (Username),
	CONSTRAINT UserAccess_fk1
		FOREIGN KEY (UserGroup) REFERENCES GroupRole(RoleID) ON UPDATE CASCADE
	);

-- Student Table
CREATE TABLE Student
	(
	StudentNo			VARCHAR(7)						NOT NULL,
	Username			VARCHAR(30),
	S_LastName			VARCHAR(30)						NOT NULL,
	S_FirstName			VARCHAR(30)						NOT NULL,
	Grade8Year			SMALLINT						NOT NULL,
	GradYear			SMALLINT						NOT NULL,
	Homeroom			VARCHAR(2)						NOT NULL,
	Gender				VARCHAR(6)						NOT NULL,
	S_BirthDate			DATE							NOT NULL,
	S_Email				VARCHAR(250)					NOT NULL,
	S_CellNumber		VARCHAR(25),
	S_HomeNumber		VARCHAR(25),
	PrevSchool			VARCHAR(100),
	S_Notes				TEXT,
	CONSTRAINT Student_pk
		PRIMARY KEY (StudentNo),
	CONSTRAINT Student_fk1
		FOREIGN KEY (Homeroom) REFERENCES Homeroom(Homeroom) ON UPDATE CASCADE,
	CONSTRAINT Student_fk2
		FOREIGN KEY (Username) REFERENCES UserAccess(Username) ON DELETE SET NULL ON UPDATE CASCADE,
	CONSTRAINT Student_uniqueUsername
		UNIQUE (Username)
	);

-- Coach Table
CREATE TABLE Coach
	(
	Coach_ID			INT				AUTO_INCREMENT	NOT NULL,
	Username			VARCHAR(30),
	C_DefaultType		VARCHAR(20)						NOT NULL,
	C_LastName			VARCHAR(30)						NOT NULL,
	C_FirstName			VARCHAR(30)						NOT NULL,
	C_Email				VARCHAR(250)					NOT NULL,
	C_HomeNumber		VARCHAR(25),
	C_WorkNumber		VARCHAR(25),
	C_WorkNumberExt		VARCHAR(6),
	C_CellNumber		VARCHAR(25),
	C_Notes				TEXT,
	CONSTRAINT Coach_pk
		PRIMARY KEY (Coach_ID),
	CONSTRAINT Coach_fk1
		FOREIGN KEY (Username) REFERENCES UserAccess(Username) ON DELETE SET NULL ON UPDATE CASCADE,
	CONSTRAINT Coach_uniqueUsername
		UNIQUE (Username)
	);

-- Sport Table - Domain Table / Constraint Data
CREATE TABLE Sport
	(
	Sport_ID			INT								NOT NULL,
	Sport				VARCHAR(30)						NOT NULL,
	CONSTRAINT Sport_pk
		PRIMARY KEY (Sport_ID)
	);

-- Season Table - Domain Table / Constraint Data
CREATE TABLE Season
	(
	Season_ID			INT								NOT NULL,
	Season_Description	VARCHAR(50)						NOT NULL,
	CONSTRAINT Season_pk
		PRIMARY KEY (Season_ID)
	);

-- Team Division Table - Domain Table / Constraint Data
CREATE TABLE Team_Division
	(
	DivisionName		VARCHAR(12)						NOT NULL,
	CONSTRAINT Team_Division_pk
		PRIMARY KEY (DivisionName)
	);

-- Team Table
CREATE TABLE Team
	(
	Team_ID				INT				AUTO_INCREMENT	NOT NULL,
	Season_ID			INT								NOT NULL,
	Sport_ID			INT								NOT NULL,
	DivisionName		VARCHAR(12)						NOT NULL,
	TeamSubset			VARCHAR(12),
	CONSTRAINT Team_pk
		PRIMARY KEY (Team_ID),
	CONSTRAINT Team_fk1
		FOREIGN KEY (Sport_ID) REFERENCES Sport(Sport_ID) ON UPDATE CASCADE,
	CONSTRAINT Team_fk2
		FOREIGN KEY (Season_ID) REFERENCES Season(Season_ID) ON UPDATE CASCADE,
	CONSTRAINT Team_fk3
		FOREIGN KEY (DivisionName) REFERENCES Team_Division(DivisionName) ON UPDATE CASCADE,
	CONSTRAINT Team_Unique 
		UNIQUE (Season_ID, Sport_ID, DivisionName, TeamSubset)
	);

-- Coach Team Table - This is where multiple coaches can coach one sport team.
CREATE TABLE Coach_Team
	(
	Team_ID				INT								NOT NULL,
	Coach_ID			INT								NOT NULL,
	C_Type				VARCHAR(20)						NOT NULL,

	CONSTRAINT Coach_Team_pk
		PRIMARY KEY (Team_ID, Coach_ID),
	CONSTRAINT Coach_Team_fk1
		FOREIGN KEY (Coach_ID) REFERENCES Coach(Coach_ID) ON UPDATE CASCADE,
	CONSTRAINT Coach_Team_fk2
		FOREIGN KEY (Team_ID) REFERENCES Team(Team_ID) ON DELETE CASCADE
	);

-- Team Point Table - Domain Table / Constraint Data
-- Newly added in MySQL
CREATE TABLE Point_Team
	(
	Point_Team		FLOAT(2,1)		NOT NULL,
	CONSTRAINT Point_Team_pk
		PRIMARY KEY (Point_Team)
	);

-- Point Bonus Table - Domain Table / Constraint Data
CREATE TABLE Point_Bonus
	(
	Point_Bonus			TINYINT(1)						NOT NULL,
	PB_Description		VARCHAR(200)					NOT NULL,
	CONSTRAINT Point_Bonus_pk
		PRIMARY KEY (Point_Bonus)
	);

-- Point Award Table - Used as filters for Reports (or implemented as status to next medal)
CREATE TABLE Point_Award
	(
	MinPointNeeded		TINYINT							NOT NULL,
	Point_AwardName		VARCHAR(20)						NOT NULL,
	CONSTRAINT Point_Award_pk
		PRIMARY KEY (MinPointNeeded)
	);

-- Team Roster Table.
CREATE TABLE Roster
	(
	Team_ID				INT								NOT NULL,
	StudentNo			VARCHAR(7)						NOT NULL,
	Stu_Is_Manager		TINYINT(1),
	FormBCSS			TINYINT(1),
	FormAC				TINYINT(1),
	FeePaid				TINYINT(1),
	FeeAmountPaid		DOUBLE(5,2),
	UniformNo			INT,
	UniformReturned		TINYINT(1),
	Point_Team			FLOAT(2,1),
	Point_Bonus			TINYINT,
	CONSTRAINT Roster_pk
		PRIMARY KEY (Team_ID, StudentNo),
	CONSTRAINT Roster_fk1
		FOREIGN KEY (Team_ID) REFERENCES Team(Team_ID) ON UPDATE CASCADE,
	CONSTRAINT Roster_fk2
		FOREIGN KEY (StudentNo) REFERENCES Student(StudentNo) ON UPDATE CASCADE,
	CONSTRAINT Roster_fk3
		FOREIGN KEY (Point_Bonus) REFERENCES Point_Bonus(Point_Bonus) ON UPDATE CASCADE,
	CONSTRAINT Roster_fk4
		FOREIGN KEY (Point_Team) REFERENCES Point_Team(Point_Team) ON UPDATE CASCADE
	);
	
-- ------------------ SQL CONSTRAINT DATA --------------------

-- Constraint Checking Homeroom Values --
INSERT INTO Homeroom VALUES ( 'A', null ), ( 'B', null ), ( 'C', null ), ( 'D', null ), ( 'E', null ), ( 'F', null ), ( 'G', null ), ( 'H', null ), ( 'I', null ), ( 'J', null ), ( 'K', null ), ( 'L', null ), ( 'MA', 'French Immersion' ), ( 'MB', 'French Immersion' ), ( 'N', null ), ( 'O', null ), ( 'P', null ), ( 'Q', null ), ( 'R', null ), ( 'S', 'Summit' ), ( 'T', null ), ( 'U', null ), ( 'V', null ), ( 'X', 'Flex' ), ( 'Y', null ), ( 'Z', null );

-- Constraint Checking Sport Values --
INSERT INTO Sport VALUES ( 1, 'Badminton' ), ( 2, 'Basketball' ), ( 3, 'Dragon Boat' ), ( 4, 'Football' ), ( 5, 'Golf' ), ( 6, 'Ice Hockey' ), ( 7, 'Lacrosse' ), ( 8, 'Mountain Biking' ), ( 9, 'Rugby' ), ( 10, 'Soccer' ), ( 11, 'Softball' ), ( 12, 'Swimming' ), ( 13, 'Tennis' ), ( 14, 'Track & Field' ), ( 15, 'Ultimate' ), ( 16, 'Volleyball' ), ( 17, 'Wrestling' ), ( 18, 'X-Country' );

-- Constraint Checking Point_Award Values --
INSERT INTO Point_Award VALUES ( 30, 'Small T' ), ( 45, 'Big T' ), ( 60, 'Silver Medallion' ), ( 75, 'Gold Metallion' );

-- Constraint Checking Point_Team Values --
-- Newly Added in MySql
INSERT INTO Point_Team VALUES (0), (0.5), (1), (1.5), (2), (2.5), (3), (3.5), (4), (4.5), (5);

-- Constraint Checking Point_Bonus Values --
INSERT INTO Point_Bonus VALUES ( 0, 'No Bonus Points Awarded' ), ( 1, 'Awarded when Team plays in quarter-final or semi-final of the league.' ), ( 2, 'Awarded when Team wins City Championship.  Combined with previous.' ), ( 3, 'Awarded when Team makes BC Championships.  Combined with previous.' );

-- Constraint Checking Team_Division Values --
INSERT INTO Team_Division VALUES ( 'Bantam' ), ( 'Juvenile' ), ( 'Junior' ), ( 'Senior' ), ( 'All' );

-- ------------------ CREATE STORED PROCEDURES --------------------

DELIMITER $$

CREATE PROCEDURE GetLoggedInCoach
	(
	IN	p_Username		VARCHAR(20),
	OUT	CoachID			INT
	)
BEGIN
	SELECT Coach_ID INTO CoachID FROM Coach WHERE Username = p_Username;
END$$

CREATE PROCEDURE GetLoggedInStudent
	(
	IN	p_Username		VARCHAR(20),
	OUT	StuNo			VARCHAR(7)
	)
BEGIN
	SELECT StudentNo INTO StuNo FROM Student WHERE Username = p_Username;
END$$


CREATE PROCEDURE LoginLinkCoach
	(
	IN	p_Username		VARCHAR(20),
	IN	p_password		VARCHAR(255),
	IN	p_CoachID		INT,
	IN	p_CoachEmail	VARCHAR(250)
	)
BEGIN
	INSERT INTO UserAccess (Username, UserPW, UserGroup) VALUES (p_Username, p_password, 10);
	UPDATE Coach SET C_Email = p_CoachEmail, Username = p_Username WHERE Coach_ID = p_CoachID;
END$$

CREATE PROCEDURE LoginLinkStudent
	(
	IN p_Username			VARCHAR(20),
	IN p_password			VARCHAR(255),
	IN p_StudentNo			VARCHAR(7),
	IN p_StudentEmail		VARCHAR(250)
	)
BEGIN
	INSERT INTO UserAccess (Username, UserPW, UserGroup) VALUES (p_Username, p_password, 1);
	UPDATE Student SET S_Email = p_StudentEmail, Username = p_Username WHERE StudentNo = p_StudentNo;
END$$

CREATE PROCEDURE TeamAddNew
	(
	IN	p_CoachID			INT,
	IN	p_SeasonID			INT,
	IN	p_SportID			INT,
	IN	p_DivisionName		VARCHAR(12),
	IN	p_TeamSubset		VARCHAR(12),
	OUT	Team_ID				INT
	)
BEGIN
	IF p_TeamSubset = '' THEN SET p_TeamSubset = null; END IF;
	INSERT INTO Team VALUES (p_SeasonID, p_SportID, p_DivisionName, p_TeamSubset);
	SELECT LAST_INSERT_ID() INTO Team_ID;
	INSERT INTO Coach_Team VALUES (Team_ID, p_CoachID, (SELECT C_DefaultType FROM Coach WHERE Coach_ID = p_CoachID));
END$$

CREATE PROCEDURE ValidateCoachRecord
	(
	IN	p_CoachID	INT,
	IN	p_LastName	VARCHAR(30),
	IN	p_FirstName	VARCHAR(30),
	OUT Valid		TINYINT(1),
    OUT registered  TINYINT(1)
	)
BEGIN
	SELECT EXISTS(SELECT 1 FROM Coach WHERE Coach_ID = p_CoachID AND C_LastName = p_LastName AND C_FirstName = p_FirstName) INTO Valid;
    IF Valid THEN SELECT Username IS NOT NULL INTO registered FROM Coach WHERE Coach_ID = p_CoachID; END IF;
END$$

CREATE PROCEDURE ValidateStudentRecord
	(
	IN	p_StudentNo		INT,
	IN	p_LastName		VARCHAR(30),
	IN	p_FirstName		VARCHAR(30),
	OUT Valid			TINYINT(1),
    OUT registered      TINYINT(1)
	)
BEGIN
	SELECT EXISTS(SELECT 1 FROM Student WHERE StudentNo = p_StudentNo AND S_LastName = p_LastName AND S_FirstName = p_FirstName) INTO Valid;
    IF Valid THEN SELECT Username IS NOT NULL INTO registered FROM Student WHERE StudentNo = p_StudentNo; END IF;
END$$
DELIMITER ;