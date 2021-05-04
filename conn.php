<?php

$servername = "localhost";
$uname = "admin";
$pbaza="admin123";
$baza="jbj";



$conn=new mysqli($servername,$uname,$pbaza, $baza);



if($conn->connect_error){
    die("error connecting to database" . $conn->connect_error);
}



