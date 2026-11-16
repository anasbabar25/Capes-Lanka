<?php 
include('include/conn.php');
include('include/security.php');

if($_SESSION['department']=='HHH'){
	
	
	$select_hhh_p=mysqli_query($db,"select * from tblcpapprovals where cpAID='".$_SESSION['dID']."' and cpAStatus='1'");
	$num_pending=mysqli_num_rows($select_hhh_p);

	$select_hhh_a=mysqli_query($db,"select * from tblcpapprovals where cpAID='".$_SESSION['dID']."' and cpAStatus='2'");
	$num_approved=mysqli_num_rows($select_hhh_p);

	$select_hhh_t=mysqli_query($db,"select * from tblcpapprovals where cpAID='".$_SESSION['dID']."'");
	$num_total=mysqli_num_rows($select_hhh_p);	
	
}elseif($_SESSION['department']=='INV'){
	
	$select_inv_a=mysqli_query($db,"select * from tblcp where cpINV_Flag='2'");
	$num_approved=mysqli_num_rows($select_inv_a);
	
	$select_inv_p=mysqli_query($db,"select * from tblcp where cpINV_Flag='1'");
	$num_pending=mysqli_num_rows($select_inv_p);
	
	$select_inv_t=mysqli_query($db,"select * from tblcp");
	$num_total=mysqli_num_rows($select_inv_t);
}else{


	if($_SESSION['tID']==1){
									   
	$select_pending=mysqli_query($db,"select * from tblcp where cpBUM='".$_SESSION['dID']."' and cpBUM_Flag='1'");
    $num_pending=mysqli_num_rows($select_pending);
	
	$select_approved=mysqli_query($db,"select * from tblcp where cpBUM='".$_SESSION['dID']."' and cpBUM_Flag='2'");
	$num_approved=mysqli_num_rows($select_approved);
	
    $select_rejected=mysqli_query($db,"select * from tblcp where cpBUM='".$_SESSION['dID']."' and cpBUM_Flag='3'");
    $num_rejected=mysqli_num_rows($select_rejected); 
	 
	$select_total=mysqli_query($db,"select * from tblcp where cpBUM='".$_SESSION['dID']."'");
    $num_total=mysqli_num_rows($select_total);  
	 
	}elseif($_SESSION['tID']==2){

	$select_pending=mysqli_query($db,"select * from tblcp where cpBC='".$_SESSION['dID']."' and cpBC_Flag='1'");
    $num_pending=mysqli_num_rows($select_pending);
	
	$select_approved=mysqli_query($db,"select * from tblcp where cpBC='".$_SESSION['dID']."' and cpBC_Flag='2'");
	$num_approved=mysqli_num_rows($select_approved);
	
	$select_rejected=mysqli_query($db,"select * from tblcp where cpBC='".$_SESSION['dID']."' and cpBC_Flag='3'");
    $num_rejected=mysqli_num_rows($select_rejected); 

	$select_total=mysqli_query($db,"select * from tblcp where cpBC='".$_SESSION['dID']."'");
    $num_total=mysqli_num_rows($select_total); 
	
	}elseif($_SESSION['tID']==3){

	if($_SESSION['dID']!=$_SESSION['dBC_BUM_HOD']){
	  $select_pending=mysqli_query($db,"select * from tblcp where cpDepartment='".$_SESSION['dID']."' and cpDepartment_Flag='0'");
	  $num_pending=mysqli_num_rows($select_pending);
	  
	  $select_approved=mysqli_query($db,"select * from tblcp where cpDepartment='".$_SESSION['dID']."' and cpDepartment_Flag='2'");
	  $num_approved=mysqli_num_rows($select_approved);
	  
	  $select_rejected=mysqli_query($db,"select * from tblcp where cpDepartment='".$_SESSION['dID']."' and cpDepartment_Flag='3'");
      $num_rejected=mysqli_num_rows($select_rejected); 
	  
	  $select_total=mysqli_query($db,"select * from tblcp where cpDepartment='".$_SESSION['dID']."'");
	  $num_total=mysqli_num_rows($select_total); 
	}else{
	  $select_pending=mysqli_query($db,"select * from tblcp where cpHOD='".$_SESSION['dID']."' and cpHOD_Flag='1'");
	  $num_pending=mysqli_num_rows($select_pending);
	  $select_approved=mysqli_query($db,"select * from tblcp where cpHOD='".$_SESSION['dID']."' and cpHOD_Flag='2'");
	  $num_approved=mysqli_num_rows($select_approved);
	  $select_rejected=mysqli_query($db,"select * from tblcp where cpHOD='".$_SESSION['dID']."' and cpHOD_Flag='3'");
	  $num_rejected=mysqli_num_rows($select_rejected); 
	  $select_total=mysqli_query($db,"select * from tblcp where cpHOD='".$_SESSION['dID']."'");
	  $num_total=mysqli_num_rows($select_total); 
	  
	}

	}
	
	
}	
	



?>
<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title><?php echo $title;?> -  Dashboard</title>
<link rel="icon" href="logo.png" type="image/x-icon">
<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" href="assets/icon.css?family=Material+Icons" type="text/css">
<link rel="stylesheet" href="assets/plugins/morrisjs/morris.css"/>
<!-- Custom Css -->
<link rel="stylesheet" href="assets/css/main.css"/>
</head>

<body class="theme-cyan">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-cyan">
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
 <?php $dept=$_SESSION['department'];
	   $pos = strpos($dept, 'USER');
	   if ($pos === true){?>
<!-- #Float icon -->
<ul id="f-menu" class="mfbc-br mfb-zoomin" data-mfb-toggle="hover">
    <li class="mfbc_wrap">
        <a href="javascript:void(0);" class="mfbcb-main g-bg-cyan" onclick="window.location='new-capex.php';" title="New Capex">
            <i class="mfbcm-icon-resting zmdi zmdi-plus"></i>
            <i class="mfbcm-icon-active zmdi zmdi-close"></i>
        </a>
       
    </li>
</ul>
						<?php } ?>
<!-- Top Bar -->
<?php include('include/header.php');?>
<!-- #Top Bar -->
<section> 
    <!-- Left Sidebar -->
    <?php include('include/sidebar.php');?>

</section>

<section class="content home">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Dashboard</h2>
            <small class="text-muted">Welcome to capex application</small>
        </div>
        
        <div class="row clearfix">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="info-box-4 hover-zoom-effect">
                    <div class="icon"> <i class="zmdi zmdi-explicit col-blue"></i> </div>
                    <div class="content">
                        <div class="text">Total Capex</div>
                        <div class="number"><?php echo $num_total;?></div>
                    </div>
                </div>
            </div>
			
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="info-box-4 hover-zoom-effect">
                    <div class="icon"> <i class="zmdi zmdi-explicit col-green"></i> </div>
                    <div class="content">
                        <div class="text">Approved Capex</div>
                        <div class="number"><?php echo $$num_approved;?></div>
                    </div>
                </div>
            </div>
			
			
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="info-box-4 hover-zoom-effect">
                    <div class="icon"> <i class="zmdi zmdi-explicit col-blush"></i> </div>
                    <div class="content">
                        <div class="text">Pending Capex</div>
                        <div class="number"><?php echo $$num_pending;?></div>
                    </div>
                </div>
            </div>
			
			 
			
			<div class="col-lg-3 col-md-3 col-sm-6">
                <div class="info-box-4 hover-zoom-effect">
                    <div class="icon"> <i class="zmdi zmdi-explicit"></i> </div>
                    <div class="content">
                        <div class="text">Rejected Capex</div>
                        <div class="number"><?php echo $num_rejected;?></div>
                    </div>
                </div>
            </div>
			
        </div>

    
	 
	<?php 
	if($_SESSION['department']=='HHH'){
		
		
	?>
	
	
	
	  <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
					   
						<h2> Pending List For Approval - <?php echo $row_dn['dName'];?></h2>
						
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                  <th>Serial #</th>
								  <th>Department <br> Cost Center <br> Date of Initiation</th>        
								  <th>Budgeted</th>
								  <th>Detail</th>
								  <th>Cost</th>
								  <th>Email</th>
								  <th>Action</th>
                                </tr>
                                </thead>
								<?php 
							$select_a=mysqli_query($db,"select * from tblcpapprovals where cpAID='".$_SESSION['dID']."' and cpAStatus='1'");
							while($row_a=mysqli_fetch_array($select_a)){
								   $num_a=0;
								if($_SESSION['dID']==14){
								   $check_a=mysqli_query($db,"select * from tblcpapprovals where cpID='".$row_a['cpID']."' and cpAID!='".$_SESSION['dID']."' and cpAStatus='1'");  
								   $num_a=mysqli_num_rows($check_a);
								}
								
								if($num_a==0){
									
								$select=mysqli_query($db,"select * from tblcp where cpID='".$row_a['cpID']."'");

								$row=mysqli_fetch_array($select);
								$select2=mysqli_query($db,"select dName from tbldepts where dID='".$row['cpDepartment']."'");
								$row2=mysqli_fetch_array($select2);
								
								if($row['cpCid']=='7' and $row['cpEH_Flag']=='1'){
								   $cpEH_Flag=1;  
								}else{
								   $cpEH_Flag=2;	
								}
								
								if($cpEH_Flag==2){
							?>
															
                                <tbody>
                                					<tr>
              <td><?php echo $row['cpID'];?></td>
              <td><?php echo $row2['dName'];?><br><?php echo $row['cpCC'];?><br><?php echo $row['cpDate'];?></td>
             
              <td><?php if($row['cpDBudget']==1){
				  echo "No";
			  }elseif($row['cpDBudget']==2){
				  echo "Yes";
			  }elseif($row['cpDBudget']==3){
				  echo "Strategic";
			  };?></td>
              <td><textarea name="cpDetail" cols="50" rows="3"  id="cpDetail" readonly style="border:1px solid #f2f2f2;background-color:#f2f2f2;color:#5d5d5d;"><?php echo $row['cpDetail'];?></textarea></td>
              <td><?php echo number_format($row['cpTot']);?></td>
			 <td><a href="mailto:<?php echo $row['cpEmail'];?>" title="<?php echo $row['cpEmail'];?>">View</a></td>
			  <td><a href="hhh-pending-approve2.php?cpID=<?php echo base64_encode($row['cpID']);?>">Detail</a> 

</td>
		
            </tr>
<?php 
	 }
	  
	}
} 
 ?>
									 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
	
	  <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
					   
						<h2> Approved List - <?php echo $row_dn['dName'];?></h2>
						
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                  <th>Serial #</th>
								  <th>Department <br> Cost Center <br> Date of Initiation</th>        
								  <th>Budgeted</th>
								  <th>Detail</th>
								  <th>Cost</th>
								  <th>Email</th>
								  <th>Action</th>
                                </tr>
                                </thead>
								<?php 
							$select_a=mysqli_query($db,"select * from tblcpapprovals where cpAID='".$_SESSION['dID']."' and cpAStatus='2'");
							while($row_a=mysqli_fetch_array($select_a)){
								   $num_a=0;
								if($_SESSION['dID']==14){
								   $check_a=mysqli_query($db,"select * from tblcpapprovals where cpID='".$row_a['cpID']."' and cpAID!='".$_SESSION['dID']."' and cpAStatus='1'");  
								   $num_a=mysqli_num_rows($check_a);
								}
								
								if($num_a==0){
									
								$select=mysqli_query($db,"select * from tblcp where cpID='".$row_a['cpID']."'");

								$row=mysqli_fetch_array($select);
								$select2=mysqli_query($db,"select dName from tbldepts where dID='".$row['cpDepartment']."'");
								$row2=mysqli_fetch_array($select2);
								
								if($row['cpCid']=='7' and $row['cpEH_Flag']=='1'){
								   $cpEH_Flag=1;  
								}else{
								   $cpEH_Flag=2;	
								}
								
								if($cpEH_Flag==2){
							?>
															
                                <tbody>
                                					<tr>
              <td><?php echo $row['cpID'];?></td>
              <td><?php echo $row2['dName'];?><br><?php echo $row['cpCC'];?><br><?php echo $row['cpDate'];?></td>
             
              <td><?php if($row['cpDBudget']==1){
				  echo "No";
			  }elseif($row['cpDBudget']==2){
				  echo "Yes";
			  }elseif($row['cpDBudget']==3){
				  echo "Strategic";
			  };?></td>
              <td><textarea name="cpDetail" cols="50" rows="3"  id="cpDetail" readonly style="border:1px solid #f2f2f2;background-color:#f2f2f2;color:#5d5d5d;"><?php echo $row['cpDetail'];?></textarea></td>
              <td><?php echo number_format($row['cpTot']);?></td>
			 <td><a href="mailto:<?php echo $row['cpEmail'];?>" title="<?php echo $row['cpEmail'];?>">View</a></td>
			  <td><a href="detail.php?cpID=<?php echo base64_encode($row['cpID']);?>">Detail</a> 

</td>
		
            </tr>
<?php 
	 }
	  
	}
} 
 ?>
									 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      	
		
		
		<?php 
	}elseif($_SESSION['department']=='INV'){
		
		
	?>
		
		
		
			  <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
					   
						<h2> Pending List For Approval - <?php echo $row_dn['dName'];?></h2>
						
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                  <th>Serial #</th>
								  <th>Department <br> Cost Center <br> Date of Initiation</th>        
								  <th>Budgeted</th>
								  <th>Detail</th>
								  <th>Cost</th>
								  <th>Email</th>
								  <th>Action</th>
                                </tr>
                                </thead>
								<?php 
								$select=mysqli_query($db,"select * from tblcp where cpINV_Flag='1'");
								while($row=mysqli_fetch_array($select)){
								$num_ca='';
								$check_ca=mysqli_query($db,"select * from tblcpapprovals where cpID='".$row['cpID']."'");
								$num_ca=mysqli_num_rows($check_ca);
								if($num_ca>0){	
									$num='0';	
									$select_ca=mysqli_query($db,"select * from tblcpapprovals where cpID='".$row['cpID']."' and cpAStatus='1'");	
									while($row_ca=mysqli_fetch_array($select_ca)){
										  $num='1';
										
									} 
									if($num=='0'){	
									$select2=mysqli_query($db,"select dName from tbldepts where dID='".$row['cpDepartment']."'");
									$row2=mysqli_fetch_array($select2);
								?>
															
                                <tbody>
                                					<tr>
              <td><?php echo $row['cpID'];?></td>
              <td><?php echo $row2['dName'];?><br><?php echo $row['cpCC'];?><br><?php echo $row['cpDate'];?></td>
             
              <td><?php if($row['cpDBudget']==1){
				  echo "No";
			  }elseif($row['cpDBudget']==2){
				  echo "Yes";
			  }elseif($row['cpDBudget']==3){
				  echo "Strategic";
			  };?></td>
              <td><textarea name="cpDetail" cols="50" rows="3"  id="cpDetail" readonly style="border:1px solid #f2f2f2;background-color:#f2f2f2;color:#5d5d5d;"><?php echo $row['cpDetail'];?></textarea></td>
              <td><?php echo number_format($row['cpTot']);?></td>
			 <td><a href="mailto:<?php echo $row['cpEmail'];?>" title="<?php echo $row['cpEmail'];?>">View</a></td>
			  <td><a href="inv-pending-approve2.php?cpID=<?php echo base64_encode($row['cpID']);?>">Detail</a> 

</td>
		
            </tr>
<?php 
	 }
	  
	}
} 
 ?>
									 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      	
		
		
		  <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
					   
						<h2> Approved List - <?php echo $row_dn['dName'];?></h2>
						
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                  <th>Serial #</th>
								  <th>Department <br> Cost Center <br> Date of Initiation</th>        
								  <th>Budgeted</th>
								  <th>Detail</th>
								  <th>Cost</th>
								  <th>Email</th>
								  <th>Cost Center</th>
                                  <th>Fixed Asset No</th>
								  <th>Action</th>
                                </tr>
                                </thead>
								<?php 
								$select=mysqli_query($db,"select * from tblcp where cpINV_Flag='2'");
								while($row=mysqli_fetch_array($select)){
								$select2=mysqli_query($db,"select dName from tbldepts where dID='".$row['cpDepartment']."'");
								$row2=mysqli_fetch_array($select2);
								?>
															
                                <tbody>
                                					<tr>
              <td><?php echo $row['cpID'];?></td>
              <td><?php echo $row2['dName'];?><br><?php echo $row['cpCC'];?><br><?php echo $row['cpDate'];?></td>
             
              <td><?php if($row['cpDBudget']==1){
				  echo "No";
			  }elseif($row['cpDBudget']==2){
				  echo "Yes";
			  }elseif($row['cpDBudget']==3){
				  echo "Strategic";
			  };?></td>
              <td><textarea name="cpDetail" cols="50" rows="3"  id="cpDetail" readonly style="border:1px solid #f2f2f2;background-color:#f2f2f2;color:#5d5d5d;"><?php echo $row['cpDetail'];?></textarea></td>
              <td><?php echo number_format($row['cpTot']);?></td>
			 <td><a href="mailto:<?php echo $row['cpEmail'];?>" title="<?php echo $row['cpEmail'];?>">View</a></td>
			 <td><?php echo $row['cpINV_GLNo'];?></td>
			  <td><?php echo $row['cpINV_IO'];?></td>
			  <td><a href="detail.php?cpID=<?php echo base64_encode($row['cpID']);?>">Detail</a> 
              
</td>
		
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
      	
		
		
	<?php }else{?>
	
     <?php $dept=$_SESSION['department'];
	        $pos = strpos($dept, 'USER');
           if ($pos === false){?>

	  <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
					   
						<h2> Pending List For Approval - <?php echo $_SESSION['department'];?></h2>
						
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                  <th>Serial #</th>
								  <th>Department <br> Cost Center <br> Date of Initiation</th>        
								  <th>Budgeted</th>
								  <th>Detail</th>
								  <th>Cost</th>
								  <th>Email</th>
								  <th>Action</th>
                                </tr>
                                </thead>
								<?php 

								if($_SESSION['tID']==1){
								   
								   $select=mysqli_query($db,"select * from tblcp where cpBUM='".$_SESSION['dID']."' and cpBUM_Flag='1'");
								   
								}elseif($_SESSION['tID']==2){
								   
								   $select=mysqli_query($db,"select * from tblcp where cpBC='".$_SESSION['dID']."' and cpBC_Flag='1'");
								  
								}elseif($_SESSION['tID']==3){

								   if($_SESSION['dID']!=$_SESSION['dBC_BUM_HOD']){
									  $select=mysqli_query($db,"select * from tblcp where cpDepartment='".$_SESSION['dID']."' and cpDepartment_Flag='0'");
								   }else{
									  $select=mysqli_query($db,"select * from tblcp where cpHOD='".$_SESSION['dID']."' and cpHOD_Flag='1'");
								   }
								   
								}

								while($row=mysqli_fetch_array($select)){
								$select2=mysqli_query($db,"select dName from tbldepts where dID='".$row['cpDepartment']."'");
								$row2=mysqli_fetch_array($select2);
								?>
								
                                <tbody>
                                			<tr>
											  <td><?php echo $row['cpID'];?></td>
											  <td><?php echo $row2['dName'];?><br><?php echo $row['cpCC'];?><br><?php echo $row['cpDate'];?></td>
											 
											  <td><?php 
											  if($row['cpDBudget']==1){
												  echo "No";
											  }elseif($row['cpDBudget']==2){
												  echo "Yes";
											  }elseif($row['cpDBudget']==3){
												  echo "Strategic";
											  }
											  ?></td>
											  <td><textarea name="cpDetail" cols="50" rows="3"  id="cpDetail" readonly style="border:1px solid #f2f2f2;background-color:#f2f2f2;color:#5d5d5d;"><?php echo $row['cpDetail'];?></textarea></td>
											  <td><?php echo number_format($row['cpTot']);?></td>
											  <td><a href="mailto:<?php echo $row['cpEmail'];?>" title="<?php echo $row['cpEmail'];?>">View</a></td>
												<td><a href="pending-approve2.php?cpID=<?php echo base64_encode($row['cpID']);?>">Detail</a> </td>
										
											</tr>
											<?php } ?>
									 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
		   <?php } ?>


	  <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
					   
						<h2> CAPEX Status List</h2>
				
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                  <th>Serial #</th>
								  <th>Department <br> Cost Center <br> Date of Initiation</th>
								  <th>Budgeted</th>
								  <th>Detail</th>
								  <th>Cost</th>
								  <th>Email</th>
								  <th>Pending At</th>
								  <th>Action</th>
                                </tr>
                                </thead>
								<?php 

								if($_SESSION['tID']==1){
								   
								   $select=mysqli_query($db,"select * from tblcp where cpBUM='".$_SESSION['dID']."' and cpBUM_Flag='2' order by cpID desc");
								   
								}elseif($_SESSION['tID']==2){
								   
								   $select=mysqli_query($db,"select * from tblcp where cpBC='".$_SESSION['dID']."' and cpBC_Flag='2' order by cpID desc");
								   
								}elseif($_SESSION['tID']==3){

								   if($_SESSION['dID']!=$_SESSION['dBC_BUM_HOD']){
								   
									  $select=mysqli_query($db,"select * from tblcp where cpDepartment='".$_SESSION['dID']."' and cpDepartment_Flag='1' order by cpID desc");
								  
								   }else{
									  $select=mysqli_query($db,"select * from tblcp where cpHOD='".$_SESSION['dID']."' and cpHOD_Flag='2' order by cpID desc");
								   }
								   
								   
								   
								}

								while($row=mysqli_fetch_array($select)){
								$pending_at="";

								if($_SESSION['tID']==1){
									   if($row['cpEH_Flag']=="1"){
										 if($row['cpCid']=='7'){
											$pending_at='ERP For Comments';
										 }elseif($row['cpCid']=='6'){
											$pending_at='HRD For Comments';
										 }
									  }
									  $select_al=mysqli_query($db,"select * from tblcpapprovals where cpID='".$row['cpID']."'");
									  $num_al=mysqli_num_rows($select_al);
									  while($row_al=mysqli_fetch_array($select_al)){
											 if($row_al['cpAStatus']==1){
												$cpAID=$row_al['cpAID'];
												//break;
												 $select_pan=mysqli_query($db,"select dName from tbldepts where dID='".$cpAID."'"); 
												 $row_pan=mysqli_fetch_array($select_pan);
												 $pending_at=$row_pan['dName'].','.$pending_at;
											 }
											 $pending_at=rtrim($pending_at,',');

									  }
									  
								/*      if($pending_at==""){
										 if($row['cpEH_Flag']=="2" and $row['cpIA_FLAG']=="1"){
											$pending_at='Internal Audit';	  
										 }
									  }*/
									  
									  if($pending_at=="" and $num_al > 0){
										 if($row['cpINV_Flag']==1 or $row['cpINV_Flag']==3){
											$pending_at="Inventory"; 
										 }elseif($row['cpINV_Flag']==2 and $row['cpERP_Flag']==0 and $row['cpCid']=='ERP'){
											$pending_at="ERP"; 
										 }elseif($row['cpINV_Flag']==2 and $row['cpERP_Flag']==0 and $row['cpCid']!='ERP'){
											$pending_at='<a href="javascript:" style="color:#fff;">Completed</a>';      
										 }else{
											if($row['cpINV_Flag']=='2'){
											   $pending_at='<a href="javascript:" style="color:#fff;">Completed</a>';     
											}//else{
											   //$pending_at="Supply Chain";	
											//}
											 
										} 
									  }


								}elseif($_SESSION['tID']==2){

									  if($row['cpBUM_Flag']=="1"){
										 $pending_at='BUM';
									  }elseif($row['cpEH_Flag']=="1"){
										 if($row['cpCid']=='7'){
											$pending_at='ERP For Comments';
										 }elseif($row['cpCid']=='6'){
											$pending_at='HRD For Comments';
										 }
									  }
									  $select_al=mysqli_query($db,"select * from tblcpapprovals where cpID='".$row['cpID']."'");
									  $num_al=mysqli_num_rows($select_al);
									  while($row_al=mysqli_fetch_array($select_al)){
											 if($row_al['cpAStatus']==1){
												$cpAID=$row_al['cpAID'];
												//break;
												 $select_pan=mysqli_query($db,"select dName from tbldepts where dID='".$cpAID."'"); 
												 $row_pan=mysqli_fetch_array($select_pan);
												 $pending_at=$row_pan['dName'].','.$pending_at;
											 }
											 $pending_at=rtrim($pending_at,',');

									  }
									  
								/*      if($pending_at==""){
										 if($row['cpEH_Flag']=="2" and $row['cpIA_FLAG']=="1"){
											$pending_at='Internal Audit';	  
										 }
									  }*/
									  
									  if($pending_at=="" and $num_al > 0){
										 if($row['cpINV_Flag']==1 or $row['cpINV_Flag']==3){
											$pending_at="Inventory"; 
										 }elseif($row['cpINV_Flag']==2 and $row['cpERP_Flag']==0 and $row['cpCid']=='ERP'){
											$pending_at="ERP"; 
										 }elseif($row['cpINV_Flag']==2 and $row['cpERP_Flag']==0 and $row['cpCid']!='ERP'){
											$pending_at='<a href="javascript:" style="color:#fff;">Completed</a>';      
										 }else{
											if($row['cpINV_Flag']=='2'){
											   $pending_at='<a href="javascript:" style="color:#fff;">Completed</a>';     
											}//else{
											   //$pending_at="Supply Chain";	
											//}
											 
										} 
									  }

								}elseif($_SESSION['tID']==3){

									  if($row['cpHOD_Flag']=="1"){
										 $pending_at='HOD';
									  }elseif($row['cpBC_Flag']=="1"){
										 $pending_at='BC';
									  }elseif($row['cpBUM_Flag']=="1"){
										 $pending_at='BUM / HOD';
									  }elseif($row['cpEH_Flag']=="1"){
										 if($row['cpCid']=='7'){
											$pending_at='ERP For Comments';
										 }elseif($row['cpCid']=='6'){
											$pending_at='HRD For Comments';
										 }
									  }
									  
									  $select_al=mysqli_query($db,"select * from tblcpapprovals where cpID='".$row['cpID']."'");
									  $num_al=mysqli_num_rows($select_al);
									  while($row_al=mysqli_fetch_array($select_al)){
											 if($row_al['cpAStatus']==1){
												$cpAID=$row_al['cpAID'];
												//break;
												 $select_pan=mysqli_query($db,"select dName from tbldepts where dID='".$cpAID."'"); 
												 $row_pan=mysqli_fetch_array($select_pan);
												 $pending_at=$row_pan['dName'].','.$pending_at;
											 }
											 $pending_at=rtrim($pending_at,',');

									  }
									  
								/*      if($pending_at==""){
										 if($row['cpEH_Flag']=="2" and $row['cpIA_FLAG']=="1"){
											$pending_at='Internal Audit';	  
										 }
									  }*/
									  
									  if($pending_at=="" and $num_al > 0){
										 if($row['cpINV_Flag']==1 or $row['cpINV_Flag']==3){
											$pending_at="Inventory"; 
										 }elseif($row['cpINV_Flag']==2 and $row['cpERP_Flag']==0 and $row['cpCid']=='ERP'){
											$pending_at="ERP"; 
										 }elseif($row['cpINV_Flag']==2 and $row['cpERP_Flag']==0 and $row['cpCid']!='ERP'){
											$pending_at='<a href="javascript:" style="color:#fff;">Completed</a>';         
										 }else{
											if($row['cpINV_Flag']=='2'){
											   $pending_at='<a href="javascript:" style="color:#fff;">Completed</a>';     
											}//else{
											   //$pending_at="Supply Chain";	
											//}
											 
										} 
									  }
									   
									  
									  

								}	  
									  if($pending_at=="Completed"){
									  $pat='style="color:#fff;background-color:#006600;"';
									  }else{
									  $pat='style="color:#fff;background-color:#666666;"';
									  }
									  
									  
									  if($pending_at=='' and $row['cpReview']=='N'){
										  $pending_at='Finanace Review';
									  }
									  
								$select2=mysqli_query($db,"select dName from tbldepts where dID='".$row['cpDepartment']."'");
								$row2=mysqli_fetch_array($select2);
								?>
								
                                <tbody>
                                					<tr>
              <td><?php echo $row['cpID'];?></td>
              <td><?php echo $row2['dName'];?> <br> <?php echo $row['cpCC'];?> <br> <?php echo $row['cpDate'];?></td>
              
              <td><?php 
			  if($row['cpDBudget']==1){
				  echo "No";
			  }elseif($row['cpDBudget']==2){
				  echo "Yes";
			  }elseif($row['cpDBudget']==3){
				  echo "Strategic";
			  }
			  ?></td>
              <td> <textarea name="cpDetail" cols="50" rows="3"  id="cpDetail" readonly style="border:1px solid #f2f2f2;background-color:#f2f2f2;color:#5d5d5d;"><?php echo $row['cpDetail'];?></textarea></td>
              <td><?php echo number_format($row['cpTot']);?></td>
               <td><a href="mailto:<?php echo $row['cpEmail'];?>" title="<?php echo $row['cpEmail'];?>">View</a></td>
              <td <?php echo $pat;?>><?php echo $pending_at;?></td>
              
				<td> <?php //if($row['cpHOD_Flag']=="1"){?>  
                <!--<a href="pending-approve2.php?cpID=<?php //echo base64_encode($row['cpID']);?>">Detail</a> |
                <a href="controllar.php?cpID=<?php //echo base64_encode($row['cpID']);?>&delete=capex">Delete</a>-->
                <?php //}else{?>
				<a href="detail.php?cpID=<?php echo base64_encode($row['cpID']);?>">Detail</a>
				<?php //} ?>
                 </td>
		
            </tr>
            <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



	  <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
					   
						<h2> Rejected List - <?php echo $_SESSION['department'];?></h2>
						
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                  <th>Serial #</th>
								  <th>Department <br> Cost Center <br> Date of Initiation</th>        
								  <th>Budgeted</th>
								  <th>Detail</th>
								  <th>Cost</th>
								  <th>Email</th>
								  <th>Action</th>
                                </tr>
                                </thead>
								<?php 

								if($_SESSION['tID']==1){
								   
								   $select=mysqli_query($db,"select * from tblcp where cpBUM='".$_SESSION['dID']."' and cpBUM_Flag='3'");
								   
								}elseif($_SESSION['tID']==2){
								   
								   $select=mysqli_query($db,"select * from tblcp where cpBC='".$_SESSION['dID']."' and cpBC_Flag='3'");
								   
								}elseif($_SESSION['tID']==3){

								   if($_SESSION['dID']!=$_SESSION['dBC_BUM_HOD']){
									  $select=mysqli_query($db,"select * from tblcp where cpDepartment='".$_SESSION['dID']."' and cpDepartment_Flag='3'");
								   }else{
									  $select=mysqli_query($db,"select * from tblcp where cpHOD='".$_SESSION['dID']."' and cpHOD_Flag='3'");
								   }
								   
								}

								while($row=mysqli_fetch_array($select)){
								$select2=mysqli_query($db,"select dName from tbldepts where dID='".$row['cpDepartment']."'");
								$row2=mysqli_fetch_array($select2);
								?>
								
                                <tbody>
                                			<tr>
											  <td><?php echo $row['cpID'];?></td>
											  <td><?php echo $row2['dName'];?><br><?php echo $row['cpCC'];?><br><?php echo $row['cpDate'];?></td>
											 
											  <td><?php 
											  if($row['cpDBudget']==1){
												  echo "No";
											  }elseif($row['cpDBudget']==2){
												  echo "Yes";
											  }elseif($row['cpDBudget']==3){
												  echo "Strategic";
											  }
											  ?></td>
											  <td><textarea name="cpDetail" cols="50" rows="3"  id="cpDetail" readonly style="border:1px solid #f2f2f2;background-color:#f2f2f2;color:#5d5d5d;"><?php echo $row['cpDetail'];?></textarea></td>
											  <td><?php echo number_format($row['cpTot']);?></td>
											  <td><a href="mailto:<?php echo $row['cpEmail'];?>" title="<?php echo $row['cpEmail'];?>">View</a></td>
											   <td>
											   
												<?php 

												if($_SESSION['tID']==1){?>

												 <a href="detail.php?cpID=<?php echo base64_encode($row['cpID']);?>">Detail</a>  
																
													   
												   
												   
												 <?php   
												   
												}elseif($_SESSION['tID']==2){
												   
												  ?>
												  
												   <a href="detail.php?cpID=<?php echo base64_encode($row['cpID']);?>">Detail</a>  
																
															  
												   <?php 
												}elseif($_SESSION['tID']==3){

												 if($_SESSION['dID']!=$_SESSION['dBC_BUM_HOD']){?>
													 <a href="pending-approve2.php?cpID=<?php echo base64_encode($row['cpID']);?>">Detail</a> <!-- | 
																
																<a href="controllar.php?cpID=<?php //echo base64_encode($row['cpID']);?>&delete=capex">Delete</a>-->
												   <?php }else{?>
													<a href="detail.php?cpID=<?php echo base64_encode($row['cpID']);?>">Detail</a> 
																
															  
												<?php    
													  
												   }
												?>



												 <?php 
												   
												}?>                
															   
															  </td>
																						
											</tr>
											<?php } ?>
									 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
	 <?php 
	 if($_SESSION['department']=='FIN'){
	 ?>


	  <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
					   
						<h2> For Review Only</h2>
						
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                  <th>Serial #</th>
								  <th>Department <br> Cost Center <br> Date of Initiation</th>           
								  <th>Budgeted</th>
								  <th>Detail</th>
								  <th>Cost</th>
								  <th>Email</th>
								  <th>Action</th>
                                </tr>
                                </thead>
								<?php 
								
								$select=mysqli_query($db,"select * from tblcp where cpReview!='' order by cpReview desc");
								
								while($row=mysqli_fetch_array($select)){
								$select2=mysqli_query($db,"select dName from tbldepts where dID='".$row['cpDepartment']."'");
								$row2=mysqli_fetch_array($select2);

								if($row['cpReview']=='N'){
								   $style='style="background-color:#CC3300;color:#FFFFFF;"';
								   $style2='style="border:1px solid #CC3300;background-color:#CC3300;color:#FFFFFF;"';
								}else{
								   $style='style="background-color:#009900;color:#FFFFFF;"';
								   $style2='style="border:1px solid #009900;background-color:#009900;color:#FFFFFF;"';
								   
								}
								?>
								
                                <tbody>
                                <tr <?php echo $style;?>>
								  <td><?php echo $row['cpID'];?></td>
								  <td><?php echo $row2['dName'];?><br><?php echo $row['cpCC'];?><br><?php echo $row['cpDate'];?></td>
								  
								  <td><?php if($row['cpDBudget']==1){
									  echo "No";
								  }elseif($row['cpDBudget']==2){
									  echo "Yes";
								  }elseif($row['cpDBudget']==3){
									  echo "Strategic";
								  };?></td>
								  <td><textarea name="cpDetail" cols="50" rows="3"  id="cpDetail" readonly <?php echo $style2;?>><?php echo $row['cpDetail'];?></textarea></td>
								  <td><?php echo number_format($row['cpTot']);?></td>
								  <td><a href="mailto:<?php echo $row['cpEmail'];?>" title="<?php echo $row['cpEmail'];?>" style="color:#fff;">View</a></td>
								  <td>
								  <?php if($row['cpReview']=='Y'){?>
								  <a href="pending-approve.php?cpID=<?php echo base64_encode($row['cpID']);?>&c=true" style="color:#FFFFFF;">Detail</a> 
								  <?php }else{ ?>
								   <a href="detail.php?cpID=<?php echo base64_encode($row['cpID']);?>&c=true" style="color:#FFFFFF;">Detail</a> 
								  <?php } ?>
								  
								  </td>
							
								</tr>
											<?php } ?>
									 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	 
	 
	 <?php } ?>
	 <?php } ?> 
	</div>

	
	
	
	
	</section>

<div class="color-bg"></div>
<!-- Jquery Core Js --> 
<script src="assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 
<script src="assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 

<script src="assets/bundles/chartscripts.bundle.js"></script> <!-- Chart Plugins Js -->
<script src="assets/bundles/sparklinescripts.bundle.js"></script> <!-- Chart Plugins Js -->

<script src="assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->
<script src="assets/js/pages/index.js"></script>
<script src="assets/js/pages/charts/sparkline.min.js"></script>
</body>

</html>