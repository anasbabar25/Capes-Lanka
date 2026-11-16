<?php   
$file_handle = fopen($_FILES["uploadedfile"]['tmp_name'], "r");
$count=1;
while (!feof($file_handle) ) {

$line_of_text = fgetcsv($file_handle, 10000);


echo $query = "update employee set accesslevel='".$line_of_text[1]."',hod='".$line_of_text[2]."' where emp_no='".$line_of_text[0]."';";
echo "<br>";

//mysqli_query($db,$query);
$count=$count+1;
}

fclose($file_handle);


?> 
