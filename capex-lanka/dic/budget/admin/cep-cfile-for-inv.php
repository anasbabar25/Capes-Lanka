<?php include("../../include/conn.php"); 

?>

<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 4.7.5
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    
<!-- Mirrored from keenthemes.com/preview/metronic/theme/admin_4/table_datatables_colreorder.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 May 2017 14:13:33 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
        <meta charset="utf-8" />
        <title><?php echo $title;?> CEP Completed List</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #4 for colreorder extension demos" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        
        <link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!--[if IE 7]><link type="text/css" rel="stylesheet" href="css/font-awesome-ie7.min.css"><![endif]-->
		<link href="../assets/css/font-entypo.css" rel="stylesheet" type="text/css">
		<!-- Fonts CSS -->
		<link href="../assets/css/fonts.css"  rel="stylesheet" type="text/css">
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="../assets/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/layouts/layout4/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="../assets/layouts/layout4/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 
	
		
		</head>
    <!-- END HEAD -->

    <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">
        <!-- BEGIN HEADER -->
        <?php //include('include/header.php');?>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <?php //include('include/sidebar.php');?>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEAD-->
                   
                    <!-- END PAGE HEAD-->
                    <!-- BEGIN PAGE BREADCRUMB -->
                   
                    <!-- END PAGE BREADCRUMB -->
                    <!-- BEGIN PAGE BASE CONTENT -->
                  
                    <div class="row">
                        <div class="col-md-12">
						      
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered" >
							   
								
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover" id="sample_1" >
                                        <thead>
                                            <tr>
											 
             <th width="20"><a href="javascript:">Serial #</a></th>
              <th width="30"><a href="javascript:">Department</a></th>
              <th width="20"><a href="javascript:">Cost Center</a></th>
              <th width="30"><a href="javascript:">Date of Initiation</a></th> 
              <th width="30"><a href="javascript:">Category</a></th> 			  
              <th width="20"><a href="javascript:">Budget Asset Desc</a></th>
			  <th width="20"><a href="javascript:">Budgeted</a></th>
              <th width="250"><a href="javascript:">Detail</a></th>
			  <th width="250"><a href="javascript:">Desired Asset Name </a></th>
              <th width="20"><a href="javascript:">Cost</a></th>
              <th width="20"><a href="javascript:">GL</a></th>
              <th width="20"><a href="javascript:">IO</a></th>
			  <th width="250"><a href="javascript:">Email</a></th>
              <th width="50"><a href="javascript:">Action</a></th>
											
											
											
										   </tr>
                                        </thead>
                                        <tbody>
                                         <?php 
$select=mysqli_query($db,"select * from tblcp where cpINV_Flag='2'");
while($row=mysqli_fetch_array($select)){
$select2=mysqli_query($db,"select dName from tbldepts where dID='".$row['cpDepartment']."'");
$row2=mysqli_fetch_array($select2);

$selectc=mysqli_query($db,"select cName from tblcategory where cID='".$row['cpCid']."'");
$rowc=mysqli_fetch_array($selectc);	

if($row['cpBudgetRef']==0){
   $bud=$row['cpSBudgetRef'];	
}else{
$select3=mysqli_query($db,"select bDesc from tblbudget where bID='".$row['cpBudgetRef']."'");
$row3=mysqli_fetch_array($select3);	
$bud=$row3['bDesc'];
}

?>
			<tr>
              <td width="20" align="center" ><?php echo $row['cpID'];?></td>
              <td width="30" align="left" ><?php echo $row2['dName'];?></td>
              <td width="20" align="left" ><?php echo $row['cpCC'];?></td>
              <td width="30" align="left" ><?php echo $row['cpDate'];?></td>
			  <td width="30" align="left" ><?php echo $rowc['cName'];?></td>
			  <td width="30" align="left" ><?php echo $bud;?></td>
			  
              <td width="20" align="left" ><?php if($row['cpDBudget']==1){
				  echo "No";
			  }elseif($row['cpDBudget']==2){
				  echo "Yes";
			  }elseif($row['cpDBudget']==3){
				  echo "Strategic";
			  };?></td>
              <td width="250" align="left" ><?php echo $row['cpDetail'];?></td>
			  <td width="250" align="left" ><?php echo $row['cpDAssetName'];?></td>
			  
              <td width="20" align="left" ><?php echo number_format($row['cpTot']);?></td>
			  <td width="20" align="left" ><?php echo $row['cpINV_GLNo'];?></td>
			  <td width="20" align="left" ><?php echo $row['cpINV_IO'];?></td>
			  <td width="250" align="left" ><?php echo $row['cpEmail'];?></td>
				<td width="50" align="left" ><a href="../../detail.php?cpID=<?php echo base64_encode($row['cpID']);?>">Detail</a> </td>
		
            </tr>
<?php 
}
 ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                           
                        </div>
                    </div>
                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
           
            
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php include("include/footer.php"); ?>
        <!-- END FOOTER -->

        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="../assets/pages/scripts/table-datatables-colreorder.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="../assets/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/layout4/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
        </script>


</body>



<!-- Mirrored from keenthemes.com/preview/metronic/theme/admin_4/table_datatables_colreorder.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 May 2017 14:13:35 GMT -->
</html>