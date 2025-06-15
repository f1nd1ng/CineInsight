
<?php
session_start();
?>
<?php
    $movieid=$_GET["movie"];
    $fav=$_GET["fav"];
    $id=$_SESSION["id"];
    
    echo $movieid;
    require('./connectdb.php');
    if($fav==1){


    $sql = "INSERT INTO UserMovies(id,movieid)
            VALUES ($id,$movieid)";

    if ($conn->query($sql)===TRUE) {
        echo "success";
    } else {
        echo "Error:" . $conn->error;
    }
}
    else{
        $sql = "DELETE FROM UserMovies WHERE id=$id AND movieid=$movieid ";

    if ($conn->query($sql)===TRUE) {
        echo "deleted";
    } else {
        echo "Error:" . $conn->error;
    }
    }

    echo "hi";
?>