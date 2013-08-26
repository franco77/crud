<?php 
require_once("Class_.php"); 
require_once("../Class_crud.php");
 $crud = new crud; 
$crud->setTable("");
$crud->loadCrudArrays();
if(isset($_GET['sortfield']))
	{ 
	$crud->setListSortByFieldPointer($_GET['sortfield']);
	} 
if(isset($_GET['reverseSort'])) 
{ 
     if($_GET['reverseSort']=='DESC') 
 {  
		$crud->setListSortByFieldDirection('ASCND'); 
       }else{ 
    	$crud->setListSortByFieldDirection('DESC'); 
 } 
} 
?> <!--end php for now --> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>list  record</title> 
<h2> Gray and White Computing MySql Table Control Generation System</h2>
<img src="../companylogo.jpg" alt="Gray and White Logo" width="161" height="80" longdesc="  " > 
 </head> 
<body> 
 <?PHP 
$crud->constructListTable();
$crud->listRecords();
 ?> 
</table></body></html>