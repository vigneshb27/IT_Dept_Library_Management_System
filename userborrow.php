
<?php
  session_start();
  require("templates/header.php");
  echo "<h1 style='text-align: center'>Transaction Confirmation</h1>";
  if($_SESSION['user']){
    $un=$_SESSION['user'];
     $bid=$_GET['b_id'];
     $con=mysqli_connect("localhost","root","","lib");
     $res=mysqli_query($con,"SELECT * FROM staffusers WHERE mail='$un';");
     $row=mysqli_fetch_array($res);
     $lim=$row['max_bow_lim'];
     //echo "$lim";
     if($lim==0){
        echo "<p style='color:red;align:center;font-size:30px'>Sorry!! You have reached your maximum limit!!</p>";
     }
     else{
       $rb=mysqli_query($con,"SELECT * FROM book WHERE book_id='$bid';");
       $rwn=mysqli_fetch_array($rb);
       
       ?>
       <div class="col-md-12">
       <div class="card mt-4">
           <div class="card-body">
               <table class="table table-bordered">
                   <thead>
                       <tr>
                       <th>Book-id</th>
                       <th>Book-Name</th>
                       <th>Author 1</th>
                       <th>Author 2</th>
                       <th>Author 3</th>
                       <th>Published year</th>
                       <th>Edition</th>
                       
                       </tr>
                   </thead>
                   <tr>
                           <td><?= $rwn['book_id']; ?></td>
                           <td><?= $rwn['book_name']; ?></td>
                           <td><?= $rwn['author1']; ?></td>
                           <td><?= $rwn['author2']; ?></td>
                           <td><?= $rwn['author3']; ?></td>
                           <td><?= $rwn['published_year']; ?></td>
                           <td><?= $rwn['edition']; ?></td></tr></table>
<?php
       if($rwn['available_copies']==0){
        echo "<p style='color:red;align:center;font-size:30px'>Sorry!! The book is not avialable</p>";
       }
       else{
        $message = 'Requested';
       
       
        ?>
      <form method="post"><input type="submit" class='btn btn-primary' name='sub' value='Confirm'>
       <input type="submit" class='btn btn-danger' name='can' value='Cancel'>
      </form>

        <?php
        if(isset($_POST['sub'])){
        $ins_trans =mysqli_query($con,"INSERT into request(book_id , username , requested_date,request_status) VALUES($bid,'$un',current_timestamp(),'$message');");
        $ava_chnge=mysqli_query($con,"UPDATE staffusers SET max_bow_lim=max_bow_lim-1 WHERE mail='$un';");
        $copies = mysqli_query($con,"UPDATE book SET available_copies= available_copies - 1 WHERE book_id=$bid");   
        $chk=mysqli_query($con,"SELECT * FROM book WHERE book_id='$bid';");
        $val=mysqli_fetch_array($chk);
        if($val['available_copies']==0){
            $copies = mysqli_query($con,"UPDATE book SET availability='notavailable' WHERE book_id=$bid");  
        }
        echo "<p style='color:green'>Your request was submitted successfully to the admin.</p>";
        }
        if(isset($_POST['can'])){
            echo "<script>window.open('home.php','_self')</script>";
        }
    }
    }
  }
  else{
    echo "<script>alert('Please login to borrow!!')</script>";
    echo "<script>window.open('userlogin.php','_self')<script>";

  }
 
?>