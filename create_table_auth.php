<?php
    require_once('./connectdb.php');
       $query="CREATE TABLE Users(
        id int NOT NULL PRIMARY KEY AUTO_INCREMENT, 
        username varchar(255),
        password varchar(255),
        profile_pic varchar(255)
        )";
       //checking creation of table
       if ($conn->query($query)===TRUE) {
        echo "Users Table is successfully created in GOLDEN_REELS database.";
      } else {
        echo "Error:" . $conn->error;
      }
      mysqli_close($conn);//closing conn
?>