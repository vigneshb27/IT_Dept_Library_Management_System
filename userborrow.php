
<?php
  
  require("templates/header.php");
  echo "<h1 style='text-align: center'>Transaction Confirmation</h1>";
  if(isset($_SESSION['user'])){

    $un=$_SESSION['user'];
     $bid=$_GET['b_id'];
     $con=mysqli_connect("localhost","root","","lib");
     $res=mysqli_query($con,"SELECT * FROM staffusers WHERE staffid='$un';");
     $row=mysqli_fetch_array($res);
     $lim=$row['max_bow_lim'];
     //echo "$lim";
     if($lim==0){
        echo "<p style='color:red;align:center;font-size:30px'>Sorry!! You have reached your maximum limit!!</p>";
     }
     else{
       $rb=mysqli_query($con,"SELECT * FROM book WHERE book_id='$bid';");
       $rwn=mysqli_fetch_array($rb);
       $bis=mysqli_query($con,"SELECT * FROM books WHERE bhid='$bid' and availability='available';");
       if($rwn['available_copies']==0){
        echo "<p style='color:red;align:center;font-size:30px'>Sorry!! The book is not avialable</p>";
       }
       else{
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
                   </thead><?php
                   while($bisrow=mysqli_fetch_array($bis)){
                    $bisid=$bisrow['book_id'];
                    ?>
                   <tr>
                           <td><?= $bisrow['book_id']; ?></td>
                           <td><?= $rwn['book_name']; ?></td>
                           <td><?= $rwn['author1']; ?></td>
                           <td><?= $rwn['author2']; ?></td>
                           <td><?= $rwn['author3']; ?></td>
                           <td><?= $rwn['published_year']; ?></td>
                           <td><?= $rwn['edition']; ?></td>
                           <td><a href="borrowconfirm.php?book_id=<?php echo $bisid?>"><button class='btn btn-success'>Borrow</button></a>
                          </tr>
<?php}   
        ?>
      
      <!--
      <form method="post"><input type="submit" class='btn btn-primary' name='sub' value='Confirm'>
       <input type="submit" class='btn btn-danger' name='can' value='Cancel'>
      </form>
                   -->
        <?php
        
       
    }
    }
  }}
  else{
    echo "<script>alert('Please login to borrow!!')</script>";
    echo "<script>window.open('userlogin.php','_self')</script>";

  }
 
?>