<?php

require_once "conn.php";



$sql="CREATE DATABASE IF NOT EXISTS jbj";

$results=$conn->query($sql);

if($results){
    echo"database created";
}else{
    echo"database not created".$conn->error;
}