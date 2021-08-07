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
			$sort='ASC';
			$sort_array=array('ASC','DESC');
			if(isset($_GET['sort']) and in_array($_GET['sort'],$sort_array))
			  $sort=$_GET['sort'];
			$sql = "SELECT * FROM categories order by ordring $sort ";
			$stmt = $con->prepare($sql);
			// Bind variables to the prepared statement as parameters
			$stmt->execute();     
			  ?> 

			<div class="container categories">
				<h1 class="text-center">Manage categories</h1> 
				<div class="card">
					<div class="card-header">
					   <h3> Categories</h3>
					   <div class="sort float-right">
						 <strong> Ordering : </strong>
						 <a href="?sort=ASC">ASC</a>
						  |
						 <a href="?sort=DESC">DESC</a>
					   </div>
					</div>
					<div class="card-body">
					  <?while($row=$stmt->fetch(PDO::FETCH_OBJ)):?>  
						  <div class="cat">
							  <dic class="hidden-button">
								  <a href="?go=edit&catid=<?=$row->ID?>" class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>
								  <a href="?go=delete&catid=<?=$row->ID?>" class="btn btn-danger"><i class="fas fa-times-circle">  Delete</i></a>
							  </dic>
							  <h3><?=$row->name?></h3>
						   <div class="full-view">
							  <h5 class="desc"><?if($row->description=='') echo "There is no description added"; else echo $row->description;?></h5>
							  <?if($row->visibility) :?> <span class="visible">Hidden</span> <?endif?>
							  <?if($row->allow_comments) :?> <span class="comments">Comments disabled</span> <?endif?>
							  <?if($row->allow_adds) :?> <span class="adds bg-warning">Ads disabled</span> <?endif?>
						    </div>
						  </div>
						  <hr>
					  <?endwhile?>  
					</div>
				</div>

				<a href="categories.php?go=add" class="btn btn-info mt-2"> <i class="fa fa-plus"></i> Add new category</a>

		   </div>    

 <?php }elseif($go=='add'){   // add catégories   ?>
			
			<h1 class="text-center my-2 text-lg" >Add new category</h1>

			<div class="container col-md-6" >

			<form action="?go=insert" class="form-horisontal " method='POST'>
		   
		  
		  <div class="form-group col-sm-7 col-md-8  ">
		   <label for="" class="control-label">Name :</label>
		   <input type="text" name="name"  class=" form-control" required='required' placeholder="Name category">  
		  </div>
		  
		  <div class="form-group col-sm-7 col-md-8">
		   <label for="" class=" control-label">Description</label>
		   <input type="text" name="descreption"  class=" form-control"  placeholder="descreption">  
		  </div>

		  <div class="form-group col-sm-7 col-md-8">
		   <label for="" class=" control-label">Ordering</label>
		   <input type="number" name="order"  class=" form-control"  placeholder="Ordering">  
		  </div>

 

        <div class="form-group col-sm-7 col-md-8">
			  
		  <label for="" class=" control-label">Visibility:</label>

			  <div>
				  <input  type="radio" name="visible"   id='yes-vis' value="0" checked>  
				  <label for="yes-vis" class=" ">yes</label>

			  </div>  
			  <div>
				  <input  type="radio" name="visible"   id='no-vis' value="1">  
				  <label for="no-vis" >No</label>

			  </div>  
		  </div>
		  <div class="form-group col-sm-7 col-md-8">
			   <label for="" class=" control-label">Allow comments : </label>

			   <div>
				  <input  type="radio" name="comments"   id='com-yes' value="0" checked>  
				  <label for="com-yes" class=" ">yes</label>

			  </div>  
			  <div>
				  <input  type="radio" name="comments"   id='com-no' value="1">  
				  <label for="com-no" >No</label>

			  </div>  
		  </div>

		  <div class="form-group col-sm-7 col-md-8">
			   <label for="" class="col-form-label">Allow Ads : </label>

			   <div>
				  <input  type="radio" name="adds"   id='ads-yes' value="0" checked>  
				  <label for="ads-yes" class=" ">yes</label>

			  </div>  
			  <div>
				  <input  type="radio" name="adds"   id='ads-no' value="1">  
				  <label for="ads-no" >No</label>

			  </div>  
		  </div>
		 

		  <div class="form-group ">
		   <input type="submit" name="valider" class=" btn btn-primary col-sm-3 col-md-3 btn-lg " value="save" style="margin:  auto;">  
		  </div>

		</form>  
		</div>                    
		 


 <?php  }elseif($go=='insert'){
			 
			 if($_SERVER['REQUEST_METHOD']=='POST')
			{
				echo "<h1 class='text-center my-2 text-lg' >Insert category</h1> ";
	  
				echo "<div class='container update' style='margin-top: 100px '> ";

				 // get variable from the form
				$name=trim($_POST['name']);
				$desc=$_POST['descreption'];
				$order=0;
				if(isset($_POST['order'])) $order=$_POST['order'];


				echo $order;
				$vis=trim($_POST['visible']);
				$comm=trim($_POST['comments']);
				$adds=trim($_POST['adds']);    ?>
				
				<? $chek=cheakItem('name','categories',$name); ?> 
		<?php   if($chek)
				{
					$message= "<div class='alert alert-danger'>Sorry , this name already exists</div>";?>
				   <? redirect($message,'back');?>
		<?php   }else{
				   
				   $stmt=$con->prepare('INSERT into categories  (name,description,visibility,ordring,allow_comments,allow_adds ) values(:name,:description,:visibility,:ordring,:allow_comments,:allow_adds )');
				   $stmt->bindParam(":name", $name);
				   $stmt->bindParam(":description", $desc);
				   $stmt->bindParam(":visibility", $vis);
				   $stmt->bindParam(":ordring", $order);
				   $stmt->bindParam(":allow_comments", $comm);
				   $stmt->bindParam(":allow_adds", $adds);
				   $stmt->execute();
				   $message= "<div class='alert alert-success'> The category is added succesfully .</div>";
				   redirect($message,'back');


				}

				echo "</div> ";


   }else {
	  $message= "<div class='alert alert-danger'> you can not acces this page directl.</div>";

	  redirect($message);}

		
		}elseif($go=='edit'){
			   /*---------Edit Page-----------*/ 
			$userid=isset($_GET['catid']) && is_numeric($_GET['catid'])?$_GET['catid']:0;
			$stmt=$con->prepare('SELECT * from categories where ID=:ID');
			$stmt->bindParam(":ID", $userid);
			$stmt->execute();
			$row=$stmt->fetch(PDO::FETCH_OBJ);

			if($stmt->rowCount())
		   {   ?>  

			   <div class="container col-md-6" >
				  <h1 class="text-center my-2 text-lg" >Edit category</h1>

				 <form action="?go=update" class="form-horisontal " method='POST'>
					 <!-- hidden data  -->
				   <input type="hidden" name="id" value="<?=$row->ID?>">

				   <div class="form-group col-sm-7 col-md-8">
					  <label for="" class="control-label">Name of category :</label>
					  <input type="text" name="name" value="<?=$row->name?>" class=" form-control" required='required'>  
				   </div> 
				   <div class="form-group col-sm-7 col-md-8">
		             <label for="" class=" control-label">Description</label>
		             <input type="text" name="descreption"  class=" form-control"  placeholder="descreption" value="<?=$row->description?>">  
		          </div>
				  <div class="form-group col-sm-7 col-md-8">
		              <label for="" class=" control-label">Ordering</label>
		              <input type="number" name="order"  class=" form-control"  placeholder="Ordering" value="<?=$row->ordring?>">  
		         </div>

                  <div class="form-group col-sm-7 col-md-8">
			  
		            <label for="" class=" control-label">Visibility:</label>

			        <div>
				        <input  type="radio" name="visible"   id='yes-vis' value="0" <?=($row->visibility==0)?'checked':'';?>>
				        <label for="yes-vis" class=" ">yes</label>

			        </div>  
			       <div>
				       <input  type="radio" name="visible"   id='no-vis' value="1" <?=($row->visibility==1)?'checked':'';?>>  
				       <label for="no-vis" >No</label>
			      </div>  
			   </div>
				
			   <div class="form-group col-sm-7 col-md-8">
			   <label for="" class=" control-label">Allow comments : </label>

			   <div>
				  <input  type="radio" name="comments"   id='com-yes' value="0" <?=($row->allow_comments==0)?'checked':'';?> >  
				  <label for="com-yes" class=" ">yes</label>

			  </div>  
			  <div>
				  <input  type="radio" name="comments"   id='com-no' value="1" <?=($row->allow_comments==1)?'checked':'';?>>  
				  <label for="com-no" >No</label>

			  </div>  
		  </div>
		       <div class="form-group col-sm-7 col-md-8">
			   <label for="" class="col-form-label">Allow Ads : </label>

			   <div>
				  <input  type="radio" name="adds"   id='ads-yes' value="0" <?=($row->allow_adds==0)?'checked':'';?>>  
				  <label for="ads-yes" class=" ">yes</label>

			  </div>  
			  <div>
				  <input  type="radio" name="adds"   id='ads-no' value="1" <?=($row->allow_adds==1)?'checked':'';?>>  
				  <label for="ads-no" >No</label>

			  </div>  
		  </div>
		  
				   <div class="form-group ">
					   <input type="submit" name="valider" class=" btn btn-primary col-sm-3 col-md-3 btn-lg " value="save" style="margin:  auto;">  
				   </div>

				</form>  
			</div>   


  <?php }else echo "there is no such id"
  ;
		
		}elseif($go=='update'){

			if($_SERVER['REQUEST_METHOD']=='POST')
			{
			   echo "<h1 class='text-center my-2 text-lg' >Update members</h1> ";
			   
			   echo "<div class='container update' style='margin-top: 100px '> ";
		 
			   // get variable from the form
			   $name=trim($_POST['name']);
			   $desc=trim($_POST['descreption']);
			   $order=trim($_POST['order']);
			   $visible=trim($_POST['visible']);
			   $comments=trim($_POST['comments']);
			   $adds=trim($_POST['adds']);
			   $ID=trim($_POST['id']);

			   // validate data form
			   $error= array();
			   // validate username
			   if(empty($name)){ $error[]="<div class='alert alert-danger' id='naf'>You must fill in the name of category .</div>";}

				foreach($error as $val)
				{
					echo $val;
				}
		 
			   if(empty($error))
			   {
			
				// update in the data base
					 $stmt=$con->prepare('UPDATE categories set  name=:name ,description=:description,visibility=:visibility,ordring=:ordring,allow_comments=:allow_comments,allow_adds=:allow_adds  where ID=:ID');
		 
					$stmt->bindParam(":name", $name);
					$stmt->bindParam(":description", $desc);
					$stmt->bindParam(":visibility", $visible);
					$stmt->bindParam(":ordring", $order);
					$stmt->bindParam(":allow_comments", $comments);
					$stmt->bindParam(":allow_adds", $adds);
					$stmt->bindParam(":ID", $ID);
					$stmt->execute();
					$message= "<div class='alert alert-success'>The category si updated succesfully</div>";?>
					<? redirect($message,'back');?>


				<?php }
			  
			   echo "</div> ";
		 
		 
			  }else redirect('page not found !');
		
		}elseif($go=='delete'){
			$id=isset($_GET['catid']) && is_numeric($_GET['catid'])?$_GET['catid']:0;
             $stmt=$con->prepare('SELECT * from categories where ID=:ID');
             $stmt->bindParam(":ID", $id);
             $stmt->execute();
             $row=$stmt->fetch(PDO::FETCH_OBJ);
             echo "<div class='container  '> ";
                echo "<h1 class='text-center my-2 text-lg' >Delete member</h1> ";
               if($stmt->rowCount())
               {  
                     $stmt=$con->prepare('DELETE from categories where ID=:ID');
                     $stmt->bindParam(":ID", $id);
                     $stmt->execute();  
                     $message="<div class='alert alert-success'>The category has been deleted successfully</div>";?>
                     <?redirect($message,'back');?>
		 <?php }else { 
					  $message= "<div class='alert alert-warning'>This category does not exist</div>";?>
					  <?redirect($message,'back');?>

		        <?php }
                 echo "<div/> ";			
		
		}

	  require $tpl."footer.php";


   }else {
	  $message= "<div class='alert alert-danger'> you can not acces this page directly.</div>";

   }
   

   ob_end_flush();
  ?>