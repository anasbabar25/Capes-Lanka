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
        <title><?php echo $title;?> Stop Budget File</title>
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
	
		<script>
		function budget_stop(uID){
	
			if(document.getElementById("dFlagstop"+uID).checked == true){
				 var dFlagstop = 1;
				 $.post("controller.php",{uID:uID,dFlagstop:dFlagstop},function(data){
		               

	            });
			}else if(document.getElementById("dFlagstop"+uID).checked == false){
				  var dFlagstop = 0;
				 $.post("controller.php",{uID:uID,dFlagstop:dFlagstop},function(data){
		               

	            });
			}	
			
		}
		</script>
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
                                    <table class="table table-striped table-bordered table-hover"  >
                                        <thead>
                                            <tr>
			  <th style="width:5%;">Sr #</th>
              <th style="width:5%;">Dept</th>
              <th style="width:10%;">Budget Total</th>
              <th style="width:10%;">Budget Consumed</th>
			  <th style="width:10%;">Revised Budget</th>
			  <th style="width:1%;">%</th>
              <th style="width:10%;">Stop</th>						
											
											
										   </tr>
                                        </thead>
                                        <tbody>
                                         <?php 
$select=mysqli_query($db,"select bMDept,sum(bTotal) as cpTot,sum(bConsumed) as bConsumed from tblbudget group by bMDept");
while($row=mysqli_fetch_array($select)){
	
//$select3=mysqli_query($db,"select dName from tbldepts where dID='".$row['cpDepartment']."'");
//$row3=mysqli_fetch_array($select3);	

//$cpDepartment=explode('-',mysqli_escape_string($row3['dName']));
$cpDepartment=$row['bMDept'];

$select4=mysqli_query($db,"select * from tblnewallocatedbudget where dept='".$cpDepartment."'");
$row4=mysqli_fetch_array($select4);	

//$select2=mysqli_query($db,"select bMDept,sum(bTotal) as bTotal from tblbudget where bMDept='".mysqli_escape_string($cpDepartment[0])."'");
//$row2=mysqli_fetch_array($select2);
$count=$count+1;



$per=( $row['bConsumed'] / $row4['btotal'] ) * 100;

$selectF=mysqli_query($db,"select dFlagstop from tbldepts where dName='".$row['bMDept']."'");
$rowF=mysqli_fetch_array($selectF);
if($rowF['dFlagstop']==1){
   $checked='checked="checked"';	
	
}else{
   
   $checked='';
	
}

?>
			<tr>
			  <td  align="center" ><?php echo $count;?></td>
              <td  align="left" ><?php echo $cpDepartment;?></td>
              <td  align="left" ><?php echo number_format($row['cpTot'],2);?></td>
              <td  align="left" ><?php echo  number_format($row['bConsumed'],2);?></td>
			  <td  align="left" ><?php echo number_format($row4['btotal'],2);?></td>
             <td  align="left" ><?php echo number_format($per,2);?></td>
			  <td  align="left" ><input type='checkbox' id='dFlagstop<?php echo $row['bMDept'];?>' name='dFlagstop<?php echo $row['bMDept'];?>' onclick='budget_stop("<?php echo $row['bMDept'];?>");' <?php echo $checked;?>></td>
            </tr>
            <?php } ?>
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