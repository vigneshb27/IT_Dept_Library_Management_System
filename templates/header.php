

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./Images/annaUniv.svg">
    <title>Department of Information Technology | MIT Campus, Anna University</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.1.slim.min.js"
        integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans">
    
      
</head>
<body>
    <div class="entire">
    <header>
        <img src="./images/annauniv.svg" alt="">
        <div class="heading">
            <div class="heading-title">Department of Information Technology</div>
            <div class="heading-dept">Anna University , MIT Campus</div>
            <div class="heading-lib">Library Management System</div>
        </div>
</header>
        <nav class="navbar sticky-top navbar-expand-lg navbar-dark">
  
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-center" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="home.php"><i class="bi bi-house-door-fill"></i> Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://www.it.mitindia.edu/"><i class="bi bi-info-square-fill"></i> IT website</a>
      </li>
      <?php 
      session_start();
      $con=mysqli_connect("localhost","root","","lib");
      if(isset($_SESSION['user'])){
        $id=$_SESSION['user'];
        $res=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM staffusers WHERE staffid='$id';"));
        ?>
         <li class="nav-item">
        <a class="nav-link" href="adminlogin.php"><i class="bi bi-person-rolodex"></i> Admin Login</a>
      </li>
         <li class="nav-item">
        <a class="nav-link" href="userprofile.php"><i class="bi bi-people-fill"></i> <?php echo $res['Name'];?></a>
      </li>
        <?php
      }
      else if(isset($_SESSION['admin'])){
        $id=$_SESSION['admin'];
        $res=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM staffusers WHERE staffid='$id';"));
        ?>
         <li class="nav-item">
        <a class="nav-link" href="userlogin.php"><i class="bi bi-people-fill"></i> User Login</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" href="adminpage.php"><i class="bi bi-person-rolodex"></i> <?php echo  $res['Name'];?></a>
      </li>
        <?php
      }
       else{
         ?>
         <li class="nav-item">
        <a class="nav-link" href="userlogin.php"><i class="bi bi-people-fill"></i> User Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="adminlogin.php"><i class="bi bi-person-rolodex"></i> Admin Login</a>
      </li>

         <?php
       }
      ?>
     
     
      
    </ul>
    
  </div>
</nav>
</div>