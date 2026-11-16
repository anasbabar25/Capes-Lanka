<?php 
include('include/conn.php');
include('include/security.php');
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
            <h2>Suggestions</h2>
            <small class="text-muted">Welcome to capex application</small>
        </div>
       <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
					   
						<h2> Suggestions</h2>
						<input type="button" name="new" id="new" value="New Suggestion" onclick="window.location='new-suggestion.php';" style="float:right;">
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                  <th>Serial #</th>
								  <th>Detail</th>        
								  <th>Created By</th>
								  <th>Created On</th>
								  
                                </tr>
                                </thead>
								 <tbody>
								<?php 
							$select_s=mysqli_query($db,"select * from tblsuggestions order by sID desc");
							while($row_s=mysqli_fetch_array($select_s)){
								$select2=mysqli_query($db,"select dName from tbldepts where dID='".$row_s['dID']."'");
								$row2=mysqli_fetch_array($select2);
							?>
															
                         
                          <tr>
						  <td><?php echo $row_s['sID'];?></td>

						  <td><textarea name="sDescription" cols="50" rows="3"  id="sDescription" readonly style="border:1px solid #f2f2f2;background-color:#f2f2f2;color:#5d5d5d;"><?php echo $row_s['sDescription'];?></textarea></td>
						 
						  <td><?php echo $row2['dName'];?></td>
						  <td><?php echo $row_s['sDate'];?></td>
			              
					      </tr>
						<?php 
							 
						   } 
						 ?>
									 
                                </tbody>
                            </table>
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

	<script type="text/javascript">
			
			$(function(){
				// Set up the number formatting.
				$('#cpCostL').number( true, 2 );
			    $('#cpCostI').number( true, 2 );
				$('#cpCDL').number( true, 2 );
				$('#cpCDI').number( true, 2 );
				$('#cpOthersL').number( true, 2 );
				$('#cpOthersI').number( true, 2 );
				$('#cpGSTL').number( true, 2 );
				$('#cpGSTI').number( true, 2 );
				$('#cpFCA').number( true, 2 );
				$('#cpFCR').number( true, 2 );
				
				
				
			
			});
		</script>
		<script>
		
		
	
	

		function cal(){
			var cpCostL=document.getElementById("cpCostL").value;
			var cpCostI=document.getElementById("cpCostI").value;
			var cpCDL=document.getElementById("cpCDL").value;
			var cpCDI=document.getElementById("cpCDI").value;
			var cpOthersL=document.getElementById("cpOthersL").value;
			var cpOthersI=document.getElementById("cpOthersI").value;
			var cpGSTL=document.getElementById("cpGSTL").value;
			var cpGSTI=document.getElementById("cpGSTI").value;


	            var cpFCA=document.getElementById("cpFCA").value;
				var cpFCR=document.getElementById("cpFCR").value;

			
            cpCostL   = cpCostL.replace(/,/g, '');
			cpCostI   = cpCostI.replace(/,/g, '');
			cpCDL     = cpCDL.replace(/,/g, '');
			cpCDI     = cpCDI.replace(/,/g, '');
			cpOthersL = cpOthersL.replace(/,/g, '');
			cpOthersI = cpOthersI.replace(/,/g, '');
			cpGSTL    = cpGSTL.replace(/,/g, '');
            cpGSTI    = cpGSTI.replace(/,/g, '');
		    cpFCA     = cpFCA.replace(/,/g, '');
			cpFCR     = cpFCR.replace(/,/g, '');	
			
			var cpTot=   ( cpCostL * 1 ) + ( cpCostI * 1 ) + ( cpCDL * 1 ) + ( cpCDI * 1 ) + ( cpOthersL * 1 )  +
			             ( cpOthersI * 1 ) + ( cpGSTL * 1 ) + ( cpGSTI * 1 ); 
 
			if(cpTot>0){	
			document.getElementById("cpTot").value=cpTot;
            $('#cpTot').number( true, 2 );  
			}
			
		}
		
		
				
		function cal2(){
			
			var cpFCA = document.getElementById("cpFCA").value;
			var cpFCR = document.getElementById("cpFCR").value;
			cpFCA     = cpFCA.replace(/,/g, '');
			cpFCR     = cpFCR.replace(/,/g, '');	
			
			
			var cpFC  = cpFCA * cpFCR;
			document.getElementById("cpCostI").value=cpFC;
			$('#cpCostI').number( true, 2 );
			var cpCostL=document.getElementById("cpCostL").value;
			//document.getElementById("cpCostI").value = cpFC;
			var cpCDL=document.getElementById("cpCDL").value;
			var cpCDI=document.getElementById("cpCDI").value;
			var cpOthersL=document.getElementById("cpOthersL").value;
			var cpOthersI=document.getElementById("cpOthersI").value;
			var cpGSTL=document.getElementById("cpGSTL").value;
			var cpGSTI=document.getElementById("cpGSTI").value;
			

			
			
			var cpTot=   ( cpCostL * 1 ) + ( cpFC * 1 ) + ( cpCDL * 1 ) + ( cpCDI * 1 ) + ( cpOthersL * 1 )  +
			             ( cpOthersI * 1 ) + ( cpGSTL * 1 ) + ( cpGSTI * 1 ); 
			if(cpTot>0){	
			document.getElementById("cpTot").value=cpTot;
			$('#cpTot').number( true, 2 );
			}
			
		}
		function check_form(){
		
		var cpTot=document.getElementById("cpTot").value;
	
		 if(cpTot=="" || cpTot==0){
		    alert("Amount must be greater than 0.");
			return false;
		 }
		 
		 return true;
		 
		
		}
		function show_s(val){
		    
			if(val==1){
			document.getElementById("cpBudgetRef").style.display="none";
			document.getElementById("cpSBudgetRef").style.display="none";
            document.getElementById("cpSBudgetRef2").style.display="block";		
            document.getElementById("cpBudgetRef2").style.display="none";
            document.getElementById("cpBudgetRef3").style.display="none";	
            document.getElementById("cpBudgetRef4").style.display="none";
            document.getElementById("cpBudgetRef5").style.display="none";
			document.getElementById("cpBudgetRef6").style.display="none";
			}
			
			if(val==2){
			document.getElementById("cpBudgetRef").style.display="block";
			document.getElementById("cpSBudgetRef").style.display="none";
			document.getElementById("cpSBudgetRef2").style.display="none";
			document.getElementById("cpBudgetRef2").style.display="block";
            document.getElementById("cpBudgetRef3").style.display="block";	
            document.getElementById("cpBudgetRef4").style.display="block";
            document.getElementById("cpBudgetRef5").style.display="block";
			document.getElementById("cpBudgetRef6").style.display="block";	
			}
			
			if(val==3){
			document.getElementById("cpBudgetRef").style.display="none";
			document.getElementById("cpSBudgetRef").style.display="block";
			document.getElementById("cpSBudgetRef2").style.display="none";
			document.getElementById("cpBudgetRef2").style.display="none";
            document.getElementById("cpBudgetRef3").style.display="none";	
            document.getElementById("cpBudgetRef4").style.display="none";
            document.getElementById("cpBudgetRef5").style.display="none";
			document.getElementById("cpBudgetRef6").style.display="none";
			}
			
			
			
		
		}
		
		
		
		function check_budget1(val){
			 
			 var cpBudgetRef2 = document.getElementById("cpBudgetRef2").value;
			 var cpBudgetRef3 = document.getElementById("cpBudgetRef3").value;
			 var cpBudgetRef4 = document.getElementById("cpBudgetRef4").value;
			 var cpBudgetRef5 = document.getElementById("cpBudgetRef5").value;
			 var cpBudgetRef6 = document.getElementById("cpBudgetRef6").value;
			 
			 
			 if(val==cpBudgetRef2){
				 document.getElementById("show_msg1").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef3){
				 
				  document.getElementById("show_msg1").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef4){
				 
				  document.getElementById("show_msg1").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef5){
				 
				  document.getElementById("show_msg1").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef6){
				 
				  document.getElementById("show_msg1").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else{
				  document.getElementById("show_msg1").style.display="none";
				  document.getElementById("block_form").value='0';
				  return true;
			 }
			 
			
		}



		function check_budget2(val){
			 
			 var cpBudgetRef = document.getElementById("cpBudgetRef").value;
			 var cpBudgetRef3 = document.getElementById("cpBudgetRef3").value;
			 var cpBudgetRef4 = document.getElementById("cpBudgetRef4").value;
			 var cpBudgetRef5 = document.getElementById("cpBudgetRef5").value;
			 var cpBudgetRef6 = document.getElementById("cpBudgetRef6").value;
			 
			 if(val=='0'){
				  document.getElementById("show_msg2").style.display="none";
				  document.getElementById("block_form").value='0';
				  return true;
			 }else{
			 if(val==cpBudgetRef){
				 document.getElementById("show_msg2").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef3){
				 
				  document.getElementById("show_msg2").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef4){
				 
				  document.getElementById("show_msg2").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef5){
				 
				  document.getElementById("show_msg2").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef6){
				 
				  document.getElementById("show_msg2").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else{
				  document.getElementById("show_msg2").style.display="none";
				  document.getElementById("block_form").value='0';
				  return true;
			 }
			 
			}
		}
		
		
		function check_budget3(val){
			 
			 var cpBudgetRef = document.getElementById("cpBudgetRef").value;
			 var cpBudgetRef2 = document.getElementById("cpBudgetRef2").value;
			 var cpBudgetRef4 = document.getElementById("cpBudgetRef4").value;
			 var cpBudgetRef5 = document.getElementById("cpBudgetRef5").value;
			 var cpBudgetRef6 = document.getElementById("cpBudgetRef6").value;
			 
			if(val=='0'){
				  document.getElementById("show_msg3").style.display="none";
				  document.getElementById("block_form").value='0';
				  return true;
			}else{
				 
			 if(val==cpBudgetRef){
				 document.getElementById("show_msg3").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef2){
				 
				  document.getElementById("show_msg3").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef4){
				 
				  document.getElementById("show_msg3").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef5){
				 
				  document.getElementById("show_msg3").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef6){
				 
				  document.getElementById("show_msg3").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else{
				  document.getElementById("show_msg3").style.display="none";
				  document.getElementById("block_form").value='0';
				  return true;
			 }
			}
			
		}
		
		function check_budget4(val){
			 
			 var cpBudgetRef = document.getElementById("cpBudgetRef").value;
			 var cpBudgetRef2 = document.getElementById("cpBudgetRef2").value;
			 var cpBudgetRef3 = document.getElementById("cpBudgetRef3").value;
			 var cpBudgetRef5 = document.getElementById("cpBudgetRef5").value;
			 var cpBudgetRef6 = document.getElementById("cpBudgetRef6").value;
			 
			 if(val=='0'){
				  document.getElementById("show_msg4").style.display="none";
				  document.getElementById("block_form").value='0';
				  return true;
			}else{
				 
			 if(val==cpBudgetRef){
				 document.getElementById("show_msg4").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef2){
				 
				  document.getElementById("show_msg4").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef3){
				 
				  document.getElementById("show_msg4").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef5){
				 
				  document.getElementById("show_msg4").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef6){
				 
				  document.getElementById("show_msg4").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else{
				  document.getElementById("show_msg4").style.display="none";
				  document.getElementById("block_form").value='0';
				  return true;
			 }
		    }
			 
			
		}
		
		
		function check_budget5(val){
			 
			 var cpBudgetRef = document.getElementById("cpBudgetRef").value;
			 var cpBudgetRef2 = document.getElementById("cpBudgetRef2").value;
			 var cpBudgetRef3 = document.getElementById("cpBudgetRef3").value;
			 var cpBudgetRef4 = document.getElementById("cpBudgetRef4").value;
			 var cpBudgetRef6 = document.getElementById("cpBudgetRef6").value;
			 
			 if(val=='0'){
				  document.getElementById("show_msg5").style.display="none";
				  document.getElementById("block_form").value='0';
				  return true;
			}else{
				
			 if(val==cpBudgetRef){
				 document.getElementById("show_msg5").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef2){
				 
				  document.getElementById("show_msg5").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef3){
				 
				  document.getElementById("show_msg5").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef4){
				 
				  document.getElementById("show_msg5").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef6){
				 
				  document.getElementById("show_msg5").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else{
				  document.getElementById("show_msg5").style.display="none";
				  document.getElementById("block_form").value='0';
				  return true;
			 }
			}
			
		}
		
		function check_budget6(val){
			 
			 var cpBudgetRef = document.getElementById("cpBudgetRef").value;
			 var cpBudgetRef2 = document.getElementById("cpBudgetRef2").value;
			 var cpBudgetRef3 = document.getElementById("cpBudgetRef3").value;
			 var cpBudgetRef4 = document.getElementById("cpBudgetRef4").value;
			 var cpBudgetRef5 = document.getElementById("cpBudgetRef5").value;
			 
			 if(val=='0'){
				  document.getElementById("show_msg6").style.display="none";
				  document.getElementById("block_form").value='0';
				  return true;
			}else{
			 if(val==cpBudgetRef){
				 document.getElementById("show_msg6").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef2){
				 
				  document.getElementById("show_msg6").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef3){
				 
				  document.getElementById("show_msg6").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef4){
				 
				  document.getElementById("show_msg6").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else if(val==cpBudgetRef5){
				 
				  document.getElementById("show_msg6").style.display="block";
				 document.getElementById("block_form").value='1';
				 return false;
			 }else{
				  document.getElementById("show_msg6").style.display="none";
				  document.getElementById("block_form").value='0';
				  return true;
			 }
			}
			
		}
		
		
		
		
		</script>
</body>

</html>