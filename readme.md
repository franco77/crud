System Overview
==================
When developing internet applications, a lot of time is spent maintaining the various MySql database tables. Gray and White wrote this CRUD system about three yeas ago and it has been helpful in many applications. 

While developing the Virtual Cash Register system the Jtable Crud system was cloned from Github. That system had many features, including an attractive interface, that the Graynwhite system did not have . Conversely the Graynwhite crud system did generate the four crud files namely: Create, Retreive,Update and Delete.



Private settings
--------------------
A file entitled crudPrivateSettings.php must be created with the following entries:

- $this->companyName = "Your Company name ";
- $this->dbname="the db name you are using";
- $this->mysqlServer = "The server";
- $this->mysqlUserName = "usernam";
- $this->mysqlPassword = "password";
- $this->mysqlDatabase = "data base name";