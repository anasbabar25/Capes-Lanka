<?php 
include("../include/conn.php");
if(isset($_SESSION['dID'])){
$ndppass=$_POST['ndppass'];

$update=mysqli_query($db,"UPDATE tbldepts SET dPassword='".$ndppass."' WHERE dID='".$_SESSION['dID']."'");
header("location: ../change-password.php?password=change");
}

?> 

