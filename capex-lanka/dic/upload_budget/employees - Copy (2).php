<?php   
$file_handle = fopen($_FILES["uploadedfile"]['tmp_name'], "r");
$count=1;
while (!feof($file_handle) ) {

$line_of_text = fgetcsv($file_handle, 10000);
$appraisal_id='2017-'.$line_of_text[0];

echo $query = "insert into employee 
	(appraisal_id, appraisal_year, emp_no, 
	emp_name, 
	designation, 
	dept_name, 
	grade, 
	dob, 
	appointment_date, 
	grade_change, 
	email, 
	accesslevel, 
	location, 
	hod, 
	line_manager, 
	division, 
	qualification
	)
	values
	(
	'".$appraisal_id."', '2017', '".$line_of_text[0]."', 
	'".mysqli_real_escape_string($db,$line_of_text[1])."', 
	'".mysqli_real_escape_string($db,$line_of_text[2])."', 
	'".mysqli_real_escape_string($db,$line_of_text[3])."', 
	'".mysqli_real_escape_string($db,$line_of_text[4])."', 
	'".$line_of_text[5]."', 
	'".$line_of_text[6]."', 
	'".$line_of_text[7]."', 
	'".$line_of_text[8]."', 
	'".$line_of_text[9]."', 
	'".$line_of_text[10]."', 
	'".mysqli_real_escape_string($db,$line_of_text[11])."', 
	'".mysqli_real_escape_string($db,$line_of_text[12])."', 
	'".mysqli_real_escape_string($db,$line_of_text[13])."', 
	'".mysqli_real_escape_string($db,$line_of_text[14])."'
	);";
echo "<br>";

//mysqli_query($db,$query);
$count=$count+1;
}

fclose($file_handle);


?> 
