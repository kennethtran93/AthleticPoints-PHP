###PHP Athletic Points System

*This was created for ACIT 2910 - Projects @ [BCIT - British Columbia Institute of Technology](http://www.bcit.ca)*

1. Kenneth Tran
2. Yoseph  Jo


--------------------------------------------


##### Installation Requirements:
* Webserver with Apache, MySQL, PHP

##### Installation Instructions

Simply extract all the files from the zip to the web root directory, or to a folder of your choosing inside the web root directory.


##### To initialize the database:
*The MySQL Database scripts are located in the folder `/_DB_SQL/` which should be at the top of the alphabetical listing.*
1. Run the `MySQL DB START.sql` script.  This contains the core items.  The database will be created in the process.
2. Run the `MySQL Sample Data.sql` script.  This contains the sample data used in the project.

##### To set the database connection configuration for the website:
1. Open the file `config.php` which is located inside the `phpinclude` folder.
2. Edit any configuration values (in the second set of quotes in each `define` line) as per your configuration.
