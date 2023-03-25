<?php
include("templates/header.php");

if(isset($_SESSION['user'])){
$un=$_SESSION['user'];
$con=mysqli_connect("localhost","root","","lib");
$name=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM staffusers WHERE staffid='$un';"));
}
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
                 <!-- IMAGE include*/
            <div> <img class="img-thumbnail rounded-circle dim" src='images/prof.jfif'>
</div><br>-->
                <h5><b><?php echo $name['Name']; ?> </b></h5>
            </div>
           
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
               
                    <a>
                    <form method='post'>
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
     
     $req=mysqli_query($con,"SELECT * FROM request WHERE username='$un' and request_status='accepted' ORDER by exp_return;");
     $cntcheck=mysqli_num_rows(mysqli_query($con,"SELECT * FROM transactions WHERE req_id in ( SELECT req_id FROM request WHERE username='$un')"));
     if($cntcheck!=0){
     ?>
     <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th>Transaction Id</th>
                                <th>Request Id</th>
                                <th>Book Id</th>
                                <th>Book Name</th>
                                <th>Date of Borrow</th>
                                <th>Date to return</th>
                                <th>Receipt</th>

                                </tr>
                            </thead>
<?php
     while($res=mysqli_fetch_array($req)){
        $rid=$res['req_id'];
        $bid=$res['book_id'];
        $tn=mysqli_query($con,"SELECT * FROM transactions WHERE req_id = $rid ;");
        $trans=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM transactions WHERE req_id = $rid;"));
        $bhrw=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM books WHERE book_id='$bid'"));
        $bhid=$bhrw['bhid'];
        $bookdet=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM book WHERE book_id='$bhid';"));
          if($trans['return_status']=='not return')  {
        ?>
           
        <tr>
            <td> <?= $trans['trans_id']?></td>
            <td> <?= $rid?></td>
            <td> <?= $bid?></td>
            <td> <?= $bookdet['book_name']?></td>
            <td> <?= $trans['issued_date']?></td>
            <td> <?= $res['exp_return']?></td>
            <td><form method="POST"><button class='btn btn-info' name='getr'><a href="userprofile.php?selected=bb&reqid=<?php echo $rid;?>">Get Receipt</a></button></td>
        </tr>
        <?php } }?>
     </table></div>
        <?php
        if(isset($_GET['reqid'])){
            $rid=$_GET['reqid'];     
            $res=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM request WHERE req_id='$rid';"));
            $bid=$res['book_id'];
            $sid=$res['username'];
            $stf=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM staffusers WHERE staffid='$sid'"));
            $tn=mysqli_query($con,"SELECT * FROM transactions WHERE req_id = $rid;");
            $trans=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM transactions WHERE req_id = $rid;"));
            $bhrw=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM books WHERE book_id='$bid'"));
            $bhid=$bhrw['bhid'];
            $bookdet=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM book WHERE book_id='$bhid';"));
         
        ?></table></div></div></div>
      
<div class="card text-black" >
  <div class="card-body mx-4" >
    <div class="container text-black" >
        <div   id='card'><!-- class="d-none" added for not showing but printing-->
      <p class="my-5 mx-5 " style="font-size: 30px;color:black;text-align:center;"><b>Department of Information Technology</b></p>
      <div class="row">
        <ul class="list-unstyled">
          <li class="text-black"><?= $stf['Name'] ?></li>
          <li class="text-black mt-1"><span class="text-black"><?= $sid ?></span></li>
          <li class="text-black mt-1"><?= date('d-m-Y'); ?></li>
        </ul>
        <hr>
        <div class="col-xl-10">
          <p>Book ID</p>
        </div>
        <div class="col-xl-2">
          <p class="float-end text-black" ><?= $bhrw['book_id']?>
          </p>
        </div>
        <hr>
      </div>
      <div class="row">
        <div class="col-xl-10">
          <p>Book Name</p>
        </div>
        <div class="col-xl-2">
          <p class="float-end text-black"><?= $bookdet['book_name'];?>
          </p>
        </div>
        <hr>
      </div>
      <div class="row">
        <div class="col-xl-10">
          <p>Return date</p>
        </div>
        <div class="col-xl-2">
          <p class="float-end text-black"><?= $res['exp_return'];?>
          </p>
        </div>
        <hr>
      </div>
      <div class="row">
        <div class="col-xl-10">
          <p>Rack Number</p>
        </div>
        <div class="col-xl-2">
          <p class="float-end text-black"><?= $bookdet['rack_id'];?>
          </p>
        </div>
        <hr style="border: 2px solid black;">
      </div>
      <div class="row text-black">

        <div class="col-xl-12">
          <h3 class="float-end fs-100 fw-bold text-success">Accepted
        </h3>
        </div>
        <hr style="border: 2px solid black;">
      </div></div>
      <div class="text-center" style="margin-top: 90px;">
        <button class='btn btn-warning' onclick="printDiv('card')" >Print</button>
        <br><br>
        <p><i>Please take this receipt to collect your books.</i></p>
      </div>

    </div>
  </div>
</div>
<script>
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
<?php }
        }       
        else { ?>
            <p>No books in hand!!</p>
                <?php
            }
        } ?>
     
     <?php
    
    


if($s=='rb'){
    $con=mysqli_connect("localhost","root","","lib");
    $req=mysqli_query($con,"SELECT * FROM request WHERE username='$un' AND request_status='requested';");
    $cnt=mysqli_num_rows($req);
    if($cnt==0){
        ?>
        <p>No requests Pending</p>
        <?php
     }
     else{?>
        <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                    <div class="table-responsive">
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
     }
    ?></table></div><?php
    }

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
    
     $req=mysqli_query($con,"SELECT * FROM request WHERE username='$un'and request_status='accepted' ORDER BY exp_return;");
     $cntcheck=mysqli_num_rows(mysqli_query($con,"SELECT * FROM transactions WHERE req_id in ( SELECT req_id FROM request WHERE username='$un')"));
     if($cntcheck!=0){
     ?>
     <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th>Transaction Id</th>
                                <th>Request Id</th>
                                <th>Book Id</th>
                                <th>Book Name</th>
                                <th>Date of Borrow</th>
                                <th>Date to return</th>
                                <th> Days left</th>
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
        $now = time(); // or your date as well
        $your_date = strtotime($res['exp_return']);
        $datediff =   $your_date-$now;
        $rd=round($datediff / (60 * 60 * 24));
        if($trans['return_status']=="not return"){            
        ?>
           
        <tr>
            <td> <?= $trans['trans_id']?></td>
            <td> <?= $rid?></td>
            <td> <?= $bid?></td>
            <td> <?= $bookdet['book_name']?></td>
            <td> <?= $trans['issued_date']?></td>
            <td  <?php if($rd<0) echo "style='background-color:red;'"?>> <?= $res['exp_return']?></td>
            <td <?php if($rd<0) echo "style='background-color:red;'"?>> <?= $rd ?></td>
            <td> <form><button class='btn btn-success'><a href="userprofile.php?selected=rr&trans_id=<?php echo $trans['trans_id'];?>">Return</a></button>
        </tr>
        <?php
        

     }}?>
    </table></div><?php
    }
    else{?>
    <p>No books in hand!!</p>
        <?php
    }
}

?>

</div></div></div>
</div></div></div>
</body></html>

 <?php
  include("templates/footer.php");
  ?>
