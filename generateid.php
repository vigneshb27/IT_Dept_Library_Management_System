<?php
$con=mysqli_connect("localhost","root","","lib");
$qp=mysqli_query($con,"SELECT * FROM book;");
$con1=mysqli_connect("localhost","root","","lib");
$cnt='007';
while($row=mysqli_fetch_array($qp)){
    $cp=$row['copies'];
    $bn=$row['book_name'];
   
    $a1=$row['author1'];
    
    $a2=$row['author2'];
   
    $a3=$row['author3'];

    $py=$row['published_year'];
   
    $pr=$row['publisher_id'];
    
    $rck=$row['rack_id'];
   
    $ed=$row['edition'];
    
    $avlb=$row['availability'];
    $k=$cp;
    while($k!=0){
      
    $d1=hexdec($cnt);
    $d2=hexdec('001');
    $cnt=dechex($d1+$d2);
    $cnt=str_pad($cnt, 3, "0", STR_PAD_LEFT);
    $bn = str_replace('\'', '', $bn);
    $bid="2023IT".strtoupper($cnt);
    echo $bid;
    $obid=$row['book_id'];
    echo "<br>";
    //$ins=mysqli_query($con1,"INSERT INTO books VALUES ('$bid','$bn','$a1','$a2','$a3','$pr','$py','$ed','$rck','available');");
    $ins=mysqli_query($con1,"INSERT INTO books VALUES ('$bid',$obid,'available');");
    if($ins==0){
        echo "Failed";
    }
    $k=$k-1;
}

}

?>