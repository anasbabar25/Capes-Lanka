<?php 
include('include/conn.php');
include('include/security.php');


$employees = mysqli_query($db,"SELECT * FROM tblemployees WHERE eCode='".$_SESSION['eCode']."'");
$employee = mysqli_fetch_array($employees);
?>
<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title><?php echo $title;?> -  CAPEX</title>
<link rel="icon" href="logo.png" type="image/x-icon">
<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" href="assets/icon.css?family=Material+Icons" type="text/css">
<!-- Dropzone Css -->
<link rel="stylesheet" href="assets/plugins/dropzone/dropzone.css">
<!-- Bootstrap Material Datetime Picker Css -->
<link rel="stylesheet" href="assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"/>
<!-- Wait Me Css -->
<link rel="stylesheet" href="assets/plugins/waitme/waitMe.css" />
<!-- Bootstrap Select Css -->
<link rel="stylesheet" href="assets/plugins/bootstrap-select/css/bootstrap-select.css"/>

<link rel="stylesheet" href="assets/css/main.css"/>
<style type="text/css">
<!--
.style4 {color: #CC0000}
-->
input {
height:20px;
border:solid 1px #333333;
margin:5px;
}

select{
height:20px;
border:solid 1px #333333;
margin:5px;
width:140px;
}
textarea {

border:solid 1px #333333;
margin:5px;
}
</style>

</head>

<body class="theme-cyan">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>

<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<!-- Top Bar -->
<?php include('include/header.php');?>
<!-- #Top Bar -->
<section> 
    <!-- Left Sidebar -->
<?php include('include/sidebar.php');?>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>New Suggestion</h2>
            <small class="text-muted">Welcome to capex application</small>
        </div>
        <div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					
					<div class="body">
					
					
					
					
                        <div class="row clearfix">
                           <form action="controllar.php?action=insert-suggestion" method="POST" enctype="multipart/form-data">
					<div class="container">
						<div class="home-offer-v6 box-wrapper mt-15">
							



				            <div class="row" style="margin:20px;">
					          <div>
					            <table width="100%" border="0">
                                
                                  <tr>
                                    <td><table width="100%"  >

                           
                                      <tr>
                                        <td><span class="style4">*</span>Detail:</td>
                                        <td>
                                          <textarea name="sDescription" cols="70" rows="5" id="sDescription" required></textarea>
                                       </td>
                                      </tr>
                                      
                                          <tr>
                                            <td colspan="6"><div align="center"><input type="submit" name="submit" id="submit" value="Save"></div><br></td>
                                          </tr>
                                        </table></td>
                                      </tr>

                                    </table></td>
                                  </tr>
                                </table>
					          </div>
                              
                               <div></div>
                               
                               
                              <div>                              </div>
                              <div></div>
                              
                              
                              
                              
                          </div>
                            						
							
						</div>
					</div><!-- //container	 -->
                    
                    </form>
  
  
                        </div>
                        
                        

						
                      
                    </div>
				</div>
			</div>
		</div>

	
	</div>
</section>

<div class="color-bg"></div>
<!-- Jquery Core Js --> 
<script src="assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
 
<script src="assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 

<script src="assets/plugins/autosize/autosize.js"></script> <!-- Autosize Plugin Js --> 
<script src="assets/plugins/momentjs/moment.js"></script> <!-- Moment Plugin Js -->
<script src="assets/plugins/dropzone/dropzone.js"></script> <!-- Dropzone Plugin Js -->
<!-- Bootstrap Material Datetime Picker Plugin Js --> 
<script src="assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script> 

<script src="assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->
<script src="assets/js/pages/forms/basic-form-elements.js"></script>
<script src="assets/js/mask.js"></script>
<script type="text/javascript" src="assets/js/jquery.number.js"></script>
<script type="text/javascript">
var dateToday = new Date(); 
$('#cpEDate').bootstrapMaterialDatePicker({

  // enable date picker
  date : true, 

  // enable time picker
  time : false, 

  // custom date format
  format : 'YYYY-MM-DD', 

  // min / max date
  minDate : dateToday, 
  maxDate : null, 

  // current date
  currentDate : null, 

  // Localization
  lang : 'en', 

  // week starts at
  weekStart : 0, 

  // short time format
  shortTime : false, 

    // text for cancel button
  'clearText' : 'Clear', 
  
  // text for cancel button
  'cancelText' : 'Cancel', 

  // text for ok button
  'okText' : 'OK' 

});

			
		
		
		
		</script>

	
	
		
		
		</body>

</html>