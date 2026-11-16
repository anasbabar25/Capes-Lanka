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
            <h2>CAPEX Detail # <?php echo base64_decode($_GET['cpID']);?></h2>
            <small class="text-muted">Welcome to capex application</small>
        </div>
        <div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					
					<div class="body">
					
					
					
					
                        <div class="row clearfix">
                          <form action="controllar.php?action=update&cpID=<?php echo base64_decode($_GET['cpID']);?>" method="POST" enctype="multipart/form-data" onsubmit="return check_form();">
					<div class="container">
						<div class="home-offer-v6 box-wrapper mt-15">
							
<?php 
							   $select=mysqli_query($db,"select * from tblcp where cpID='".base64_decode($_GET['cpID'])."'");
							   $row=mysqli_fetch_array($select);
							   $select2=mysqli_query($db,"select dName from tbldepts where dID='".$row['cpDepartment']."'");
                               $row2=mysqli_fetch_array($select2);
							   ?>


				            <div class="row" style="margin:20px;">
					          <div>
					             <table width="100%" border="0">
         
                                   <tr>
                                    <td><table width="100%" border="1" >

                                      <tr>
                                        <td width="37%"><div align="left"><span class="style4">*</span>Cost Center</div></td>
                                        <td width="63%">
                                          <input type="text" name="cpCC" id="cpCC" value="<?php echo $row['cpCC'];?>" readonly required />
										  
                                       </td>
                                      </tr>

                                      <tr>
                                        <td><span class="style4">*</span>Originating Department.</td>
                                        <td><select id="cpDepartmentName" name="cpDepartmentName" disabled  >
                                          <option value="<?php echo $_SESSION['department'];?>"><?php echo $_SESSION['department'];?></option>
                                        </select>
                                          <input name="cpDepartment" type="hidden" id="cpDepartment" value="<?php echo $_SESSION['dID'];?>" /></td>
                                      </tr>
                                      <tr>
                                        <td><span class="style4">*</span>Budgeted</td>
                                        <td>
                                          
										  <select id="cpDBudget" name="cpDBudget" disabled >
                                            <option value=""></option>
                                         
										   <option value="4" <?php if($row['cpDBudget']=='4'){echo 'selected="selected"';} ?>>No</option>
                                          
										   <option value="2" <?php if($row['cpDBudget']=='2'){echo 'selected="selected"';} ?>>Yes</option>
                                            <option value="3" <?php if($row['cpDBudget']=='3'){echo 'selected="selected"';} ?>>Strategic</option>
                                          </select>
										  <input type="hidden" name="cpDBudgettype" id="cpDBudgettype" value="<?php echo $row['cpDBudget'];?>"   />
										  
										  
                                        </td>
                                      </tr>
                                     <?php if($row['cpDBudget']==2){?>
                                      <tr>
                                        <td><span class="style4">*</span>Budget Reference</td>
                                        <td>
                                          <select id="cpBudgetRefID" name="cpBudgetRefID"  style="width:500px;" disabled>
                                            <option value=""></option>
                                            <?php $select_b=mysqli_query($db,"select * from tblbudget where bMDept='".$_SESSION['bMDept']."' order by bDept asc");
										while($row_b=mysqli_fetch_array($select_b)){ 
										?>
                                            <option value="<?php echo $row_b['bID'];?>" <?php if($row['cpBudgetRef']==$row_b['bID']){echo 'selected="selected"';} ?>><?php echo $row_b['bDept'].'----'.$row_b['bDesc'];?></option>
                                            <?php }?>
                                          </select>
                                          <input type="hidden" name="cpBudgetRef" id="cpBudgetRef" value="<?php echo $row['cpBudgetRef'];?>">
                                        
									
										<?php 
										      
											  $select_adj=mysqli_query($db,"select * from tblcpadjustment 
										      where cpID='".base64_decode($_GET['cpID'])."' 
											  and refbID!='".$row['cpBudgetRef']."'");
											  $num_adj=mysqli_num_rows($select_adj);
											  if($num_adj>0){
											  echo "<p><b>Capex adjusted from following the budgets:</b></p>";
										      while($row_adj=mysqli_fetch_array($select_adj)){
												  $count_b=$count_b+1;
												  $select_b=mysqli_query($db,"select bDesc from tblbudget where 
												  bID='".$row_adj['refbID']."'");
												  $row_b=mysqli_fetch_array($select_b);
												  
										?>
										      <p><?php echo $count_b;?> - <?php echo $row_b['bDesc'];?> - <b>Adjusted Amount</b> = <?php echo number_format($row_adj['bAmount']);?></p> 
											  <?php
											  }
											  } ?>
										
										
										<?php 
									$famont=0;
									$submit_f=1;
									
									$dept=$_SESSION['department'];
						            $pos = strpos($dept, 'USER');
						 
					     
									
									if($_SESSION['tID']==2 or ($pos !== false and $_SESSION['bMDept']!='BUFC' and $_SESSION['bMDept']!='BUFP' and $_SESSION['bMDept']!='')){
									       $select_am=mysqli_query($db,"select * from tblbudget where bID='".$row['cpBudgetRef']."' and bMDept='".$_SESSION['bMDept']."'");	
										   
										   $row_am=mysqli_fetch_array($select_am);
										   $bRemaining=$row_am['bTotal'] - $row_am['bConsumed'];
										   //$bRemaining=$row_am['bConsumed'];
									       $famont=$bRemaining - $row['cpTot'];
									       if($famont<0){
											  $submit_f=0; 
											   
										  
									?>
									<br>	
									<div id="badjusted"> 
									<b style="color:red;" id="bad">Budgeted Amount is <?php echo number_format($bRemaining); ?>.Please Adjust Amount = <?php echo number_format($famont*-1);?>.</b></div>
									
									 <select id="cpBudgetRef2" name="cpBudgetRef2"  style="width:500px;" onchange="check_budget2(this.value);">
                                           <option value="">Select Budget Reference for Adjustment only</option>
                                            <?php $select_b=mysqli_query($db,"select * from tblbudget where bID!='".$row['cpBudgetRef']."' and bMDept='".$_SESSION['bMDept']."' order by bDesc asc");
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
										   <select id="cpBudgetRef3" name="cpBudgetRef3"  style="width:500px;" onchange="check_budget3(this.value);">
                                           <option value="">Select Budget Reference for Adjustment only</option>
                                            <?php $select_b=mysqli_query($db,"select * from tblbudget where bID!='".$row['cpBudgetRef']."' and bMDept='".$_SESSION['bMDept']."' order by bDesc asc");
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
										  <select id="cpBudgetRef4" name="cpBudgetRef4"  style="width:500px;" onchange="check_budget4(this.value);">
                                           <option value="">Select Budget Reference for Adjustment only</option>
                                            <?php $select_b=mysqli_query($db,"select * from tblbudget where bID!='".$row['cpBudgetRef']."' and bMDept='".$_SESSION['bMDept']."' order by bDesc asc");
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
										   
										  <select id="cpBudgetRef5" name="cpBudgetRef5"  style="width:500px;" onchange="check_budget5(this.value);">
                                           <option value="">Select Budget Reference for Adjustment only</option>
                                            <?php $select_b=mysqli_query($db,"select * from tblbudget where bID!='".$row['cpBudgetRef']."' and bMDept='".$_SESSION['bMDept']."' order by bDesc asc");
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
										  
										  <select id="cpBudgetRef6" name="cpBudgetRef6"  style="width:500px;" onchange="check_budget6(this.value);">
                                           <option value="">Select Budget Reference for Adjustment only</option>
                                            <?php $select_b=mysqli_query($db,"select * from tblbudget where bID!='".$row['cpBudgetRef']."' and bMDept='".$_SESSION['bMDept']."' order by bDesc asc");
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
									
									<?php 
									 }
									} ?>
									<input type="hidden" name="famont" id="famont" value="<?php echo $famont;?>">
									<input type="hidden" name="famont2" id="famont2" value="<?php echo $famont;?>">
									<input type="hidden" name="submit_f" id="submit_f" value="<?php echo $submit_f;?>">
                                    <input type="hidden" name="bugRemaining" id="bugRemaining" value="<?php echo $bRemaining;?>">
									<input type="hidden" name="adjusted" id="adjusted" value="<?php echo $famont;?>">
										</td>
                                      </tr>
                                     
                                     <?php }if($row['cpDBudget']==3){?>
                                     
                                      <tr>
                                        <td><span class="style4">*</span>Strategic Budget Reference</td>
                                        <td>
                                          
										  <select id="cpsBudgetRef" name="cpsBudgetRef"  style="width:500px;" disabled>
                                            <option value=""></option>
                                            <?php $select_b=mysqli_query($db,"select * from tblsbudget where sbMDept='".$_SESSION['bMDept']."' order by sbDept asc");
										while($row_b=mysqli_fetch_array($select_b)){ 
										?>
                                            <option value="<?php echo $row_b['sbID'];?>" <?php if($row['cpSBudgetRef']==$row_b['sbID']){echo 'selected="selected"';} ?>><?php echo $row_b['sbDept'].'----'.$row_b['sbDesc'];?></option>
                                            <?php }?>
                                          </select>
										   <input type="hidden" name="cpsBudgetRefid" id="cpsBudgetRefid" value="<?php echo $row['cpSBudgetRef'];?>">
                                        </td>
                                      </tr>
                                     <?php }if($row['cpDBudget']==4){ ?>
									 
									  <tr>
                                        <td><span class="style4">*</span>Strategic Budget Reference</td>
                                        <td>
                                          
										<input name="cpSBudgetRef2" type="text" id="cpSBudgetRef2"  value="<?php echo $row['cpSBudgetRef'];?>" style="width:500px;"  />
										 
                                        </td>
                                      </tr>
									 
                                     <?php }?>
									 
									
                                      <tr>
                                        <td><span class="style4">*</span>Expected Completion    Date</td>
                                        <td>
                                          <input name="cpEDate" type="text" id="cpEDate" value="<?php echo $row['cpEDate'];?>" required readonly  />
                                        </td>
                                      </tr>
                                      <tr>
                                        <td><span class="style4">*</span>Replacement / Expansion</td>
                                        <td>
                                         <select id="cpWERI" name="cpWERI" >
                                            <option value=""></option>
                                            <option value="Replacement" <?php if($row['cpWERI']=='Replacement'){echo 'selected="selected"';} ?>>Replacement</option>
                                            <option value="Expansion" <?php if($row['cpWERI']=='Expansion'){echo 'selected="selected"';} ?>>Expansion</option>
                                          </select>
                                       </td>
                                      </tr>
                                      <tr>
                                        <td><span class="style4">*</span>Category.</td>
                                        <td>
                                          <select id="cpCid" name="cpCid" >
                                            <option value=""></option>
                                            <?php 
										 $select_cat=mysqli_query($db,"select * from tblcategory where cStatus='1' order by cName");
										 while($row_cat=mysqli_fetch_array($select_cat)){
										 ?>
                                            <option value="<?php echo $row_cat['cID'];?>" <?php if($row['cpCid']==$row_cat['cID']){echo 'selected="selected"';} ?>><?php echo $row_cat['cName'];?></option>
                                            <?php } ?>
                                          </select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td><span class="style4">*</span>Detail of Proposal:</td>
                                        <td>
                                          <textarea name="cpDetail" cols="70" rows="5" id="cpDetail" required><?php echo $row['cpDetail'];?></textarea>
                                      </td>
                                      </tr>
                                      <tr>
                                        <td><span class="style4">*</span>Desired Asset Name    in SAP Register</td>
                                        <td>
                                          <textarea name="cpDAssetName" cols="70" rows="5" id="cpDAssetName" required><?php echo $row['cpDAssetName'];?></textarea>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td><span class="style4">*</span>Option of In-House    Availablility</td>
                                        <td>
                                          <select id="cpOIHA" name="cpOIHA" >
                                            <option value=""></option>
                                            <option value="1" <?php if($row['cpOIHA']==1){echo 'selected="selected"';} ?>>No</option>
                                            <option value="2" <?php if($row['cpOIHA']==2){echo 'selected="selected"';} ?>>Yes</option>
                                          </select>
                                        </td>
                                      </tr>
									  
									  <tr>
                                        <td><span class="style4">*</span>Entered By(Email)</td>
                                        <td>
                                        <input type="email" name="cpEmail" id="cpEmail" value="<?php echo $row['cpEmail'];?>" readonly />
                                        </td>
                                      </tr>
                                      <tr>
                                        <td><span class="style4">*</span>Ext No</td>
                                        <td>
                                        <input type="number" name="e_ext" id="e_ext" value="<?php echo $row['cpExtNo'];?>" readonly />
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
                                            <input name="cpCostL" type="text" id="cpCostL"  onblur="cal();" size="12" value="<?php echo number_format($row['cpCostL']);?>" />
                                            </td>
                                            <td align="center">
                                            <input name="cpCostI" type="text" id="cpCostI"  onblur="cal();" size="12" value="<?php echo number_format($row['cpCostI']);?>" />
                                            </td>
                                            <td><div align="center">
                                              <input name="cpCur" type="text" id="cpCur"   size="12" value="<?php echo ($row['cpCur']);?>" />
                                            </div></td>
                                            <td><div align="center">
                                              <input name="cpFCA" type="text" id="cpFCA" onblur="cal2();"   size="28" value="<?php echo number_format($row['cpFCA']);?>" />
                                            </div></td>
                                            <td><div align="center">
                                              <input name="cpFCR" type="text" id="cpFCR" onblur="cal2();" size="12" value="<?php echo number_format($row['cpFCR']);?>" />
                                            </div></td>
                                          </tr>
                                          <tr>
                                            <td>Custom Duty</td>
                                            <td><div align="center">
                                              <input name="cpCDL" type="text" id="cpCDL"  onblur="cal();" size="12" value="<?php echo number_format($row['cpCDL']);?>" />
                                            </div></td>
                                            <td><div align="center">
                                              <input name="cpCDI" type="text" id="cpCDI"  onblur="cal();" size="12" value="<?php echo number_format($row['cpCDI']);?>" />
                                            </div></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>Others</td>
                                            <td><div align="center">
                                              <input name="cpOthersL" type="text" id="cpOthersL"  onblur="cal();" size="12" value="<?php echo number_format($row['cpOthersL']);?>" />
                                            </div></td>
                                            <td><div align="center">
                                              <input name="cpOthersI" type="text" id="cpOthersI"  onblur="cal();" size="12" value="<?php echo number_format($row['cpOthersI']);?>" />
                                            </div></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>GST (Not applicable for Plant &amp; Machinery)</td>
                                            <td><div align="center">
                                              <input name="cpGSTL" type="text" id="cpGSTL"  onblur="cal();" size="12" value="<?php echo number_format($row['cpGSTL']);?>" />
                                            </div></td>
                                            <td><div align="center">
                                              <input name="cpGSTI" type="text" id="cpGSTI"  onblur="cal();" size="12" value="<?php echo number_format($row['cpGSTI']);?>" />
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
                                              <input name="cpTot" type="text" id="cpTot"   size="28" readonly="readonly" style="border:1px solid #FFFFFF;font-size:14px;font-weight:bold;" value="<?php echo number_format($row['cpTot']);?>" />
                                            </div></td>
                                          </tr>
                                          <tr>
                                            <td colspan="6">&nbsp;</td>
                                          </tr>
                                          
                                           <tr>
									     <td align="center">Uploaded Attachements	</td>
									     <td colspan="6">&nbsp;</td>
								      </tr>
                                      <?php 
									  $select_q=mysqli_query($db,"select * from tblcpquotations where cpID='".base64_decode($_GET['cpID'])."'");
									  while($row_q=mysqli_fetch_array($select_q)){
									  $count=$count+1;
									  ?>
                                      <tr>
									     <td align="center"><?php echo $count;?></td>
									     <td colspan="6"><a href="img/quotations/<?php echo $row_q['cpQuotation'];?>" style="color:#006600;" target="_blank"><?php echo $row_q['cpQuotation'];?><a></td>
								      </tr>
                                      <?php
									    
									   }
									  ?>
                                          <?php if($_SESSION['tID']==2){?>
										   <tr>
                                            <td colspan="6">&nbsp;</td>
                                          </tr>
								      <tr>
									     <td align="center">Upload Attachements	</td>
									     <td colspan="6">&nbsp;</td>
								      </tr>
										  
										  <tr>
									     <td>1</td>
									     <td colspan="2"><input type="file" name="files11" id="files11" ></td>
								      </tr>
									   <tr>
									     <td>2</td>
									     <td colspan="2"><input type="file" name="files22" id="files22" ></td>
								      </tr>
								       <tr>
									     <td>3</td>
									     <td colspan="2"><input type="file" name="files33" id="files33" ></td>
								      </tr>
										  <?php } ?>
                                           <tr>
                                            <td colspan="6">&nbsp;</td>
                                          </tr>
                                          
                                          <?php if($_SESSION['department']=='COA' or $_SESSION['tID']==2){
											  
											  if($row['cpTot']>'1000000'){
												  
												  $required='required="required"';
											  }else{
												  $required='';
											  }
										  ?>
                                          <tr>
                                            <td>Payback </td>
                                            <td colspan="5"><input name="cpPBack" type="text" id="cpPBack"   size="28" value="<?php echo $row['cpPBack'];?>" <?php echo $required; ?> /></td>
                                          </tr>
                                          <tr>
                                            <td>IRR</td>
                                            <td colspan="5"><input name="cpIRR" type="text" id="cpIRR"   size="28" value="<?php echo $row['cpIRR'];?>" <?php echo $required; ?> /></td>
                                          </tr>
                                          
                                          <tr>
                                            <td colspan="6">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td colspan="6">&nbsp;</td>
                                          </tr><?php } ?>
                                        </table></td>
                                      </tr>

                                    </table></td>
                                  </tr>
                                </table>
					          </div>
                                                             <?php 
							 
							  if($row['cpHOD']!=0){
								 $select_ht=mysqli_query($db,"select * from tbldepts where dID='".$row['cpHOD']."'");
			                     $row_ht=mysqli_fetch_array($select_ht); 
								 $bum=$row_ht['dEmail'];
								 $bum_hod=explode('@',$bum);
								 $cpHOD_Date=$row['cpHOD_Date']; 
								  
							  }elseif($row['cpBUM']!=0){
							     $select_ht=mysqli_query($db,"select * from tbldepts where dID='".$row['cpBUM']."'");
			                     $row_ht=mysqli_fetch_array($select_ht); 
								 $bum=$row_ht['dEmail'];
								 $bum_hod=explode('@',$bum);
								 $cpHOD_Date=$row['cpBUM_Date']; 
							  
							  }
							  
							    if($row['cpIA_FLAG']==2){
							     
								 $select_ia=mysqli_query($db,"select * from tbldepts where dID='8'");
								 $row_ia=mysqli_fetch_array($select_ia); 
								 $ia=$row_ia['dEmail'];
								 $ia=explode('@',$ia);
								 $cpIA_Date=$row['cpIA_Date'];
								} 
							 
							   $select_al=mysqli_query($db,"select * from tblcpapprovals where cpID='".$row['cpID']."' 
							                           and cpAStatus='2' order by cpHID");
							   while($row_al=mysqli_fetch_array($select_al)){
								
							   $cpAID=$row_al['cpAID'];
							   
							   $select_pan=mysqli_query($db,"select * from tbldepts where dID='".$cpAID."'"); 
							   $row_pan=mysqli_fetch_array($select_pan);
							   $dName=$row_pan['dName'];
							  
								  if($dName=='HOP'){
									 $dEmail=$row_pan['dEmail'];
									 $hhh=explode('@',$dEmail);
									 $hhh_cpADate=$row_al['cpADate'];
								  }elseif($dName=='HOE'){
									 $dEmail=$row_pan['dEmail'];
									 $hhh=explode('@',$dEmail);
									 $hhh_cpADate=$row_al['cpADate'];
								  }elseif($dName=='HCD'){
									 $dEmail=$row_pan['dEmail'];
									 $hhh=explode('@',$dEmail);
									 $hhh_cpADate=$row_al['cpADate'];
								  }elseif($dName=='GHSC'){
									 $dEmail=$row_pan['dEmail'];
									 $hhh=explode('@',$dEmail);
									 $hhh_cpADate=$row_al['cpADate'];
								  }elseif($dName=='COA'){
									 $dEmail=$row_pan['dEmail'];
									 $coa=explode('@',$dEmail);
									 $coa_cpADate=$row_al['cpADate'];
								  }elseif($dName=='CFO'){
									 $dEmail=$row_pan['dEmail'];
									 $cfo=explode('@',$dEmail);
									 $cfo_cpADate=$row_al['cpADate'];
								  }elseif($dName=='MD'){
									 //$dEmail=$row_pan['dEmail'];
									 $md='Ahmad Ramzan';
									 $md_cpADate=$row_al['cpADate'];
								  }     
							  }	  
							 
							  ?>
							  
							           <div class="row" style="margin:20px;">
					            <table  style="width:80% !important;" border="0">
                                  
                                  <tr>
                                    <td width="16%"><div align="center">
                                      <input type="text" name="oDept13" id="oDept13" value="<?php echo $bum_hod[0];?>" style="border-bottom:none;border-top:none;border-left:none;border-right:none;text-align:center;" readonly="readonly">
                                      <input type="text" name="oDept13" id="oDept13" value="<?php echo $cpHOD_Date;?>" style="border-bottom:1px solid;border-top:none;border-left:none;border-right:none;text-align:center;" readonly="readonly">
                                    </div></td>
                                   
                                    <td width="16%"><div align="center">
                                      <input type="text" name="oDept13" id="oDept13" value="<?php echo $hhh[0];?>" style="border-bottom:none;border-top:none;border-left:none;border-right:none;text-align:center;" readonly="readonly">
                                       <input type="text" name="oDept13" id="oDept13" value="<?php echo $hhh_cpADate;?>" style="border-bottom:1px solid;border-top:none;border-left:none;border-right:none;text-align:center;" readonly="readonly">
                                    </div></td>
                                    <td width="16%"><div align="center">
                                      <input type="text" name="oDept13" id="oDept13" value="<?php echo $coa[0];?>" style="border-bottom:none;border-top:none;border-left:none;border-right:none;text-align:center;" readonly="readonly">
                                       <input type="text" name="oDept13" id="oDept13" value="<?php echo $coa_cpADate;?>" style="border-bottom:1px solid;border-top:none;border-left:none;border-right:none;text-align:center;" readonly="readonly">
                                    </div></td>
                                    <td width="16%"><div align="center">
                                      <input type="text" name="oDept13" id="oDept13" value="<?php echo $cfo[0];?>" style="border-bottom:none;border-top:none;border-left:none;border-right:none;text-align:center;" readonly="readonly">
                                       <input type="text" name="oDept13" id="oDept13" value="<?php echo $cfo_cpADate;?>" style="border-bottom:1px solid;border-top:none;border-left:none;border-right:none;text-align:center;" readonly="readonly">
                                    </div></td>
                                    <td width="16%"><div align="center">
                                      <input type="text" name="oDept13" id="oDept13" value="<?php echo $md;?>" style="border-bottom:none;border-top:none;border-left:none;border-right:none;text-align:center;" readonly="readonly">
                                       <input type="text" name="oDept13" id="oDept13" value="<?php echo $md_cpADate;?>" style="border-bottom:1px solid;border-top:none;border-left:none;border-right:none;text-align:center;" readonly="readonly">
                                    </div></td>
                                  </tr>
                                  <tr>
                                    <td><div align="center">BUM/HOD</div></td>
                                    <td><div align="center">Head of Packaging</div></td>
                                    <td><div align="center">Financial Controller</div></td>
                                    <td><div align="center">CFO</div></td>
                                    <td><div align="center">Managing Director </div></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td><div align="center">Group Head of Supply Chain & Logistics</div></td>
                                    <td><div align="center">(Above Rs.1 million)</div></td>
                                    <td><div align="center">(Above Rs 0.5 million)</div></td>
                                    <td><div align="center">(Above Rs 0.5 million)</div></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td><div align="center">Head of Consumer Division</div></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td><div align="center">Group Head of IT</div></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td><div align="center">Group Head of HR</div></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td><div align="center">(Upto Rs.0.5 million)</div></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td colspan="6">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td colspan="6">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td colspan="6">* Approval of Managing Director is not required where entitlements are as per policies approved by Board of Directors.</td>
                                  </tr>
                                  <tr>
                                    <td colspan="6">* Logical sequence should be followed for approvals.</td>
                                  </tr>
                                  <tr>
                                    <td colspan="6">&nbsp;</td>
                                  </tr>
                                  
                                 
								  <!--
                                   <tr>
                                    <td colspan="6">* Comments</td>
                                  </tr>
                                  <tr>
                                    <td colspan="6"><textarea name="comments" id="comments" cols="110" rows="8" style="border:1px dashed;" required></textarea></td>
                                  </tr>
                                  <tr>
                                    <td colspan="6">&nbsp;</td>
                                  </tr>
							-->
                                  
                                  
                                  <tr>
                                    <td colspan="6" style="color:#CC0000;font-weight:bold;font-size:16px;">*Comments</td>
                                  </tr>
                                   <tr>
                                      <td>&nbsp;</td>
                                    </tr>
                                  <?php 
								       //if($_SESSION['department']=='IA'){
									   $select_cfbum=mysqli_query($db,"select * from tblcpcomments where
									    cpID='".base64_decode($_GET['cpID'])."'");  
									   //}else{
								       //$select_cfbum=mysqli_query($db,"select * from tblcpcomments where 
									  // cpID='".base64_decode($_GET['cpID'])."' 
									   //and cpTDepartment='".$_SESSION['dID']."'");       
									   //}							  
									   while($row_cfbum=mysqli_fetch_array($select_cfbum)){
									   $select_d=mysqli_query($db,"select dName from tbldepts where dID='".$row_cfbum['cpFDepartment']."'");
			                           $row_d=mysqli_fetch_array($select_d);
									   
									   $counter=$counter+1;
							       ?>			
                                    <tr>
                                      <td colspan="6" style="color:#000000;"><?php echo $counter;?> - <?php echo nl2br($row_cfbum['cpComments']);?></td>
                                    </tr>
                                     
                                    <tr>
                                    <td colspan="6" style="color:#333333;font-size:11px;font-style:italic;">
                                    From - <?php if($row_d['dName']=='COA'){echo "Financial Controller";}else{echo $row_d['dName'];}?> - <?php echo $row_cfbum['cpCDateTime'];?></td>
                                    </tr>
                                    <tr>
								    <td colspan="6" style="color:#000000;font-weight:bold;">&nbsp;</td>
								    </tr>
                                    <?php 
									 }
									//}?>
                                    
                                    
                                     <?php 
							
							if($_SESSION['tID']!=2){
							
							?><!--<tr style="display:none;">-->
                                     <tr style="display:none;">
								     <td>* Send to</td>
                                     <td colspan="6"><br>
                                     <?php 
									    $dept=explode('-',$row2['dName']);
										if($row['cpCid']!='6'){
											if($row['cpTot'] > '500000'){
											   //$cfo="checked='checked'";	
											   //$md="checked='checked'";	
											}
											
											if($row['cpTot'] > '1000000'){
											   //$coa="checked='checked'";	
											   
											}
										}
										
									 
									 //if($row['cpINV_Flag']!=3){?>
									 <?php 
									 
									 
									 if(( $dept[0]=='BUFC' or $dept[0]=='FIN' or $dept[0]=='IA' or $dept[0]=='MANEX' or $dept[0]=='IR' or $dept[0]=='LOGISTICS' or $dept[0]=='Main.Office' or $dept[0]=='Karachi.Office' or $dept[0]=='CS'  or $dept[0]=='SECURITY' or $dept[0]=='ICS' or $dept[0]=='INVESTMENT' )){
										   //if(( $dept[0]=='BUFC' or $dept[0]=='BUFP' or $dept[0]=='FIN' or $dept[0]=='IA' or $dept[0]=='MANEX' or $dept[0]=='IR' or $dept[0]=='LOGISTICS' or $dept[0]=='Main-Office' or $dept[0]=='Karachi-Office' or $dept[0]=='SM' or $dept[0]=='CS' or $dept[0]=='ICS' or $dept[0]=='SECURITY' ) and ($row['cpCid']!='6' )){
										 ?>
									 <input type="checkbox" name="hop" id="hop" checked='checked' > Head of Packaging <br>
                                     <?php }else if( ( $dept[0]=='BUMF' or $dept[0]=='POWER.HOUSE' or $dept[0]=='HVAC') ){?>
									 <input type="checkbox" name="hoe" id="hoe" checked='checked'> Head of Engineering	 <br>
                                     <?php } else if($dept[0]=='BUCP' or $dept[0]=='TS' or $dept[0]=='AFH' or $dept[0]=='FM'){
										 
										 /*if($row['cpTot'] > '1000000'){
											   $coa="checked='checked'";	
											   
											}else{
												if($row['cpTot'] > '500000'){
											  
											    $cfo="checked='checked'";	
											    }else{
													
												$inv="checked='checked'";	
												}
												
											}*/
											
										 ?>
									 <input type="checkbox" name="hcd" id="hcd" checked='checked' > HCD <br>

									 <br>	 								 
									 <?php }else if($dept[0]=='ERP' or $dept[0]=='SYSTEMS'){?>
									 <input type="checkbox" name="ghit" id="ghit" checked='checked' > Group Head & IT   <br>
									 <?php }else if($dept[0]=='BUFP'){?>
									 
									 
									 
									 
									 
									 <input type="checkbox" name="hop_fp" id="hop_fp" checked='checked' > Head of Packaging BUFP   <br>
									 
									 <?php 
									 if($row['cpCid']!='6'){
											
											
											if($row['cpTot'] > '1000000'){
											   $coa="checked='checked'";	
											   
											}else{
												
												
												if($row['cpTot'] > '500000'){
											  
											    $cfo="checked='checked'";	
											    }else{
													
												$inv="checked='checked'";	
												}

												
											}
										
									 
									 } ?>
									 
                                    
                                     <br>	 								 
									 <?php }else if($dept[0]=='SM'){?>
									 <input type="checkbox" name="gsm" id="gsm" checked='checked' > Group Head of Supply Chain & Logistics   <br>


									<?php }else{?>
									 
                                     <?php } ?>
                                     <?php if($dept[0]=='HR'){?>
                                      <input type="checkbox" name="ghhr" id="ghhr" checked='checked' > Group Head & HR  <br>
									 <?php }?>
									 
									 <input type="checkbox" name="inv" id="inv" <?php echo $inv;?>> INV <br>
									 <input type="checkbox" name="coa" id="coa" <?php echo $coa;?>> COA <br>
									 <input type="checkbox" name="cfo" id="cfo" <?php echo $cfo;?> > CFO <br>
									 <input type="checkbox" name="md" id="md" <?php echo $md;?>> MD <br>
                                     <?php //}else{ ?>
                                    
                                     <?php //} ?>
                                     </td>
								    </tr>
                                    <?php } ?>
									
									
									 <tr>
                                            <td colspan="6">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td colspan="6"><div align="center">
                            <!--<input type="submit" name="submit" id="submit" value="Submit">-->
                            
                            
							<?php 
							
							if($_SESSION['tID']==1){
							
							?>
                            
                            <input type="button" name="reject" id="reject" value="Reject" onClick="rejected('<?php echo base64_decode($_GET['cpID']);?>','<?php echo $_SESSION['dID']; ?>','<?php echo $row['cpDepartment']; ?>');">
                            
                          <!--  <input type="button" name="back" id="back" value="Back to originator" onClick="return_back('<?php //echo base64_decode($_GET['cpID']);?>','<?php //echo $_SESSION['dID']; ?>','<?php //echo $row['cpDepartment']; ?>');">-->
                            
                            
                            <?php 
							   
							}elseif($_SESSION['tID']==2){
							   
							   
							 ?>  
							   
							 <input type="button" name="reject" id="reject" value="Reject" onClick="rejected('<?php echo base64_decode($_GET['cpID']);?>','<?php echo $_SESSION['dID']; ?>','<?php echo $row['cpDepartment']; ?>');">
                            
                         <!--   <input type="button" name="back" id="back" value="Back to originator" onClick="return_back('<?php //echo base64_decode($_GET['cpID']);?>','<?php //echo $_SESSION['dID']; ?>','<?php //echo $row['cpDepartment']; ?>');">-->
                              
							<?php }elseif($_SESSION['tID']==3){
							
							   if($_SESSION['dID']==$_SESSION['dBC_BUM_HOD'] and (!isset($_GET['c']))){
							   
							   ?>
                               
                               <input type="button" name="reject" id="reject" value="Reject" onClick="rejected('<?php echo base64_decode($_GET['cpID']);?>','<?php echo $_SESSION['dID']; ?>','<?php echo $row['cpDepartment']; ?>');">
                            
                          <!--  <input type="button" name="back" id="back" value="Back to originator" onClick="return_back('<?php //echo base64_decode($_GET['cpID']);?>','<?php //echo $_SESSION['dID']; ?>','<?php //echo $row['cpDepartment']; ?>');">-->
							<?php 	 
							   }elseif($_SESSION['dID']==$_SESSION['dBC_BUM_HOD']){?>
							                              
                            <input type="button" name="back" id="back" value="Not Recommended" onClick="not_recommend('<?php echo base64_decode($_GET['cpID']);?>','<?php echo $_SESSION['dID']; ?>','<?php echo $row['cpDepartment']; ?>');">
							     
							  <?php  }
							   
							}
							
							
							
							?>
                              
                            
                            
                            </div>
						<br></td>
                                          </tr>
									
                                </table>
					          </div>
                              
                              		
						
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
			 var famont       = document.getElementById("adjusted").value;

			 
			 $.post("controllar.php",{id:val,adjusted:famont,adjust_amount:"adjust_amount"},function(data){   
				
				if(data>0){
					$("#bad").css("color", "green");
					document.getElementById("show_b2").style.display='none';
					document.getElementById("show_b3").style.display='none';
					document.getElementById("show_b4").style.display='none';
					document.getElementById("show_b5").style.display='none';
					
				}else{
					document.getElementById("adjusted").value=data;
					$("#bad").css("color", "red");
					document.getElementById("show_b2").style.display='block';
					document.getElementById("show_b3").style.display='block';
					document.getElementById("show_b4").style.display='block';
					document.getElementById("show_b5").style.display='block';
				}
			});
			 
             
			 
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
			 
			 var famont       = document.getElementById("adjusted").value;
			 
			 $.post("controllar.php",{id:val,adjusted:famont,adjust_amount:"adjust_amount"},function(data){   
				
				if(data>0){
					$("#bad").css("color", "green");
					document.getElementById("show_b3").style.display='none';
					document.getElementById("show_b4").style.display='none';
					document.getElementById("show_b5").style.display='none';
				}else{
					document.getElementById("adjusted").value=data;
					$("#bad").css("color", "red");
					document.getElementById("show_b3").style.display='block';
					document.getElementById("show_b4").style.display='block';
					document.getElementById("show_b5").style.display='block';
				}
			});
			 
			 
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
			 
			 var famont       = document.getElementById("adjusted").value;
			 
			 $.post("controllar.php",{id:val,adjusted:famont,adjust_amount:"adjust_amount"},function(data){   
				
				if(data>0){
					$("#bad").css("color", "green");
					document.getElementById("show_b4").style.display='none';
					document.getElementById("show_b5").style.display='none';
				}else{
					document.getElementById("adjusted").value=data;
					$("#bad").css("color", "red");
					document.getElementById("show_b4").style.display='block';
					document.getElementById("show_b5").style.display='block';
				}
			});
			 
			 
			 
			 
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
			 
			 
			 var famont       = document.getElementById("adjusted").value;
			 
			 $.post("controllar.php",{id:val,adjusted:famont,adjust_amount:"adjust_amount"},function(data){   
				
				if(data>0){
					$("#bad").css("color", "green");
					document.getElementById("show_b5").style.display='none';
				}else{
					document.getElementById("adjusted").value=data;
					$("#bad").css("color", "red");
					document.getElementById("show_b5").style.display='block';
				}
			});
			 
			 
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
			 
			 
			 var famont       = document.getElementById("adjusted").value;
			 
			 $.post("controllar.php",{id:val,adjusted:famont,adjust_amount:"adjust_amount"},function(data){   
				
				if(data>0){
					$("#bad").css("color", "green");
				}else{
					document.getElementById("adjusted").value=data;
					$("#bad").css("color", "red");
				}
			});
			 
			 
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
			
			var cpTot=   ( cpCostL * 1 ) + ( cpCostI * 1 ) + ( cpCDL * 1 ) + ( cpCDI * 1 ) + ( cpOthersL * 1 )  +
			             ( cpOthersI * 1 ) + ( cpGSTL * 1 ) + ( cpGSTI * 1 ); 
			if(cpTot>0){	
			document.getElementById("cpTot").value=cpTot;
			}
			
		}
		</script>
<script type="text/javascript">

$(document).ready(function(){

    var counter = 1;

    $("#addButton").click(function () {

	if(counter>10){
            alert("Only 10 textboxes allow");
            return false;
	}

	var newTextBoxDiv = $(document.createElement('div'))
	     .attr("id", 'TextBoxDiv' + counter);

	newTextBoxDiv.after().html('<label>File #'+ counter + ' : </label>' +
	      '<input type="file" name="files[]" id="files[]" >');

	newTextBoxDiv.appendTo("#TextBoxesGroup");


	counter++;
     });

     $("#removeButton").click(function () {
	if(counter==1){
          //alert("No more textbox to remove");
          $("#TextBoxDiv" + counter).remove();
		  return false;
       }

	counter--;

        $("#TextBoxDiv" + counter).remove();

     });

     $("#getButtonValue").click(function () {

	var msg = '';
	for(i=1; i<counter; i++){
   	  msg += "\n Textbox #" + i + " : " + $('#files' + i).val();
	}
    	  alert(msg);
     });
  });
  
  function check_form(){
		
		var cpTot=document.getElementById("cpTot").value;
	
		 if(cpTot=="" || cpTot==0){
		    alert("Amount must be greater than 0.");
			return false;
		 }
		 
		 return true;
		 
		
		}
		
</script>

		<script type="text/javascript">
		 function check_form(){
			  var famount=document.getElementById("famont2").value;
			  var submit_f=document.getElementById("submit_f").value;
			  if(submit_f==0){
				 alert("Please adjust budget first."); 
				 return false;
				  
			  }
			  return true;
		  }
		function get_b_list1(cpBudgetRef){
		var bMDept='<?php echo $_SESSION['bMDept'];?>';	
		
		$.post("controllar.php",{bMDep:bMDept,cpBudgetRef:cpBudgetRef,GET_LIST1:'get_list1'},function(data){	
                document.getElementById("blist1").innerHtml=$("#blist1").html(data);
				document.getElementById("bl1").style.display="none";
        });	
		}
		function get_b_list2(cpBudgetRef){
		var bMDept='<?php echo $_SESSION['bMDept'];?>';	
		
		$.post("controllar.php",{bMDep:bMDept,cpBudgetRef:cpBudgetRef,GET_LIST2:'get_list2'},function(data){	
                document.getElementById("blist2").innerHtml=$("#blist2").html(data);
				document.getElementById("bl2").style.display="none";
        });	
		}
		function check_budget(bID){
		var bMDept='<?php echo $_SESSION['bMDept'];?>';	
		var famount=document.getElementById("famont2").value;
		var cpID='<?php echo $_SESSION['cpID'];?>';	
		
		$.post("controllar.php",{CPID:cpID,BID:bID,bMDep:bMDept,FAMOUNT:famount,CHECK_BUDGET:'check_budget'},function(data){	
                //document.getElementById("blist2").innerHtml=$("#blist2").html(data);
				document.getElementById("famont").value=data;
				if(data>=0){
				   document.getElementById("bl2").style.display="none";	 
				   document.getElementById("bad").style.display="none";	 
				   document.getElementById("submit_f").value=1;
				}else if(data<0){
					//alert("Please select another budget option for adjust.");
					document.getElementById("bl2").style.display="block";
                    document.getElementById("bad").style.display="block";						
					document.getElementById("submit_f").value=0;
					
				}
        });	
		}
		
		
		
		
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
		</script>
 <script type="text/javascript">
		function return_back(cpID,cpFDepartment,cpTDepartment){
		 var comments=document.getElementById("comments").value;
		 if(comments==""){
		 alert("Please enter some comments.");
		 return false;
		 }  
		 	 
		 $.post("controllar.php",{cpID:cpID,FDept:cpFDepartment,TDept:cpTDepartment,comments:comments,action:'return-back-comments'},function(data){
                window.location="index.php"; 
 	       });
		}
		
		function not_recommend(cpID,cpFDepartment,cpTDepartment){
		 var comments=document.getElementById("comments").value;
		 if(comments==""){
		 alert("Please enter some comments.");
		 return false;
		 }  
		 	 
		 $.post("controllar.php",{cpID:cpID,FDept:cpFDepartment,TDept:cpTDepartment,comments:comments,action:'not_recommend'},function(data){
                window.location="index.php"; 
 	       });
		}
		
		function rejected(cpID,cpFDepartment,cpTDepartment){
		 var comments=document.getElementById("comments").value;
		 if(comments==""){
		 alert("Please enter some comments.");
		 return false;
		 }  
		 	 
		 $.post("controllar.php",{cpID:cpID,FDept:cpFDepartment,TDept:cpTDepartment,comments:comments,action:'rejected'},function(data){
                window.location="index.php"; 
 	       });
		}
		
		 
		
		</script>
		
		
		</script>
</body>

</html>