-- Startup Sample Data
-- Delete all non-constraint data from all tables, in case of conflicts

DELETE FROM News;
DELETE FROM AdminProfile;
DELETE FROM useraccess;
DELETE FROM GroupRole;
DELETE FROM Roster;
DELETE FROM Coach_Team;
DELETE FROM Team;
DELETE FROM Season; -- It's a constraint, but will be modified per season.
DELETE FROM Student;
DELETE FROM Coach;


-- Reset Auto_increment values
ALTER TABLE News AUTO_INCREMENT = 1;
ALTER TABLE AdminPRofile AUTO_INCREMENT = 1;
ALTER TABLE Team AUTO_INCREMENT = 1;
ALTER TABLE Coach AUTO_INCREMENT = 1;

SET @@auto_increment_increment = 10;


-- Adding Group ROLES
INSERT INTO GroupRole VALUES (1, 'Student'), (10, 'Coach'), (90, 'Office'), (99, 'Admin');

-- Values for Admin user role Table
-- generate php password hash first!
INSERT INTO useraccess VALUES ('kenneth', '$2y$10$FO.tG9lRVUJheWgRSCORd.raCuMFRtW7RoWiFjcmOOOC4wb5bQfxG', 'Kenneth', 'Tran', '99', '1', '2015-05-01 00:00:00', NOW()), ('yoseph', '$2y$10$z3gpV/uhAwGTOW2YW3AQQ.1wWjCF//d.CXtDcbh7fNcxrWZZdf.oi', 'Yoseph', 'Jo', '99', '1', '2015-05-01 00:00:00', NOW());

-- Adding some news items.
INSERT INTO News ( NewsSubject, NewsBody, StartDate, EndDate, PublicView, StudentView, CoachView, AdminView ) VALUES ( 'Welcome!', 'This site has just been freshly created.  Data from your school will be implemented soon.<br /><br />This post is set to "disappear" in two weeks after the posted date.', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 2 WEEK), 1, 0, 0, 0 ), ( 'Visibility Test - Student', 'This post should only be visible to logged in students only.<br /><br />This post is set to "disappear" in two weeks after the posted date.', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 2 WEEK), 0, 1, 0, 0 ), ( 'Visibility Test - Coach', 'This post should only be visible to logged in coaches only.<br /><br />This post is set to "disappear" in two weeks after the posted date.', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 2 WEEK), 0, 0, 1, 0 ), ( 'Visibility Test - Admin', 'This post should only be visible to logged in Admins only.<br /><br />This post is set to "disappear" in two weeks after the posted date.', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 2 WEEK), 0, 0, 0, 1 ), ( 'Visibility Test - Student & Coach', 'This post should only be visible to logged in students AND coaches only.<br /><br />This post is set to "disappear" in two weeks after the posted date.', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 2 WEEK), 0, 1, 1, 0 );


-- Adding some Admin Contacts for the Contact Us Page.
INSERT INTO AdminProfile ( Name, Email, Phone, Notes, PublicDisplay, DisplayOrder ) VALUES ( 'Kenneth Tran', 'kenneth@SAM.school', '604-123-4567', 'A PHP-ported version of the site', 1, 1 ), ( 'Yoseph Jo', 'yoseph@SAM.school', '', 'Created as per ACIT2910 Projects', 1, 2 );


-- Values for HomeRoom table --
-- Refer to SQL MySQL DB START.sql - Constraint Data Section


-- Adding student credentials to the Student Table --
INSERT INTO Student (StudentNo, S_LastName, S_FirstName, Grade8Year, GradYear, Homeroom, Gender, S_BirthDate, S_Email, S_CellNumber, S_HomeNumber, PrevSchool, S_Notes) VALUES ( 123000, 'Mcgurk', 'Olin', 2011, 2016, 'A', 'Male', '1996-05-30', 'none@none.com', '6045974399', '7785206733', 'Somewhere School', null ), ( 123010, 'Amrhein', 'Luis', 2012, 2017, 'B', 'Male', '1996-08-04', 'none1@none.com', '6043168981', '6048054785', null, null ), ( 123020, 'Trafton', 'Mirtha', 2010, 2015, 'A', 'Female', '1997-04-16', 'none2@none.com', '6046043482', '7782752001', 'Somewhere School', null ), ( 123030, 'Mass', 'Harlan', 2008, 2013, 'B', 'Male', '1997-04-27', 'none3@none.com', '6048096858', '6046225780', 'Somewhere School', null ), ( 123040, 'Patenaude', 'Lashell', 2006, 2011, 'A', 'Female', '1997-07-10', 'none4@none.com', '6049014175', '7782859988', null, null ), ( 123050, 'Bresnahan', 'Leon', 2010, 2015, 'B', 'Male', '1997-08-08', 'none5@none.com', '6044689201', '6046629777', null, null ), ( 123060, 'Ferdinand', 'Dagny', 2009, 2014, 'C', 'Female', '1997-12-02', 'none6@none.com', '6044833909', '6046902002', 'Somewhere School', null ), ( 123070, 'Mcnemar', 'Lorilee', 2011, 2016, 'C', 'Female', '1998-04-10', 'none7@none.com', '7788023037', '7786091756', null, null ), ( 123080, 'Mccuin', 'Vi', 2012, 2017, 'D', 'Female', '1998-04-21', 'none8@none.com', '7781042719', '6042163183', 'Somewhere School', null ), ( 123090, 'Hocking', 'Karoline', 2014, 2019, 'D', 'Female', '1998-10-27', 'none9@none.com', '7788497702', '7782065313', 'Somewhere School', null ), ( 123100, 'Apperson', 'Magen', 2015, 2020, 'MA', 'Female', '1999-02-14', 'none10@none.com', '7787332691', '6044203414', null, null ), ( 123110, 'Ashburn', 'Andy', 2015, 2020, 'MB', 'Male', '1999-04-17', 'none11@none.com', '6043698740', '6043121084', 'Somewhere School', null ), ( 123120, 'Reuss', 'Robena', 2014, 2019, 'MA', 'Female', '1999-06-18', 'none12@none.com', '7786487702', '7786468464', 'Somewhere School', null ), ( 123130, 'Wallach', 'Tyesha', 2014, 2019, 'MB', 'Female', '2000-05-19', 'none13@none.com', '6047807778', '6042364448', null, null ), ( 123140, 'Arab', 'Lakeshia', 2014, 2019, 'A', 'Female', '2001-02-19', 'none14@none.com', '7783102174', '7788022979', 'Somewhere School', null ), ( 123150, 'Jim', 'Carie', 2103, 2108, 'A', 'Female', '2002-07-25', 'none15@none.com', '6044165096', '7788415414', null, null ), ( 123160, 'Scrivens', 'Mitchel', 2013, 2018, 'B', 'Male', '2002-08-23', 'none16@none.com', '7781683613', '7789293489', 'Somewhere School', null ), ( 123170, 'Casady', 'Rhoda', 2012, 2017, 'B', 'Female', '2002-11-05', 'none17@none.com', '6042297099', '6046048413', null, null ), ( 123180, 'Schillinger', 'Joel', 2012, 2017, 'E', 'Male', '2003-09-13', 'none18@none.com', '7786551845', '7788088371', null, null ), ( 123190, 'Boland', 'Guy', 2011, 2016, 'F', 'Male', '2003-12-08', 'none19@none.com', '6043613619', '6045213140', 'Somewhere School', null ), ( 123200, 'Cruze', 'Roseanna', 2010, 2015, 'D', 'Female', '2004-02-17', 'none20@none.com', '7784863751', '7781123847', null, null ), ( 123210, 'Snider', 'Herlinda', 2009, 2014, 'C', 'Female', '2004-07-04', 'none21@none.com', '6049418958', '6045008759', null, null ), ( 123220, 'Laymon', 'Melva', 2013, 2018, 'G', 'Female', '2005-03-15', 'none22@none.com', '7782413735', '7785396179', 'Somewhere School', null ), ( 123230, 'Reigle', 'Ocie', 2012, 2017, 'H', 'Male', '2005-04-25', 'none23@none.com', '6049282930', '6041722542', null, null ), ( 123240, 'Johannsen', 'Alice', 2012, 2017, 'D', 'Female', '2005-06-09', 'none24@none.com', '7785578904', '7788296764', 'Somewhere School', null );


-- Adding coach credentials to the Coach Table --
-- Coach Table has auto-increment for Coach_ID as it is DB internal use only.
INSERT INTO Coach ( C_DefaultType, C_LastName, C_FirstName, C_Email, C_HomeNumber, C_WorkNumber, C_WorkNumberExt, C_CellNumber, C_Notes ) VALUES ( 'VSB Teacher', 'Luis', 'Mirtha', 'none@none.com', null, '7785206733', '101', '7785774210', null ), ( 'Community', 'Theresa', 'Mother', 'hi@email.com', null, null, null, '6049876543', null ), ( 'VSB Sponsor', 'Ra', 'Nancy', 'nancy@ra.com', '6049998888', null, null, '7788888888', null );


-- Values for Sports table --
-- Refer to SQL MySQL DB START.sql - Constraint Data Section


-- Insert Seasons for season table --
INSERT INTO Season VALUES ( 201209, '2012 Fall' ), ( 201301, '2013 January' ), ( 201304, '2013 Spring' ), ( 201309, '2013 Fall' ), ( 201401, '2014 Winter' ), ( 201404, '2014 Spring' ), ( 201409, '2014 Fall' ), ( 201501, '2015 Winter' ), ( 201504, '2015 Spring' ), ( 201509, '2015 Fall' );


-- Values for Team Divison table --
-- Refer to SQL MySQL DB START.sql - Constraint Data Section


-- Adding teams to the Teams Table --
-- Team Table has auto-increment for Team_ID (DB Internal Use).  
INSERT INTO Team ( Season_ID, Sport_ID, DivisionName, TeamSubset ) VALUES ( 201404, 13, 'All', null ), ( 201404, 3, 'All', null ), ( 201404, 2, 'Bantam', null ), ( 201404, 12, 'All', null ), ( 201409, 5, 'All', null ), ( 201409, 18, 'All', null ), ( 201409, 14, 'All', null ), ( 201409, 16, 'Senior', 'Gold' );


-- Adding values to Coach_Team table - Links multiple coaches to a team. --
INSERT INTO Coach_Team VALUES ( 1, 11, 'Community' ), ( 21, 21, 'VSB Teacher' ), ( 11, 1, 'VSB Teacher' ), ( 31, 1, 'VSB Teacher' ), ( 11, 21, 'VSB Sponsor' ), ( 1, 1, 'VSB Sponsor' ), ( 41, 1, 'VSB Teacher' ), ( 51, 11, 'Community' ), ( 51, 21, 'VSB Sponsor' ), ( 61, 11, 'Community' ), ( 61, 1, 'VSB Sponsor' ), ( 71, 11, 'Community' );


-- Values for Point Team TABLE --
-- Refer to SQL MySQL DB START.sql - Constraint Data Section


-- Values for Point Bonus Table --
-- Refer to SQL MySQL DB START.sql - Constraint Data Section


-- Values for Point Award Table --
-- Refer to SQL MySQL DB START.sql - Constraint Data Section


-- Adding master team roster data into Roster table --
INSERT INTO Roster VALUES ( 41, 123200, 0, 1, 1, 1, 40, null, 0, 0, 2 ), ( 51, 123230, 0, 1, 1, 1, 50, null, 0, 5, 2 ), ( 21, 123120, 0, 1, 1, 1, 40, 13, 1, 3, 2 ), ( 11, 123170, 0, 1, 1, 1, 50, null, 0, 0, 2 ), ( 71, 123180, 0, 1, 1, 1, 40, 7, 1, 0, 2 ), ( 11, 123040, 1, 1, 1, 1, 25, null, 0, 0, 2 ), ( 31, 123130, 0, 1, 1, 1, 50, null, 0, 1, 2 ), ( 21, 123010, 0, 1, 1, 1, 25, 25, 1, 1, 2 ), ( 21, 123090, 0, 1, 1, 1, 25, 15, 0, 1, 2 ), ( 71, 123200, 0, 1, 1, 1, 50, 28, 1, 2, 2 ), ( 1, 123200, 1, 1, 1, 1, 40, null, 0, 4, 2 ), ( 1, 123140, 0, 1, 1, 1, 40, null, 0, 3, 2 ), ( 61, 123020, 0, 1, 1, 1, 25, null, 0, 3, 2 ), ( 41, 123110, 0, 1, 1, 1, 25, null, 0, 0, 2 ), ( 31, 123190, 0, 1, 1, 1, 50, null, 0, 5, 2 ), ( 1, 123230, 0, 1, 1, 1, 50, null, 0, 2, 3 ), ( 11, 123010, 0, 1, 1, 1, 40, null, 0, 3, 3 ), ( 51, 123140, 0, 1, 1, 1, 40, null, 0, 5, 3 ), ( 61, 123010, 0, 1, 1, 1, 25, null, 0, 2, 3 ), ( 51, 123190, 0, 1, 1, 1, 40, null, 0, 0, 3 ), ( 41, 123060, 0, 1, 1, 1, 50, null, 0, 2, 3 ), ( 11, 123200, 0, 1, 1, 1, 40, null, 0, 5, 3 ), ( 21, 123000, 1, 1, 1, 1, 40, 35, 1, 3, 3 ), ( 11, 123030, 0, 1, 1, 1, 40, null, 0, 4, 3 ), ( 51, 123060, 1, 1, 1, 1, 40, null, 0, 1, 3 ), ( 51, 123000, 0, 1, 1, 1, 40, null, 0, 5, 3 ), ( 41, 123100, 0, 1, 1, 1, 25, null, 0, 4, 3 ), ( 1, 123010, 0, 1, 1, 1, 40, null, 0, 4, 3 ), ( 11, 123210, 0, 1, 1, 1, 50, null, 0, 3, 3 ), ( 1, 123120, 0, 1, 1, 1, 50, null, 0, 2, 3 ), ( 1, 123110, 0, 1, 1, 1, 40, null, 0, 0, 1 ), ( 11, 123090, 0, 1, 1, 1, 40, null, 0, 2, 1 ), ( 61, 123030, 0, 1, 1, 1, 25, null, 0, 2, 1 ), ( 51, 123020, 1, 1, 1, 1, 50, null, 0, 5, 1 ), ( 61, 123170, 1, 1, 1, 1, 40, null, 0, 5, 1 ), ( 11, 123120, 0, 1, 1, 1, 50, null, 0, 5, 1 ), ( 71, 123010, 0, 1, 1, 1, 50, 35, 1, 1, 1 ), ( 51, 123030, 1, 1, 1, 1, 50, null, 0, 4, 1 ), ( 31, 123230, 1, 1, 1, 1, 40, null, 0, 4, 1 ), ( 31, 123100, 0, 1, 1, 1, 50, null, 0, 0, 1 ), ( 11, 123230, 0, 1, 1, 1, 25, null, 0, 2, 1 ), ( 21, 123210, 0, 1, 1, 1, 40, 27, 1, 1, 1 ), ( 21, 123180, 0, 1, 1, 1, 40, 38, 0, 1, 1 ), ( 51, 123040, 0, 1, 1, 1, 50, null, 0, 2, 1 ), ( 31, 123220, 0, 1, 1, 1, 40, null, 0, 4, 0 ), ( 31, 123240, 0, 1, 1, 1, 50, null, 0, 4, 0 ), ( 71, 123030, 0, 1, 1, 1, 40, 18, 1, 0, 0 ), ( 21, 123160, 0, 1, 1, 1, 25, 29, 1, 4, 0 ), ( 11, 123110, 0, 1, 1, 1, 25, null, 0, 1, 0 ), ( 41, 123080, 1, 1, 1, 1, 50, null, 0, 0, 0 ), ( 61, 123070, 0, 1, 1, 1, 40, null, 0, 5, 0 ), ( 51, 123210, 0, 1, 1, 1, 25, null, 0, 3, 0 ), ( 61, 123210, 0, 1, 1, 1, 50, null, 0, 1, 0 ), ( 1, 123080, 0, 1, 1, 1, 40, null, 0, 4, 0 ), ( 71, 123220, 0, 1, 1, 1, 40, 49, 1, 3, 0 ), ( 51, 123170, 0, 1, 1, 1, 40, null, 0, 1, 0 ), ( 31, 123070, 0, 1, 1, 1, 50, null, 0, 4, 1 ), ( 51, 123150, 0, 1, 1, 1, 40, null, 0, 4, 1 ), ( 1, 123050, 0, 1, 1, 1, 40, null, 0, 2, 1 ), ( 1, 123020, 0, 1, 1, 1, 50, null, 0, 0, 1 ), ( 11, 123130, 0, 1, 1, 1, 40, null, 0, 4, 1 ), ( 41, 123170, 0, 1, 1, 1, 50, null, 0, 2, 1 ), ( 71, 123020, 1, 1, 1, 1, 25, 16, 0, 3, 1 ), ( 31, 123080, 0, 1, 1, 1, 25, null, 0, 4, 1 ), ( 61, 123080, 0, 1, 1, 1, 25, null, 0, 5, 1 ), ( 21, 123190, 0, 1, 1, 1, 50, 43, 0, 5, 1 ), ( 51, 123130, 0, 1, 1, 1, 25, null, 0, 2, 1 ), ( 1, 123130, 0, 1, 1, 1, 50, null, 0, 4, 1 ), ( 71, 123140, 0, 1, 1, 1, 25, 22, 0, 3, 3 ), ( 41, 123150, 0, 1, 1, 1, 50, null, 0, 3, 3 ), ( 21, 123030, 0, 1, 1, 1, 25, 34, 1, 3, 3 ), ( 21, 123200, 0, 1, 1, 1, 40, 6, 1, 0, 3 ), ( 31, 123020, 0, 1, 1, 1, 25, null, 0, 2, 3 ), ( 41, 123010, 0, 1, 1, 1, 50, null, 0, 2, 3 ), ( 41, 123020, 0, 1, 1, 1, 25, null, 0, 0, 3 ), ( 71, 123240, 0, 1, 1, 1, 50, 9, 0, 4, 3 ), ( 71, 123120, 0, 1, 1, 1, 50, 8, 1, 1, 3 ), ( 1, 123090, 0, 1, 1, 1, 40, null, 0, 3, 3 ), ( 61, 123230, 0, 1, 1, 1, 50, null, 0, 1, 3 ), ( 1, 123150, 0, 1, 1, 1, 25, null, 0, 0, 3 ), ( 31, 123200, 0, 1, 1, 1, 25, null, 0, 2, 3 ), ( 21, 123240, 0, 1, 1, 1, 25, 28, 0, 2, 3 ), ( 1, 123160, 0, 1, 1, 1, 50, null, 0, 5, 2 ), ( 1, 123030, 0, 1, 1, 1, 25, null, 0, 0, 2 ), ( 11, 123160, 0, 1, 1, 1, 25, null, 0, 1, 2 ), ( 51, 123200, 0, 1, 1, 1, 40, null, 0, 3, 2 ), ( 11, 123100, 0, 1, 1, 1, 50, null, 0, 2, 2 ), ( 21, 123100, 0, 1, 1, 1, 40, 3, 1, 2, 2 ), ( 21, 123020, 0, 1, 1, 1, 25, 18, 0, 1, 2 ), ( 41, 123000, 0, 1, 1, 1, 40, null, 0, 2, 2 ), ( 51, 123220, 0, 1, 1, 1, 25, null, 0, 3, 3 ), ( 11, 123220, 0, 1, 1, 1, 50, null, 0, 5, 3 ), ( 21, 123220, 0, 1, 1, 1, 50, 49, 1, 3, 3 ), ( 11, 123150, 0, 1, 1, 1, 25, null, 0, 3, 3 ), ( 31, 123060, 0, 1, 1, 1, 25, null, 0, 2, 3 ), ( 1, 123060, 0, 1, 1, 1, 25, null, 0, 5, 3 ), ( 71, 123000, 1, 1, 1, 1, 25, 5, 0, 0, 3 ), ( 41, 123090, 0, 1, 1, 1, 40, null, 0, 2, 3 ), ( 41, 123140, 0, 1, 1, 1, 40, null, 0, 4, 3 ), ( 31, 123050, 0, 1, 1, 1, 25, null, 0, 4, 3 );


-- Values for StudentLogin Table --
-- Cannot be inserted here - must be manually registered using the site's registration form!


-- Values for CoachLogin Table --
-- Cannot be inserted here - must be manually registered using the site's registration form!