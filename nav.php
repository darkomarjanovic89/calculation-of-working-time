
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">JBJ</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
    <?php 
      if(!isset($_SESSION['id'])){
       echo'    
    <li class="nav-item fw-bold active"> <a class="nav-link" href="index.php">Home </a> </li>
    <li class="nav-item fw-bold"><a class="nav-link" href="checkin.php"> Check in </a></li>
    <li class="nav-item fw-bold"><a class="nav-link" href="checkout.php"> Check out</a></li>
    <li class="nav-item fw-bold"><a class="nav-link" href="login.php">Log in</a></li>
    <li class="nav-item fw-bold"><a class="nav-link" href="registration.php">Registration</a></li>
  </li>';}else{
    echo'
    <h4 class="text-dark  fw-bold me-3 mt-1">Hello, '.$_SESSION["full_name"].'!</h4>
    <li class=" logout"><a class="  rounded-pill text-danger fw-bold" href="logout.php">Log out</a></li>';} ?>

    </ul>
          </div> 
   
    </div>
  </div>
</nav>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
 
