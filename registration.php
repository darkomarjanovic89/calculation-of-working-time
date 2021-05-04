<?php
require_once "conn.php";
require_once "validation.php";
require_once "nav.php";
include "head.php";


$name = $surname = $telephone = $username = $password = $retypePassword = $succes = "";
$nameErr = $surnameErr = $telephoneErr = $usernameErr = $passwordErr =  $retypePasswordErr="";




if($_SERVER["REQUEST_METHOD"]=="POST"){


$validated= true;

$name=$_POST['name'];
$surname=$_POST['surname'];
$telephone=$_POST['telephone'];
$username=$_POST['username'];
$password=$_POST['password'];
$retypePassword=$_POST['password'];


    // Name validation
    if(textValidation($name)){
        $validated = false;
        $nameErr = textValidation($name);
    }
    else {
        $name = trim($name); //Odsecanje praznina pre i nakon stringa
        $name = preg_replace('/\s\s+/', ' ', $name); //Odsecanje duplih praznina unutar stringa
    }


    // Surname validation
    if(textValidation($surname)){
        $validated = false;
        $surnameErr = textValidation($surname);
    }
    else {
        $surname = trim($surname); //Odsecanje praznina pre i nakon stringa
        $surname = preg_replace('/\s\s+/', ' ', $surname); //Odsecanje duplih praznina unutar stringa
    }

    // Telephone validation
    if(numberValidation($telephone)){
            $validated = false;
            $telephoneErr = numberValidation($telephone);
        }


    // Username validation
    if(usernameValidation($username, $conn)){
        $validated = false;
        $usernameErr = usernameValidation($username, $conn);
    }

    // Password validation
    if(passwordValidation($password)){
        $validated = false;
        $passwordErr = passwordValidation($password);
    }

    // Retype password
    if(passwordValidation($retypePassword)){
        $validated = false;
        $retypePasswordErr = passwordValidation($retypePassword);
    }

    // Password == Retype password
    if($password != $retypePassword){
        $validated = false;
        $retypePasswordErr = "Password and Retype password must be the same";
    }
    else {
        $password =$password;
    }

}

if($validated){


        $sqlU = "SELECT * FROM users
        WHERE username = '$username'";
        $rezultat = $conn->query($sqlU);
        $br = $rezultat->num_rows;
        if($br != 0){
            $usernameErr = "Username allready taken";
        }else{
            $sql ="INSERT INTO users(username,password)
        VALUES
        ('$username','$password');";
        $conn->query($sql);
        $sql = "SELECT id FROM users
        WHERE username = '$username'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $sql="INSERT INTO radnici (`name`, `surname`, `telephone`, `users_id`) VALUES ('$name','$surname','$telephone','$id')";
        $result=$conn->query($sql); 

            if($result) {
            $succes="You have successfully registered!";
            }
            else {                
            $error="an error has occurred, " . $conn->error . "</p>";
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
    <title>Registry</title>
</head>
<body>
<div class="container py-5">
<div class="row d-flex justify-content-center">

    <div class="col-xl-5 col-sm-12 py-2">
                <h2 class="text-white text-center">Registration</h2>
             <!-- form -->
                <form action="" method="POST">
            <div class="mb-3">
               
                <input type="text" name="name" placeholder="Name" class="text-center form-control"><span class="text-danger"><?php echo $nameErr ?></span>
               
            </div>

            <div class="mb-3">
                <input type="text" name="surname"  placeholder="Surname" class="text-center  form-control"><span class="text-danger"><?php echo $surnameErr ?></span>
               
            </div>

            <div class="mb-3">
                <input type="text" name="telephone"  placeholder="Telephone" class="text-center form-control">
                <span class="text-danger"><?php echo $telephoneErr ?></span>
               
            </div>

            <div class="mb-3">
                <input type="text" name="username"  placeholder="Username" class="text-center form-control">
                <span class="text-danger"><?php echo $usernameErr ?></span>
               
            </div>
            <div class="mb-3">
                <input type="password" name="password"  placeholder="Password" class="text-center form-control">
                <span class="text-danger"><?php echo $passwordErr ?></span>
            </div>  
            <div class="mb-3">                
                <input type="password" name="retypePassword"  placeholder="Retype password" class="text-center form-control">
                <span class="text-danger"><?php echo $retypePasswordErr ?></span>
            </div>  
            <button type="submit" class="text-center btn btn-primary">Submit</button>
            <span class="text-danger"><?php echo $succes ?></span>
            </form>
        </div>    
    
    </div>

</div>
  
</body>
</html>