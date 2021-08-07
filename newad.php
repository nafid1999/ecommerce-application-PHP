<?
 session_start();
 $title="Create new ad";

 require "init.php";?>
 <?if(isset($_SESSION['user'])) :?>
    
    <?
        //  fetch infos from data base
        $stm=$con->prepare('SELECT * from users where username=:username');
        $stm->execute(array("username"=>$_SESSION['user']));
        $row=$stm->fetch(PDO::FETCH_OBJ);

        
    ?>
  <h1 class="text-center">Create new ad</h1>
 <div class="information block">
    <div class="container">
        <div class="card border-primary  ">
            <div class="card-header bg-info text-white "> <span>New Ad</span>  <i class="fa fa-minus float-right toggle"></i> </div>

            <div class="card-body ">
                <div class="row">
                    <div class="col-md-9">
                    <form action=<?=$_SERVER['PHP_SELF']?> class="form-horisontal " method='POST'>
		   
		  
                             <div class="form-group  col-md-9  ">
                                 <label for="" class="control-label">Name of the item :</label>
                                  <input type="text" name="name"  class=" form-control" required='required' placeholder="Name of item">  
                            </div>
           
           <div class="form-group  col-md-9">
            <label for="" class=" control-label">Description :</label>
            <input type="text" name="description"  class=" form-control"  placeholder="description">  
           </div>
 
           <div class="form-group  col-md-9">
            <label for="" class=" control-label">price :</label>
            <input type="text" name="price"  class=" form-control"  placeholder="Price" required='required'>  
           </div>  
           
           <div class="form-group  col-md-9">
            <label for="" class=" control-label">Country :</label>
            <input type="text" name="country"  class=" form-control"  placeholder="country of made">  
           </div>
           
           <div class="form-group  col-md-9">
            <label for="" class=" control-label">status :</label>
            <select name="status"  class="form-control">
                <option value="0">...</option>
                <option value="1">New</option>
                <option value="2">Old</option>
                <option value="3">Used</option>
            </select>
           </div>
           
          
           <div class="form-group  col-md-9">
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
                    <div class="col-md-3">
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
 
<?else :?>
    <? header("location:login.php"); exit();?>
<?endif?>    
  

 <?require $tpl."footer.php";