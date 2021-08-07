<?php 
  ob_start();
  session_start();
  $no_navbar='';
  if(isset($_SESSION['username'])  and isset($_SESSION['id']))
{   
        require_once "init.php"; 
        require_once  "includes/functions/function.php";

        $go=isset($_GET['go']) ? $_GET['go']: 'manage';
    
      if($go=='manage')
     {   // manage page?>
         <div class="container">
            <h1 class="text-center">Manage members</h1>
            <div class="table-responsive">
            <table class=" main-table table table-bordered text-center my-2">
               <thead class="">
                <tr>
                  <th>#ID</th>
                  <th>Full name</th>
                  <th>Username</th>
                  <th>email</th>
                  <th>Registred date</th>
                 <th>Control</th>
               </tr>
              </thead>

              <?php 
              $query='';
              if(isset($_GET['page']) and $_GET['page']='pending'){$query="and regstatus= 0";}
               $sql = "SELECT * FROM users where group_id !=1 $query ";
               $stmt = $con->prepare($sql);
               // Bind variables to the prepared statement as parameters
               $stmt->execute(); 
             
              while($row=$stmt->fetch(PDO::FETCH_OBJ)) {?>
              <tr>
                <td><?=$row->user_ID?></td>
                <td><?=$row->fullname?></td>
                <td><?=$row->username?></td>
                <td><?=$row->email?></td>
                <td><?=$row->date?></td>
                <td>
                  <a href="?go=edit&id=<?=$row->user_ID?>" class="btn btn-warning  my-2 "><i class="fa fa-edit"></i>Edit</a>
                  <a href="?go=delete&id=<?=$row->user_ID?>" class="btn btn-danger confirm"><i class="fa fa-trash"></i> Delete</a>
                  <?if($row->regstatus==0) :?>
                    <a href="?go=activate&id=<?=$row->user_ID?>" class="btn btn-success confirm"><i class="fa fa-trash"></i>Activate</a>
                 <?endif?>
                </td>
              </tr>
           <?php }?>
            
          </table>


        </div>
        <a href="members.php?go=add" class="btn btn-primary"> <i class="fa fa-plus"></i> Add new  members</a>
     
     </div>
    
    
 <?php }elseif($go=='add')
       {    // add members                   ?>  
          <h1 class="text-center my-2 text-lg" >Add new member</h1>

           <div class="container col-md-6" >

         <form action="?go=insert" class="form-horisontal " method='POST'>
           <!-- hidden data  -->
          

          <div class="form-group col-sm-7 col-md-8 ">
           <label for="" class="col-form-label">User name :</label>
           <input type="text" name="username"  class=" form-control" required='required' placeholder="Username">  
          </div>
          
          <div class="form-group col-sm-7 col-md-8">
           <label for="" class="col-form-label">Email :</label>
           <input type="email" name="email"  class=" form-control" required='required' placeholder="Email">  
          </div>

          <div class="form-group col-sm-7 col-md-8">
           <label for="" class="col-form-label">Password :</label>
           <input type="password" name="password" class="password form-control" placeholder="password" required ='required'>  
          </div>
          <div class="form-group col-sm-7 col-md-8">
           <label for="" class=" control-label"> Confirm Password :</label>
           <input type="password" name="confirm-password" class="password form-control" placeholder=" Confirm password" required ='required'>  
          </div>

          <div class="form-group col-sm-7 col-md-8">
           <label for="" class=" control-label">full name:</label>
           <input type="text" name="name" class="form-control" required='required' placeholder="Full name">  
          </div>

          <div class="form-group ">
           
           <input type="submit" name="valider" class=" btn btn-primary col-sm-3 col-md-3 btn-lg " value="save" style="margin:  auto;">  
          </div>

        </form>  
        </div>  

 <?php  }
 
   elseif($go=='insert')
    {
      if($_SERVER['REQUEST_METHOD']=='POST')
     {
      echo "<h1 class='text-center my-2 text-lg' >Insert members</h1> ";
      
      echo "<div class='container update' style='margin-top: 100px '> ";

      // get variable from the form
      $username=trim($_POST['username']);
      $fullname=trim($_POST['name']);
      $email=trim($_POST['email']);
      $password=trim($_POST['password']);
      $confirm_password=trim($_POST['confirm-password']);
      $hash_pass=sha1($password);

      // validate data form
      $error= array();
      // validate username
      if(empty($username)){ $error[]="username must not be empty .";}
      if(strlen($username)<4 and strlen($username)>20) { $error[]="name should contains more than 4 caracters and less than 20 caracters";}
      else{ 
          // Prepare a select statement
              $sql = "SELECT user_ID FROM users WHERE username = :username";
              $stmt = $con->prepare($sql);
              // Bind variables to the prepared statement as parameters
              $stmt->bindParam(":username", $username);
              $stmt->execute();
              $stmt->fetch(PDO::FETCH_OBJ);

              if($stmt->rowCount() == 1)
              $error[]='This username is already taken.';
             
              unset($stmt);
           
      }
      // validate email
      if(empty($email)){ $error[]="You have to enter the email .";}
      if(!filter_var($email,FILTER_VALIDATE_EMAIL)){ $error[]=" invalide email !. ";}
      else{ 
        // Prepare a select statement
            $sql = "SELECT user_ID FROM users WHERE email = :email";
            $stmt = $con->prepare($sql);
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if($stmt->rowCount() == 1)
            $error[]='This email is already taken.';
           
            unset($stmt);
         
    }
      //validate full name
      if(empty($fullname)){ $error[]="the full name must not be empty .";}
      if(strlen($username)<4 and strlen($username)>20){ $error[]="name should contains more than 4 caracters and less than 20 caracters";}
      // validate password
      if(strlen($password)<6){ $error[]="the password must contains more than 6 caracters";}
      if($password!=$confirm_password){ $error[]="password does not match";}

       foreach($error as $val)
       {  if($val==null) continue;
           echo "<div class='alert alert-danger'>". $val."</div>";
       }

        if(empty($error))
       { 
       // update in the data base
       
        $stmt=$con->prepare('INSERT into users  (username,password,email,fullname,regstatus,date ) values(:username,:password,:email,:fullname,1,now())');
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hash_pass);
        $stmt->bindParam(":email",$email);
        $stmt->bindParam(":fullname", $fullname);
        $stmt->execute();
        $message= "<div class='alert alert-success'> The member was addes succesfully .</div>";
        redirect($message,'back');
    
      }
      echo "</div> ";


   }else {
      $message= "<div class='alert alert-danger'> you can not acces this page directly.</div>";

      redirect($message);}
   
    }
   
   elseif($go=='edit')
    {  
      /*---------Edit Page-----------*/ 
      $userid=isset($_GET['id']) && is_numeric($_GET['id'])?$_GET['id']:0;
      $stmt=$con->prepare('SELECT * from users where user_ID=:user_ID');
      $stmt->bindParam(":user_ID", $userid);
      $stmt->execute();
      $row=$stmt->fetch(PDO::FETCH_OBJ);

       if($stmt->rowCount())
       {   ?>  

        <div class="container col-md-6" >
        <h1 class="text-center my-2 text-lg" >Edit members</h1>

         <form action="?go=update" class="form-horisontal " method='POST'>
           <!-- hidden data  -->
           <input type="hidden" name="userid" value="<?=$row->user_ID?>">
           <input type="hidden" name="oldpassword" value="<?=$row->password?>">

          <div class="form-group  col-sm-7 col-md-8">
           <label for="" class="col-form-label">User name :</label>
           <input type="text" name="username" value="<?=$row->username?>" class=" form-control" required='required'>  
          </div>
          
          <div class="form-group col-sm-7 col-md-8">
           <label for="" class=" control-label">Email :</label>
           <input type="email" name="email" value="<?=$row->email?>" class=" form-control" required='required'>  
          </div>

          <div class="form-group col-sm-7 col-md-8">
           <label for="" class=" control-label">Password :</label>
           <input type="password" name="password" class=" form-control" placeholder="it's not necessary">  
          </div>

          <div class="form-group col-sm-7 col-md-8">
           <label for="" class=" control-label">full name:</label>
           <input type="text" name="name" value="<?=$row->fullname?>"class=" form-control" required='required'>  
          </div>

          <div class="form-group ">
           
           <input type="submit" name="valider" class=" btn btn-info " value="Edit infos" >  
          </div>

        </form>  
        </div>   


  <?php }else echo "there is no such id";

 }elseif($go=="update")
  {                       

   if($_SERVER['REQUEST_METHOD']=='POST')
   {
      echo "<h1 class='text-center my-2 text-lg' >Update members</h1> ";
      
      echo "<div class='container update' style='margin-top: 100px '> ";

      // get variable from the form
      $username=trim($_POST['username']);
      $fullname=trim($_POST['name']);
      $email=trim($_POST['email']);
      $id=trim($_POST['userid']);
   
      $pass=empty($_POST['password'])?$_POST['oldpassword']:sha1($_POST['password']);

      // validate data form
      $error= array();
      // validate username
      if(empty($username)){ $error[]="<div class='alert alert-danger' id='naf'>username must not be empty .</div>";}
      if(strlen($username)<4 and strlen($username)>20) { $error[]="<div class='alert alert-danger' >name should contains more than 4 caracters and less than 20 caracters</div>";}
      // validate email
      if(empty($email)){ $error[]="<div class='alert alert-danger'>You have to enter the email .</div>";}
      if(!filter_var($email,FILTER_VALIDATE_EMAIL)){ $error[]="<div class='alert alert-danger'>invalide email !. .</div>";}
      //validate full name
      if(empty($fullname)){ $error[]="<div class='alert alert-danger '>the full name must not be empty .</div>";}
      if(strlen($username)<4 and strlen($username)>20){ $error[]="<div class='alert alert-danger'>name should contains more than 4 caracters and less than 20 caracters</div>";}

       foreach($error as $val)
       {
           echo $val;
       }

      if(empty($error))
      {
        if(cheakItem('username','users',$username))
        {
          echo "<div class='alert alert-danger '>this username already taken</div>";
        }else{
       // update in the data base
            $stmt=$con->prepare('UPDATE users set  username=:username ,fullname=:fullname,email=:email, password=:password  where user_ID=:user_ID');

           $stmt->bindParam(":username", $username);
           $stmt->bindParam(":fullname", $fullname);
           $stmt->bindParam(":email", $email);
           $stmt->bindParam(":password", $pass);
           $stmt->bindParam(":user_ID", $id);
           $stmt->execute();
       }
    }
      echo "</div> ";


     }else redirect('page not found !');

    
  }elseif($go=='delete')
   {
    $userid=isset($_GET['id']) && is_numeric($_GET['id'])?$_GET['id']:0;
    $stmt=$con->prepare('SELECT * from users where user_ID=:user_ID');
    $stmt->bindParam(":user_ID", $userid);
    $stmt->execute();
    $row=$stmt->fetch(PDO::FETCH_OBJ);
    echo "<div class='container  '> ";
    echo "<h1 class='text-center my-2 text-lg' >Delete member</h1> ";
    if($stmt->rowCount())
    {  
      $stmt=$con->prepare('DELETE from users where user_ID=:user_ID');
      $stmt->bindParam(":user_ID", $userid);
      $stmt->execute();  
      $message="<div class='alert alert-success'>The memeber has been deleted successfully</div>";
      redirect($message,'back');
         
    
    }else   echo "<div class='alert alert-warning'>This member does not exist</div>";
       echo "<div/> ";
 }elseif($go='activate')
   {
    $userid=isset($_GET['id']) && is_numeric($_GET['id'])?$_GET['id']:0;
    $chek=cheakItem('user_ID','users',$userid);
    echo "<div class='container  '> ";
    echo "<h1 class='text-center my-2 text-lg' >Activate member</h1> ";
    if($chek)
    {  

      $stmt=$con->prepare('UPDATE users set  regstatus=1 where user_ID=:user_ID ');
      $stmt->bindParam(":user_ID", $userid);
      $stmt->execute();  
     
        $message="<div class='alert alert-success'>The memeber has been activated successfully</div>";
         redirect($message,'back');
         
    
    }else   echo "<div class='alert alert-warning'>This member does not exist</div>";
       echo "<div/> ";
   }
    require $tpl."footer.php";
  
}
  else  echo "hhhh";
   ob_end_flush();
  ?>