<?php
    require_once('./connectdb.php');
    //Movies Table
       $query="CREATE TABLE Movies(
        id int NOT NULL PRIMARY KEY AUTO_INCREMENT, 
        movie_name varchar(255),
        href varchar(255),
        rating double,
        duration varchar(10),
        release_year int,
        trailer_link varchar(255),
        poster_image varchar(255),
        movie_description text
        )";
       //checking creation of table
       if ($conn->query($query)===TRUE) {
        echo "Movies Table is successfully created in GOLDEN_REELS database.";
      } else {
        echo "Error:" . $conn->error;
      }
      //language table
      $query="CREATE TABLE Languages(
        id int NOT NULL REFERENCES Movies(id) , 
        lang varchar(255)
        )";
       //checking creation of table
       if ($conn->query($query)===TRUE) {
        echo "Languages Table is successfully created in GOLDEN_REELS database.";
      } else {
        echo "Error:" . $conn->error;
      }
      //genre table
      $query="CREATE TABLE Genres(
        id int NOT NULL REFERENCES Movies(id) , 
        genre varchar(255)
        )";
       //checking creation of table
       if ($conn->query($query)===TRUE) {
        echo "Genres Table is successfully created in GOLDEN_REELS database.";
      } else {
        echo "Error:" . $conn->error;
      }

    mysqli_close($conn);//closing conn

?>