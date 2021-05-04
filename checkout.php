<?php
require_once "conn.php";
require_once "validation.php";
require_once "nav.php";
include "head.php";


$vreme=date('G:i:s');
$datum= date('Y-m-d');


$username = $password ="";
$usernameErr = $passwordErr = $checkoutInfo="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $validated= false;
    $username =$conn->real_escape_string($_POST['username']);
    $password =$conn->real_escape_string($_POST['password']);

    // Username validation
    if(empty($username)){
    $validated = true;
    $usernameErr="Username cannot be left blank!";
    }

    // Password validation
    if(empty($password)){
        $validated = true;
        $passwordErr="Password cannot be left blank!";
    }
    if($validated==false){


        $sqlUser="SELECT * FROM users 
        WHERE username = '$username' AND password = '$password'";
        $resultUser=$conn->query($sqlUser);
        $row=$resultUser->fetch_assoc();
        $id=$row['id'];
        
        
        $sql="SELECT id, prijava, odjava, datum from evidencija_sati
        WHERE users_id ='$id' AND datum='$datum'";
        $result=$conn->query($sql);
        
            
            $row=$result->fetch_assoc();
            $idPrijava=$row['id'];
            
            $odjava=$row['odjava'];  
            $datumPrijave=$row['datum'];
            $prijava=$row['prijava'];  

        
        if($resultUser->num_rows == 0){
            $checkoutInfo= "This username doesn't exist!";
        }elseif($odjava == $prijava AND $datumPrijave==$datum){
            //update check out
        $sql="UPDATE evidencija_sati SET odjava='$vreme'
        WHERE users_id='$id' AND datum='$datum'";
        $result=$conn->query($sql);      
        
        // calculate different between check in and check out
        $sql="SELECT TIMEDIFF(odjava, prijava) as 'ukupno_sati' from evidencija_sati
        WHERE users_id='$id' AND datum='$datum'";
        $result=$conn->query($sql);
        $row=$result->fetch_assoc();
        $ukupno_sati=$row['ukupno_sati'];     
        $sql="UPDATE evidencija_sati SET ukupno_sati='$ukupno_sati'
        WHERE users_id='$id'AND datum='$datum'";  
        $result=$conn->query($sql); 
        $checkoutInfo="you are checked out";
        }else{
           $checkoutInfo="you are allready check out";
        }
            
                 
        }

}

?>


<div class="container py-5">

<div class="row d-flex justify-content-center">

    <div class="col-xl-5 col-sm-12 py-5">
                <h2 class="text-white text-center">Check out</h2>

                    <form action="" method="POST">
                <fieldset>
                <div class="mb-3 ">
                      
                        <input  type="text" name="username" placeholder="username" class="form-control text-center">
                        <span class="text-danger"><?php echo $usernameErr?></span>
                    
                    </div>
                    <div class="mb-3">
                        
                        <input type="password" placeholder="password" name="password" class="form-control text-center">
                        <span class="text-danger"><?php echo $passwordErr ?></span>
                    </div> 
                    <button type="submit" class="btn btn-primary">Submit</button> 
                
                </fieldset>      
            </form>
            <p class="text-white text-center"><?php echo $checkoutInfo ?></p>
        
        </div>
    
    </div>

</div>


</body>
</html>