
<?php

require("templates/header.php"); 
?>

    <style>
.form{
	display:none;
}


</style>
<link rel="stylesheet" href="css/search.css">
<script>
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
    	var demovalue = $(this).val(); 
        $("div.form").hide();
        $("#show"+demovalue).show();
        $("#table_display").hide();
    });
    
});

$(function() {
        var $radios = $('input:radio[name=demo]');
        if(!document.location.search.length) {
            $radios.filter('[value=Book]').prop('checked', true);
            $("#showBook").show();
        }
        
        
        
    });
    function disp_tab()
    {
        if(document.location.search.length) {
             document.getElementById("table_display").style.display = "block"// query string exists
        } else {
            console.log("No display")
             document.getElementById("table_display").style.display = "none"// no query string exists
        }
    }
    

</script>
</head>
<body onload = "disp_tab()">
         
        </div>
    <!--form start-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                    <div class = "structure">
                        <h2>Information Technology Library</h2>
                        <!--radio button start-->
                        <input type="radio" name="demo" value="Book"/> Book name &nbsp&nbsp&nbsp
                        <input type="radio" name="demo" value="Author"/> Author name &nbsp&nbsp&nbsp
                        <input type="radio" name="demo" value="Publisher"/> Publisher name &nbsp&nbsp&nbsp
                        <input type="radio" name="demo" value="Domain"/> Type/ Domain
                        <!--radio button start-->
                    </div>
                    
                    <div class = "input_display">
                        
                            
                                <div id="showBook" class="form">
                                <strong>Search by Book name :</strong><br><br>
                                <form id="MyForm" action="" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" name="search_by_book" required value="<?php if(isset($_GET["search_by_book"])){echo $_GET["search_by_book"]; } ?>" class="form-control" placeholder="Search data">&nbsp
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                                </div>
                                <div id="showAuthor" class="form">
                                <strong>Search by Author name :</strong><br><br>
                                <form id="MyForm" action="" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" name="search_by_author" required value="<?php if(isset($_GET["search_by_author"])){echo $_GET["search_by_author"]; } ?>" class="form-control" placeholder="Search data">&nbsp
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                                </div>
                                <div id="showPublisher" class="form">
                                <strong>Search by Publisher name :</strong><br><br>
                                <form id="MyForm" action="" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" name="search_by_publ" required value="<?php if(isset($_GET["search_by_publ"])){echo $_GET["search_by_publ"]; } ?>" class="form-control" placeholder="Search data">&nbsp
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                                </div>
                                <div id="showDomain" class="form">
                                <strong>Search by Book type :</strong><br><br>
                                <form action="" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" name="search_by_type" required value="<?php if(isset($_GET["search_by_type"])){echo $_GET["search_by_type"]; } ?>" class="form-control" placeholder="Search data">&nbsp
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!--form end -->
            <div id="table_display">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <th>book_id</th>
                                    <th>Book_Name</th>
                                    <th>First author</th>
                                    <th>Second Author</th>
                                    <th>Third Author</th>
                                    <th>Publisher Name</th>
                                    <th>Published Year</th>
                                    <th>Edition</th>
                                    <th>Copies</th>
                                    <th>Book Type</th>
                                    <th>Availability</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $con = mysqli_connect("localhost","root","","lib");
                                    /*------------book name----------------------------- */
                                    if(isset($_GET['search_by_book']))
                                    {
                                        $filtervalues = $_GET['search_by_book'];
                                        $query = "SELECT a1.name AS author_1, a2.name AS author_2, a3.name AS author_3,book_id,book_name,publisher_name,published_year,rack_type,edition,available_copies,availability FROM book AS b INNER JOIN publisher on b.publisher_id=publisher.publisher_id INNER JOIN rack on b.rack_id=rack.rack_id LEFT JOIN author AS a1 ON b.author1 = a1.author_id LEFT JOIN author AS a2 ON b.author2 = a2.author_id LEFT JOIN author AS a3 ON b.author3 = a3.author_id WHERE book_name LIKE '%$filtervalues%'";
                                        $query_run = mysqli_query($con, $query);

                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            foreach($query_run as $items)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?= $items['book_id']; ?></td>
                                                    <td><?= $items['book_name']; ?></td>
                                                    <td><?= $items['author_1']; ?></td>
                                                    <td><?= $items['author_2']; ?></td>
                                                    <td><?= $items['author_3']; ?></td>
                                                    <td><?= $items['publisher_name']; ?></td>
                                                    <td><?= $items['published_year']; ?></td>
                                                    <td><?= $items['edition']; ?></td>
                                                    <td><?= $items['available_copies']; ?></td>
                                                    <td><?= $items['rack_type']; ?></td>
                                                    <td><?= $items['availability']; ?></td>
                                               </tr>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                                <tr>
                                                    <td colspan="4">No Record Found</td>
                                                </tr>
                                            <?php
                                        }
                                    }
                    /*------------book name----------------------------- */
                    /*------------author name----------------------------- */
                    if(isset($_GET['search_by_author']))
                    {
                        $filtervalues = $_GET['search_by_author'];
                        $query = "SELECT a1.name AS author_1, a2.name AS author_2, a3.name AS author_3,book_id,book_name,publisher_name,published_year,rack_type,edition,available_copies,availability FROM book AS b INNER JOIN publisher on b.publisher_id=publisher.publisher_id INNER JOIN rack on b.rack_id=rack.rack_id LEFT JOIN author AS a1 ON b.author1 = a1.author_id LEFT JOIN author AS a2 ON b.author2 = a2.author_id LEFT JOIN author AS a3 ON b.author3 = a3.author_id WHERE a1.name LIKE '%$filtervalues%' or a2.name LIKE '%$filtervalues%' or a3.name LIKE '%$filtervalues%'";
                        $query_run = mysqli_query($con, $query);

                        if(mysqli_num_rows($query_run) > 0)
                        {
                            foreach($query_run as $items)
                            {
                                ?>
                                <tr>
                                <?$_SESSION["book_id"] = $items['book_id'];?>
                                    <td><?= $items['book_id']; ?></td>
                                    <td><?= $items['book_name']; ?></td>
                                    <td><?= $items['author_1']; ?></td>
                                    <td><?= $items['author_2']; ?></td>
                                    <td><?= $items['author_3']; ?></td>
                                    <td><?= $items['publisher_name']; ?></td>
                                    <td><?= $items['published_year']; ?></td>
                                    <td><?= $items['edition']; ?></td>
                                    <td><?= $items['available_copies']; ?></td>
                                    <td><?= $items['rack_type']; ?></td>
                                    <td><?= $items['availability']; ?></td>
                                       </tr>
                                <?php
                            }
                        }
                        else
                        {
                            ?>
                                <tr>
                                    <td colspan="4">No Record Found</td>
                                </tr>
                            <?php
                        }
                    }
                    /*------------author name----------------------------- */
                    /*------------publisher name----------------------------- */
                    if(isset($_GET['search_by_publ']))
                    {
                        $filtervalues = $_GET['search_by_publ'];
                        $query = "SELECT a1.name AS author_1, a2.name AS author_2, a3.name AS author_3,book_id,book_name,publisher_name,published_year,rack_type,edition,available_copies,availability FROM book AS b INNER JOIN publisher on b.publisher_id=publisher.publisher_id INNER JOIN rack on b.rack_id=rack.rack_id LEFT JOIN author AS a1 ON b.author1 = a1.author_id LEFT JOIN author AS a2 ON b.author2 = a2.author_id LEFT JOIN author AS a3 ON b.author3 = a3.author_id WHERE publisher_name LIKE '%$filtervalues%'";
                        $query_run = mysqli_query($con, $query);

                        if(mysqli_num_rows($query_run) > 0)
                        {
                            foreach($query_run as $items)
                            {
                                ?>
                                <tr>
                                <?$_SESSION["book_id"] = $items['book_id'];?>
                                    <td><?= $items['book_id']; ?></td>
                                    <td><?= $items['book_name']; ?></td>
                                    <td><?= $items['author_1']; ?></td>
                                    <td><?= $items['author_2']; ?></td>
                                    <td><?= $items['author_3']; ?></td>
                                    <td><?= $items['publisher_name']; ?></td>
                                    <td><?= $items['published_year']; ?></td>
                                    <td><?= $items['edition']; ?></td>
                                    <td><?= $items['available_copies']; ?></td>
                                    <td><?= $items['rack_type']; ?></td>
                                    <td><?= $items['availability']; ?></td>
                                </tr>
                                <?php
                            }
                        }
                        else
                        {
                            ?>
                                <tr>
                                    <td colspan="4">No Record Found</td>
                                </tr>
                            <?php
                        }
                    }
                    /*------------publisher name----------------------------- */
                    /*------------type name----------------------------- */
                    if(isset($_GET['search_by_type']))
                    {
                        $filtervalues = $_GET['search_by_type'];
                        $query = "SELECT a1.name AS author_1, a2.name AS author_2, a3.name AS author_3,book_id,book_name,publisher_name,published_year,rack_type,edition,available_copies,availability FROM book AS b INNER JOIN publisher on b.publisher_id=publisher.publisher_id INNER JOIN rack on b.rack_id=rack.rack_id LEFT JOIN author AS a1 ON b.author1 = a1.author_id LEFT JOIN author AS a2 ON b.author2 = a2.author_id LEFT JOIN author AS a3 ON b.author3 = a3.author_id WHERE rack_type LIKE '%$filtervalues%'";
                        $query_run = mysqli_query($con, $query);

                        if(mysqli_num_rows($query_run) > 0)
                        {
                            foreach($query_run as $items)
                            {
                                ?>
                                <tr>
                                <?$_SESSION["book_id"] = $items['book_id'];?>
                                    <td><?= $items['book_id']; ?></td>
                                    <td><?= $items['book_name']; ?></td>
                                    <td><?= $items['author_1']; ?></td>
                                    <td><?= $items['author_2']; ?></td>
                                    <td><?= $items['author_3']; ?></td>
                                    <td><?= $items['publisher_name']; ?></td>
                                    <td><?= $items['published_year']; ?></td>
                                    <td><?= $items['edition']; ?></td>
                                    <td><?= $items['available_copies']; ?></td>
                                    <td><?= $items['rack_type']; ?></td>
                                    <td><?= $items['availability']; ?></td>
                                   
                                </tr>
                                <?php
                            }
                        }
                        else
                        {
                            ?>
                                <tr>
                                    <td colspan="4">No Record Found</td>
                                </tr>
                            <?php
                        }
                    }
                    /*------------type name----------------------------- */                
                                ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
<?php
// Set session variables
$_SESSION["user_id"] = /*$_GET['search']*/4567 ;
?>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
