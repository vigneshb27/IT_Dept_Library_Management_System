<link rel="stylesheet" href="css/userborrow.css">
<?php
  
  require("templates/header.php");
  
  if(isset($_SESSION['user'])){

    $un=$_SESSION['user'];
     $bid=$_GET['b_id'];
     $con=mysqli_connect("localhost","root","","lib");
     $res=mysqli_query($con,"SELECT * FROM staffusers WHERE staffid='$un';");
     $row=mysqli_fetch_array($res);
     $lim=$row['max_bow_lim'];
     //echo "$lim";
     if($lim==0){
        echo "<h3 style='color:red'>Sorry!! You have reached your maximum limit!!</h3>";
        ?>
        <div class="text-center"><a href="userprofile.php?selected=rb"><button class="btn btn-danger">Books Requests</button></a></div><br>
        <?php
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
       <h3> Transaction Confirmation </h1>
       <div class="form">
       <form method="POST" action="#">

          Select the excpected days to return book 
          <br><br>
            <select name="days" required class="form-select"> 
              
            <option name="days" value="1 day">1 day</option>
            <option name="days" value="3 days">3 days</option>
            <option name="days" value="7 days">7 days</option>
            <option name="days" value="14 days">14 days</option>
            <option name="days" value="30 days">1 month</option>
            <option name="days" value="60 days">2 months</option>
            <option name="days" value="150 days">5 months</option>
            
       </select>
       <br>
       <input type="submit" name="submitb"></div></form>
                   </thead><?php
                   if(isset($_POST['submitb'])){
                   $days=$_POST['days'];?>
                  <div class="col-md-12">
                 <div class="card mt-4">
                 <div class="card-body">
                 <div class="table-responsive">
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
                       
                       </tr><?php 
                  
                  
                   while($bisrow=mysqli_fetch_array($bis)){
                    $bisid=$bisrow['book_id'];
                    $query = "SELECT a1.name AS author_1, a2.name AS author_2, a3.name AS author_3,book_id,book_name,publisher_name,published_year,rack_type,edition,available_copies,availability FROM book AS b INNER JOIN publisher on b.publisher_id=publisher.publisher_id INNER JOIN rack on b.rack_id=rack.rack_id LEFT JOIN author AS a1 ON b.author1 = a1.author_id LEFT JOIN author AS a2 ON b.author2 = a2.author_id LEFT JOIN author AS a3 ON b.author3 = a3.author_id WHERE book_id='$bid';";
                    $query_run = mysqli_query($con, $query);
                    $rwnb=mysqli_fetch_array($query_run);
                    ?>
                   <tr>
                           <td><?= $bisrow['book_id']; ?></td>
                           <td><?= $rwn['book_name']; ?></td>
                           <td><?= $rwnb['author_1']; ?></td>
                           <td><?= $rwnb['author_2']; ?></td>
                           <td><?= $rwnb['author_3']; ?></td>
                           <td><?= $rwn['published_year']; ?></td>
                           <td><?= $rwn['edition']; ?></td>
                           <td><a href="borrowconfirm.php?book_id=<?php echo $bisid?>&days=<?php echo $days?>"><button class='btn btn-success' name="borrow">Borrow</button></a>
                          </tr>
                          </div>
<?php}  } 
        ?>
      
      <!--
      <form method="post"><input type="submit" class='btn btn-primary' name='sub' value='Confirm'>
       <input type="submit" class='btn btn-danger' name='can' value='Cancel'>
      </form>
                   -->
        <?php
        
       
    }
    }
  }}}

  else{
    echo "<script>alert('Please login to borrow!!')</script>";
    echo "<script>window.open('userlogin.php','_self')</script>";

  }
 
?>

</table></div>
<div class="text-center">
<a href="bookborrow.php"><button class="btn btn-danger">Back</button></a>
</div>
</div></div>
 <?php
  include("templates/footer.php");
  ?>