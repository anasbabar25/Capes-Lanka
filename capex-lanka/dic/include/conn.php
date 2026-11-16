<?php 
session_start();
error_reporting(0);
$conn=mysql_connect("localhost","root","");
mysql_select_db("dic_cp",$conn);
?>