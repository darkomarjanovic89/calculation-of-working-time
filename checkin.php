<?php
require_once "conn.php";
require_once "validation.php";
include "head.php";
require_once "nav.php";


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


    if($validated == false){
        
        $sql="SELECT * FROM users 
        WHERE username = '$username' AND password = '$password'";
        $result=$conn->query($sql);
        
            //check if username exists
        if($result->num_rows == 0){
            $checkoutInfo= "This username doesn't exist!";
        }else{
            $row=$result->fetch_assoc();
            $id=$row['id'];
           
            $sql="SELECT datum FROM evidencija_sati
            WHERE datum = (SELECT max(datum) from evidencija_sati WHERE  users_id=$id);";
            $result=$conn->query($sql);
            $row=$result->fetch_assoc(); 
            
            if($result->num_rows>0){
            //check if the same date with records
            
                $datumUpisa=$row['datum'];
               
                if($datum == $datumUpisa){
                    $checkoutInfo= "You are allready registred on today";
                }else{
                    $sql="INSERT INTO evidencija_sati (`prijava`,`odjava`, `datum`, `users_id`) VALUES ('$vreme','$vreme','$datum','$id')";
                    $result=$conn->query($sql);        
                    $checkoutInfo = "You have successfully check in";   
                }  
        
            }else{
                $sql="INSERT INTO evidencija_sati (`prijava`,`odjava`, `datum`, `users_id`) VALUES ('$vreme','$vreme','$datum','$id')";
                $result=$conn->query($sql);        
                $checkoutInfo = "Uspesno ste se prijavili";
            }
        }
        }



}

?>


    <div class="container py-5">

    <div class="row d-flex justify-content-center">

        <div class="col-xl-5 col-sm-12 py-5">

        <h2 class="text-white text-center">Check in</h2>

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