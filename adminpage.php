<?php

include "templates/header.php";
if(isset($_SESSION['admin'])){
    $admin=$_SESSION['admin'];
    $con = mysqli_connect("localhost","root","","lib");
    $cnt=mysqli_num_rows(mysqli_query($con,"SELECT * FROM book;"));

}
else{
    
        echo "<script>alert('Please login!!')</script>";
        echo "<script>window.open('adminlogin.php','_self')</script>";
    
}
if(isset($_GET['selected'])){
$s=$_GET['selected'];}
else{
    $s='db';
}
?>
<style>
  
    .borderclr{
        border-color: rgba(10, 1, 35, 0.933);
        border-width: 10px;
        background-color: rgba(10, 1, 35, 0.933);
        color: white;
        text-align:center;
        padding-top:10%;
        
    }
    .titlecss{
        font-size:400%;
    }
    .text{
        color:white;
    }
    .borderclr1{
        border-color: rgba(10, 1, 35, 0.933);
        border-width: 5px;        
        color: rgba(10, 1, 35, 0.933);;
    }
    .table-text{
        color:white;
    }
    
    </style>
<link rel="stylesheet" href="css/adminpage.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<div class="wrapper">
        <!-- Sidebar  -->
        
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Admin Panel</h3>
            </div>

            <ul class="list-unstyled components">
               <!-- <p>Dummy Heading</p>-->
                <li>
                  <a href="adminpage.php?selected=db" class=<?php if($s=='db') echo "'active'"?>>Dashboard</a>

                <!--
                <form method="post">
                    <input  id="vb" class="active" type='submit' name="vb" value='View Book Details'>
                 -->
                </li>
                <li >
                <a href="adminpage.php?selected=ab" class=<?php if($s=='ab') echo "'active'"?>>CRUD on Books</a>
                <!-- <input  type='submit' id="ab"  name="ab" value=' Add Book'>-->
                </li>

                <li > 
                <a href="adminpage.php?selected=mu" class=<?php if($s=='mu') echo "'active'"?>>CRUD on users</a>
                <!--<input  type='submit' id='mu'   name="mu" value='Manage users'>-->
                </li>
                <li > 
                <a href="adminpage.php?selected=pm" class=<?php if($s=='pm') echo "'active'"?>>Purchase Management</a>
                <!--<input  type='submit' id='mu'   name="mu" value='Manage users'>-->
                </li>
                <li >
                <a href="adminpage.php?selected=bm" class=<?php if($s=='bm') echo "'active'"?>>Borrow Management</a>
                <!--<input  type='submit' id='bm'  name="bm" value='Borrow Management'>-->
                </li>
                <li >
                <a href="adminpage.php?selected=rm" class=<?php if($s=='rm') echo "'active'"?>>Return Management</a>
                <!--<input  type='submit' id='rm'  name="rm" value='Return Management'>-->
                </li>
                <form method='post'>
                    <a>
                <input type='submit' value='Logout' name='logout'>
                    </a>
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
        <!-- Page Content  -->
        <div id="content">

<?php
if(isset($_POST['logout'])){
    session_destroy();
    echo "<script>window.open('adminlogin.php','_self');</script>";
}
if($s=='db'){
    ?>
   <div class="row">
  <div class="col-sm-4">
    <div class="card borderclr">
      <div class="card-body">
        <p class="card-text text">Total number of books</p>
        <h5 class="card-title titlecss"><?php echo $cnt ?></h5>
         <br>
        <a href="booklist.php" class="btn btn-primary">More..</a>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card borderclr">
      <div class="card-body">
        <h5 class="card-title">Borrow Request Pending</h5>
        <p class="card-text">
        
                        <table class="table table-bordered table-text">
                            <thead>
                                <tr>
                                <th>user_name</th>
                                <th>book_id</th>
                                
                                </tr>
                            </thead> <tr>
        <?php 
        $brw=mysqli_query($con,"SELECT * FROM request WHERE request_status='Requested'");
        $i=0;
        $cnt=mysqli_num_rows($brw);
        //echo $cnt;
        while($row=mysqli_fetch_array($brw) and $i!=5){
            $i=$i+1;
            ?>
             <td><?php echo $row['username'];?></td>
             <td><?php echo $row['book_id'];?></td>
              
        <?php
           }?>
       </tr>
        </table></p>
        <a href="adminpage.php?selected=bm" class="btn btn-primary">More..</a>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card borderclr">
      <div class="card-body">
        <h5 class="card-title">Purchase history</h5>
        <p class="card-text">Adding table to dsiplay purchase history</p>
        <a href="#" class="btn btn-primary">More...</a>
      </div>
    </div>
  </div>
</div>
<br>
  <br>
<div class="row">
  <div class="col-sm-4">
    <div class="card borderclr">
      <div class="card-body">
        <h5 class="card-title">Student Donated books</h5>
        <p class="card-text">Student books</p>
        <a href="#" class="btn btn-primary">More..</a>
      </div>
    </div>
  </div>
  
  <div class="col-sm-4">
    <div class="card borderclr">
      <div class="card-body">
        <h5 class="card-title">Widget 5</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card borderclr">
      <div class="card-body">
        <h5 class="card-title">Widget 6</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div>
</div>
    <?php
   
}
else if($s=='ab'){
    ?>
         <button type="button" class="btn btn-primary btn-lg"><a href="booklist.php">View all books</a></button>
         <button type="button" class="btn btn-success btn-lg"><a href="adminpage.php?selected=ab&opt=add">Add books</a></button>
         <button type="button" class="btn btn-danger btn-lg"><a href="adminpage.php?selected=ab&opt=del">Remove books</a></button>
         
    <?php
    if(isset($_GET['opt'])){
        $opt=$_GET['opt'];
        if($opt=='add'){
            /* FORM FOR ADDDING THE BOOKS*/
        }
        else if($opt=='del'){
            /* FORM FOR DELETING THE BOOK*/
        }
    }
}
else if($s=='mu'){
    $row=mysqli_query($con,"SELECT * FROM staffusers;");
    $staffcnt=mysqli_num_rows($row);?>
    <div class="row">
  <div class="col-sm-4">
    <div class="card borderclr">
      <div class="card-body">
        <p class="card-text text">Total number of Users (staffs)</p>
        <h5 class="card-title titlecss"><?php echo $staffcnt ?></h5>
         <br>
        
      </div>
    </div>
  </div>
  <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th>Staff id</th>
                                <th>Staff Name</th>
                                <th>Designation</th>
                                <th>Email Id</th>
                                <th>Allowed book count</th>
                               
                                </tr>
                            </thead>

      <?php

          while($res=mysqli_fetch_array($row)){
?>
          <tr>
            <td><?php /* YET TO ADD STAFF IDS HERE*/ ?></td>
            <td><?php echo $res['Name'];?></td>
            <td><?php echo $res['desig'];?></td>
            <td><?php echo $res['mail'];?></td>
            <td><?php echo $res['max_bow_lim'];?></td>
          </tr>
<?php
          }
        
      ?></table> 
        <button type="button" class="btn btn-success btn-lg"><a href="adminpage.php?selected=mu&opt=add">Add Users</a></button>
        <button type="button" class="btn btn-danger btn-lg"><a href="adminpage.php?selected=mu&opt=del">Remove Users</a></button>
       
    
    <?php
   if(isset($_GET['opt'])){
    $opt=$_GET['opt'];
    if($opt=='add'){
        /* FORM FOR ADDDING THE USERS*/
    }
    else if($opt=='del'){
        /* FORM FOR DELETING THE USERS*/
    }
}

}

else if($s=='bm'){?>

    <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th>user_name</th>
                                <th>book_name</th>
                                <th>request_date</th>
                                <th>Accept</th>
                                <th>Decline</th>
                                </tr>
                            </thead>
<?php
                       
                    if ($con) {

                        if(isset($_GET["book_id"]) && isset($_GET["req_id"]) && isset($_GET["option"])){
                            $book_id = $_GET["book_id"];
                            $req_id = $_GET["req_id"];
                            if( $_GET["option"]=="accept"){ 
                                
                                $status = "UPDATE request SET request_status = \"accepted\" WHERE req_id=$req_id";

                                if (mysqli_query($con, $status)) {
                                    //echo "status successful";
                                }
                                else {
                                        echo "Error: <br>" . mysqli_error($con);
                                }

                                $trans  = "INSERT INTO transactions(req_id, issued_date, due_date,return_status) VALUES ($req_id,CURRENT_TIMESTAMP,ADDDATE(CURRENT_TIMESTAMP,INTERVAL 3 MONTH),'not return')";
                                if (mysqli_query($con, $trans)){
                                    //echo "inserted into  transaction";
                                }
                            }   
                            if($_GET["option"]=="decline" ){ 
                                //1
                                $status = "UPDATE request SET request_status = \"declined\" WHERE req_id=$req_id";

                                if (mysqli_query($con, $status)) {
                                    //echo "<br>status successful";
                                }
                                else {
                                        echo "Error: <br>" . mysqli_error($con);
                                }
                                //2
                                $ava_cop = "SELECT available_copies FROM book where book_id=$book_id";
                                $ava_cop_run = mysqli_query($con, $ava_cop);
                                $ava_cop_items = $ava_cop_run->fetch_array(); 

                                if ($ava_cop_items['available_copies'] == 0)  {
                                    //3
                                    $ins_book = "UPDATE book SET availability='available' WHERE book_id=$book_id";
                                    if (mysqli_query($con, $ins_book)){
                                           // echo "<br>Availability change successful";
                                    }
                                    else {
                                            echo "Error: <br>" . mysqli_error($con);
                                    }
                                }
                                else echo $ava_cop_items['available_copies'];
                                //4
                                $copies = "UPDATE book SET available_copies= available_copies + 1 WHERE book_id=$book_id";                 
                                if (mysqli_query($con, $copies)){
                                    //echo "<br>Copies incremented successful";
                                }
                                else   {
                                    echo "Error: " . $sql . "<br>" . mysqli_error($con);
                                }
                                //5
                                $lim = "UPDATE user SET max_bow_lim= max_bow_lim+1 WHERE username LIKE (SELECT username from request where req_id=$req_id)";                 
                                if (mysqli_query($con, $lim)){
                                    //echo "<br>limit decremented successful";
                                }
                                else   {
                                    echo "Error: " . $sql . "<br>" . mysqli_error($con);
                                }

                            }
                             
                        }

                        $query = "SELECT username,book_name,requested_date,req_id,request.book_id,request.request_status FROM request INNER JOIN book ON request.book_id=book.book_id WHERE request_status = 'requested' ";
                        $query_run = mysqli_query($con, $query);
                        
                        if(mysqli_num_rows($query_run) > 0){
                            foreach($query_run as $items) {

                                ?>
                                <tr>
                                    <td><?= $items['username']; ?></td>
                                    <td><?= $items['book_name']; ?></td>
                                    <td><?= $items['requested_date']; ?></td>
                                    <?php $req_id = $items['req_id'];$book_id=$items['book_id'];?>
                                    <td><a style="color:green;" href="adminpage.php?selected=bm&option=accept&book_id=<?php echo $book_id; ?>&req_id=<?php echo $req_id; ?>" >Accept</a> </td>
                                    <td><a style="color:red;"  href="adminpage.php?selected=bm&option=decline&book_id=<?php echo $book_id; ?>&req_id=<?php echo $req_id; ?>" >Decline</a> </td>
                                </form>
                                    </tr>
                                    <?php                                    
                                }
                                
                               
                    }
                    else {
                        ?>
                            <tr>
                                <td colspan="4">No Requests Found</td>
                            </tr>
                        <?php
                    }}}                            
if($s=='rm'){?>

<div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th>user_name</th>
                                <th>trans_id</th>
                                <th>book_name</th>
                                <th>return_request_date</th>
                                <th>Accept</th>
                                <th>Decline</th>
                                </tr>
                            </thead>


                    
                    <?php 
                        $con = mysqli_connect("localhost","root","","lib");
                    if ($con) {

                        if(isset($_GET["book_id"]) && isset($_GET["return_req_id"]) && isset($_GET["trans_id"]) && isset($_GET["option"])){
                            $book_id = $_GET["book_id"];
                            $return_req_id = $_GET["return_req_id"];
                            $trans_id = $_GET["trans_id"];

                            if( $_GET["option"]=="accept"){ 
                                //1
                                $status = "UPDATE return_request SET return_req_status = \"accepted\" WHERE return_req_id=$return_req_id";

                                if (mysqli_query($con, $status)) {
                                 //   echo "status successful";
                                }
                                else {
                                        echo "Error: <br>" . mysqli_error($con);
                                }
                                //2
                                $trans  = "UPDATE transactions SET return_status='returned',returned_date=CURRENT_TIMESTAMP WHERE trans_id = $trans_id";
                                if (mysqli_query($con, $trans)){
                                    //echo "inserted into  transaction";
                                }
                                else {
                                    //echo "Error: <br>" . mysqli_error($con);
                                }


                                $ava_cop = "SELECT available_copies FROM book where book_id=$book_id";
                                    $ava_cop_run = mysqli_query($con, $ava_cop);
                                    $ava_cop_items = $ava_cop_run->fetch_array(); 

                                    if ($ava_cop_items['available_copies'] == 0)  {
                                        //3
                                        $ins_book = "UPDATE book SET availability='available' WHERE book_id=$book_id";
                                        if (mysqli_query($con, $ins_book)){
                                               // echo "Availability change successful";
                                        }
                                        else {
                                                //echo "Error: <br>" . mysqli_error($con);
                                         }
                                     }
                                     //4
                                    $copies = "UPDATE book SET available_copies= available_copies + 1 WHERE book_id=$book_id";                 
                                    
                                    if (mysqli_query($con, $copies)){
                                       // echo "Copies decrement successful";
                                    }
                                    else   {
                                        //echo "Error: " . $sql . "<br>" . mysqli_error($con);
                                    }  
                                    //5
                                    $lim = "UPDATE user SET max_bow_lim= max_bow_lim + 1 WHERE username=(SELECT username FROM request Where req_id=(SELECT req_id from request where book_id=$book_id ) )";                 
                                    
                                    if (mysqli_query($con, $lim)){
                                        //echo "limit increment successful";
                                    }
                                    else   {
                                       // echo "Error: " . $sql . "<br>" . mysqli_error($con);
                                    }                           

                            }   

                            if($_GET["option"]=="decline" ){ 
                                $status = "UPDATE return_request SET return_req_status = \"declined\" WHERE return_req_id=$return_req_id";

                                if (mysqli_query($con, $status)) {
                                    echo "status successful";
                                }
                                else {
                                        echo "Error: <br>" . mysqli_error($con);
                                }

                                $trans  = "UPDATE transactions SET return_status='not return' WHERE trans_id = $trans_id";
                                if (mysqli_query($con, $trans)){
                                    echo "inserted into  transaction";
                                }
                                else {
                                    echo "Error: <br>" . mysqli_error($con);
                                }

                            }
                           
                        }


                        $query = "SELECT transactions.trans_id,username,book_name,return_req_date,return_req_id,request.book_id,request.request_status FROM transactions INNER JOIN (request INNER JOIN book ON book.book_id = request.book_id) ON request.req_id=transactions.req_id INNER JOIN return_request ON transactions.trans_id = return_request.trans_id WHERE return_status = 'requested' ";
                        $query_run = mysqli_query($con, $query);
                        
                        if(mysqli_num_rows($query_run) > 0){
                            foreach($query_run as $items) {

                                ?>
                                <tr>
                                    <td><?= $items['username']; ?></td>
                                    <td><?= $items['trans_id']; ?></td>
                                    <td><?= $items['book_name']; ?></td>
                                    <td><?= $items['return_req_date']; ?></td>
                                    <?php 
                                        $return_req_id = $items['return_req_id'];
                                        $book_id=$items['book_id'];
                                        $trans_id =  $items['trans_id'];
                                    ?>
                                    <td><a style="color:green;" href="adminpage.php?selected=rm&option=accept&book_id=<?php echo $book_id; ?>&return_req_id=<?php echo $return_req_id; ?>&trans_id=<?php echo $trans_id; ?>" >Accept</a> </td>
                                    <td><a style="color:red;" href="adminpage.php?selected=rm&option=decline&book_id=<?php echo $book_id; ?>&return_req_id=<?php echo $return_req_id; ?>&trans_id=<?php echo $trans_id; ?>" >Decline</a> </td>
                                </form>
                                    </tr>
                                    <?php                                    
                                }
                                
                               
                    }
                    else {
                        ?>
                            <tr>
                                <td colspan="4">No Requests Found</td>
                            </tr>
                        <?php
                    }}}
                    

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
