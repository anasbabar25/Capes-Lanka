<?php 
$file_handle = fopen($_FILES["uploadedfile"]['tmp_name'], "r");
$count=1;
while (!feof($file_handle) ) {

$line_of_text = fgetcsv($file_handle, 10000);



echo $query = "INSERT INTO reportedto(id,level1)
  	      VALUES ('".$line_of_text[0]."','".$line_of_text[1]."');";
echo "<br>";
//mysqli_query($db,$query);
$count=$count+1;
}

fclose($file_handle);


?> 
