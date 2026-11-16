<?php include("../../include/conn.php");  
 $dName=$_POST['uID'].'-USER';
$update=mysqli_query($db,"update tbldepts set dFlagstop='".$_POST['dFlagstop']."' WHERE dName='".$_POST['uID']."'"); 
$update=mysqli_query($db,"update tbldepts set dFlagstop='".$_POST['dFlagstop']."' WHERE dName='".$dName."'"); 
	  
?>