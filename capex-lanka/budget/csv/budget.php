<?php   
$file_handle = fopen($_FILES["uploadedfile"]['tmp_name'], "r");
$count=1;
while (!feof($file_handle) ) {

$line_of_text = fgetcsv($file_handle, 10000);


echo $query = "insert into tblbudget 
	(bDesc, bMDept, bDept, bTotal,bConsumed,bRemaining
	)
	values
	('".mysqli_real_escape_string($db,$line_of_text[0])."','".mysqli_real_escape_string($db,$line_of_text[1])."', '".mysqli_real_escape_string($db,$line_of_text[1])."', 
	 '".mysqli_real_escape_string($db,$line_of_text[3])."','".mysqli_real_escape_string($db,$line_of_text[4])."','".mysqli_real_escape_string($db,$line_of_text[5])."'
	);";
echo "<br>";

//mysqli_query($db,$query);
$count=$count+1;
}

fclose($file_handle);


?> 
