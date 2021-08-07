<? 
 session_start();
 if(isset($_SESSION['username']))
 {
    header('location:dashboard.php');

 }
   require "init.php";
  
   // cheak the user
   if($_SERVER['REQUEST_METHOD']==='POST')
   {
      $username=$_POST['user'];
      $password=$_POST['password'];
      $hash_password=sha1($password);
     $stmt=$con->prepare('SELECT * from users where username=:username and password=:password and group_id=1');
    
     $stmt->bindParam(":username", $username);
     $stmt->bindParam(":password", $hash_password);
     $stmt->execute();
     $row=$stmt->fetch(PDO::FETCH_OBJ);
     if($stmt->rowCount())
     {
       $_SESSION['username']=$username;
       $_SESSION['id']=$row->user_ID;
       $_SESSION['fullname']=$row->fullname;

      
       header('location:dashboard.php');

     }else
     echo "nnnnnn";
     
   }



?>
 
<form action="<?=$_SERVER['PHP_SELF']?>" method ='post' class="login " >
   <h4 class="text-center">Login Admin</h4>
   <div class="form-group">
   <input type="text" name="user" id="user" placeholder="username"  class="form-control"></div>
   <input type="password" name="password" placeholder="password"  class="form-control">
   <input type="submit" value="submit" class="btn btn-primary btn-block " >
  
</form>

 


<? require $tpl."footer.php";?>