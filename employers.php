<?php
session_start();
require_once "conn.php";
include "head.php";
include "nav.php";

if(empty($_SESSION['id'])){
    header("Location: login.php");
}else{
$user_id=$_SESSION['id'];



$sql="SELECT DISTINCT users.id , CONCAT(radnici.name,' ', radnici.surname) as 'name_surname'
FROM evidencija_sati
INNER JOIN users
ON evidencija_sati.users_id=users.id
INNER JOIN radnici
ON users.id=radnici.users_id;";

$result=$conn->query($sql);

if($result->num_rows){

    echo '<div class="container py-5">';
    echo '<div class="row d-flex justify-content-center py-5">';
    
  
        echo '<h2 class"text-centre">List of all workers</h2>
        <table class="table table-striped table-primary  w-auto">
        <th>Name and surname</th>';
        
    foreach($result as $row){
        $usersId=$row['id'];
        echo "<tr>";
        echo"<td><a href='evidencija_sati.php?user_id=$usersId'>".$row['name_surname']."</a></td>";        
        echo"<tr>";
    }
        echo"<table>";
}

echo '</div>';
echo '</div>';
}
?>

