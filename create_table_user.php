<?php
    require_once('./connectdb.php');
       $query="CREATE TABLE UserMovies(
        id int NOT NULL REFERENCES Users(id), 
        movieid int NOT NULL REFERENCES Movies(id)
        )";
       //checking creation of table
       if ($conn->query($query)===TRUE) {
        echo "UserMovies Table is successfully created in GOLDEN_REELS database.";
      } else {
        echo "Error:" . $conn->error;
      }
      mysqli_close($conn);//closing conn
?>