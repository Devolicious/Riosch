<?php 
/** 
 * This sample service contains functions that illustrate typical
 * service operations. This code is for prototyping only. 
 *  
 *  Authenticate users before allowing them to call these methods. 
 */ 

class EmployeeService { 
  var $username = "root"; 
  var $password = ""; 
  var $server = "localhost"; 
  var $port = "3306"; 
  var $databasename = "dev_riosch"; 
  var $tablename = "people"; 
  
  var $connection; 
  public function __construct() { 
    $this->connection = mysqli_connect( 
                       $this->server,  
                       $this->username,  
                       $this->password, 
                       $this->databasename, 
                       $this->port 
                       ); 
    
    $this->throwExceptionOnError($this->connection); 
  } 

  public function getEmployees() {
     $stmt = mysqli_prepare($this->connection,
          "SELECT * FROM people");     
         
      $this->throwExceptionOnError();

      mysqli_stmt_execute($stmt);
      $this->throwExceptionOnError();

      $rows = array();
      mysqli_stmt_bind_result($stmt, $row->id, $row->sync,
                    $row->voornaam, $row->naam, $row->pic);

      while (mysqli_stmt_fetch($stmt)) {
          $rows[] = $row;
          $row = new stdClass();
          mysqli_stmt_bind_result($stmt,  $row->id, $row->sync,
                    $row->voornaam, $row->naam, $row->pic);
      }

      mysqli_stmt_free_result($stmt);
      mysqli_close($this->connection);

      return $rows;
  }  

  private function throwExceptionOnError($link = null) { 
    if($link == null) { 
      $link = $this->connection; 
    } 
    if(mysqli_error($link)) { 
      $msg = mysqli_errno($link) . ": " . mysqli_error($link); 
      throw new Exception('MySQL Error - '. $msg); 
    }         
  } 
} 
?>
