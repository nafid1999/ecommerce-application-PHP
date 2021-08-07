
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= getTitle();?></title>
    <link rel="stylesheet" href= "<?=$css?>bootstrap.css">
    <link rel="stylesheet" href= "<?=$css?>style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
 
</head>
<body>
<div class="row">
  <div class="col-md-4">
    <a href="" class="btn ">
      <h1><span style="color: red">Ma</span> <span style="color: blue">Boutique</span> </h1>
    </a>
  </div>
  <div class=" col-md-8 ">

      <div class=" float-right">
     

        <? if (isset($_SESSION["user"] ) ) : ?>
             <?if (!checkUser($_SESSION["user"]) ) :?>
                  <a class="dropdown-item" href="profile.php"><i class="fa fa-user"></i> <?= $_SESSION['user'] ?></a>
                  <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out"></i> déconnection</a>
            
             <? else : ?>
              <h4>not valide</h4>
            <? endif; ?>
         <? else : ?>
         
               <a class="dropdown-item" href="register.php"> <i class="fa fa-user-plus"></i> inscription</a>
               <a class="dropdown-item" href="login.php"><i class="fa fa-sign-in"></i> connection</a>

        <? endif; ?>
      </div>

    </div>

</div>
<nav class="navbar sticky-top navbar-expand-md navbar-dark bg-dark ">
  <a class="navbar-brand mb-2 h1" href="index.php ">My store</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav  text-md-center nav-justified w-50">
      <li class="nav-item active">
        <a class="nav-link " href="index.php">Dashboard <span class="sr-only">(current)</span></a>
      </li>
     
    
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white">
          catégories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown" >

          <? foreach( getCat() as $row) : ?>

           <a class="dropdown-item bg-light" href="categories.php?id=<?= $row['ID'] ?>&cat=<?=$row['name'] ?>"><?= $row['name'] ?></a>
           <div class="dropdown-divider"></div>
         <? endforeach; ?>



        </div>
      </li>
         
      </li>
      <li class="nav-item">
        <a class="nav-link" href="items.php">Items</a>
      </li>
     
      <li class="nav-item">
        <a class="nav-link" href="#">statistic</a>
      </li>
      
    </ul>
    
 
  </div>
</nav>

