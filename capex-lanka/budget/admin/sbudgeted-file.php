<?php include("../../include/conn.php"); 
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    

<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
        <meta charset="utf-8" />
        <title><?php echo $title;?> Strategic Budget File</title>
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
        <link rel="icon" href="../../logo.png" type="image/x-icon">
	
		
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
							   <h3><b>Strategic Budget - 2020</b></h3>
								
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover" id="sample_1" >
                                        <thead>
                                            <tr>
											 <th style="width:5%;">Sr #</th>
											  <th style="width:10%;">Dept</th>
											  <th style="width:20%;">Desc</th>
											  <th style="width:10%;">Budget</th>
											  <th style="width:10%;">Under Progress</th>
											  <th style="width:10%;">Utilized</th>
											  <th style="width:15%;">Remaining (Unutilized)</th>
											  <th style="width:10%;">Internal Order No</th>
											  <th style="width:10%;">CP Form No</th>
											  <th style="width:10%;">Adjusted From </th>
										   </tr>
                                        </thead>
                                        <tbody>
                                         <?php 
$select=mysqli_query($db,"select * from tblsbudget where sbMDept='".$_SESSION['bMDept']."' order by sbID");
while($row=mysqli_fetch_array($select)){
$utilized='';
$up='';
$remaining='';
$style='';
$cpINV_IO='';
$cpfno='';
$cpID='';
$select_cp=mysqli_query($db,"select * from tblcp where cpSBudgetRef='".$row['sbID']."'");
while($row_cp=mysqli_fetch_array($select_cp)){
	if($row_cp['cpINV_IO']!=0){
	   //$utilized = $utilized + $row_cp['cpTot'];	 
	   $cpINV_IO=$row_cp['cpINV_IO'].','.$cpINV_IO;
	}else{
		//$up = $up + $row_cp['cpTot'];
		
	}
}


/* $select_b=mysqli_query($db,"select * from tblcpadjustment where refbID='".$row['sbID']."'");
while($row_b=mysqli_fetch_array($select_b)){
	
	   
	   $cpID=base64_encode($row_b['cpID']);
	   
	   $select_cep=mysqli_query($db,"select * from tblcp where cpID='".$row_b['cpID']."'");
       $row_cep=mysqli_fetch_array($select_cep);
	   if($row_cep['cpINV_IO']!=0){
		   
		 $utilized = $utilized + $row_b['bAmount'];	  
	   }else{
		 $up = $up + $row_b['bAmount'];  
	   }
	   
	   
	   $cpfno='<a href="../../detail.php?cpID='.$cpID.'" target="_blank">'.$row_b['cpID'].'</a>,'.$cpfno;	 
	   
} */

$utilized = $row['sbConsumed'];	

$remaining = $row['sbTotal'] - $utilized;

if($remaining<0){
	$style='style="color:red;"';
	
}else{
	$style='';
}



/*  $adjusted='';
 $count_b='';
 $select_adj=mysqli_query($db,"select * from tblcpadjustment 
  where bID='".$row['sbID']."'");
  $num_adj=mysqli_num_rows($select_adj);
  if($num_adj>0){
 
  while($row_adj=mysqli_fetch_array($select_adj)){
	  $count_b=$count_b+1;
	  $select_b=mysqli_query($db,"select sbDesc from tblsbudget where 
	  sbID='".$row_adj['refbID']."'");
	  $row_b=mysqli_fetch_array($select_b);
	  $adjusted.='  <p> ('.$count_b.') - '.$row_adj['refbID'].'-'.$row_b['sbDesc'].' - <b> Adjusted Amount </b> = '.number_format($row_adj['bAmount']).'</p><br>'; 
	  
  }
  }

  
  $select_adj=mysqli_query($db,"select * from tblcpbadjust 
  where bID='".$row['sbID']."'");
  $num_adj=mysqli_num_rows($select_adj);
  if($num_adj>0){
 
  while($row_adj=mysqli_fetch_array($select_adj)){
	  $count_b=$count_b+1;
	  $select_b=mysqli_query($db,"select sbDesc from tblsbudget where 
	  sbID='".$row_adj['cpBudgetRef']."'");
	  $row_b=mysqli_fetch_array($select_b);
	  $adjusted.='  <p> ('.$count_b.') - '.$row_adj['cpBudgetRef'].'-'.$row_b['sbDesc'].' - <b> Adjusted Amount </b> = '.number_format($row_adj['bADAmount']).'</p><br>'; 
	  
  }
  } */
  

?>
										<tr>
              <td  align="center" ><?php echo $row['sbID'];?></td>
			  <td  align="left" ><?php echo $row['sbMDept'];?></td>
              <td  align="left" ><?php echo $row['sbDesc'];?></td>
              <td  align="left" ><?php echo number_format($row['sbTotal']);?></td>
              <td  align="left" ><?php echo number_format($up);?></td>
			  <td  align="left" ><?php echo number_format($utilized);?> </td>
              <td  align="left" <?php echo $style;?>><?php echo number_format($remaining);?> </td>
			  <td  align="left" ><?php echo rtrim($cpINV_IO, ',');?> </td>
			  <td  align="left" ><?php echo rtrim($cpfno, ',');?> </td>
                <td  align="left" ><?php echo $adjusted;?> </td>
				 
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




</html>