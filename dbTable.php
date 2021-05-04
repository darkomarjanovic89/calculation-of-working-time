<?php
    $myfile = fopen("createTable.sql", "r") or die("Unable to open file!");
    $sql = fread($myfile,filesize("createTable.sql"));
    fclose($myfile);

    require_once "conn.php";

    if (!$conn->multi_query($sql)) {
        echo "<p>Error: " . $sql . " --- " . $conn->error . "</p>";
    } else {
        echo "<h1>Baza je uspesno kreirana :)</h1>";   
    }
?>

