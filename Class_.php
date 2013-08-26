<?php 
class 
{ 
public function createRecord() 
 
{ 
$this->sql = "insert into 
"; 
$result= mysql_query($this->sql); 
       if(!mysql_error()== "") 
 {trigger_error("sql error" . $this->sql . mysql_error() ); 
 exit;}
 if(mysql_affected_rows()   == 0 ) 
 { trigger_error("action error"  . $this->sql . mysql_error()  );
 exit;} 
 
 
 } 

public function updateRecord() 
 

 { 
 $this->sql = "update 

 where  = \"$\""; 
$result= mysql_query($this->sql); 
       if(!mysql_error()== "") 
 {trigger_error("sql error" . $this->sql . mysql_error() ); 
 exit;}
 } 

public function retrieveRecord($)
{

  
 $this->sql = "select * from  where  = \"$\"" ;
$result= mysql_query($this->sql); 
       if(!mysql_error()== "") 
 {trigger_error("sql error" . $this->sql . mysql_error() ); 
 exit;}
 if(mysql_affected_rows()   == 0 ) 
 { trigger_error("action error"  . $this->sql . mysql_error()  );
 exit;}
 $row = mysql_fetch_assoc("$result");
 return $row;
 } 

public function deleteRecord($id) 
 {$this->sql = "delete  from  where  = \"$id\"";

$result= mysql_query($this->sql); 
       if(!mysql_error()== "") 
 {trigger_error("sql error" . $this->sql . mysql_error() ); 
 exit;}
 if(mysql_affected_rows()   == 0 ) 
 { trigger_error("action error"  . $this->sql . mysql_error()  );
 exit;}
 } 

public function getAllRecords()
 { 
$this->sql = "select * from "; 

$result= mysql_query($this->sql); 
       if(!mysql_error()== "") 
 {trigger_error("sql error" . $this->sql . mysql_error() ); 
 exit;}
 if(mysql_affected_rows()   == 0 ) 
 { trigger_error("action error"  . $this->sql . mysql_error()  );
 exit;}
 return $result;
 } 

} 
?> 