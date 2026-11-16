<?php   
$file_handle = fopen($_FILES["uploadedfile"]['tmp_name'], "r");
$count=1;
while (!feof($file_handle) ) {

$line_of_text = fgetcsv($file_handle, 10000);
$appraisal_id='2017-'.$line_of_text[1];

echo $query = "insert into login 
	(email, emp_no, appraisal_id, dob, password, 
	lock_status, 
	attempts, 
	Login_readinst, 
	Login_first, 
	admin_allow_phase1, 
	admin_allow_phase12, 
	admin_allow_phase2
	)
	values
	(
	'".$line_of_text[0]."','".$line_of_text[1]."','".$appraisal_id."', 
	'".$line_of_text[2]."', 
	'123', 
	'1', 
	'1', 
	'1', 
	'1', 
	'1', 
	'1', 
	'1'
	);";
echo "<br>";

//mysqli_query($db,$query);
$count=$count+1;
}

fclose($file_handle);


?> 
