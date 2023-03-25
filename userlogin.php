<?php
session_start();
session_destroy();
include "templates/header.php";


?>
 
 
 
 <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Yinka Enoch Adedokun">
	<title>Login Page</title>
	
  
	<link rel="stylesheet" href="css/login.css">


<body >
	<!-- Main Content -->

  <center>
 
	<div class="container-fluid mt-4">
		<div class="row main-content bg-success text-center">
			<div class="col-md-4 text-center company__info">
				
				<h4 class="company_title">Today Reader, tomorrow a Leader!! <br><br> -Margaret Fuller</h4>
			</div>
			<div class="col-md-8 col-xs-12 col-sm-12 login_form ">
				<div class="container-fluid">
					<div class="row">
						<h2>Log In</h2>
					</div>
					<div class="row">
						<form method="post" class="form-group">
							<div class="row">
								<input type="text" name="username" id="username" class="form__input" placeholder="Username" required>
							</div>
							<div class="row">
							    <div >
								<input type="password" style="display:inline" name="password" id="password" class="form__input" placeholder="Password" required>
								<i class="bi bi-eye-slash " style="display:inline" id="togglePassword"></i>	</div>
								
							</div>
							<div class="row">
							<button type="submit" class="btn btn-primary" name="submit">Submit</button>
							</div>
						</form>
					</div>
					<div class="row">
						<p>Forgot password? <a href="sendpwd.php">Click Here</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</center>
</body>
<script>
	const togglePassword = document
            .querySelector('#togglePassword');
  
        const password = document.querySelector('#password');
  
        togglePassword.addEventListener('click', () => {
  
            // Toggle the type attribute using
            // getAttribure() method
            const type = password
                .getAttribute('type') === 'password' ?
                'text' : 'password';
                  
            password.setAttribute('type', type);
  
            // Toggle the eye and bi-eye icon
            togglePassword.classList.toggle('bi-eye');
        });
</script>
<?php
if(isset($_POST['submit'])){

$un=$_POST['username'];
$pwd=$_POST['password'];
$con=mysqli_connect("localhost","root","","lib");
$res=mysqli_query($con,"SELECT * FROM staffusers WHERE staffid='$un';");
$cnt=mysqli_num_rows($res);
echo $cnt;
if($cnt==0){
	echo "<script>alert('User does not exist')</script>";
}
else {
	$row=mysqli_fetch_array($res);
	if($row['pwd']!=$pwd)
	{
		echo "<script>window.alert('Wrong password!! you can try clicking the forgot passoword')</script>";
	}
	else{
		
		$_SESSION['user']=$un;
		echo "<script>window.open('userprofile.php','_self')</script>";
	}
}

}
?>
</html>
 <?php
  include("templates/footer.php");
  ?>