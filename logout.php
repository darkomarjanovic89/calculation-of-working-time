<?php
session_start();
if(isset($_SESSION['id'])){
//brisemo sesiju ako postoji
$_SESSION =array(); //sesion_unset()
session_destroy();
}

header('Location:index.php');