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
<title><?php echo $title;?> -  Pending List</title>
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

<!-- #Float icon -->
<ul id="f-menu" class="mfbc-br mfb-zoomin" data-mfb-toggle="hover">
    <li class="mfbc_wrap">
        <a href="javascript:void(0);" class="mfbcb-main g-bg-cyan" onclick="window.location='new-capex.php';" title="New Capex">
            <i class="mfbcm-icon-resting zmdi zmdi-plus"></i>
            <i class="mfbcm-icon-active zmdi zmdi-close"></i>
        </a>
       
    </li>
</ul>

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