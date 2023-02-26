<?php
session_start();
include "templates/header.php";
if(isset($_SESSION['admin'])){
    $admin=$_SESSION['admin'];
}
else{
    
        echo "<script>alert('Please login!!')</script>";
        echo "<script>window.open('adminlogin.php','_self')</script>";
    
}
if(isset($_GET['selected'])){
$s=$_GET['selected'];}
else{
    $s='vb';
}
?>

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
                  <a href="adminpage.php?selected=vb" class=<?php if($s=='vb') echo "'active'"?>>View Book Details</a>

                <!--
                <form method="post">
                    <input  id="vb" class="active" type='submit' name="vb" value='View Book Details'>
                 -->
                </li>
                <li >
                <a href="adminpage.php?selected=ab" class=<?php if($s=='ab') echo "'active'"?>>Add Book</a>
                <!-- <input  type='submit' id="ab"  name="ab" value=' Add Book'>-->
                </li>
                <li >
                <a href="adminpage.php?selected=mb" class=<?php if($s=='mb') echo "'active'"?>>Modify Book</a>
                <!--<input  type='submit'  id='mb'  name="mb" value='Modify Book'>-->
                    
                </li>
                <li >
                <a href="adminpage.php?selected=rb" class=<?php if($s=='rb') echo "'active'"?>>Remove Book</a>
                <!--<input  type='submit'  id='rb'  name="rb" value='Remove Book'>-->
                </li>
                <li > 
                <a href="adminpage.php?selected=mu" class=<?php if($s=='mu') echo "'active'"?>>Manage users</a>
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
                <input type='submit' value='Logout' name='logout'></form>
</form>
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
if($s=='bm'){?>

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




                        $con = mysqli_connect("localhost","root","","lib");
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
if($s=='rm'){
    ?>

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
                    }}     }                       
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

 