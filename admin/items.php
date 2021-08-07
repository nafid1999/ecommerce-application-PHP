<?php 
  ob_start();
  session_start();
  $no_navbar='';
  if(isset($_SESSION['username'])  and isset($_SESSION['id']))
   {   
		require_once "init.php"; 
		require_once  "includes/functions/function.php";

		$go=isset($_GET['go']) ? $_GET['go']: 'manage';
	
		if($go=='manage'){  
 // manage page?>
         <div class="container">
            <h1 class="text-center">Manage Items</h1>
            <div class="table-responsive">
            <table class=" main-table table table-bordered text-center my-2">
               <thead class="">
                <tr>
                  <th>#ID</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>User adder</th>
                  <th>Category</th>
                  <th>Adding date</th>
                 <th>Control</th>
               </tr>
              </thead>

              <?php 
              
               $sql = "SELECT items.* , categories.name as name_cat,users.username from items  
               inner join categories on categories.ID=items.cat_id 
               inner join users on users.user_ID=items.user_id  ";
               $stmt = $con->prepare($sql);
               // Bind variables to the prepared statement as parameters
               $stmt->execute(); 
             
              while($row=$stmt->fetch(PDO::FETCH_OBJ)) {?>
              <tr>
                <td><?=$row->id_item?></td>
                <td><?=$row->name?></td>
                <td><?=$row->description?></td>
                <td><?=$row->price?> $</td>
                <td><?=$row->username?> </td>
                <td><?=$row->name_cat?> </td>
                <td><?=$row->date_item?></td>
                <td>
                  <a href="?go=edit&item_id=<?=$row->id_item?>" class="btn btn-warning btn-sm  my-2 "><i class="fa fa-edit"></i> Edit</a>
                  <a href="?go=delete&item_id=<?=$row->id_item?>" class="btn btn-danger btn-sm confirm"><i class="fas fa-times-circle "></i> Delete</a>
                  <?if($row->approve==0) :?>
                    <a href="?go=approve&item_id=<?=$row->id_item?>" class="btn btn-info btn-sm  "> <i class="fa fa-check"></i> Activate</a>
                 <?endif?>

                </td>
              </tr>
           <?php }?>
            
          </table>


        </div>
        <a href="items.php?go=add" class="btn btn-primary"> <i class="fa fa-plus"></i>  new item</a>
     
     </div>

  <?php }elseif($go=='add'){?>
            <h1 class="text-center my-2 text-lg" >Add new Item</h1>

			<div class="container col-md-6" >

			<form action="?go=insert" class="form-horisontal " method='POST'>
		   
		  
		  <div class="form-group col-sm-7 col-md-8  ">
		   <label for="" class="control-label">Name of the item :</label>
		   <input type="text" name="name"  class=" form-control" required='required' placeholder="Name of item">  
		  </div>
		  
		  <div class="form-group col-sm-7 col-md-8">
		   <label for="" class=" control-label">Description :</label>
		   <input type="text" name="description"  class=" form-control"  placeholder="description">  
		  </div>

		  <div class="form-group col-sm-7 col-md-8">
		   <label for="" class=" control-label">price :</label>
		   <input type="text" name="price"  class=" form-control"  placeholder="Price" required='required'>  
          </div>  
          
		  <div class="form-group col-sm-7 col-md-8">
		   <label for="" class=" control-label">Country :</label>
		   <input type="text" name="country"  class=" form-control"  placeholder="country of made">  
          </div>
          
		  <div class="form-group col-sm-7 col-md-8">
		   <label for="" class=" control-label">status :</label>
		   <select name="status"  class="form-control">
               <option value="0">...</option>
               <option value="1">New</option>
               <option value="2">Old</option>
               <option value="3">Used</option>
           </select>
          </div>
          
		  <div class="form-group col-sm-7 col-md-8">
		   <label for="" class=" control-label">Member :</label>
		   <select name="member"  class="form-control">
               <option value="0"></option>
              <?php
              $sql = "SELECT * FROM users ";
               $stmt = $con->prepare($sql);
               $stmt->execute(); 
               while($row=$stmt->fetch(PDO::FETCH_OBJ)) { ?>
                 
                 <option value="<?=$row->user_ID?>"><?=$row->username?></option>

              <?php } ?>
      
           </select>
		  </div>
		  <div class="form-group col-sm-7 col-md-8">
		   <label for="" class=" control-label">Category :</label>
		   <select name="category"  class="form-control">
               <option value="0"></option>
              <?php
              $sql = "SELECT * FROM categories ";
               $stmt = $con->prepare($sql);
               $stmt->execute(); 
               while($row=$stmt->fetch(PDO::FETCH_OBJ)) { ?>
                 
                 <option value="<?=$row->ID?>"><?=$row->name?></option>

              <?php } ?>
      
           </select>
		  </div>

		  <div class="form-group ">
		   <input type="submit" name="valider" class=" btn btn-sm btn-primary " value="Add item" style="margin:  auto;">  
		  </div>

		</form>  
		</div>                    
		 
            
    <?php }elseif($go=='insert'){

                    if($_SERVER['REQUEST_METHOD']=='POST')
                    {
                     echo "<h1 class='text-center my-2 text-lg' >Insert item</h1> ";
                     
                     echo "<div class='container update' style='margin-top: 100px '> ";
               
                     // get variable from the form
                     $name=trim($_POST['name']);
                     $des=trim($_POST['description']);
                     $price=trim($_POST['price']);
                     $status=trim($_POST['status']);
                     $country=trim($_POST['country']);
                     $member=trim($_POST['member']);
                     $cat=trim($_POST['category']);
                     
               
                     // validate data form
                     $error= array();
                     // validate 
                     if(empty($name)){ $error[]="Name must not be empty .";}
                    
                     // validate description
                     if(empty($des)){ $error[]="You have to enter the description .";}
                   
                     
                     //validate price
                     if(empty($price)){ $error[]="the price must not be empty .";}

                     if(empty($status)){ $error[]="the status must not be empty .";}

                     if(empty($country)){ $error[]="the country must not be empty .";}

                     if(empty($cat)){ $error[]="tYou must choose the category .";}

                     if(empty($member)){ $error[]="You must  choose the member.";}
                     
               
                      foreach($error as $val)
                      { 
                          echo "<div class='alert alert-danger'>". $val."</div>";
                      }
               
                       if(empty($error))
                      { 
                      // update in the data base
                      
                       $stmt=$con->prepare('INSERT into items  (name,description,price,date_item,country,img,status,cat_id,user_id ) values(:name,:description,:price,now(),:country,5,:status,:cat_id,:user_id)');
                       $stmt->bindParam(":name", $name);
                       $stmt->bindParam(":description", $des);
                       $stmt->bindParam(":price", $price);
                       $stmt->bindParam(":country", $country);
                       $stmt->bindParam(":status", $status);
                       $stmt->bindParam(":cat_id", $cat);
                       $stmt->bindParam(":user_id", $member);
                       $stmt->execute();
                       $message= "<div class='alert alert-success'> The item was added succesfully .</div>";?>
                      <? redirect($message);?>
                   
                 <?php }
                     echo "</div> ";
               
               
                  }else {
                     $message= "<div class='alert alert-danger'> you can not acces this page directly.</div>";?>
               
                     <?redirect($message);?>
                <?php }

        }elseif($go=='edit'){
      /*---------Edit Page-----------*/ 
            $item=isset($_GET['item_id']) && is_numeric($_GET['item_id'])?$_GET['item_id']:0;
            $stmt=$con->prepare('SELECT * from items where id_item=:id_item');
            $stmt->bindParam(":id_item", $item);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_OBJ);

            if($stmt->rowCount())
            {   ?>  

                <div class="container col-md-6" >
                   <h1 class="text-center my-2 text-lg" >Edit Item</h1>

                  <form action="?go=update" class="form-horisontal " method='POST'>
               <!-- hidden data  -->
                    <input type="hidden" name="id" value="<?=$row->id_item?>">
       
                    <div class="form-group col-sm-7 col-md-8  ">
		                   <label for="" class="control-label">Name of the item :</label>
		                   <input type="text" name="name"  class=" form-control" required='required' placeholder="Name of item" value="<?=$row->name?>">  
		                </div>
		  
		                <div class="form-group col-sm-7 col-md-8">
		                   <label for="" class=" control-label">Description :</label>
		                    <input type="text" name="description"  class=" form-control"  placeholder="description" value="<?=$row->description?>">  
		                </div>

		                <div class="form-group col-sm-7 col-md-8">
		                  <label for="" class=" control-label">price :</label>
		                  <input type="text" name="price"  class=" form-control"  placeholder="Price" required='required' value="<?=$row->price?>">  
                    </div>  
          
                    <div class="form-group col-sm-7 col-md-8">
		                   <label for="" class=" control-label">Country :</label>
		                   <input type="text" name="country"  class=" form-control"  placeholder="country of made" value="<?=$row->country?>">  
                    </div>
          
		               <div class="form-group col-sm-7 col-md-8">
		                 <label for="" class=" control-label">status :</label>
		                 <select name="status"  class="form-control">
                        <option value="1"<?=($row->status==1)?"selected":""?> >New</option>
                        <option value="2" <?=($row->status==2)?"selected":""?> >Old</option>
                        <option value="3" <?=($row->status==3)?"selected":""?> >Used</option>
                    </select>
                   </div>
                   
                   <div class="form-group col-sm-7 col-md-8">
		                  <label for="" class=" control-label">Member :</label>
		                  <select name="member"  class="form-control">
                         <?php
                          $sql2 = "SELECT * FROM users ";
                          $stmt2 = $con->prepare($sql2);
                          $stmt2->execute(); 
                          while($row2=$stmt2->fetch(PDO::FETCH_OBJ)) { ?>
                 
                             <option value="<?=$row2->user_ID?>" <?=($row->user_id==$row2->user_ID)?"selected":""?> ><?=$row2->username?></option>

                          <?php } ?>
      
                      </select>
                    </div>
                    
                    <div class="form-group col-sm-7 col-md-8">
		                  <label for="" class=" control-label">Category:</label>
		                  <select name="category"  class="form-control">
                         <?php
                          $sql2 = "SELECT * FROM categories ";
                          $stmt2 = $con->prepare($sql2);
                          $stmt2->execute(); 
                          while($row2=$stmt2->fetch(PDO::FETCH_OBJ)) { ?>
                 
                             <option value="<?=$row2->ID?>" <?=($row->cat_id==$row2->ID)?"selected":""?> ><?=$row2->name?></option>
                          <?php } ?>
                      </select>
		                </div>

                     <div class="form-group ">
                        <input type="submit" name="valider" class=" btn btn-info  btn-sm " value="Edit item" style="margin:  auto;">  
                     </div>

                  </form>  
               </div>   


          <?php }else echo "there is no such id";             
            
        }elseif($go=='update'){

          if($_SERVER['REQUEST_METHOD']=='POST')
          {
             echo "<h1 class='text-center my-2 text-lg' >Update members</h1> ";
             
             echo "<div class='container update' style='margin-top: 100px '> ";
         
             // get variable from the form
            
             $name=trim($_POST['name']);
             $des=trim($_POST['description']);
             $price=trim($_POST['price']);
             $status=trim($_POST['status']);
             $country=trim($_POST['country']);
             $member=trim($_POST['member']);
             $cat=trim($_POST['category']);
             $ID=trim($_POST['id']);
    
             // validate data form
             $error= array();
             // validate 
             if(empty($name)){ $error[]="Name must not be empty .";}
            
             // validate description
             if(empty($des)){ $error[]="You have to enter the description .";}
           
             
             //validate price
             if(empty($price)){ $error[]="the price must not be empty .";}

             if(empty($status)){ $error[]="the status must not be empty .";}

             if(empty($country)){ $error[]="the country must not be empty .";}

             if(empty($cat)){ $error[]="tYou must choose the category .";}

             if(empty($member)){ $error[]="You must  choose the member.";}
             
       
              foreach($error as $val)
              { 
                  echo "<div class='alert alert-danger'>". $val."</div>";
              }
         
             if(empty($error))
             {
          
            // update in the data base
               $stmt=$con->prepare('UPDATE items set  name=:name ,description=:description,price=:price,country=:country,status=:status,cat_id=:cat_id,user_id=:user_id where id_item=:id_item');
         
              $stmt->bindParam(":name", $name);
              $stmt->bindParam(":description", $des);
              $stmt->bindParam(":price", $price);
              $stmt->bindParam(":country", $country);
              $stmt->bindParam(":status", $status);
              $stmt->bindParam(":cat_id", $cat);
              $stmt->bindParam(":user_id", $member);
              $stmt->bindParam(":id_item", $ID);
              $stmt->execute();
              $message= "<div class='alert alert-success'>The category si updated succesfully</div>";?>
              <? redirect($message,'back');?>
    
    
            <?php }
            
             echo "</div> ";
         
         
            }else redirect('page not found !');          
            
        }elseif($go=='delete'){

          $id=isset($_GET['item_id']) && is_numeric($_GET['item_id'])?$_GET['item_id']:0;?>
         <? $chek= cheakItem('id_item','items',$id);?>
  <?php   echo "<div class='container  '> ";
          echo "<h1 class='text-center my-2 text-lg' >Delete member</h1> ";
          if($chek)
          {  
            $stmt=$con->prepare('DELETE from items where id_item=:id_item');
            $stmt->bindParam(":id_item", $id);
            $stmt->execute();  
            $message="<div class='alert alert-success'>The item has been deleted successfully</div>";
            redirect($message,'back');
               
          
          }else   echo "<div class='alert alert-warning'>This item does not exist</div>";
             echo "<div/> ";
            
        }elseif($go=='approve'){
          $id=isset($_GET['item_id']) && is_numeric($_GET['item_id'])?$_GET['item_id']:0;
          $chek=cheakItem('id_item','items',$id);
         echo "<div class='container  '> ";
            echo "<h1 class='text-center my-2 text-lg' >Activate member</h1> ";
         if($chek)
        {  

           $stmt=$con->prepare('UPDATE items set  approve =1 where id_item=:id_item ');
           $stmt->bindParam(":id_item", $id);
           $stmt->execute();  
          $message="<div class='alert alert-success'>The item has been approved </div>";
          redirect($message,'back');
         
    
       }else   echo "<div class='alert alert-warning'>This item does not exist</div>";

       echo "<div/> ";
   }

        
       
	  require $tpl."footer.php";
    

   }else {
	  $message= "<div class='alert alert-danger'> you can not acces this page directly.</div>";

   }
   

   ob_end_flush();
  ?>