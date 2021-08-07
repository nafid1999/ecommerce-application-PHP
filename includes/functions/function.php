<?

function getCat()
{
    global $con;
    $stmt=$con->prepare("SELECT * from categories  ");
    $stmt->execute();
     $row=$stmt->fetchAll();
    return $row;
}
function getitems($where,$value)
{
    global $con;
    $stmt=$con->prepare("SELECT * from items  where $where = ? order by id_item desc  ");
    $stmt->execute(array($value));
     $row=$stmt->fetchAll();
    return $row;
}

function getTitle()
{
    global $title;
    return (isset($title))?$title: "Dashboard";
}

function checkUser($user)
{
   global $con;
   $stmt=$con->prepare('SELECT * from users where username=:username and regstatus=0 ');
     
      $stmt->bindParam(":username", $user);
      $stmt->execute();
    return $stmt->rowCount();  
}

function checkUserForm($field,$val)
{
   global $con;
   $stmt=$con->prepare("SELECT * from users where $field =? ");
 
      $stmt->execute(array($val));
    return $stmt->rowCount();  
}

function getComments($user_id)
{
    global $con;
   $stm= $con->prepare('SELECT * from comments where user_id= ?');
   $stm->execute(array($user_id));
   return $stm->fetchAll();


}

?>