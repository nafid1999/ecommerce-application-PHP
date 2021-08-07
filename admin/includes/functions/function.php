<?
function fon()
{
    echo "<div class='alert alert-warning'>hahahha</div>";
    $time=3;
     header("refresh:$time;url=index.php");
}
// redirect function
function redirect($message,$url=null,$time=4)
{ if($url===null)
    {
        $url="index.php";
    }else{
        if(isset($_SERVER['HTTP_REFERER']) and $_SERVER['HTTP_REFERER']!=='')
        $url=$_SERVER['HTTP_REFERER'];
        else $url='index.php';
    }
    echo $message;
   
     header("refresh:$time;url=$url");
}

// cheak items
function cheakItem($select,$from,$value)
{
    global $con;
    $stmt=$con->prepare("SELECT $select from $from where $select =?");
    $stmt->execute([$value]);
    $count=$stmt->rowCount();
    return $count;
}

function countItems($item,$table)
{
    global $con;
    $stmt=$con->prepare("SELECT count($item) from $table ");
    $stmt->execute();
    $count=$stmt->fetchColumn();
    return $count;
}

function getLatest($select,$table,$order,$limit=5)
{
    global $con;
    $stmt=$con->prepare("SELECT $select from $table order by $order desc Limit $limit ");
    $stmt->execute();
     $row=$stmt->fetchAll();
    return $row;
}

?>