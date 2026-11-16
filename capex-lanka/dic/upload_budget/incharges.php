<?php 
$db = mysql_connect("localhost", "root", "");
      mysql_select_db("neo_hr",$db);

$file_handle = fopen($_FILES["uploadedfile"]['tmp_name'], "r");
$count=1;
while (!feof($file_handle) ) {

$line_of_text = fgetcsv($file_handle, 10000);



echo $query = "INSERT INTO tblusers(UserName, UserPassword, UserType)
  	      VALUES ('".$line_of_text[0]."','neo@123','incharge');";
echo "<br>";
//mysqli_query($db,$query);
$count=$count+1;
}

fclose($file_handle);


?> 
