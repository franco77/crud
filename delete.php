<?php  
require_once("Class_.php"); 
require_once("../Class_crud.php");
 
$crud = new crud;
$crud->setTable(""); 
$crud->loadCrudArrays(); 
if (isset($_POST['submit'])) 
{ 
	$ =  new ; 
	$->deleteRecord($_POST['']);
	header("Location:index.php"); 
 } else { 
 }
?> <!--end of php for now-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>Delete  record</title> 
<h2> Gray and White Computing MySql Table Control Generation System</h2>
<img src="../companylogo.jpg" alt="Gray and White Logo" width="161" height="80" longdesc="  " > 
 </head> 
<body> 
 <form name="inputform" method="post" action="delete.php" />">
<table width="773"  border="1" caption = "<h2>  Delete   Record</h2>"> 
<?php // back into php
$crud->getrecord($_GET['']);
$fields = $crud->field_name_array;
$type = $crud->field_type_array; 
$field_count= count($fields); 
 	for($i=0;$i < $field_count;$i++) 
	{	$line = $crud->compose_Html_line($fields[$i],$type[$i],"true");
	echo $line;
	}	
?> nl</table>
<center><input type="submit" name="submit" value="submit Delete"><input type ="reset" name="reset" value="reset"> </center>
 </form></body> 
<? } ?>