<?php
    $servername="localhost";
    $username="root";
    $password="root";
    //setting up connection
    $connection = mysqli_connect($servername, $username, $password);
    // Checking the  connection
    if (!$connection) {
        die("Failed ". mysqli_connect_error());
    }
    echo "Connection established successfully";
    $query = "CREATE DATABASE GOLDEN_REELS";
    //checking creation of database
    if (mysqli_query($connection, $query)) {
        echo "A new database called GOLDEN_REELS is successfully created!";
      } else {
        echo "Error:" . mysqli_error($connection);
      }

      $query = "CREATE DATABASE LOGIN_REGISTER";
    //checking creation of database
    if (mysqli_query($connection, $query)) {
        echo "A new database called LOGIN_REGISTER is successfully created!";
      } else {
        echo "Error:" . mysqli_error($connection);
      }

    mysqli_close($connection);//closing connection

?>

