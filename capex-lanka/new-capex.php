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
            <h2>New CAPEX Form</h2>
            <small class="text-muted">Welcome to capex application</small>
        </div>
        <div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					
					<div class="body">
					
					
					
					
                        <div class="row clearfix">
                           <form action="controllar.php?action=insert" method="POST" enctype="multipart/form-data">
					<div class="container">
						<div class="home-offer-v6 box-wrapper mt-15">
							



				            <div class="row" style="margin:20px;">
					          <div>
					            <table width="100%" border="0">
                                
                                  <tr>
                                    <td><table width="100%" border="1" >

                                      <tr>
                                        <td width="37%"><div align="left"><span class="style4">*</span>Cost Center</div></td>
                                        <td width="63%">
                                          <input type="text" name="cpCC" id="cpCC" required />
										  
                                     </td>
                                      </tr>

                                      <tr>
                                        <td><span class="style4">*</span>Originating Department.</td>
                                        <td><select id="cpDepartmentName" name="cpDepartmentName"  >
                                          <option value="<?php echo $_SESSION['department'];?>"><?php echo $_SESSION['department'];?></option>
                                        </select>
                                          <input name="cpDepartment" type="hidden" id="cpDepartment" value="<?php echo $_SESSION['dID'];?>" /></td>
                                      </tr>
                                      <tr>
                                        <td><span class="style4">*</span>Budgeted</td>
                                        <td>
										
										<?php if($_SESSION['bMDept']!='BUFC' and $_SESSION['bMDept']!='BUFP' and $_SESSION['bMDept']!='AFH' and $_SESSION['bMDept']!='TS' and $_SESSION['bMDept']!='FM'){
											$blur_function='onchange="check_budget1(this.value);"';
											$change_function='onchange="show_s(this.value);"';
										}else{
											$blur_function='';
											$change_function='onchange="show_s2(this.value);"';
										}
											
											?>
										
                                          <select id="cpDBudget" name="cpDBudget" <?php echo $change_function;?>  >
                                            <!--<option value=""></option>-->
                                           
                                            <option value="2">Yes</option>
                                            <option value="3">Strategic</option>
											<?php if($_SESSION['bMDept']!='BUFC' and $_SESSION['bMDept']!='BUFP' and $_SESSION['bMDept']!='AFH' and $_SESSION['bMDept']!='TS' and $_SESSION['bMDept']!='FM'){?>
                                            <option value="4">No</option>
                                           <?php } ?>
                                          </select>
                                    </td>
                                      </tr>
                                       
                                      <tr>
                                        <td><span class="style4">*</span>Strategic / Budget Reference</td>
                                        <td>
										
										
										
										
                                          <select id="cpBudgetRef" name="cpBudgetRef"  style="width:500px;" <?php echo $blur_function;?> required='required'>
                                           <option value="">Select Budget Reference</option>
                                            <?php $select_b=mysqli_query($db,"select * from tblbudget where bMDept='".$_SESSION['bMDept']."' order by bDesc asc");
										while($row_b=mysqli_fetch_array($select_b)){ 
										if($row_b['bTotal']!=$row_b['bConsumed']){
										$remainig=$row_b['bTotal'] - $row_b['bConsumed'];
										?>
                                            <option value="<?php echo $row_b['bID'];?>"><?php echo $row_b['bDesc'].'('.$row_b['bDept'].')'.'----Cost='.number_format($row_b['bTotal']).'----Remaining Cost='.number_format($remainig);?></option>
                                            <?php 
											 }
											}?>
                                          </select>
										   <input name="cpSBudgetRefNo" type="text" id="cpSBudgetRefNo"  style="width:500px;display:none;"  />
										  
										  <div id="show_msg1" style="display:none;color:red;">You cannot select same budget at a time.</div>
										  
										  <div id="badjusted"> </div>
										  
								
                                          <select id="cpSBudgetRef" name="cpSBudgetRef"  style="width:500px;display:none;" >
                                            <option value="">Select Budget Reference</option>
                                            <?php $select_sb=mysqli_query($db,"select * from tblsbudget where sbMDept='".$_SESSION['bMDept']."' order by sbDesc asc");
										while($row_sb=mysqli_fetch_array($select_sb)){ 
										if($row_sb['sbTotal']!=$row_sb['sbConsumed']){
										$sremainig=$row_sb['sbTotal'] - $row_sb['sbConsumed'];
										?>
                                            <option value="<?php echo $row_sb['sbID'];?>"><?php echo $row_sb['sbDesc'].'('.$row_sb['sbDept'].')'.'----Cost='.number_format($row_sb['sbTotal']).'----Remaining Cost='.number_format($sremainig);?></option>
                                            <?php 
											 }
											}?>
                                          </select>
										  <input name="cpSBudgetRef2" type="text" id="cpSBudgetRef2"  style="width:500px;display:none;"  />
										  
										   <?php if($_SESSION['bMDept']!='BUFC' and $_SESSION['bMDept']!='BUFP' and $_SESSION['bMDept']!='BUCP'){?>
										  <select id="cpBudgetRef2" name="cpBudgetRef2"  style="width:500px;display:none;" onchange="check_budget2(this.value);">
                                           <option value="">Select Budget Reference for Adjustment only</option>
                                            <?php $select_b=mysqli_query($db,"select * from tblbudget where bMDept='".$_SESSION['bMDept']."' order by bDesc asc");
										while($row_b=mysqli_fetch_array($select_b)){ 
										if($row_b['bTotal']!=$row_b['bConsumed']){
										$remainig=$row_b['bTotal'] - $row_b['bConsumed'];
										?>
                                            <option value="<?php echo $row_b['bID'];?>"><?php echo $row_b['bDesc'].'('.$row_b['bDept'].')'.'----Cost='.number_format($row_b['bTotal']).'----Remaining Cost='.number_format($remainig);?></option>
                                            <?php 
											 }
											}?>
                                          </select>
										   <div id="show_msg2" style="display:none;color:red;">You cannot select same budget at a time.</div>
										   <div id="show_b2">
										   <select id="cpBudgetRef3" name="cpBudgetRef3"  style="width:500px;display:none;" onchange="check_budget3(this.value);">
                                           <option value="">Select Budget Reference for Adjustment only</option>
                                            <?php $select_b=mysqli_query($db,"select * from tblbudget where bMDept='".$_SESSION['bMDept']."' order by bDesc asc");
										while($row_b=mysqli_fetch_array($select_b)){ 
										if($row_b['bTotal']!=$row_b['bConsumed']){
										$remainig=$row_b['bTotal'] - $row_b['bConsumed'];
										?>
                                            <option value="<?php echo $row_b['bID'];?>"><?php echo $row_b['bDesc'].'('.$row_b['bDept'].')'.'----Cost='.number_format($row_b['bTotal']).'----Remaining Cost='.number_format($remainig);?></option>
                                            <?php 
											 }
											}?>
                                          </select>
										  </div>
										  <div id="show_msg3" style="display:none;color:red;">You cannot select same budget at a time.</div>
										  
										  <div id="show_b3">
										  
										  <select id="cpBudgetRef4" name="cpBudgetRef4"  style="width:500px;display:none;" onchange="check_budget4(this.value);">
                                           <option value="">Select Budget Reference for Adjustment only</option>
                                            <?php $select_b=mysqli_query($db,"select * from tblbudget where bMDept='".$_SESSION['bMDept']."' order by bDesc asc");
										while($row_b=mysqli_fetch_array($select_b)){ 
										if($row_b['bTotal']!=$row_b['bConsumed']){
										$remainig=$row_b['bTotal'] - $row_b['bConsumed'];
										?>
                                            <option value="<?php echo $row_b['bID'];?>"><?php echo $row_b['bDesc'].'('.$row_b['bDept'].')'.'----Cost='.number_format($row_b['bTotal']).'----Remaining Cost='.number_format($remainig);?></option>
                                            <?php 
											 }
											}?>
                                          </select>
										  </div>
										   <div id="show_msg4" style="display:none;color:red;">You cannot select same budget at a time.</div>
										   <div id="show_b4">
										  <select id="cpBudgetRef5" name="cpBudgetRef5"  style="width:500px;display:none;" onchange="check_budget5(this.value);">
                                           <option value="">Select Budget Reference for Adjustment only</option>
                                            <?php $select_b=mysqli_query($db,"select * from tblbudget where bMDept='".$_SESSION['bMDept']."' order by bDesc asc");
										while($row_b=mysqli_fetch_array($select_b)){ 
										if($row_b['bTotal']!=$row_b['bConsumed']){
										$remainig=$row_b['bTotal'] - $row_b['bConsumed'];
										?>
                                            <option value="<?php echo $row_b['bID'];?>"><?php echo $row_b['bDesc'].'('.$row_b['bDept'].')'.'----Cost='.number_format($row_b['bTotal']).'----Remaining Cost='.number_format($remainig);?></option>
                                            <?php 
											 }
											}?>
                                          </select>
										  </div>
										  <div id="show_msg5" style="display:none;color:red;">You cannot select same budget at a time.</div>
										  <div id="show_b5">
										  <select id="cpBudgetRef6" name="cpBudgetRef6"  style="width:500px;display:none;" onchange="check_budget6(this.value);">
                                           <option value="">Select Budget Reference for Adjustment only</option>
                                            <?php $select_b=mysqli_query($db,"select * from tblbudget where bMDept='".$_SESSION['bMDept']."' order by bDesc asc");
										while($row_b=mysqli_fetch_array($select_b)){ 
										if($row_b['bTotal']!=$row_b['bConsumed']){
										$remainig=$row_b['bTotal'] - $row_b['bConsumed'];
										?>
                                            <option value="<?php echo $row_b['bID'];?>"><?php echo $row_b['bDesc'].'('.$row_b['bDept'].')'.'----Cost='.number_format($row_b['bTotal']).'----Remaining Cost='.number_format($remainig);?></option>
                                            <?php 
											 }
											}?>
                                          </select>
										  </div>
										  <div id="show_msg6" style="display:none;color:red;">You cannot select same budget at a time.</div>
										  <?php } ?>
                                          </td>
                                      </tr>
                                      
                   
								  
									 
                                      <tr>
                                        <td><span class="style4">*</span>Expected Completion    Date</td>
                                        <td>
                                          <input name="cpEDate" type="text" id="cpEDate" required   />
                                        </td>
                                      </tr>
                                      <tr>
                                        <td><span class="style4">*</span>Replacement / Expansion</td>
                                        <td>
                                        
                                        <select id="cpWERI" name="cpWERI" >
                                            <option value=""></option>
                                            <option value="Replacement">Replacement</option>
                                            <option value="Expansion">Expansion</option>
                                          </select>                                        </td>
                                      </tr>
                                      <tr>
                                        <td><span class="style4">*</span>Category.</td>
                                        <td>
										 <div id="cat_select">
                                         <select id="cpCid" name="cpCid" required >
                                            <option value=""></option>
                                            <?php 
										 $select_cat=mysqli_query($db,"select * from tblcategory where cStatus='1' order by cName");
										 while($row_cat=mysqli_fetch_array($select_cat)){
										 ?>
                                            <option value="<?php echo $row_cat['cID'];?>"><?php echo $row_cat['cName'];?></option>
                                            <?php } ?>
                                          </select>
										  </div>
										  
                                        </td>
                                      </tr>
                                      <tr>
                                        <td><span class="style4">*</span>Detail of Proposal:</td>
                                        <td>
                                          <textarea name="cpDetail" cols="70" rows="5" id="cpDetail" required></textarea>
                                       </td>
                                      </tr>
                                      <tr>
                                        <td><span class="style4">*</span>Desired Asset Name    in SAP Register</td>
                                        <td>
                                          <textarea name="cpDAssetName" cols="70" rows="5" id="cpDAssetName" required></textarea>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td><span class="style4">*</span>Option of In-House    Availablility</td>
                                        <td>
                                          <select id="cpOIHA" name="cpOIHA" required>
                                            <option value=""></option>
                                            <option value="1">No</option>
                                            <option value="2">Yes</option>
                                          </select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td><span class="style4">*</span>Entered By(Email)</td>
                                        <td>
                                        <input type="email" name="cpEmail" id="cpEmail" required />
                                        </td>
                                      </tr>
                                      <tr>
                                        <td><span class="style4">*</span>Ext No</td>
                                        <td>
                                        <input type="number" name="cpExtNo" id="cpExtNo"  required/>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td colspan="2"><table  border="1">
                                          <tr>
                                            <td colspan="6" height="34" width="1297"><div align="center"><strong>Cost of Project</strong></div></td>
                                          </tr>
                                        </table>
                                        <div align="center"></div></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td colspan="2"><table width="100%" border="1">
                                          
                                          <tr>
                                            <td width="21%"><div align="center"></div></td>
                                            <td width="14%"><div align="center"><strong>Locally</strong></div></td>
                                            <td width="13%"><div align="center"><strong>Imported</strong></div></td>
                                            <td width="12%">&nbsp;</td>
                                            <td width="27%">&nbsp;</td>
                                            <td width="13%">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td><div align="center"></div></td>
                                            <td><div align="center"><strong>Rs.</strong></div></td>
                                            <td><div align="center"><strong>Rs.</strong></div></td>
                                            <td><div align="center"><strong>Currency</strong></div></td>
                                            <td><div align="center"><strong>Foreign Currency Amount</strong></div></td>
                                            <td><div align="center"><strong>Rate</strong></div></td>
                                          </tr>
                                          <tr>
                                            <td>Cost</td>
                                            <td align="center">
                                              <input name="cpCostL" type="text" id="cpCostL"  onblur="cal();" size="12"  />
                                              </td>
                                            <td align="center">
                                            <input name="cpCostI" type="text" id="cpCostI"   size="12" readonly="readonly" />
                                            </td>
                                            <td><div align="center">
                                              <input name="cpCur" type="text" id="cpCur"   size="12" />
                                            </div></td>
                                            <td><div align="center">
                                            <input name="cpFCA" type="text" id="cpFCA"   size="28" onblur="cal2();" />
                                            </div></td>
                                            <td><div align="center">
                                            <input name="cpFCR" type="text" id="cpFCR"  size="12" onblur="cal2();" />
                                            </div></td>
                                          </tr>
                                          <tr>
                                            <td>Custom Duty</td>
                                            <td><div align="center">
                                            <input name="cpCDL" type="text" id="cpCDL"  onblur="cal();" size="12" />
                                            </div></td>
                                            <td><div align="center">
                                            <input name="cpCDI" type="text" id="cpCDI"  onblur="cal();" size="12" />
                                            </div></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>Others</td>
                                            <td><div align="center">
                                            <input name="cpOthersL" type="text" id="cpOthersL"  onblur="cal();" size="12" />
                                            </div></td>
                                            <td><div align="center">
                                            <input name="cpOthersI" type="text" id="cpOthersI"  onblur="cal();" size="12" />
                                            </div></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>GST (Not applicable for Plant &amp; Machinery)</td>
                                            <td><div align="center">
                                            <input name="cpGSTL" type="text" id="cpGSTL"  onblur="cal();" size="12" />
                                            </div></td>
                                            <td><div align="center">
                                            <input name="cpGSTI" type="text" id="cpGSTI"  onblur="cal();" size="12" />
                                            </div></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>GRAND TOTAL (Rs.)</td>
                                            <td colspan="5"><div align="center">
                                              <input name="cpTot" type="text" id="cpTot"   size="28" style="border:1px solid #FFFFFF;font-size:14px;font-weight:bold;" required />
                                           </div></td>
                                          </tr>
                                          <tr>
                                            <td colspan="6">&nbsp;</td>
                                          </tr>
                                          
                                          
                                           <tr>
									     <td align="center">Attachements	</td>
									     <td colspan="6">&nbsp;</td>
								      </tr>
									   <tr>
									     <td align="center"><span class="style4">*</span>1</td>
									     <td colspan="6"><input type="file" name="files1" id="files1" required  ></td>
								      </tr>
									   <tr>
									     <td align="center">2</td>
									     <td colspan="6"><input type="file" name="files2" id="files2" ></td>
								      </tr>
								       <tr>
									     <td align="center">3</td>
									     <td colspan="6"><input type="file" name="files3" id="files3" ></td>
								      </tr>
                                          
                                          
                                          <tr>
                                            <td colspan="6"><div id="b_adjust" style="display:none;color:red;" align="center"><b>Please adjust budget.</b></div>
											<div id="sb_adjust" style="display:none;color:red;" align="center"><b>Capex amount must be less than or equal to selected budget amount.</b></div>
											</td>
                                          </tr>
                                          <tr>
                                            <td colspan="6"><div align="center"><input type="submit" name="submit" id="submit" value="Submit"></div><br></td>
                                          </tr>
                                        </table></td>
                                      </tr>

                                    </table></td>
                                  </tr>
                                </table>
					          </div>
                               <input name="block_form" type="hidden" id="block_form" value="0"    />
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
			var cpSBudgetRef = document.getElementById("cpSBudgetRef").value;
			
			if(cpDBudget==2){
			
			
			$.post("controllar.php",{cpBudgetRef:cpBudgetRef,cpTot:cpTot,check_ca:"check_ca"},function(data){   
				if(data!=0){
					$('#submit').attr('disabled', 'disabled');
					document.getElementById("sb_adjust").style.display="none";
					document.getElementById("b_adjust").style.display="block";
					document.getElementById("badjusted").innerHtml=$("#badjusted").html(data);
					document.getElementById("cpBudgetRef2").style.display="block";
					document.getElementById("cpBudgetRef3").style.display="block";	
					document.getElementById("cpBudgetRef4").style.display="block";
					document.getElementById("cpBudgetRef5").style.display="block";
					document.getElementById("cpBudgetRef6").style.display="block";
					
					
				}else{
					$('#submit').removeAttr('disabled', '');
					document.getElementById("sb_adjust").style.display="none";
					document.getElementById("b_adjust").style.display="none";
					document.getElementById("badjusted").innerHtml=$("#badjusted").html(" ");
				}
				//document.getElementById("cat_select").innerHtml=$("#cat_select").html(data);
			});	
			
			
			}else{
				if(cpDBudget!=4){
				$.post("controllar.php",{cpSBudgetRef:cpSBudgetRef,cpTot:cpTot,check_ca2:"check_ca2"},function(data){   
				if(data!=0){
					$('#submit').attr('disabled', 'disabled');
					document.getElementById("b_adjust").style.display="none";
					document.getElementById("sb_adjust").style.display="block";
					
				}else{
					$('#submit').removeAttr('disabled', '');
					document.getElementById("b_adjust").style.display="none";
					document.getElementById("sb_adjust").style.display="none";
					
				
				}
				//document.getElementById("cat_select").innerHtml=$("#cat_select").html(data);
			});	
			}
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
			var cpSBudgetRef = document.getElementById("cpSBudgetRef").value;
			
			
			if(cpDBudget==2){

			$.post("controllar.php",{cpBudgetRef:cpBudgetRef,cpTot:cpTot,check_ca:"check_ca"},function(data){   
				if(data!=0){
					$('#submit').attr('disabled', 'disabled');
					
					document.getElementById("b_adjust").style.display="block";
					document.getElementById("badjusted").innerHtml=$("#badjusted").html(data);
					
					document.getElementById("cpBudgetRef2").style.display="block";
					document.getElementById("cpBudgetRef3").style.display="block";	
					document.getElementById("cpBudgetRef4").style.display="block";
					document.getElementById("cpBudgetRef5").style.display="block";
					document.getElementById("cpBudgetRef6").style.display="block";
					
				}else{
					$('#submit').removeAttr('disabled', '');
					
					document.getElementById("b_adjust").style.display="none";
					document.getElementById("badjusted").innerHtml=$("#badjusted").html(" ");
				}
				//document.getElementById("cat_select").innerHtml=$("#cat_select").html(data);
			});	
			}else{
				if(cpDBudget!=4){
				$.post("controllar.php",{cpSBudgetRef:cpSBudgetRef,cpTot:cpTot,check_ca2:"check_ca2"},function(data){   
				if(data!=0){
					$('#submit').attr('disabled', 'disabled');
					document.getElementById("b_adjust").style.display="none";
					document.getElementById("sb_adjust").style.display="block";
					
				}else{
					$('#submit').removeAttr('disabled', '');
					document.getElementById("b_adjust").style.display="none";
					document.getElementById("sb_adjust").style.display="none";
					
				}
				//document.getElementById("cat_select").innerHtml=$("#cat_select").html(data);
			});	
			}
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
		
		
		
				function show_s2(val){
		    
			
			$.post("controllar.php",{id:val,show_cat:"show_cat"},function(data){   
				
				document.getElementById("cat_select").innerHtml=$("#cat_select").html(data);
			});			
			
			
			
			/*if(val==1){
			document.getElementById("cpBudgetRef").style.display="none";
			document.getElementById("cpSBudgetRef").style.display="none";
            document.getElementById("cpSBudgetRef2").style.display="block";		
            document.getElementById("cpBudgetRef2").style.display="none";
            document.getElementById("cpBudgetRef3").style.display="none";	
            document.getElementById("cpBudgetRef4").style.display="none";
            document.getElementById("cpBudgetRef5").style.display="none";
			document.getElementById("cpBudgetRef6").style.display="none";
			$('#cpSBudgetRef2').attr('required', 'required');			
            $('#cpBudgetRef').removeAttr('required', '');	
			$('#cpSBudgetRef').removeAttr('required', '');
			
			}*/
			
			if(val==2){
			document.getElementById("cpBudgetRef").style.display="block";
			document.getElementById("cpSBudgetRef").style.display="none";

			
			$('#cpSBudgetRef').removeAttr('required', '');
			//$('#cpSBudgetRef2').removeAttr('required', '');			
            $('#cpBudgetRef').attr('required', 'required');	
			
			}
			
			if(val==3){
			document.getElementById("cpBudgetRef").style.display="none";
			document.getElementById("cpSBudgetRef").style.display="block";
			
			$('#cpBudgetRef').removeAttr('required', '');
			//$('#cpSBudgetRef2').removeAttr('required', '');			
			$('#cpSBudgetRef').attr('required', 'required');
			}

			
			if(val==4){
		    document.getElementById("cpBudgetRef").style.display="none";
			document.getElementById("cpSBudgetRef").style.display="none";
            document.getElementById("cpSBudgetRefNo").style.display="block";	


            $('#cpSBudgetRef').removeAttr('required', '');
			$('#cpBudgetRef').removeAttr('required', '');
            $('#cpSBudgetRefNo').attr('required', 'required');				
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
			
			
			
		
		}
		
		function show_s(val){
		    
			if(val==4){
			document.getElementById("cpBudgetRef").style.display="none";
			document.getElementById("cpSBudgetRef").style.display="none";
			document.getElementById("cpSBudgetRef2").style.display="none";
			document.getElementById("cpBudgetRef2").style.display="none";
            document.getElementById("cpBudgetRef3").style.display="none";	
            document.getElementById("cpBudgetRef4").style.display="none";
            document.getElementById("cpBudgetRef5").style.display="none";
			document.getElementById("cpBudgetRef6").style.display="none";
            document.getElementById("cpSBudgetRefNo").style.display="block";	


            $('#cpSBudgetRef').removeAttr('required', '');
			$('#cpBudgetRef').removeAttr('required', '');
            $('#cpSBudgetRefNo').attr('required', 'required');				
			}
			
			
			
			$.post("controllar.php",{id:val,show_cat:"show_cat"},function(data){   
				
				document.getElementById("cat_select").innerHtml=$("#cat_select").html(data);
			});			
			
			
			
			
			if(val==2){
			document.getElementById("cpBudgetRef").style.display="block";
			document.getElementById("cpSBudgetRef").style.display="none";
			document.getElementById("cpSBudgetRef2").style.display="none";
			document.getElementById("cpBudgetRef2").style.display="block";
            document.getElementById("cpBudgetRef3").style.display="block";	
            document.getElementById("cpBudgetRef4").style.display="block";
            document.getElementById("cpBudgetRef5").style.display="block";
			document.getElementById("cpBudgetRef6").style.display="block";	
			document.getElementById("cpSBudgetRefNo").style.display="none";
			
			$('#cpSBudgetRef').removeAttr('required', '');
			//$('#cpSBudgetRef2').removeAttr('required', '');			
            $('#cpBudgetRef').attr('required', 'required');	
			$('#cpSBudgetRefNo').removeAttr('required', '');
			
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
			document.getElementById("cpSBudgetRefNo").style.display="none";

			$('#cpBudgetRef').removeAttr('required', '');
			//$('#cpSBudgetRef2').removeAttr('required', '');			
			$('#cpSBudgetRef').attr('required', 'required');
			$('#cpSBudgetRefNo').removeAttr('required', '');
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
			 var famont       = document.getElementById("adjusted").value;
			 
				 
			 
			 
		 
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
				  
				  $.post("controllar.php",{id:val,adjusted:famont,adjust_amount:"adjust_amount"},function(data){   
				
				if(data>0){
					$("#bad").css("color", "green");
					document.getElementById("show_b2").style.display='none';
					document.getElementById("show_b3").style.display='none';
					document.getElementById("show_b4").style.display='none';
					document.getElementById("show_b5").style.display='none';
					document.getElementById("b_adjust").style.display="none";
					$('#submit').removeAttr('disabled', '');
					return true;
				}else{
					document.getElementById("adjusted").value=data;
					$("#bad").css("color", "red");
					document.getElementById("show_b2").style.display='block';
					document.getElementById("show_b3").style.display='block';
					document.getElementById("show_b4").style.display='block';
					document.getElementById("show_b5").style.display='block';
					document.getElementById("b_adjust").style.display="block";
					$('#submit').attr('disabled', 'disabled');
					return false;
				}
			});		
				  
				  
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
			 
			 var famont       = document.getElementById("adjusted").value;
			 
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
				  
				  $.post("controllar.php",{id:val,adjusted:famont,adjust_amount:"adjust_amount"},function(data){   
				
				if(data>0){
					$("#bad").css("color", "green");
					
					document.getElementById("show_b3").style.display='none';
					document.getElementById("show_b4").style.display='none';
					document.getElementById("show_b5").style.display='none';
					document.getElementById("b_adjust").style.display="none";
					$('#submit').removeAttr('disabled', '');
				}else{
					document.getElementById("adjusted").value=data;
					$("#bad").css("color", "red");
					
					document.getElementById("show_b3").style.display='block';
					document.getElementById("show_b4").style.display='block';
					document.getElementById("show_b5").style.display='block';
					document.getElementById("b_adjust").style.display="block";
					$('#submit').attr('disabled', 'disabled');
				}
			});
				  
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
			 var famont       = document.getElementById("adjusted").value;
			 
			 
			 
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
				  $.post("controllar.php",{id:val,adjusted:famont,adjust_amount:"adjust_amount"},function(data){   
				
				if(data>0){
					$("#bad").css("color", "green");
					
					
					document.getElementById("show_b4").style.display='none';
					document.getElementById("show_b5").style.display='none';
					document.getElementById("b_adjust").style.display="none";
					$('#submit').removeAttr('disabled', '');
				}else{
					document.getElementById("adjusted").value=data;
					$("#bad").css("color", "red");
					
					
					document.getElementById("show_b4").style.display='block';
					document.getElementById("show_b5").style.display='block';
					document.getElementById("b_adjust").style.display="block";
					$('#submit').attr('disabled', 'disabled');
				}
			}); 
				  
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
			 var famont       = document.getElementById("adjusted").value;
			 
			 
			 
			 
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
				  $.post("controllar.php",{id:val,adjusted:famont,adjust_amount:"adjust_amount"},function(data){   
				
				if(data>0){
					$("#bad").css("color", "green");
					
					
					
					document.getElementById("show_b5").style.display='none';
					document.getElementById("b_adjust").style.display="none";
					$('#submit').removeAttr('disabled', '');
				}else{
					document.getElementById("adjusted").value=data;
					$("#bad").css("color", "red");
					
					
					
					document.getElementById("show_b5").style.display='block';
					document.getElementById("b_adjust").style.display="block";
					$('#submit').attr('disabled', 'disabled');
				}
			});
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
			 
			 var famont       = document.getElementById("adjusted").value;
			
			 
			 
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
				  $.post("controllar.php",{id:val,adjusted:famont,adjust_amount:"adjust_amount"},function(data){   
				
				if(data>0){
					$("#bad").css("color", "green");
					document.getElementById("b_adjust").style.display="none";
					$('#submit').removeAttr('disabled', '');
				}else{
					document.getElementById("adjusted").value=data;
					$("#bad").css("color", "red");
					document.getElementById("b_adjust").style.display="block";
					$('#submit').attr('disabled', 'disabled');
				}
			});
				  return true;
			 }
			}
			 
		}
		
		</script>
</body>

</html>