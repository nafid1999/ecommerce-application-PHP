 <?php
 session_start();
 $no_navbar='';
 if(isset($_SESSION['username']))
  {
      require "init.php";
      require_once  "includes/functions/function.php";

      ?>


<div class="container text-center home-stats">
            <h1 class="text-center">Dashboard</h1>
           <div class="row">
               <div class="col-md-3 ">
                   <div class="stats st-members">  
                     <i class="fa fa-users"></i>  
                    <div class="infos">
                       Total members
                       <span><? echo countItems('*','users');?></span>
                    </div>  
                   </div>
               </div>
               
              
               <div class="col-md-3">
                   <div class="stats st-pending">
                   <i class="fa fa-user-plus"></i>
                       <div class="infos">
                          pending members
                          <span><?echo cheakItem('regstatus','users',0)?></span>
                      </div>
                   </div>
                  
               </div>

               <div class="col-md-3">
                   <div class="stats st-items">
                       <i class="fa fa-tag"></i>
                       <div class="infos">
                            last Items added
                           <span><? echo countItems('*','items');?></span>
                      </div>
                   </div>
                  
               </div>
               <div class="col-md-3">
                   <div class="stats st-comments">
                       <i class="fa fa-comments"></i>


                     <div class="infos">
                       Last comments
                        <span>100</span>
                    </div>  
                 </div>
                  
               </div>
               
           
           </div>
        
        </div>

        
        <div class="container  latest">
            <div class="row"> 
               <div class="col-md-6">
                   <div class="card ">
                       <div class="card-header bg-secondary">
                           <i class="fa fa-users"></i> last users
                           <i class="fa fa-minus float-right toggle"></i>
                       </div>
                 
                      <div class="card-body  ">
                         <ul class="list-unstyled " id="latest-users">
                            <?
                                $latest=getLatest("*","users","user_ID",5);
                                foreach($latest as $user)
                               {
                                  echo '<li>';
                                  echo $user['username'];
                                  echo '<a class="btn btn-warning float-right" href="members.php?go=edit&id='.$user['user_ID'].'"><i class="fa fa-edit"></i> Edit</a>';?>
                                  <?  if($user['regstatus']==0) :?>
                                    <a  href="members.php?go=activate&id=<?=$user['user_ID']?>" class="btn btn-info float-right mx-2"><i class="fa fa-plus"></i> Activate</a>
                                  <?endif?>
                               
                                 <? echo '</li>'; 
                               } ?>                      
                         </ul>
                     </div>
                 </div>
             </div>    

               <div class="col-md-6">
                   <div class="card ">
                       <div class="card-header bg-secondary">
                           <i class="fa fa-tag"></i> last items
                           <i class="fa fa-minus float-right toggle"></i>
                       </div>
                 
                      <div class="card-body  ">
                         <ul class="list-unstyled " id="latest-users">
                            <?
                                $lastitems=getLatest("*","items","id_item",5);
                                foreach($lastitems as $item)
                               {
                                  echo '<li>';
                                  echo $item['name'];
                                  echo '<a class="btn btn-warning float-right" href="items.php?go=edit&item_id='.$item['id_item'].'"><i class="fa fa-edit"></i> Edit</a>';?>
                                  <?  if($item['approve']==0) :?>
                                    <a  href="items.php?go=approve&item_id=<?=$item['id_item']?>" class="btn btn-info float-right mx-2"><i class="fa fa-plus"></i> Activate</a>
                                  <?endif?>
                               
                                 <? echo '</li>'; 
                               } ?>                      
                         </ul>
                     </div>
                 </div>
             </div>    
          </div>

        </div>

    <?php   require $tpl."footer.php";

  }else{

      header('location:index.php');
      exit ();
  }

 
 ?>