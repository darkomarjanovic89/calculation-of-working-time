<?php
session_start();
require_once "conn.php";
include "head.php";
include "nav.php";



$usernameErr = $passwordErr = "";

if($_SERVER['REQUEST_METHOD']=='POST'){
    
   
    //korisnik je poslao user name i pass i pokusao logovanje
$username =$conn->real_escape_string($_POST['username']);
$password =$conn->real_escape_string($_POST['password']);
$val = true;

if(empty($username)){
    $val=false;
    $usernameErr="Username cannot be left blank!";
}
if(empty($password)){
    $val=false;
    $passwordErr="Password cannot be left blank!";
}
if($val){
    
    $sql="SELECT * FROM users 
    WHERE username = '$username'";
    $result=$conn->query($sql);
    if($result->num_rows ==0){
        $usernameErr="This username doesn't exist!";
    }else{
        //postoji korisnik treba proveriti sifre
        $row=$result->fetch_assoc();
        $dbPass = $row['password'];
        $admin=$row['username'];
        
        
        if($dbPass != $password){
            $passwordErr="incorrect password!";
        }elseif($admin=='admin'){
            $_SESSION['id'] = $row['id'];
            $sql="SELECT CONCAT(radnici.name, ' ',radnici.surname) as 'full_name'
            from radnici
            INNER JOIN users
            ON users.id=radnici.users_id
            WHERE users.username='$username'";            
            
           
            $result=$conn->query($sql);
            $row=$result->fetch_assoc();
            $_SESSION['full_name']=$row['full_name'];
            header('Location: employers.php');

        }else{
           
            //ovde vrsimo logovanje
            $_SESSION['id'] = $row['id'];

            $sql="SELECT CONCAT(radnici.name, ' ',radnici.surname) as 'full_name'
            from radnici
            INNER JOIN users
            ON users.id=radnici.users_id
            WHERE users.username='$username'";            
            
           
            $result=$conn->query($sql);
            $row=$result->fetch_assoc();
            $_SESSION['full_name']=$row['full_name'];

            header('Location: user.php');

        }
    }

}

}

?>

<body>
    
    <div class="container">
         <div class="row d-flex justify-content-center">
            <div class="col-xl-5 col-sm-12 py-5">
                     <h2 class="text-center text-white py-4 ">Log in to your account</h2>
                <form action="" method="POST">
                            
                    <fieldset>
                        <input class=" form-control text-center  bg-primary" type="text" name="username" id="username" placeholder="username"><span class="text-danger">*<?php echo $usernameErr?></span>

                        <input  class=" form-control text-center mt-4  bg-primary" type="password" name="password" id="password" placeholder="password"><span class="text-danger">*<?php echo $passwordErr?></span>

                        <input class=" form-control text-center btn btn-primary mt-4" type="submit" value="Log in!">
                    </fieldset>

                </form>

                         
            </div>

        </div>
                      
    </div>


</body>
</html>