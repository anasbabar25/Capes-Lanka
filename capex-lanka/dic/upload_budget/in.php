<?php 
$db = mysql_connect("localhost", "root", "1234");
      mysql_select_db("neo",$db);

$file_handle = fopen($_FILES["uploadedfile"]['tmp_name'], "r");
$count=1;
while (!feof($file_handle) ) {

$line_of_text = fgetcsv($file_handle, 10000);


echo $query = "update tbluserinfodetail set E_Repid='".$line_of_text[1]."', E_Hod='".$line_of_text[2]."' where Userid='".$line_of_text[0]."';";
echo "<br>";
//mysqli_query($db,$query);
$count=$count+1;
}

fclose($file_handle);


?> 
