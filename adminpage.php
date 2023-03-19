<?php

include "templates/header.php";
if(isset($_SESSION['admin'])){
    $admin=$_SESSION['admin'];
    $con = mysqli_connect("localhost","root","","lib");
    $cnt=mysqli_num_rows(mysqli_query($con,"SELECT * FROM books;"));
    $cur_year_books = mysqli_num_rows(mysqli_query($con,"SELECT * FROM purchase WHERE year = 2023;"));
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
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/fonts/simple-line-icons/style.min.css">
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
                <a href="adminpage.php?selected=pm" class=<?php if($s=='pm') echo "'active'"?>>Purchase History</a>
                <!--<input  type='submit' id='mu'   name="mu" value='Manage users'>-->
                </li>
                <li >
                <a href="adminpage.php?selected=bm" class=<?php if($s=='bm') echo "'active'"?>>Borrow Management</a>
                <!--<input  type='submit' id='bm'  name="bm" value='Borrow Management'>-->
                </li>
                <li >
                <a href="adminpage.php?selected=rm" class=<?php if($s=='rm') echo "'active'"?>>Return Requests</a>
                <!--<input  type='submit' id='rm'  name="rm" value='Return Management'>-->
                </li>
                <br>
                <form method='post'>
                    <a>
                <div class="logout"><a href='adminlogin.php'><i class="bi bi-box-arrow-right"></i> Logout</a></div>
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
  <div class=" col-sm-4">
    <div class="card borderclr">
      <div class="card-body">
      <i class="icon-book-open design-icon-book"></i><br><br>
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
      <i class="icon-bubbles design-icon-request"></i><br><br>
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
        if($cnt!=0){
        while($row=mysqli_fetch_array($brw) and $i!=2){
            $i=$i+1;
            ?>
             <td><?php echo $row['username'];?></td>
             <td><?php echo $row['book_id'];?></td>
        </tr>
        <?php
           }}
           else{
             echo "No requests";
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
      <i class="icon-wallet design-icon-wallet"></i><br><br>
      <p class="card-text text">Books purchased this year</p>
      <h5 class="card-title titlecss"><?php echo $cur_year_books ?></h5>
         <br>
        <a href="adminpage.php?selected=pm" class="btn btn-primary">More...</a>
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
      <i class="icon-user design-icon-student"></i><br><br>
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
         <button type="button" class = "head-button-view"><a href="booklist.php">View all books</a></button>&nbsp;&nbsp;&nbsp;
         <button type="button" class = "head-button-add"><a href="adminpage.php?selected=ab&opt=add">Add books</a></button>&nbsp;&nbsp;&nbsp;
         <button type="button" class = "head-button-remove"><a href="adminpage.php?selected=ab&opt=del">Remove books</a></button>
         <br><br>
    <?php
    if(isset($_GET['opt'])){
        $opt=$_GET['opt'];
        if($opt=='add'){ 
            /* FORM FOR ADDDING THE BOOKS*/
            ?>
            <div class="container h-100">
                <div class="row h-100 justify-content-center align-items-center">
                    
                        
                <form id="add-book" method="post">
                    
                    
    
                    <br><br>
                    <label for="bname">Book Name :</label>
                    <input type="text" name="bname"  id="bname" class="form-control" required>
                    <br><br>
                    <label for="bdm">Book Domain :</label>
                    <select id='bd' name='bd' class = "form-select"  required>
                       <option>IT</option>
                       <option>AIDS</option>
                    </select>
                    <br><br>
        <label for="a1">Author 1 </label>
        <input type="text" name="a1"  id="a1" class="form-control" required>
	  <br><br>
      <label for="s2"> Author 2 </label>
      <input type="text" name="a2"  id="a2" class="form-control">
	  <br><br>
      <label for="a3">Author 3 </label>
      <input type="text" name="a3"  id="a3" class="form-control" >
	  <br><br>
      <label for="pname">Publisher Name </label>
	  <input type="text" name="pname"  id="pname" class="form-control" >
	  <br><br>
      <label for="pyear">Published Year </label>
      <input type="text" name="pyear" id="pyear" class="form-control">
	  <br><br>
      <label for="ed">Edition </label>
	  <input type="text" name="ed" id="ed" class="form-control" >
	  <br><br>
      <label for="copies">No of Copies </label>
	  <input type="number" name="copies" id="copies" class="form-control" required>
	  <br><br>
      <label for="rack">Rack Type</label>
      <select name="rck" id= "rck" class = "form-select"  required>
        
            <?php
            $con = mysqli_connect("localhost","root","","lib");
     
  
    $sql = "SELECT * FROM rack";
    $all_categories = mysqli_query($con,$sql);
                while ($a3 = mysqli_fetch_array(
                        $all_categories,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $a3["rack_type"];
                ?>">
                    <?php echo $a3["rack_type"];
                        // To show the category name to the user
                    ?>
                </option>
                <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
	  <br><br>
     
	  <br><br><br>
	  <div class="form-submit"><input type="submit" value="Submit" name="addbook" id="form-submit" class="form-control"></div>
      <?php
       if(isset($_POST['addbook'])){
              $con=mysqli_connect("localhost","root","","lib");
              $cnt=mysqli_num_rows(mysqli_query($con,"SELECT * FROM book;"));
              $bookid=20000+$cnt+1;
              $bname=$_POST['bname'];
              $a1=$_POST['a1'];
              $a2=$_POST['a2'];
              $a3=$_POST['a3'];
              $pname=$_POST['pname'];
              $pr=$_POST['pyear'];
              $ed=$_POST['ed'];
              $cp=$_POST['copies'];
              $rck=$_POST['rck'];
              $dmn=$_POST['bd'];
              $cq=mysqli_query($con,"SELECT * FROM author WHERE name='$a1';");
              $cr=mysqli_fetch_array($cq);
              $c1=mysqli_num_rows($cq);
              $aid1=NULL;
              if($c1==0){
                //echo "A1 not found";
                /*INSERT INTO AUTHOR TABLE*/
                $cnt=mysqli_num_rows(mysqli_query($con,"SELECT * FROM author;"));
                $aid1=30000+$cnt+1;
            
                $ins=mysqli_query($con,"INSERT INTO author VALUES($aid1,'$a1');");
              }
              else{
                 $aid1=$cr['author_id'];
              }
              $cq=mysqli_query($con,"SELECT * FROM author WHERE name='$a2';");
              $cr=mysqli_fetch_array($cq);
              $c1=mysqli_num_rows($cq);
              $aid2=NULL;
              if($c1==0){
                //echo "A2 not found";
                /* Insert author in author table*/
                $cnt=mysqli_num_rows(mysqli_query($con,"SELECT * FROM author;"));
                $aid2=30000+$cnt+1;
                $ins=mysqli_query($con,"INSERT INTO author VALUES($aid2,'$a2');");
              }
              else{
                 $aid2=$cr['author_id'];
              }
              $cq=mysqli_query($con,"SELECT * FROM author WHERE name='$a3';");
              $cr=mysqli_fetch_array($cq);
              $c1=mysqli_num_rows($cq);
              $aid3=NULL;
              if($c1==0){
                //echo "A3 not found";
                /* Insert author in author table*/
                $cnt=mysqli_num_rows(mysqli_query($con,"SELECT * FROM author;"));
                $aid3=30000+$cnt+1;
                $ins= mysqli_query($con,"INSERT INTO author VALUES($aid3,'$a3');");
              }
              else{
                 $aid3=$cr['author_id'];
              }
              $pid=NULL;
              $cq=mysqli_query($con,"SELECT * FROM publisher WHERE publisher_name='$pname';");
              $cr=mysqli_fetch_array($cq);
              $c1=mysqli_num_rows($cq);
              if($c1==0){
                //echo "Publisher  not found";
                /* Insert author in author table*/
                $cnt=mysqli_num_rows(mysqli_query($con,"SELECT * FROM publisher;"));
                $pid=40000+$cnt+1;
                $ins=mysqli_query($con,"INSERT INTO publisher VALUES($pid,'$pname');");
              }
              else{
                 $pid=$cr['publisher_id'];
              }
              $rid=NULL;
              $cr=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM rack WHERE rack_type='$rck';"));
              $rid=$cr['rack_id'];
              echo $rid;
              echo $aid1;
              echo $aid2;
              echo $aid3;
              echo $pid;
              $res=mysqli_query($con,"INSERT INTO book VALUES($bookid,'$bname','$aid1','$aid2','$aid3','$pid','$pr','$ed','$cp','$rid','available',$cp);");
              if($res==1){
              $rup=mysqli_query($con,"UPDATE rack SET book_count=book_count+1 WHERE rack_id=$rid;");}
              $cnt=mysqli_num_rows(mysqli_query($con,"SELECT * FROM books;"));
              $cnt=$cnt+1;
              $hexval=dechex($cnt);
              $hexval=str_pad($hexval, 3, "0", STR_PAD_LEFT);
    
              $uniqid="2023".$dmn.strtoupper($cnt);
              $books=mysqli_query($con,"INSERT INTO books VALUES('$uniqid','$bookid','available')");

              /*Insert book and change the rack book count*/
       }
      ?>
	  <!--</center><a href="userlogin.html">Click to Login</a>-->
</div>
            </div>  
            </div>
</form>
       <?php }
        else if($opt=='del'){
            /* FORM FOR DELETING THE BOOK*/
            ?>
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    
                        <br><br>
                <form id="remove-book" method="post">
                    
                    <label for="bid">Book ID :</label>
                    <input type="text" name="bid"  id="bid" class="form-control" required>
    
                    <br><br><br>
                    <div class="form-submit"><input type="submit" value="Submit" name="delete"  id="form-submit" class="form-control"></div>
        
                    </div></div>

            <?php
          if(isset($_POST['delete'])){
            $b_id=$_POST['bid'];
            $brw=mysqli_query($con,"SELECT * FROM books WHERE book_id='$b_id'");
            $bid=$brw['bhid'];
            $rckq=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM book WHERE book_id=$bid;"));
            $rckid=$rckq['rack_id'];
            $rp=mysqli_query($con,"DELETE FROM book WHERE book_id=$bid;");
            $rup=mysqli_query($con,"UPDATE rack SET book_count=book_count-1 WHERE rack_id=$rckid;");
            $bdes=mysqli_query($con,"DELETE FROM books WHERE book_id='$b_id'");
            echo "Deleted Successfully";
          }            
        }
        
    }
    else {
        /*Image to show if none of the option is selected for crud books*/
        ?>
        <img src="images/admin.png" alt="helo" class = "admin-img">
        <?php
        }
}
else if($s=='mu'){
    $row=mysqli_query($con,"SELECT * FROM staffusers;");
    $staffcnt=mysqli_num_rows($row);?></form>
    <div class="row">
    <div class="h-100 d-flex align-items-center justify-content-center">
  <div class="col-sm-4">
    <div class="card borderclr">
      <div class="card-body">
      <i class="icon-user design-icon-student"></i><br><br>
        <p class="card-text text">Total number of Users (staffs)</p>
        <h5 class="card-title titlecss"><?php echo $staffcnt ?></h5>
         <br>
        
      </div>
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
            <td><?php echo $res['staffid'] ?></td>
            <td><?php echo $res['Name'];?></td>
            <td><?php echo $res['desig'];?></td>
            <td><?php echo $res['mail'];?></td>
            <td><?php echo $res['max_bow_lim'];?></td>
          </tr>
<?php
          }
        
      ?></table> 
        <button type="button" class="head-button-add"><a href="adminpage.php?selected=mu&opt=add">Add Users</a></button>&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" class="head-button-remove"><a href="adminpage.php?selected=mu&opt=del">Remove Users</a></button>
       
    
    <?php
   if(isset($_GET['opt'])){
    $opt=$_GET['opt'];
    if($opt=='add'){ 
        /* FORM FOR ADDDING THE USERS*/
        ?>
        <div class="container">
                <div class="row justify-content-center align-items-center">
                    
                        <br>
                <form id="add-user" method="post">
                    <label for="stfid">Staff Id</label>
                    <input type="text" name="stfid"  id="stfid" class="form-control" required>
                    <br><br>
                    <label for="name">Name</label>
                    <input type="text" name="name"  id="name" class="form-control" required>
                    <br><br>
                    <label for="desig">Designation</label>
                    <select name="desig"  id="desig" class = "form-select" required>
                    <option value="Professor">Professor</option>
                    <option value="Associate Professor">Associate Professor</option>
                    <option value="Assistant Professor [Sl Grade]">Assistant Professor [Sl Grade]</option>
                    <option value="Assistant Professor [Sr. Grade]">Assistant Professor [Sr. Grade]</option>
                    <option value="Teaching Fellow">Teaching Fellow</option>
                    <option value="Professional Assistant - I">Professional Assistant - I</option>
                    <option value="Professional Assistant - II">Professional Assistant - II</option>
                    </select>
                    <br><br>
                    <label for="email">Email</label>
                    <input type="email" name="email"  id="email" class="form-control" required>
                    <br><br>
                    <label for="pass">Password</label>
                    <input type="password" name="pass"  id="pass" class="form-control" required>
                    <br><br>

                    <div class="form-submit"><input type="submit" value="Submit" name="adduser" id="form-submit" class="form-control"></div>
        </form>
    <?php 
    if(isset($_POST['adduser'])){
          $id=$_POST['stfid'];
          $name=$_POST['name'];
          $des=$_POST['desig'];
          $em=$_POST['email'];
          $pwd=$_POST['pass'];
          $ins=mysqli_query($con,"INSERT INTO staffusers VALUES('$name','$des','$em','$pwd',4);");
    }
    }
    else if($opt=='del'){
        /* FORM FOR DELETING THE USERS*/
        ?>
        <div class="container">
                <div class="row justify-content-center align-items-center">
                    
                        <br>
                <form id="remove-user" method="post">
                    <label for="id">User ID</label>
                    <input type="text" name="id"  id="id" class="form-control" required>
                    <br><br>
                    <div class="form-submit"><input type="submit" value="Submit" name='deluser' id="form-submit" class="form-control"></div>
        </form>
        <?php
        if(isset($_POST['deluser'])){
             $id=$_POST['id'];
             $del=mysqli_query($con,"DELETE FROM staffusers WHERE staffid=$id;");
        }
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
                                <th>book_id</th>
                                <th>book_name</th>
                                <th>request_date</th>
                                <th>Accept</th>
                                <th>Decline</th>
                                </tr>
                            </thead>
<?php
                       
                    if ($con) {


                        if(isset($_GET["book_id"]) && isset($_GET["req_id"]) && isset($_GET["option"])){
                           
                            $req_id = $_GET["req_id"];
                            $bid = $_GET["book_id"];
                            $bsrw=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM books WHERE book_id='$bid';"));
                            $book_id=$bsrw['bhid'];
                            if( $_GET["option"]=="accept"){ 
                                
                                $status = "UPDATE request SET request_status = \"accepted\" WHERE req_id=$req_id";

                                if (mysqli_query($con, $status)) {
                                    //echo "status successful";
                                }
                                else {
                                        echo "Error: <br>" . mysqli_error($con);
                                }

                                $trans  = "INSERT INTO transactions(req_id, issued_date, due_date,return_status) VALUES ($req_id,CURRENT_TIMESTAMP,ADDDATE(CURRENT_TIMESTAMP,INTERVAL 3 MONTH),'not return')";
                               // $updatenot=mysqli_query($con,"UPDATE books SET availability='notavailable' WHERE book_id='$book_id';");
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
                                $update=mysqli_query($con,"UPDATE books SET availability='available' WHERE book_id='$bid';");
                                //5
                                $lim = "UPDATE staffusers SET max_bow_lim= max_bow_lim+1 WHERE staffid LIKE (SELECT username from request where req_id=$req_id)";                 
                                if (mysqli_query($con, $lim)){
                                    //echo "<br>limit decremented successful";
                                }
                                else   {
                                    echo "Error: " . $sql . "<br>" . mysqli_error($con);
                                }

                            }
                             
                        }

                        $query = "SELECT username,bhid,requested_date,req_id,request.book_id,request.request_status FROM request INNER JOIN books ON request.book_id=books.book_id WHERE request_status = 'requested' ";
                        $query_run = mysqli_query($con, $query);
                        
                        if(mysqli_num_rows($query_run) > 0){
                            
                            foreach($query_run as $items) {
                                $bhid=$items['bhid'];
                                $bnm=mysqli_fetch_array(mysqli_query($con,"SELECT * from book WHERE book_id='$bhid';"));
                                ?>
                                <tr>
                                    <td><?= $items['username']; ?></td>
                                    <td><?= $items['book_id'];?></td>
                                    <td><?= $bnm['book_name']; ?></td>
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
                            
                            $bid = $_GET["book_id"];
                            $bsrw=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM books WHERE book_id='$bid';"));
                            $book_id=$bsrw['bhid'];
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
                                $bookava=mysqli_query($con,"UPDATE books SET availability='available' WHERE book_id='$bid';");
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
                                    $lim = "UPDATE staffusers SET max_bow_lim= max_bow_lim + 1 WHERE staffid=(SELECT username FROM request Where req_id=(SELECT req_id from request where book_id='$bid' ) )";                 
                                    
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


                        $query = "SELECT transactions.trans_id,bhid,username,return_req_date,return_req_id,request.book_id,request.request_status FROM transactions INNER JOIN (request INNER JOIN books ON books.book_id = request.book_id) ON request.req_id=transactions.req_id INNER JOIN return_request ON transactions.trans_id = return_request.trans_id WHERE return_status = 'requested' ";
                        $query_run = mysqli_query($con, $query);
                        
                        if(mysqli_num_rows($query_run) > 0){
                            foreach($query_run as $items) {
                                $bhid=$items['bhid'];
                                $bnm=mysqli_fetch_array(mysqli_query($con,"SELECT * from book WHERE book_id='$bhid';"));
                                ?>
                                <tr>
                                    <td><?= $items['username']; ?></td>
                                    <td><?= $items['trans_id']; ?></td>
                                    <td><?= $bnm['book_name']; ?></td>
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
if($s=='pm'){    
    $con=mysqli_connect("localhost","root","","lib") ;          
     $row=mysqli_query($con,"SELECT * FROM purchase GROUP BY year ORDER BY year DESC;");
     while($re=mysqli_fetch_array($row)){
        ?><?php
        $yr=$re['year'];?>
        <div class="col-md-12">
                <div class="card mt-4">
                <div class="card-header">
                <h4 ><?=$re['year'];?></h4>
                </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th>Book_id</th>
                                <th>Name</th>
                                <th>Publisher</th>
                                <th>Month</th>
                                <th>Price</th>
                                </tr>
                            </thead>
                            <?php
          $data=mysqli_query($con,"SELECT * FROM purchase WHERE year=$yr;");
          while($rs=mysqli_fetch_array($data)){
            ?>
           <tr><td><?= $rs['book_id'];?></td>
           <td><?=  $rs['title'];?></td>
           <td><?= $rs['publisher'];?></td>
           <td><?= $rs['month'];?></td>
           <td><?= $rs['price'];?></td></tr>
          <?php }
        ?></table></div><br><?php  
        }
        
        } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
</body>
    </html>

    <?php
  include("templates/footer.php");
  ?>