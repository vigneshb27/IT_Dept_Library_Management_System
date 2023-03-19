<?php
  include("templates/header.php");
  if(isset($_SESSION['user'])){
    $un=$_SESSION['user'];
    $bsid=$_GET['book_id'];
  $con=mysqli_connect("localhost","root","","lib");
  $row=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM books WHERE book_id='$bsid';"));
  $bid=$row['bhid'];
    $message="requested";
    $ins_trans =mysqli_query($con,"INSERT into request(book_id , username , requested_date,request_status) VALUES('$bsid','$un',current_timestamp(),'$message');");
    $ava_chnge=mysqli_query($con,"UPDATE staffusers SET max_bow_lim=max_bow_lim-1 WHERE staffid='$un';");
    $copies = mysqli_query($con,"UPDATE book SET available_copies= available_copies - 1 WHERE book_id='$bid'");   
    $chk=mysqli_query($con,"SELECT * FROM book WHERE book_id='$bid';");
    $updatebooks=mysqli_query($con,"UPDATE books SET availability='notavailable' WHERE book_id='$bsid';");
    $val=mysqli_fetch_array($chk);
    if($val['available_copies']==0){
        $copies = mysqli_query($con,"UPDATE book SET availability='notavailable' WHERE book_id='$bid'");  
    }
    echo "<script>alert('Borrowed successfully!!')</script>";
    echo "<script>window.open('userborrow.php?b_id=$bid','_self')</script>";    

  }
  else{
    echo "<script>alert('Please login to borrow!!')</script>";
    echo "<script>window.open('userlogin.php','_self')</script>";
  }
  

?>
 <?php
  include("templates/footer.php");
  ?>