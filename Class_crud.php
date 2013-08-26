<?php

class crud
{
//
private $companyName;
private $dbname;
private $mysqlServer;
private $mysqlUserName;
private $mysqlPassword;
private $mysqlDatabase;
//
private  $table="dummy";
private $slash = "\\\""; // \" 
private $sql;
private  $keyfield; 
private $listSortByFieldPointer = 1;
private $listSortByFieldDirection = "ASCND"; 
private $checkMarkPicture = "../checkMark.jpg";
private $deleteMarkPicture = "../deleteMark.jpg";
private $sortAscendingPicture = "../sortAscending.jpg";
private $sortDescendingPicture = "../sortDescending.jpg";
private $sortPicture = "../sortMark.jpg";

public $action;
public $returnTo;


public $headerReturn;

public $values = array();
public $table_title=array();

public $tableTitle;
public $len;
public $maxFieldLength = 80;
public $field_default_array = array();
public $field_extra_array = array();
public $field_key_array = array();
public $field_null_array = array();
public $field_type_array = array();
public $values_array = array();
public $field_length_array = array();
public $field_name_array=array();


//_______________________________________________________________________________
private function connect()
{
require_once("crudPrivateSettings.php");
	$dbcnx = @mysql_connect($this->mysqlServer,$this->mysqlUserName, $this->mysqlPassword );
   
	if (!$dbcnx) {  
                      echo("<h1>Unable to connect to the database server at this time.</h1></p>");
		      echo("<P>For help, please send mail to the webmaster (webmaster@graynwhite.com), giving this error message and the time and date of the error.</p>"); 	
	           exit();
                      }
       //	 Select the cauleyfj  database
      	if (! @mysql_select_db($this->mysqlDatabase )) {
      		echo("<p> <h1>Unable to locate   database at this time. Try again later.</h1></p>");
		echo("<P>For help, please send mail to the webmaster (webmaster@graynwhite.com), giving this error message and the time and date of the error.</p>"); 
      		
		exit();
		}  
	} 

//_______________________________________________________________________________
public function setListSortByFieldPointer($pointer)
{
	$this->listSortByFieldPointer = $pointer;
}
public function getListSortByFieldPointer()
{
	return $this->listSortByFieldPointer;
}
//_______________________________________________________________________________

public function setTable($tableName)
{
	$this->table = $tableName;
}
//_______________________________________________________________________________
public function getTable()
{
	return $this->table;
}
//_______________________________________________________________________________
public function setListSortByFieldDirection($direction)
{
	$this->listSortByFieldDirection = $direction;
}
//_______________________________________________________________________________	
public function getListSortByFieldDirection()
{
	return $this->listSortByFieldDirection;
}
//_______________________________________________________________________________
public function resultStatement($affectedRows='true',$message='sql error',$message2='action error')
{
//echo "<br><br>affected Rows is " . $affectedRows ;
$returntext='';
$returntext .= "\n\$result= mysql_query(\$this->sql); \n ";
$returntext.= "      if(!mysql_error()== \"\") \n ";
$returntext .= "{trigger_error(\"$message\" . \$this->sql . mysql_error() ); \n exit;}";
if($affectedRows=='true')
{
$returntext .= "\n if(mysql_affected_rows()   == 0 ) \n { trigger_error(\"$message2\"  . \$this->sql . mysql_error()  );\n exit;}";
}
//echo "  return text is " . $returntext;
return $returntext;

}


//_______________________________________________________________________________
public function loadCrudArrays()
{
	crud::connect();
	$sql="SHOW COLUMNS FROM " . $this->table;
	$result= mysql_query($sql);
	if (!mysql_error()=="")
	{
		trigger_error("trouble with get column names " . $sql . " " . mysql_error());
	}
	
	while($row = mysql_fetch_assoc($result))
	 {
        //print_r($row);
		$this->field_name_array[]= $row['Field'];
		$this->field_type_array[] = $row['Type'];
		$this->field_null_array[] = $row['Null'];
		$this->field_key_array[] = $row['Key'];
		$this->field_extra_array[] = $row['Extra'];
		$this->field_default_array[] = $row['Default'];
		if($row['Key'] == 'PRI')
		{
			$this->keyfield = $row['Field'];
		}
		}
	}
//---------------------------------------------------------------------------------	
public function getfield_name_array()
{
	return $this->field_name_array();
}
//_______________________________________________________________________________
public function listRecords($sort_mode="ASCN")
{
$sql = "select * from " . $this->table . " order by " . $this->field_name_array[crud::getListSortByFieldPointer()];
if(crud::getListSortByFieldDirection() == 'DESC')
{
	$sql .= " DESC ";
}

$result = mysql_query($sql);
if(!mysql_error() == "")
{
 echo"trouble with sql " . mysql_error() . $sql ;
 exit;
}


while($row = mysql_fetch_array($result))
	{
	echo "<tr><td><a href=\"update.php?" . $this->keyfield . "=". $row[$this->keyfield] . "\"><img src= \"" . $this->checkMarkPicture ."\" alt='change'/></a></td><td><a href=\"delete.php?" . $this->keyfield . "=". $row[$this->keyfield] . "\"><img src=\"". $this->deleteMarkPicture. "\" alt='Delete' /></a></td>";
	for($i=0;$i< count($this->field_name_array);$i++)
		{
		echo "<td> $row[$i] </td>";
		}
		echo "</tr> \n";
	}
	
	//return "this is the results of listRecords";
	
}
//_______________________________________________________________________________
public function insertSortButton($ptr)
{	
	echo "<td >";
	if($ptr == crud::getListSortByFieldPointer())
		{
			if(crud::getListSortByFieldDirection() == "ASCND")
				{
					echo  "<a href=\"index.php?sortfield=" . $ptr . "&reverseSort=" . crud::getListSortByFieldDirection()."\"><img src=\"". $this->sortAscendingPicture . "\" align='center' alt= 'sort ascending'/></a>";
				}else
				{
					echo "<a href=\"index.php?sortfield=" . $ptr . "&reverseSort=". crud::getListSortByFieldDirection()."\"><img src=\"". $this->sortDescendingPicture . "\" alt='sort descending' /></a>";
				}
		}else
		{
			echo "<a href=\"index.php?sortfield=" .$ptr. "\"><img src=\"". $this->sortPicture . "\" alt='sort'/></a>";
		}
	echo "</td> ";

}
//_______________________________________________________________________________
public function constructListTable()
{
echo "<a href=\"create.php\"><input type=\"button\" value=\" Add A Record \"></a>";
echo "<table border=\"2\" width=\"100%\"> \n";
	echo "\n <tr><th>Change</th><th>Delete</th> ";
	for($i=0;$i<count($this->field_name_array);$i++)
	{
		echo "<th> ". $this->field_name_array[$i] . "</th> ";
	}
	echo "</tr> \n ";
	echo "\n <tr> <td>  </td><td>  </td>";
	for($i=0;$i<count($this->field_name_array);$i++)
	{
		crud::insertSortButton($i);
	}
	echo "</tr> \n ";
	
}
//_______________________________________________________________________________
public function generateArguments($includeKey=false,$prefixPost=false)
{
$returnText='';

for ($i=0;$i<count($this->field_name_array);$i++)
	{
		if(!$this->field_key_array[$i]== "PRI" || $includeKey==true)
		if ($prefixPost==false)
		{
		$returntext .= "$" . $this->field_name_array[$i] . ",";
		}else {
		$returntext .= "\$_POST['" . $this->field_name_array[$i] . "'] ,";
		}
		
	}
		$returntext = substr($returntext,0,strlen($returntext)-1); // get rid of last comma
		$returntext.= ") \n \n";
		return $returntext;
}
//_______________________________________________________________________________
public function generateSetFields($includeKey=false)
{
$returntxt='';
$field_set_count=0;
for ($i=0;$i<count($this->field_name_array);$i++)
				{
				if(!$this->field_key_array[$i]== "PRI" )
				{
				{if ($field_set_count ==0)
					{
						$returntext .= "set  ";
						
					}
					$returntext .= $this->field_name_array[$i] . "= ". $this->slash   ."$". $this->field_name_array[$i] . $this->slash . ", \n";
					$field_set_count ++;
				}			
				}
				}
		
	$returntext = substr($returntext,0,strlen($returntext)-3);
	$returntext .= "";

if($includeKey)
		{
			$returntext .= "\n where " . $this->keyfield . " = " . $this->slash . "\$" . $this->keyfield . $this->slash ;
		}
$returntext .= "\"; ";				
return $returntext;
}
//_______________________________________________________________________________
public function generateListFields($includeKey=false)
{
$returntxt='';
$field_set_count=0;
for ($i=0;$i<count($this->field_name_array);$i++)
				{
				$returntext .= "<td>\$row['" .$this->field_name_array[$i] . "<]'</td> \n";				
				}
	
return $returntext;
}

//_______________________________________________________________________________
public function generateClass()
{
$text = "<?php \n";
$text .= "class " . $this->table . "\n";
$text .= "{ \n";
$text .= "public function createRecord(";
$text .= crud::generateArguments();	
$text .= "{ \n";
$text .= "\$this->sql = \"insert into " . $this->table . "\n";
$text .= crud::generateSetFields();			
$text .= crud::resultstatement();				
$text .= " \n \n ";

$text .= "\n } \n\n";

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$text .= "public function updateRecord(";
$text .= crud::generateArguments(true);
$text .= "\n { \n \$this->sql = \"update " . $this->table . "\n";
$text .= crud::generateSetFields('true');	// include keyfield
$text .= crud::resultstatement('false'); // no affected field test
$text .= "\n } \n\n";
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$text .= "public function retrieveRecord(\$" . $this->keyfield . ")\n{\n";
$text .= "\n  \n \$this->sql = \"select * from " . $this->table .  " where " . $this->keyfield . " = " . $this->slash . "\$" . $this->keyfield . $this->slash . "\" ;";
$text .= crud::resultstatement();
$text .= "\n \$row = mysql_fetch_assoc(\"\$result\");";
$text .= "\n return \$row;";
$text .= "\n } \n\n";
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$text .= "public function deleteRecord(\$id) \n {";
$text .= "\$this->sql = \"delete  from " . $this->table .  " where " . $this->keyfield . " = " . $this->slash . "\$id" . $this->slash . "\";\n";
$text .= crud::resultstatement();
$text .= "\n } \n\n";
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$text .= "public function getAllRecords()\n { \n";
$text .= "\$this->sql = \"select * from " . $this->table . "\"; \n";
$text .= crud::resultstatement();
$text .= "\n return \$result;";
$text .= "\n } \n\n";
$text .= "} \n";
$text .= "?> ";
//print (\n 2br($text));

$classFile2 = fopen($_SERVER['DOCUMENT_ROOT']. "/crud/" . $this->table . "/Class_" . $this->table . ".php",'w') or die("cannot open class file");
	fwrite($classFile2,$text);
	fclose($classFile2);


}
//___________________________________________________________________________
public function generateListPhp()
{

//$listphp = fopen($_SERVER['DOCUMENT_ROOT']. "/_private/index.php",'w') or die("cannot open list records file");
$listphp = fopen($_SERVER['DOCUMENT_ROOT']. "/crud/". $this->table. "/index.php",'w') or die("cannot open list records file");
	$text = "<?php \n";
	$text .= "require_once(\"Class_" .$this->table . ".php\"); \n";
	$text .= "require_once(\"../Class_crud.php\");\n ";
	$this->action="list";
	$this->return_action= "./index.php";
	$text .= "\$crud = new crud; \n";
	$text .= "\$crud->setTable(\"" . $this->table . "\");\n";
	$text .= "\$crud->loadCrudArrays();\n";
	$text .= "if(isset(\$_GET['sortfield']))\n";
	$text .= "	{ \n";
	$text .= "	\$crud->setListSortByFieldPointer(\$_GET['sortfield']);\n";
	$text .= "	} \n";
	$text .= "if(isset(\$_GET['reverseSort'])) \n";
	$text .= "{ \n";
	$text .= "     if(\$_GET['reverseSort']=='DESC') \n";
	$text .= " {  \n";
	$text .= "		\$crud->setListSortByFieldDirection('ASCND'); \n";
	$text .= "       }else{ \n";
	$text .= "    	\$crud->setListSortByFieldDirection('DESC'); \n";
	$text .= " } \n";
   	$text .= "} \n";
	$text .= "?> <!--end php for now --> \n";
	$text .= crud::insertPageHeader();
	$text .= "<?PHP \n";
	$text .=  "\$crud->constructListTable();\n";
	$text .= "\$crud->listRecords();\n ";
	$text .= "?> \n";
	$text .= "</table></body></html>";
	fwrite($listphp,$text,4096);
	fclose($listphp);
}
//___________________________________________________________________________
public function generateCreatePhp()
{
$text = "<?php  \n";
$text .= "require_once(\"Class_" .$this->table . ".php\"); \n";
$text .= "require_once(\"../Class_crud.php\");\n ";
$text .= "\n \$crud = new crud;";
$text .= "\$crud->setTable(\"" . $this->table . "\"); \n";
$text .= "\$crud->loadCrudArrays(); \n";
$this->action = "Create";
$this->return_action = 'create.php';
$text .= "?> <!--end php for now --> \n";
$text .= crud::insertPageHeader();
$text .= "<?php  \n";
$text .= "if (isset(\$_POST['submit'])) \n";
$text .= "{ \n";
$text .= "\$" . $this->table . " = new " . $this->table . ";";
$text .= "\$" . $this->table . "->createRecord(" . crud::generatearguments(false,true);

$text .= "; \n } \n";
$text .= "?> <!--end of php for now-->\n";
$text .= "<form name=\"inputform\" method=\"post\" action=\"create.php\" />";

$text .= "\n";
	$text .=  "<table width=\"773\"  border=\"1\" ";
	$text .= "caption=\"<h2>  ". $this->action . " " .  strtoupper($this->table). "  Record</h2> \" /> \n";
//$text .= "<?php // back into php\n";	
	for($i=0;$i< count($this->field_name_array);$i++)
   
	 {
		
	if (!$this->field_key_array[$i] =="PRI")
	{ 
	$text .= crud::compose_Html_Line($this->field_name_array[$i],$this->field_type_array[$i],false);
	}      
    }
	$text .= "?>";
	$text .= "}";	
	$text .= "</table>\n";
	
	$text .= "<center><input type=\"submit\" name=\"submit\" value=\"submit "  .$this->action . "\"><input type =\"reset\" name=\"reset\" value=\"reset\"> <a href=\"index.php\"><input type=\"button\" value=\"finished\"></a></center>\n </form>";
	$text .= "</body> \n";
	$text .= "</html> ";
	

//print (nl2br($text));
$createphp = fopen($_SERVER['DOCUMENT_ROOT']. "/crud/" . $this->table . "/create.php",'w') or die("cannot open create record file");
	
	fwrite($createphp,$text,4096);
	fclose($createphp);
}
//___________________________________________________________________________
public function createHeader()
{
$return = "header(\"Location:" .$this->headerReturn . "\")";
//echo $return;
return $return;
}
//___________________________________________________________________________
public function generateUpdatePhp()
{
$updatephp = fopen($_SERVER['DOCUMENT_ROOT']. "/crud/" . $this->table . "/update.php",'w') or die("cannot open create record file");
$text = "<?php  \n";
$text .= "require_once(\"Class_" .$this->table . ".php\"); \n";
$text .= "require_once(\"../Class_crud.php\");\n ";
$text .= "\n \$crud = new crud;";
$text .= "\$crud->setTable(\"" . $this->table . "\"); \n";
$text .= "\$crud->loadCrudArrays(); \n";
$this->action = "Update";
$this->return_action = 'update.php';
$this->headerReturn = 'index.php';
$text .= "?> <!--end php for now --> \n";
$text .= "<?php  \n";
$text .= "if (isset(\$_POST['submit'])) \n";
$text .= "{ \n";
$text .= "\$" . $this->table . " =  new " . $this->table . "; \n";
$text .= "\$"  . $this->table . "->updateRecord(" . crud::generatearguments(true,true). ";\n";
$text .= crud::createHeader();
$text .= "; \n } else { \n";
$text .= "?> <!--end of php for now-->\n";
$text .= crud::insertPageHeader();
$text .= "<form name=\"inputform\" method=\"post\" action=\"update.php\" >";

$text .= "\">\n";
	$text .=  "<table width=\"773\"  border=\"1\" ";
	$text .= "caption = \"<h2>  ". $this->action . " " .  strtoupper($this->table). "  Record</h2>\"> \n";
$text .= "<?php // back into php\n";
$text .= "\$crud->getrecord(\$_GET['$this->keyfield']);\n";
$text .= "\$fields = \$crud->field_name_array;\n";
$text .= "\$type = \$crud->field_type_array; \n";
$text .= "\$field_count= count(\$fields); \n ";
$text .= "	for(\$i=0;\$i < \$field_count;\$i++) \n";
$text .= "	{";
$text .= "	\$line = \$crud->compose_Html_line(\$fields[\$i],\$type[\$i],\"true\");\n";
$text .= "	echo \$line;\n";
$text .= "	}	\n";
$text .= "?> \n";
$text .= "</table>\n";
$text .= "<center><input type=\"submit\" name=\"submit\" value=\"submit "  .$this->action . "\"><input type =\"reset\" name=\"reset\" value=\"reset\"> </center>\n </form>";
	$text .= "</body> \n";
	$text .= "<? } ?>";
	

	fwrite($updatephp,$text,4096);
	fclose($updatephp);

}

//___________________________________________________________________________
public function generateDeletePhp()
{
$deletephp = fopen($_SERVER['DOCUMENT_ROOT']. "/crud/" . $this->table . "/delete.php",'w') or die("cannot open delete record file");
	$text = "<?php  \n";
$text .= "require_once(\"Class_" .$this->table . ".php\"); \n";
$text .= "require_once(\"../Class_crud.php\");\n ";
$text .= "\n \$crud = new crud;";
$text .= "\$crud->setTable(\"" . $this->table . "\"); \n";
$text .= "\$crud->loadCrudArrays(); \n";
$this->action = "Delete";
$this->return_action = 'delete.php';
$this->headerReturn = 'index.php';
$text .= "?> <!--end php for now --> \n";
$text .= "<?php  \n";
$text .= "if (isset(\$_POST['submit'])) \n";
$text .= "{ \n";
$text .= "\$" . $this->table . " =  new " . $this->table . "; \n";
$text .= "\$"  . $this->table . "->deleteRecord(\$_POST['" . $this->keyfield . "']);\n";
$text .= crud::createHeader();
$text .= "; \n } else { \n";
$text .= "?> <!--end of php for now-->\n";
$text .= crud::insertPageHeader();
$text .= "<form name=\"inputform\" method=\"post\" action=\"delete.php\" />";

$text .= "\">\n";
	$text .=  "<table width=\"773\"  border=\"1\" ";
	$text .= "caption = \"<h2>  ". $this->action . " " .  strtoupper($this->table). "  Record</h2>\"> \n";
$text .= "<?php // back into php\n";
$text .= "\$crud->getrecord(\$_GET['$this->keyfield']);\n";
$text .= "\$fields = \$crud->field_name_array;\n";
$text .= "\$type = \$crud->field_type_array; \n";
$text .= "\$field_count= count(\$fields); \n ";
$text .= "	for(\$i=0;\$i < \$field_count;\$i++) \n";
$text .= "	{";
$text .= "	\$line = \$crud->compose_Html_line(\$fields[\$i],\$type[\$i],\"true\");\n";
$text .= "	echo \$line;\n";
$text .= "	}	\n";
$text .= "?> nl";
$text .= "</table>\n";
$text .= "<center><input type=\"submit\" name=\"submit\" value=\"submit "  .$this->action . "\"><input type =\"reset\" name=\"reset\" value=\"reset\"> </center>\n </form>";
	$text .= "</body> \n";
	$text .= "<? } ?>";
	
	fwrite($deletephp,$text,4096);
	fclose($deletephp);
}

//___________________________________________________________________________
function retrieveRecords()
{
$html = crud::showLogo();

$html .=  "<table class=\"tableStyle\" width=\"773\"  border=\"1\"\n";
	$html .= "<caption><h2> " . $this->action . ' ' .  strtoupper($this->table). "  Records</h2>";
	$html .= "<center><a href=\"". $this->process_script."?table=".$this->table."&action=Create\"><input type=\"button\" value=\"Add a new record\"></a></center>";
	  $html .= "</caption> \n";
	
	$html .= "<tr><th> Key </th><th> Description Field </th><th> Action</th></tr> \n";
	$this->result = crud::getAllrecords();
	while($row = mysql_fetch_assoc($this->result))
	{
	 $html .= "<tr><td> " . $row[$this->keyfield] . "</td><td>" . $row[$this->description_field[$this->table]] . "</td><td>" . "<a href=\"" .$this->process_script . "?table=".$this->table . "&action=Update&" .$this->keyfield."=".$row[$this->keyfield] ."\"> Update</a> | <a href=\"".$this->process_script. "?table=" . $this->table . "&action=Delete&". $this->keyfield. "=". $row[$this->keyfield] ."\" >Delete</a></td><tr>";
	}
	$html .= "</table>";
return $html;
}
//_____________________________________________________________________________________________
// end of retrieve record
//________________________________________________________________________
function echoField($field,$textarea=false)
{
$startPHP = "<? echo ";
$endPHP = "?>";
$openbracket = "['";
$closebracket = "']";

	if($textarea)
	{
	$returnValue =   $this->values[$field] ; 
	}else
	{
	$returnValue = " value=\"" .  $this->values[$field]  . "\" ";
	} 
return $returnValue;

}
//_________________________________________________________________________________
public function insertPageHeader()
{
$return = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"> \n";
$return .= "<html xmlns=\"http://www.w3.org/1999/xhtml\"> \n";
$return .= "<head> \n";
$return .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /> \n";
$return .= "<title>" . $this->action . " " . $this->table . " record</title> \n";
$return .= "<h2> " . $this->companyName . "MySql Table Control Generation System</h2>\n";
$return .= crud::showLogo();
$return .= "\n </head> \n";
$return .= "<body> \n ";
return $return;
}

//----------------------------------------------------------------------------------
function showLogo()
{
$return= "<img src=\"../companylogo.jpg\" alt=\"Gray and White Logo\" width=\"161\" height=\"80\" longdesc=\"  \" > ";
return $return;
}
//----------------------------------------------------------------------------------
function getrecord($id)
{
	$this->sql = "Select * from ". $this->table . " where " . $this->keyfield . " = " . "\"$id\"";
	//print "sql is " . $this->sql;
	$result = mysql_query($this->sql);
	if (mysql_error() != '')
	{
		echo "<p> error trying to update record " . $this->sql . " error is " . mysql_error();
		
	}
	$this->values= mysql_fetch_assoc($result);
	
	
	
	
}

//----------------------------------------------------------------------------------
function createForm($id)
{

crud::getRecord($id);

$html = crud::showLogo();


$html .= "<form name=\"inputform\" method=\"post\" action=\"" . $this->process_script . "?table=" . $this->table . "&action=replace";
$html .= "\">\n";



	$html .=  "<table class=\"tableStyle\" width=\"773\"  border=\"1\"\n";
	$html .= "<caption><h2> " . $this->action .  strtoupper($this->table). "  Record</h2> </caption> \n";
	
	for($i=0;$i< count($this->field_array);$i++)
   
	 {
		
	$html .= crud::compose_Html_Line($this->field_array[$i],$this->field_type_array[$i],True);
	
      
    }
	$html .= "</table>";
	
	$html .= "<center><input type=\"submit\" value=\"" .$this->action . "\"></center></form>";
	
	return $html;
	
	}
	


//________________________________________________________
function compose_Html_Line($field,$type,$value=false,$post=false)
{
	
	$type_array = explode('(',$type) ;
	//print_r($type_array);
				$len_array = explode(')',$type_array[1]);
				$this->len = $len_array[0]; 
				if ($this->len >$this->maxFieldLength)
				{
					$this->nolines=ceil(round($this->len/$this->maxFieldLength));
				}	
					
	$return="<tr><td>$field</td><td>";
	$line_type = $type_array[0];
	//print "<br> type is ". $line_type;
	//print "<br> length is " . $this->len . " max field length is " .$this->maxFieldLength;
	
	switch($line_type)
	{
		case 'int':
		case 'integer':
		case 'bigint':
		case 'date':
		case  'smallint' :
		case  'mediumint':
		case 'INT':
		case 'INTRGER':
		case 'BIGINT':
		case 'DATE':
		case  'SMALLINT' :
		case  'MEDIUMINT':
		case 'DATETIME':
		case 'datetime':
		
		
		$return .= "<input type=\"text\" size=\"24\" name=\"" .$field . "\"";
			if ($value==true)
			{
			$return .= crud::echoField($field,false);
			}
		
		break;
		
		case 'bit':
		case 'bool':
		case 'tinyint':
		case 'BIT':
		case 'BOOL':
		case 'TINYINT':
		
		
		$return .= "<input type=\"text\" size=\"2\" name=\"" .$field . "\"";
			if ($value==true)
			{
			$return .= crud::echoField($field,false);
			}
		
		break;
		
		case 'TEXT':
		case 'text':
		
			$this->nolines = ceil(256/$this->maxFieldLength);
			$return .= "<textarea rows=\"" . $this->nolines . "\" cols=\"". $this->maxFieldLength. "\" name=\"" . $field . "\"> "; 
			if ($value==true)
			{
			$return .= crud::echoField($field,true,$post);
			}
			$return .= "</textarea> \n";
			break;
			
		case 'varchar':
		
		
		if ($this->len > $this->maxFieldLength)
		{
			$this->nolines = ceil($this->len /$this->maxFieldLength);
			$return .= "<textarea rows=\"" . $this->nolines . "\" cols=\"". $this->maxFieldLength. "\" name=\"" . $field . "\"> ";
			if ($value==true)
			{
			$return .= crud::echoField($field,true,$post);
			}
			$return .= "</textarea> \n";
		}else{
		$return .= "<input type=\"text\" size=\"" . $this->len . "\" name=\"" .$field . "\"";
			if ($value)
			{
			$return .= crud::echoField($field,false,$post);
			}
			
			}
		break;
		
		
		default:
		{
		$return .= "<input type=\"text\" size=\"" . $this->len . "\" name=\"" .$field . "\"";
			if ($value)
			{
			$return .= crud::echoField($field);
			}
			
			}
			
		
		}
		$return .= "</td></tr>\n";	
		return $return;
		
	
}
//_________________________________________________________________________________________
function updateRecord($inArray)
{
$this->sqlCode= "update " . $this->table . " set ";
	while(list($key,$value) = each($this->field_array))
	{
	
	
	if($value == $this->keyfield )
		{ 
		}else{
		$this->sqlCode .= $value . " = \"" . $inArray[$value] . "\" ,";
		}
	}
	$this->sqlCode = substr($this->sqlCode,0,strlen($this->sqlCode)-1); // to get rid of last comma
	$this->sqlCode .= "where " . $this->keyfield . "= \"" . $inArray[$this->keyfield] . "\"";
	$result = mysql_query($this->sqlCode);
	if(mysql_error() != '') {
	echo "<br /> Record not updated " . $this->sqlCode . " " . mysql_error() ;
	}
	
}
//_________________________________________________________________________________________
function createRecord($inArray,$command)

{
	$postit= "$" . "_POST['";
	$this->sqlCode = $command . $this->table . " ( ";
	
	while(list($key,$value) = each($this->field_array))
	{
		//echo "<p> autoincrement is " . $this->autoincrement[$this->table];
		if($value == $this->keyfield and $this->autoincrement[$this->table]== 'yes')
		{ //echo "<p> value is " . $value . "and autoincrement is " .$this->autoincrement[$this->table];
		}else{
		$this->sqlCode .= $value ." ,";
		}
	}
	$this->sqlCode = substr($this->sqlCode,0,strlen($this->sqlCode)-1); // to get rid of last comma
	$this->sqlCode .= ") VALUES ( ";
	reset($this->field_array);
	
	while(list($key,$value) = each($this->field_array))
	{
		if($value == $this->keyfield and $this->autoincrement[$this->table]== 'yes')
		{
		}else{
			$a= $inArray[$value];
			$this->sqlCode .=   "\"" . $a . "\" ,";
		}
	}
	$this->sqlCode = substr($this->sqlCode,0,strlen($this->sqlCode)-1); // to get rid of last comma
	$this->sqlCode .= ") ";
	echo $this->sqlCode;
//	exit;
	
	$result = mysql_query($this->sqlCode);
	if (!$result) {
    	echo 'Could not run query: ' . mysql_error();
    	exit;
	}



}// end of create record	
//_____________________________________________________________________________
function deleteRecord($id)
{
	$thisSql = "delete from " . $this->table . " where " . $this->keyfield . " = \"" . $id . "\" ";
	$result = mysql_query($thisSql);
	if (mysql_error() != '')
	{
		$html = "<p> error trying to delete record " . $thisSql . " error is " . mysql_error();
		return $html;
	}
	$html = " Record deleted ";
	return $html;
	
		
}
// end of deleteRecord
//_______________________________________________________________________________





}// end of Class crud


?>
