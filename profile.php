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
  <h1 class="text-center">My profile</h1>
 <div class="information block">
    <div class="container">
        <div class="card border-primary  ">
            <div class="card-header bg-info text-white "> <span>My informations</span>  <i class="fa fa-minus float-right toggle"></i> </div>

            <div class="card-body ">
                <ul class="list-unstyled">
                     <li class="ele">
                        <i class="fa fa-lock"></i>
                       <span>UserName : </span><?=$row->username?>
                     </li>

                     <li class="ele"> 
                         <i class="fas fa-envelope"></i>
                         <span>Email : </span> <?=$row->email?>
                    </li>

                     <li class="ele">
                         <i class="fa fa-user"></i> 
                         <span>Full Name : </span> <?=$row->fullname?>
                     </li>

                     <li class="ele"> 
                         <i class="fa fa-calendar-alt" ></i> 
                         <span>Registred Day : </span> <?=$row->date?>
                     </li>

                     <li class="ele"> 
                         <i class="fa fa-tag"></i> 
                         <span>Registred Day : </span> <?=$row->date?>
                     </li>
                </ul>
            </div>
        </div>
    </div>
 </div>
 <div class="Items block">
    <div class="container">
        <div class="card border-dark  ">
            <div class="card-header bg-warning text-white ">  <span>My ads</span> <i class="fa fa-minus float-right toggle"></i></div>
             
            <div class="card-body ">
             <div class="row">
            <?if(!empty(getItems('user_id',$row->user_ID))):?>     
            <? foreach( getItems('user_id',$row->user_ID) as $item) : ?>
            <div class="col-sm-6 col-md-3">  
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
            <? endforeach; ?>
            <?else:?>
                <div class="container alert alert-info text-center font-weight-bold">There is  No Item Added Yet ! . <a href="ads.php">Create Ad</a></div>
            <?endif?>
           </div>
              
            </div>
        </div>
    </div>
 </div>
 <div class="comments block">
    <div class="container">
        <div class="card border-primary  ">
            <div class="card-header bg-secondary text-white ">  <span> My comments</span> <i class="fa fa-minus float-right toggle"></i></div>

            <div class="card-body ">
              <? $comments=getComments($row->user_ID);
              if(!empty($comments))   
               foreach($comments as $comment)
               {
                    echo '<p>'.$comment['comment'].'</p>';
               }else{
                   echo' <div class="container alert alert-info text-center font-weight-bold">There is  No Comments  ! .</div>';
               }
              
              ?>
             
              
            </div>
            </div>
        </div>
    </div>
 </div>
<?else :?>
    <? header("location:login.php"); exit();?>
<?endif?>    
  

 <?require $tpl."footer.php";