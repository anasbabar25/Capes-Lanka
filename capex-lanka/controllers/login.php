<?php 
session_start();
include("../include/conn.php");

//checking username and password
$eCode=mysqli_real_escape_string($db,$_POST['eCode']);
$ePassword=mysqli_real_escape_string($db,$_POST['ePassword']);

$check_user = mysqli_query($db,"SELECT * FROM tblemployees WHERE eCode='".mysqli_real_escape_string($db,$eCode)."' and 
                                                                 ePassword='".mysqli_real_escape_string($db,$ePassword)."'");
																 
$rs = mysqli_num_rows($check_user);
$row = mysqli_fetch_array($check_user);


if ( $rs > 0 ) {

$eCode          = $row['eCode'];
$eName          = $row['eName'];
$eDept          = $row['eDept'];


$_SESSION['eCode']         = $eCode;
$_SESSION['eName']         = $eName;
$_SESSION['eDept']         = $eDept;
$_SESSION['user']          = '0';
    header("location: ../index.php");

}
else{
	
	$check_user = mysqli_query($db,"SELECT * FROM tbldepts WHERE dName='".mysqli_real_escape_string($db,$eCode)."' and 
                                                                 dPassword='".mysqli_real_escape_string($db,$ePassword)."'");		
																 
																 
	$rs = mysqli_num_rows($check_user);
	$row = mysqli_fetch_array($check_user);


	if ( $rs > 0 ) {
		
	$_SESSION['eCode']         = $row['dID'];
	$_SESSION['eName']         = $row['dName'];
	$_SESSION['user']          = '1';
		
	header("location: ../index.php");	
	}else{
    header("location: ../login.php?login=false");
	}
}


?> 

