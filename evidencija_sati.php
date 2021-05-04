<?php
session_start();
require_once "conn.php";
require_once "head.php";

if(empty($_SESSION['id'])){
    header("Location: login.php");
}else{
$user_id=$_SESSION['id'];

$info ="";
$years = range(2021, strftime("%Y", time()));
$months = range(1, 12);

if(isset($_GET['user_id'])){
    if(isset($_POST['submit'])){
        
        $m=$_POST['m'];
        $y=$_POST['y'];       
 
        $user_id=$_GET['user_id'];


        $sql="SELECT evidencija_sati.users_id, evidencija_sati.prijava as 'prijava', evidencija_sati.odjava as 'odjava',  evidencija_sati.ukupno_sati as 'sati', users.username as 'un', evidencija_sati.datum as 'datum', CONCAT(radnici.name,' ', radnici.surname) as 'name_surname'
        FROM evidencija_sati
        INNER JOIN users
        ON evidencija_sati.users_id=users.id
        INNER JOIN radnici
        ON users.id=radnici.users_id
        WHERE evidencija_sati.users_id=$user_id AND 
        MONTH(datum)=$m AND YEAR(datum) =$y;";
    
    $result=$conn->query($sql);
    
    
    
    if($result->num_rows != 0){
        $nameSurname=$result->fetch_assoc();
        $nameSurname=$nameSurname['name_surname'];          
            
        echo '<div class="container py-5">';
        echo '<div class="row d-flex justify-content-center py-5">';
        echo '<div class="text-center text-danger">
                 <h1>'.$nameSurname.'</h1>
              </div>';
            echo '<table class="table table-striped table-primary  w-auto">
            <th>prijava</th>
            <th>odjava</th>
            <th>datum</th>
            <th>ukupno vremena na poslu</th>';
            
        foreach($result as $row){
            
            
            echo "<tr>";   
            echo"<td>".$row['prijava']."</td>";
            echo"<td>".$row['odjava']."</td>";       
            echo"<td>".$row['datum']."</td>";       
            echo"<td class='text-center text-danger'>".$row['sati']."</td>";            
            echo"<tr>";
        }
            echo"<table>";
    
            $sql="SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(ukupno_sati))) as 'ukupno'
            FROM evidencija_sati
            where users_id = $user_id AND 
            MONTH(datum)=$m AND YEAR(datum) = $y";
    
            $res=$conn->query($sql);
            $r=$res->fetch_assoc();
            $time=$r['ukupno'];
            
    
            echo "<div class='text-center text-white fs-5'>
            <p>$nameSurname has spend total time on work:</p>
            <p class='text-danger fs-1'> $time</p>
            </div>";
                
    }else{
       $info= "<p class='text-white'>no records</p>".$conn->error;
    }
    
    }
    
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odjava</title>
</head>
<body>
    <br>
    <br>
    <br>

<!-- form for input fields month and year -->
 

    <div class="container">
         <div class="row d-flex justify-content-center">
            <div class="col-xl-5 col-sm-12 py-5">
            <form action="" method="POST">
        <fieldset>    

                <!-- month -->
                <h2 class="text-center text-white py-4 ">Choose months</h2>
                <label class="text-white" for="">month</label>
                <select name="m" > 
                
                    <?php foreach($months as $month) :  ?>      
                                                                     
                        <option value='<?php echo $month; ?>''><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- year -->
                <label class="text-white" for="">year</label>
                <select name="y">                 
                    <?php foreach($years as $year) : ?>                                          
                        <option value='<?php echo $year; ?>''><?php echo $year; ?></option>
                    <?php endforeach; ?>
                </select>           
            <input type="submit" name="submit" value="Confirm">
            <?php echo $info; ?>
        </fieldset>      
    </form>
   <a class="btn btn-primary  w-auto" href="employers.php" role="button">go back</a>
   </div>
    </div>
                         
            </div>

        </div>
                      
    </div>
</body>
</html>