<?
 session_start();
 $title="Profile";

 require "init.php";?>
 <?if(isset($_SESSION['user'])) :?>
    
    <?
        //  fetch infos from data base
        $stm=$con->prepare('SELECT * from users where username=:username');
        $stm->execute(array("username"=>$_SESSION['user']));
        $row=$stm->fetch(PDO::FETCH_OBJ);

    ?>
  
 <div class="Items block">
    <div class="container">
        <div class="card border-dark  ">
            <div class="card-header bg-warning text-white ">  <span>My ads</span> <i class="fa fa-minus float-right toggle"></i></div>
             
            <div class="card-body ">
             <div class="row">
           
            <div class="col-sm-6 col-md-4">  
                  <div class="card box-item" >
                       <span><?=$item['price']?>$</span>
                        <img src="img.png" class="card-img-top" alt="...">
                       <div class="card-body">
                           <h5 class="card-title"> <?=$item['name']?> </h5>
                           <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                           <a href="#" class="btn btn-primary">Go somewhere</a>
                       </div>
                  </div>
              
            </div>   
            <div class="col-sm-6 col-md-9">  
                  <div class="card box-item" >
                       <span>100$</span>
                        <img src="img.png" class="card-img-top" alt="...">
                       <div class="card-body">
                           <h5 class="card-title"> </h5>
                           <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                           <a href="#" class="btn btn-primary">Go somewhere</a>
                       </div>
                  </div>
              
            </div>   
          
           </div>
              
            </div>
        </div>
    </div>
 </div>
 
<?else :?>
    <? header("location:login.php"); exit();?>
<?endif?>    
  

 <?require $tpl."footer.php";