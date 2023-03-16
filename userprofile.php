<?php
include("templates/header.php");

if(isset($_SESSION['user'])){
$un=$_SESSION['user'];}
else{
    echo "<script>alert('Please login to borrow!!')</script>";
    echo "<script>window.open('userlogin.php','_self')</script>";
}
if(isset($_GET['selected'])){
    $s=$_GET['selected'];}
    else{
        $s='bb';
    }
?>
<style>
    .dim{
        width: 60%;
        height: 60%;
        margin-left:15%;
    }
    </style>
<link rel="stylesheet" href="css/adminpage.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<div class="wrapper">
        <!-- Sidebar  -->
        
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Profile</h3>
            </div>
            <!-- IMAGE include*/
            <div> <img class="img-thumbnail rounded-circle dim" src='images/prof.jfif'>
</div>-->
            <ul class="list-unstyled components">
               <!-- <p>Dummy Heading</p>-->
                <li>
                  <a href="userprofile.php?selected=bb" class=<?php if($s=='bb') echo "'active'"?>>Borrowed Books</a>

                <!--
                <form method="post">
                    <input  id="vb" class="active" type='submit' name="vb" value='View Book Details'>
                 -->
                </li>
                <li >
                <a href="userprofile.php?selected=rb" class=<?php if($s=='rb') echo "'active'"?>>Requested Book</a>
                <!-- <input  type='submit' id="ab"  name="ab" value=' Add Book'>-->
                </li>
                <li >
                <a href="userprofile.php?selected=rr" class=<?php if($s=='rr') echo "'active'"?>>Return book</a>
                <!--<input  type='submit'  id='mb'  name="mb" value='Modify Book'>-->
                    
                </li>
                <li >
                <a href="bookborrow.php" class=<?php if($s=='nb') echo "'active'"?>>Borrow Book</a>
                <!--<input  type='submit'  id='rb'  name="rb" value='Remove Book'>-->
                </li>
                <li > 
                <form method='post'>
                    <a>
                <div class="logout"><a href='userlogin.php'><i class="bi bi-box-arrow-right"></i> Logout</a></div>
                    </a>
                <!--<input  type='submit' id='mu'   name="mu" value='Manage users'>-->
                </li>
                
            </ul>

            
        </nav>
        <script >

$(document).ready(function () {
    $("input").click(function() { 
        var e=$(".active");
        $(e).removeClass("active");
        $(this).toggleClass("active");
          });
         
     });

</script>
<div id="content">
    <?php
    if(isset($_POST['logout'])){
        session_destroy();
        echo "<script>window.open('userlogin.php','_self');</script>";
    }
    else if($s=='bb'){
     $con=mysqli_connect("localhost","root","","lib");
     
     $req=mysqli_query($con,"SELECT * FROM request WHERE username='$un' and request_status='accepted' ;");
     $cntcheck=mysqli_num_rows(mysqli_query($con,"SELECT * FROM transactions WHERE req_id in ( SELECT req_id FROM request WHERE username='$un')"));
     if($cntcheck!=0){
     ?>
     <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th>Transaction Id</th>
                                <th>Request Id</th>
                                <th>Book Id</th>
                                <th>Book Name</th>
                                <th>Date of Borrow</th>
                                <th>Date to return</th>

                                </tr>
                            </thead>
<?php
     while($res=mysqli_fetch_array($req)){
        $rid=$res['req_id'];
        $bid=$res['book_id'];
        $tn=mysqli_query($con,"SELECT * FROM transactions WHERE req_id = $rid;");
        $trans=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM transactions WHERE req_id = $rid;"));
        $bhrw=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM books WHERE book_id='$bid'"));
        $bhid=$bhrw['bhid'];
        $bookdet=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM book WHERE book_id='$bhid';"));
            
        ?>
           
        <tr>
            <td> <?= $trans['trans_id']?></td>
            <td> <?= $rid?></td>
            <td> <?= $bid?></td>
            <td> <?= $bookdet['book_name']?></td>
            <td> <?= $trans['issued_date']?></td>
            <td> <?= $trans['due_date']?></td>
            
        </tr>
        <?php
        

     }
    }
    else{?>
    <p>No books in hand!!</p>
        <?php
    }

    }
if($s=='rb'){
    $con=mysqli_connect("localhost","root","","lib");
    $req=mysqli_query($con,"SELECT * FROM request WHERE username='$un' ;");
    $cnt=mysqli_num_rows($req);
    if($cnt==0){
        ?>
        <p>No requests made so far</p>
        <?php
     }
     else{?>
        <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                               
                                <th>Request Id</th>
                                <th>Book Id</th>
                                <th>Book Name</th>
                                <th>Date of Request</th>
                                <th>Status</th>

                                </tr>
                            </thead>
<?php
     while($res=mysqli_fetch_array($req)){
        $rid=$res['req_id'];
        $bsid=$res['book_id'];
        $rb=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM books WHERE book_id='$bsid';"));
        $bid=$rb['bhid'];
        $stat=$res['request_status'];
        $bookdet=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM book WHERE book_id='$bid';"));
        ?>
        <tr>
          
            <td> <?= $rid?></td>
            <td> <?= $bid?></td>
            <td> <?= $bookdet['book_name']?></td>
            <td> <?= $res['requested_date']?></td>
            <td> <?= $res['request_status']?></td>
        </tr>
        <?php
     }}

}
if($s=='rr'){
    $con=mysqli_connect("localhost","root","","lib");
    if(isset($_GET["trans_id"]) ){
       
        if(isset($_GET["trans_id"])){
        $trans_id = $_GET["trans_id"];
   
        
        $insert = mysqli_query($con,"INSERT INTO return_request(trans_id, return_req_date, return_req_status) VALUES ($trans_id,CURRENT_TIMESTAMP,'requested')");
        mysqli_query($con,"UPDATE transactions SET return_status='requested' WHERE trans_id=$trans_id;");
    }
    }
    
     $req=mysqli_query($con,"SELECT * FROM request WHERE username='$un'and request_status='accepted';");
     $cntcheck=mysqli_num_rows(mysqli_query($con,"SELECT * FROM transactions WHERE req_id in ( SELECT req_id FROM request WHERE username='$un')"));
     if($cntcheck!=0){
     ?>
     <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th>Transaction Id</th>
                                <th>Request Id</th>
                                <th>Book Id</th>
                                <th>Book Name</th>
                                <th>Date of Borrow</th>
                                <th>Date to return</th>

                                </tr>
                            </thead>
<?php
     while($res=mysqli_fetch_array($req)){
        
        $rid=$res['req_id'];
        //echo $rid;
        $bid=$res['book_id'];
        $trans=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM transactions WHERE req_id = $rid;"));
        $tn=mysqli_query($con,"SELECT * FROM transactions WHERE req_id = $rid;");
        $bhrw=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM books WHERE book_id='$bid'"));
        $bhid=$bhrw['bhid'];
        $bookdet=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM book WHERE book_id=$bhid;"));
        if($trans['return_status']=="not return"){            
        ?>
           
        <tr>
            <td> <?= $trans['trans_id']?></td>
            <td> <?= $rid?></td>
            <td> <?= $bid?></td>
            <td> <?= $bookdet['book_name']?></td>
            <td> <?= $trans['issued_date']?></td>
            <td> <?= $trans['due_date']?></td>
            <td> <form><button class='btn btn-success'><a href="userprofile.php?selected=rr&trans_id=<?php echo $trans['trans_id'];?>">Return</a></button>
        </tr>
        <?php
        

     }}
    }
    else{?>
    <p>No books in hand!!</p>
        <?php
    }
}

?>
