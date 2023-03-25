<?php
session_start();
session_destroy();
include "templates/header.php";
?>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Yinka Enoch Adedokun">
	<title>Login Page</title>
	
  
	<link rel="stylesheet" href="css/login.css">

</head>
<body >
	<!-- Main Content -->

  <center>
 
	<div class="container-fluid mt-4">
		<div class="row main-content bg-success text-center">
			<div class="col-md-4 text-center company__info">
				
				<h4 class="company_title">"Books are a uniquely portable magic" <br><br> - Stephen King</h4>
			</div>
			<div class="col-md-8 col-xs-12 col-sm-12 login_form ">
				<div class="container-fluid">
					<div class="row">
						<h2>Admin panel</h2>
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
$res=mysqli_query($con,"SELECT * FROM admin WHERE staffid='$un';");
$cnt=mysqli_num_rows($res);
echo $cnt;
if($cnt==0){
	echo "<script>alert('User does not exist')</script>";
}
else {
	$row=mysqli_fetch_array($res);
	if($row['password']!=$pwd)
	{
		echo "<script>window.alert('Wrong password!! you can try clicking the forgot passoword')</script>";
	}
	else{
	
		$_SESSION['admin']=$un;
        echo "<script>window.open('adminpage.php','_self')</script>";

	}
}

}
?>
 <?php
  include("templates/footer.php");
  ?>