
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "carwash_data";


       $conn = mysqli_connect($servername, $username, $password, $dbname);

       if (!$conn){

        die("could not connect to server"  . mysqli_connect_error());
       } 
       
?> 
