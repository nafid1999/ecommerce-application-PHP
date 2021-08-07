<?
  session_start();
  if(isset($_SESSION['user']))
  {
     header('location:index.php');
 
  }
    require "init.php";
   
    // cheak the user
    if($_SERVER['REQUEST_METHOD']==='POST')
    { if(isset($_POST['login']))
        {
       $username=$_POST['username'];
       $password=$_POST['password'];
       $hash_password=sha1($password);
      $stmt=$con->prepare('SELECT * from users where username=:username and password=:password ');
     
      $stmt->bindParam(":username", $username);
      $stmt->bindParam(":password", $hash_password);
      $stmt->execute();
      $row=$stmt->fetch(PDO::FETCH_OBJ);
      if($stmt->rowCount())
      {
        $_SESSION['user']=$username;
        $_SESSION['id']=$row->user_ID;
        $_SESSION['fullname']=$row->fullname;
 
        header('location:index.php') ;
        exit;

      }else
         echo "nnn"; 
     }else{

        $errors=array();
        // check user name 
        if(isset($_POST['username']))
        {
            $username=filter_var($_POST['username'],FILTER_SANITIZE_STRING );
            if(strlen($username)<4)
            {
               $errors['username']="The username is too short";

            }else{
                if(checkUserForm('username',$username))
                {
                    $errors['username']='This username is already taken ! .';
                }
               
            }

        }
       
        if(isset($_POST['email']))
        {
            $email=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL );
            if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL ))
            {
               $errors['email']="This email is invalide !.";

            }else{
                if(checkUserForm("email",$email))
                {
                    $errors['username']='This email is already taken ! .';
                }
               
            }

        }
        $password="";
        if(empty(trim($_POST["password"]))){
            $errors['password'] = "Please enter a password.";     
        } elseif(strlen(trim($_POST["password"])) < 6){
            $errors['password'] = "Password must have atleast 6 characters.";
        } else{
            $password = trim($_POST["password"]);
        }
        
        // Validate confirm password
        if(empty(trim($_POST["confirm_password"]))){
            $errors['confirm_password']="Please confirm password.";     
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if( ($password != $confirm_password)){
                $confirm_password_err = "Password did not match.";
            }
        }

        if(empty($errors)){
        
            // Prepare an insert statement
            $sql = "INSERT INTO users (username,password,email,date) VALUES (:username, :password,:email,now()";
             
               $stmt = $con->prepare($sql);
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

                
                // Set parameters
                $param_username = $username;
                $param_password = sha1($password); 
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Redirect to login page
                    header("location: login.php");
                } else{
                    echo "Something went wrong. Please try again later.";
                }
    
                // Close statement
                unset($stmt);
            
        }
        
       

     }
    }
 
 
 
 ?>


  <div class="container login-page">
   <div class="wrapper ">
        <h1 class="text-center  "><span data-class="login" class="selected">Login</span> | <span data-class="singup" >Sing up</span></h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login" >
            <div class="form-group ">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" pattern=".{3,10}" title="The user name must contains more than 3 chars"  >
                <span class=" help-block userErr text-danger font-weight-bold"></span>

            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="type your password" required minlength="4">
                <span class="passwordErr text-danger font-weight-bold" style="color: red"></span>
            </div>
            <div class="form-group">
                 <input type="submit" class="btn btn-primary btn-block" value="Login" name="login"><br> <br><a href="forget_pass.php">forget password ?</a>
            </div> 
            <!-- <p>Don't have an account? <a href="register.php">Sign up now</a>.</p> -->
        </form>

        <!--========= Sing UP ============= -->

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class=" singup" >
                <div class="form-group ">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control user" placeholder="Username">
                    <small><span class=" help-block userErr text-danger font-weight-bold"><?=(!empty($errors['username']))?$errors['username']:''?></span></small>

                </div>   
    
                <div class="form-group">
                    <label>email</label>
                    <input type="text" name="email" class="form-control" value="" required placeholder="Email">
                    <small> <span class=" help-block userErr text-danger font-weight-bold"><?=(!empty($errors['email']))?$errors['email']:''?></span></small>

                </div>  
  
            <div class="form-group ">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="type password" required >
                <small> <span class=" help-block userErr text-danger font-weight-bold"><?=(!empty($errors['username']))?$errors["password"]:''?></span></small>

            </div>

            <div class="form-group ">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required placeholder="Confirm password" >
                <small> <span class=" help-block userErr text-danger font-weight-bold"><?=(!empty($errors['confirm_password']))?$errors['username']:''?></span></small>

            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Submit" name="singup">
                <input type="reset" class="btn btn-secondary" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
       </div>
    </div>
<?require $tpl."footer.php"?>