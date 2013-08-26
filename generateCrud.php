<?php


require_once("Class_crud.php");
$crud = new crud;
$crud->setTable($_GET['table']);
$crud->loadCrudArrays();
if (is-dir($_SERVER['DOCUMENT_ROOT']. "/crud/" .$_GET['table']))
{
	echo " The directory for " . $_GET['table'] . " is already established.";
}else
{
	@mkdir($_SERVER['DOCUMENT_ROOT'] . "/crud/" . $_GET['table']);
}

$crud->generateClass();
$crud->generateListPhp();
$crud->generateCreatePhp();
$crud->generateUpdatePhp();
$crud->generateDeletePhp();
echo "crud generated";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Generate Crud Sql and forms</title>
</head>

<body>
</body>
</html>
