<?php 
if(!isset($_SESSION['tID'])){
header("location: login.php?login=false");
}
$title="Capital Expenditure Proposal ";
?>