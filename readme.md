System Overview
==================
When developing internet applications, a lot of time is spent maintaining the various MySql database tables. Gray and White wrote this CRUD system about three years ago and it has been helpful in many applications. 

While developing the Virtual Cash Register system the Jtable Crud system was cloned from Github. That system had many features, including an attractive interface, that the Graynwhite system did not have . Conversely the Graynwhite crud system did generate the four crud files namely: Create, Retreive,Update and Delete.



Private settings
--------------------
A file entitled crudPrivateSettings.php must be created with the following entries:

- $this->companyName = "Your Company name ";
- $this->dbname="the db name you are using";
- $this->mysqlServer = "The server";
- $this->mysqlUserName = "username";
- $this->mysqlPassword = "password";
- $this->mysqlDatabase = "data base name";

How to use this system
----------------------

1. Setup a directory on your server and name it crud.
2. Pull the crud files into that directory.
3. Create a file crudPrivateSettings.php.
4. Execute the file /crud/generateCrud.php?table=xxxxx (xxxxx being the table name in the mysql database described in crudPrivateSettings.php.
5. generateCrud.php will create a subdirectory xxxxxx with the four crud files create.php, retreive.php, update.php and delete.php