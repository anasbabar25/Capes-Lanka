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
<script>
    


function check_pass(){

var ndppass=document.getElementById("ndppass").value;
var nrdppass=document.getElementById("nrdppass").value;
	if(ndppass!=nrdppass){
		alert("Passwords mismatch!");
		document.getElementById("nrdppass").value="";
		document.getElementById("nrdppass").focus(); 
		return false;
	}
	return true;
}

    </script>
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
            <h2>Change Password</h2>
            <small class="text-muted">Welcome to capex application</small>
        </div>
        <div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					
					<div class="body">
					
					<?php if($_GET['password']=='change'){?>
					<div style="color:green;">Password changed successfully !</div>
					<?php } ?>
                        <div class="row clearfix">
                         <form id="form1" name="form1" method="post" action="controllers/change-password.php" onSubmit="return check_pass();"; >
					<div class="container">
						<div class="home-offer-v6 box-wrapper mt-15">
							



				            <div class="row" style="margin:20px;">
					          <div>
					            <table width="100%" border="0">
									<tr>
									  <td width="41%">&nbsp;</td>
									  <td width="59%">&nbsp;</td>
								  </tr>

									<tr>
									 <td width="41%">New Password:</td>
									  <td width="59%">
										<input type="password" name="ndppass" id="ndppass" required />
									 </td>
								  </tr>

									<tr>
									  <td width="41%">
									  Retype Password:
									  </td>
						  <td width="59%"><input type="password" name="nrdppass" id="nrdppass" required /></td>
								  </tr>
									
									<tr>
									  <td>&nbsp;</td>
									  <td><label>
										<input type="submit" name="Submit" id="Submit" value="Change" />
									  </label></td>
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
			
			
			var cpDBudget   = document.getElementById("cpDBudget").value;
			var cpBudgetRef = document.getElementById("cpBudgetRef").value;
			
			
			if(cpDBudget==2){
			
			
			$.post("controllar.php",{cpBudgetRef:cpBudgetRef,cpTot:cpTot,check_ca:"check_ca"},function(data){   
				if(data!=0){
					$('#submit').attr('disabled', 'disabled');
					document.getElementById("badjusted").innerHtml=$("#badjusted").html(data);

					
					
				}else{
					$('#submit').removeAttr('disabled', '');
					document.getElementById("badjusted").innerHtml=$("#badjusted").html(" ");
				}
				//document.getElementById("cat_select").innerHtml=$("#cat_select").html(data);
			});	
			
			
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
			
			
			var cpDBudget   = document.getElementById("cpDBudget").value;
			var cpBudgetRef = document.getElementById("cpBudgetRef").value;
			
			
			if(cpDBudget==2){
			
			
			$.post("controllar.php",{cpBudgetRef:cpBudgetRef,cpTot:cpTot,check_ca:"check_ca"},function(data){   
				if(data!=0){
					$('#submit').attr('disabled', 'disabled');
					document.getElementById("badjusted").innerHtml=$("#badjusted").html(data);

					
					
				}else{
					$('#submit').removeAttr('disabled', '');
					document.getElementById("badjusted").innerHtml=$("#badjusted").html(" ");
				}
				//document.getElementById("cat_select").innerHtml=$("#cat_select").html(data);
			});	
			
			
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
            document.getElementById("cpSBudgetRef2").style.display="block";	
            $('#cpSBudgetRef2').attr('required', 'required');			
            $('#cpBudgetRef').removeAttr('required', '');		
			}
			
			if(val==2){
			document.getElementById("cpBudgetRef").style.display="block";
			document.getElementById("cpSBudgetRef2").style.display="none";
			$('#cpSBudgetRef2').removeAttr('required', '');			
            $('#cpBudgetRef').attr('required', 'required');		
			}
			
			document.getElementById("cpCostL").value='';
			document.getElementById("cpCostI").value='';
			document.getElementById("cpCDL").value='';
			document.getElementById("cpCDI").value='';
			document.getElementById("cpOthersL").value='';
			document.getElementById("cpOthersI").value='';
			document.getElementById("cpGSTL").value='';
			document.getElementById("cpGSTI").value='';
            document.getElementById("cpFCA").value='';
			document.getElementById("cpFCR").value='';
			document.getElementById("cpTot").value='';
	        document.getElementById("badjusted").innerHtml=$("#badjusted").html(" ");
		}
		
		function show_af(val){
			
			if(val=='Replacement'){
				$('#cpDAssetName').attr('required', 'required');
				$('#aname').show();																	
			}else{
				
				$('#cpDAssetName').removeAttr('required', '');
				$('#aname').hide();
			}
			
		}
		
		function check_budget1(){
			
			document.getElementById("cpCostL").value='';
			document.getElementById("cpCostI").value='';
			document.getElementById("cpCDL").value='';
			document.getElementById("cpCDI").value='';
			document.getElementById("cpOthersL").value='';
			document.getElementById("cpOthersI").value='';
			document.getElementById("cpGSTL").value='';
			document.getElementById("cpGSTI").value='';
            document.getElementById("cpFCA").value='';
			document.getElementById("cpFCR").value='';
			document.getElementById("cpTot").value='';
			document.getElementById("badjusted").innerHtml=$("#badjusted").html(" ");
		}

		</script>
</body>

</html>