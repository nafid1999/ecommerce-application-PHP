<?require "init.php";?>
 
   <div class="container">
      <h1 class="text-center"><?=$_GET['cat']?></h1>
      <div class="row">
          <? foreach( getitems('cat_id',$_GET['id']) as $row) : ?>
            <div class="col-sm-6 col-md-3"> 
                  
                  <div class="card box-item" >
                       <span><?=$row['price']?>$</span>
                        <img src="img.png" class="card-img-top" alt="...">
                       <div class="card-body">
                           <h5 class="card-title"> <?=$row['name']?> </h5>
                           <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                           <a href="#" class="btn btn-primary">Go somewhere</a>
                       </div>
                  </div>
              
            </div>   
           <? endforeach; ?>
           </div>
      </div>
   </div>
 
     

  <? require $tpl."footer.php";?>









