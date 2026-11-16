<?php 
$db = mysql_connect("localhost", "root", "");
      mysql_select_db("neo_hr",$db);

$file_handle = fopen($_FILES["uploadedfile"]['tmp_name'], "r");
$count=1;
while (!feof($file_handle) ) {

$line_of_text = fgetcsv($file_handle, 10000);


echo $query = "INSERT INTO tbldesignations(DesigName)
  	      VALUES ('".$line_of_text[0]."');";
echo "<br>";
//mysqli_query($db,$query);
$count=$count+1;
}

fclose($file_handle);


?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload </title>


</head>
<body>
<div class="container" id="container">
        <div  id="header">
          <div id="logo"><h1></h1></div>
		
    </div>
<!-- end header -->
	    <div id="content" >
	
		<div id="content_main" class="clearfix">
			<div id="main_panel_container" class="right">
			<div id="dashboard">
				
		        <div id="fail" class="info_div" style="display:none;"><span class="ico_cancel">Please enter some value in search criteria.</span></div>		
<div id="success" class="info_div"><span class="ico_success"><?php echo $count;?> Successfully Inserted!</span></div>		
			</div><!-- end #dashboard -->
			<!-- end #shortcuts -->
		  </div>
			        <?php include("../include/left.php");?>
<!-- end #sidebar -->
		</div><!-- end #content_main -->
		<!-- end #postedit -->
		<!-- end #tabledata -->
		<!-- end #section -->
		
	  <div id="panels" class="clearfix"><!-- end #photo --><!-- end #todo -->
        <!-- end #calendar -->
		</div>
	  <!-- end #panels -->
		<!-- end #dialog [if you don't want this, delete whole div and 6th line i custom.js -->
  </div>
	    <!-- end #content -->
  <!-- end #footer -->
</div>
<!-- end container -->

</body>
</html>