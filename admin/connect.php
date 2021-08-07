<?
  // connection to database;
  $db_name="mysql:host=localhost;dbname=shop";
  $user="root";
  $pass='';

  try {
      $con=new PDO($db_name,$user,$pass);
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
  }
  catch(Exception $e)
  {
          die('connection failed : '.$e->getMessage());  
          
  }
  



?>