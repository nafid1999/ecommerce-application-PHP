<nav class="navbar sticky-top navbar-expand-md navbar-dark bg-dark ">
  <a class="navbar-brand mb-2 h1" href="#">My store</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link " href="index.php">Dashboard <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="categories.php">catégories</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="items.php">Items</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="members.php">Members</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">statistic</a>
      </li>
      <li class="nav-item dropdown  ">
        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
       <? echo $_SESSION['fullname'];?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="../index.php">Visit shop</a>
          <a class="dropdown-item" href="members.php?go=edit&id=<?=$_SESSION['id']?>">setting</a>
          <a class="dropdown-item" href="#">profile</a>
          <a class="dropdown-item" href="logout.php">log out</a>
        </div>
      </li>
    </ul>
    
 
  </div>
</nav>
