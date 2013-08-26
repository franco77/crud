<?php  
require_once("Class_.php"); 
require_once("../Class_crud.php");
 
 $crud = new crud;$crud->setTable(""); 
$crud->loadCrudArrays(); 
?> <!--end php for now --> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>Create  record</title> 
<h2> Gray and White Computing MySql Table Control Generation System</h2>
<img src="../companylogo.jpg" alt="Gray and White Logo" width="161" height="80" longdesc="  " > 
 </head> 
<body> 
 <?php  
if (isset($_POST['submit'])) 
{ 
$ = new ;$->createRecord() 
 
; 
 } 
?> <!--end of php for now-->
<form name="inputform" method="post" action="create.php" />
<table width="773"  border="1" caption="<h2>  Create   Record</h2> " /> 
?>}</table>
<center><input type="submit" name="submit" value="submit Create"><input type ="reset" name="reset" value="reset"> <a href="index.php"><input type="button" value="finished"></a></center>
 </form></body> 
</html> 