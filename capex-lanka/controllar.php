<?php 
include('include/conn.php');

//ini_set("display_errors",1);
//error_reporting(E_ALL);


if($_POST['dpass']){
	
$select=mysqli_query($db,"select * from tbldepts where dName='".$_POST['department']."' 
and dPassword='".mysqli_escape_string($db,$_POST['dpass'])."'");
$num=mysqli_num_rows($select);
	
	if($num==1){
	   $row=mysqli_fetch_array($select);
	   if($row['dHHH']==1){
	   $_SESSION['department']='HHH';
	   }elseif($row['dHHH']==2){
	   $_SESSION['department']='INV';
	   }else{
	   $_SESSION['department']=$_POST['department'];
	   }
	   $_SESSION['dID']=$row['dID'];
	   $_SESSION['tID']=$row['tID'];
	   $_SESSION['dBC_BUM_HOD']=$row['dBC_BUM_HOD'];
	   $bMDept=explode('-',$_POST['department']);
	   $_SESSION['bMDept']=$bMDept[0];
	   header("location: index.php"); 
	   
	}else{
	   $tID=$_POST['tID'];
	   $department=$_POST['department'];
	   header("location: login.php?department=$department&p=in&t=$tID");  
	}
}

if($_POST['dppass']){

$select=mysqli_query($db,"select * from tbldepts where dName='".$_POST['department']."' and dPassword='".$_POST['dppass']."'");
$num=mysqli_num_rows($select);
	
	if($num==1){
	   $row=mysqli_fetch_array($select);
	   $_SESSION['department']=$_POST['department'];
	   $_SESSION['dID']=$row['dID'];
	   $_SESSION['tID']=$row['tID'];
	   $_SESSION['dBC_BUM_HOD']=$row['dBC_BUM_HOD'];
	   $bMDept=explode('-',$_POST['department']);
	   $_SESSION['bMDept']=$bMDept[0];
	   $dPChanged=$row['dPChanged'];
	   $dept=$_POST['department'];
	    if ((strpos($dept, 'USER') !== false)) {
			header("location: pending-list.php"); 
		}else{
			if($dPChanged==0){
			header("location: password-change.php"); 	
			}else{
			header("location: pending-list.php"); 	
			}
		}
 
	}else{
	   $tID=$_POST['tID'];
	   $department=$_POST['department'];
	   header("location: pending.php?department=$department&p=in&t=$tID");  
	}
}


if($_POST['nrdppass']){

   $update=mysqli_query($db,"update tbldepts set dPassword='".$_POST['nrdppass']."',dPChanged='1' where dID='".$_SESSION['dID']."'"); 
   header("location: pending-list.php");  	
}	


if($_POST['nrdppass2']){

   $update=mysqli_query($db,"update tbldepts set dPassword='".$_POST['nrdppass2']."',dPChanged='1' where dID='".$_SESSION['dID']."'"); 
   header("location: pending-list.php");  	
}	


if($_POST['iapass']){

	if($_POST['iapass']=='ia@123'){
	   $row=mysqli_fetch_array($select);
	   $_SESSION['department']='IA';
	   $_SESSION['dID']='8';
	   $_SESSION['tID']='3';
	   $_SESSION['dBC_BUM_HOD']='8';
	  
	   header("location: ia-pending-list.php"); 
	}else{
	   header("location: ia-pending.php");  
	}
}


if($_POST['invpass']){

	if($_POST['invpass']=='inv@123'){
	   $row=mysqli_fetch_array($select);
	   $_SESSION['department']='INV';
	   $_SESSION['dID']='15';
	   $_SESSION['tID']='3';
	   $_SESSION['dBC_BUM_HOD']='15';
	  
	   header("location: inv-pending-list.php"); 
	}else{
	   header("location: inv-pending.php");  
	}
}

if($_POST['erppass']){

	if($_POST['erppass']=='erp@123'){
	   $row=mysqli_fetch_array($select);
	   $_SESSION['department']='ERP';
	   $_SESSION['dID']='6';
	   $_SESSION['tID']='3';
	   $_SESSION['dBC_BUM_HOD']='6';
	  
	   header("location: pending-for-pr-list.php"); 
	}else{
	   header("location: pending-for-pr.php?department=$department&p=in");  
	}

/*$select=mysqli_query($db,"select * from tbldepts where dName='".$_POST['department']."' 
and dPassword='".mysqli_real_escape_string($db,$_POST['erppass'])."'");
$num=mysqli_num_rows(($select));
	
	if($num==1){
	   $row=mysqli_fetch_array($select);
	   $_SESSION['department']=$_POST['department'];
	   $_SESSION['dID']=$row['dID'];
	   $_SESSION['tID']=$row['tID'];
	   $_SESSION['dBC_BUM_HOD']=$row['dBC_BUM_HOD'];
	  
	   header("location: pending-for-pr-list.php"); 
	}else{
	   $tID=$_POST['tID'];
	   $department=$_POST['department'];
	   header("location: pending-for-pr.php?department=$department&p=in&t=$tID");  
	}*/
	
	
}

if($_POST['smpass']){

	if($_POST['smpass']=='sm@123'){
	   $row=mysqli_fetch_array($select);
	   $_SESSION['department']='SM';
	   //$_SESSION['dID']='6';
	   $_SESSION['tID']='3';
	   //$_SESSION['dBC_BUM_HOD']='6';
	  
	   header("location: budget/admin/cep-cfile-for-inv.php"); 
	}else{
	   header("location: sm-pending.php");  
	}
}


if($_POST['hhhpass']){

$select=mysqli_query($db,"select * from tbldepts where dName='".$_POST['hhh']."' and dPassword='".$_POST['hhhpass']."'");
$num=mysqli_num_rows($select);
	
	if($num==1){
	   $row=mysqli_fetch_array($select);
	   $_SESSION['department']='HHH';
	   $_SESSION['dID']=$row['dID'];
	   $_SESSION['tID']=$row['tID'];
	   $_SESSION['dBC_BUM_HOD']=$row['dBC_BUM_HOD'];
	   $dPChanged=$row['dPChanged'];
            if($dPChanged==0){
			header("location: hhh-password-change.php"); 	
			}else{
			header("location: hhh-pending-list.php"); 	
			}

	}else{
	   $department=$_POST['hhh'];
	   if($department=='MD'){
	   header("location: hhh-pending2.php?department=$department&p=in");  	   
	   }else{
	   header("location: hhh-pending.php?department=$department&p=in");  
	   }
	}
}


if($_POST['nhhhpass']){

   $update=mysqli_query($db,"update tbldepts set dPassword='".$_POST['nhhhpass']."',dPChanged='1' where dID='".$_SESSION['dID']."'"); 
   header("location: hhh-pending-list.php"); 
}	


if($_POST['coapass']){

$select=mysqli_query($db,"select * from tbldepts where dName='".$_POST['coa']."' and dPassword='".$_POST['coapass']."'");
$num=mysqli_num_rows($select);
	
	if($num==1){
	   $row=mysqli_fetch_array($select);
	   $_SESSION['department']='COA';
	   $_SESSION['dID']=$row['dID'];
	   $_SESSION['tID']=$row['tID'];
	   $_SESSION['dBC_BUM_HOD']=$row['dBC_BUM_HOD'];
	  
	   header("location: coa-pending-list.php"); 
	}else{
	   $department=$_POST['coa'];
	   header("location: coa-pending.php?department=$department&p=in");  
	}
}

if($_POST['cmpass']){

$select=mysqli_query($db,"select * from tbldepts where dName='".$_POST['cm']."' and dPassword='".$_POST['cmpass']."'");
$num=mysqli_num_rows($select);
	
	if($num==1){
	   $row=mysqli_fetch_array($select);
	   $_SESSION['department']='CM';
	   $_SESSION['dID']=$row['dID'];
	   $_SESSION['tID']=$row['tID'];
	   $_SESSION['dBC_BUM_HOD']=$row['dBC_BUM_HOD'];
	  
	   header("location: cm-pending-list.php"); 
	}else{
	   $department=$_POST['cm'];
	   header("location: cm-pending.php?department=$department&p=in");  
	}
}

if($_POST['action']=='return-back-comments'){
	if($_SESSION['tID']==1){
	   $update=mysqli_query($db,"update tblcp set cpBC_Flag='1',cpBUM_Flag='0' where cpID='".$_POST['cpID']."'");
       $select=mysqli_query($db,"select cpBC from tblcp where cpID='".$_POST['cpID']."'");
	   $row=mysqli_fetch_array($select);
	   
	   $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
                            values('".$_POST['cpID']."', '".$_SESSION['dID']."', '".$row['cpBC']."','".mysqli_escape_string($db,$_POST['comments'])."', 
					               '".date('Y-m-d H:i')."')");
	   
	}elseif($_SESSION['tID']==2){
	   $update=mysqli_query($db,"update tblcp set cpDepartment_Flag='0',cpBC_Flag='0' where cpID='".$_POST['cpID']."'");
	   $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
                            values('".$_POST['cpID']."', '".$_POST['FDept']."', '".$_POST['TDept']."','".mysqli_escape_string($db,$_POST['comments'])."', 
					               '".date('Y-m-d H:i')."')");
	}elseif($_SESSION['tID']==3){
	   $update=mysqli_query($db,"update tblcp set cpDepartment_Flag='0',cpHOD_Flag='0' where cpID='".$_POST['cpID']."'");
	   $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
                            values('".$_POST['cpID']."', '".$_POST['FDept']."', '".$_POST['TDept']."','".mysqli_escape_string($db,$_POST['comments'])."', 
					               '".date('Y-m-d H:i')."')");
	}


}

if($_POST['action']=='not_recommend'){
	
$update=mysqli_query($db,"update tblcp set cpDepartment_Flag='3',cpHOD_Flag='0',cpEH_Flag='0' where cpID='".$_POST['cpID']."'");
$insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
					 values('".$_POST['cpID']."', '".$_POST['FDept']."', '".$_POST['TDept']."',
					 '".mysqli_escape_string($db,$_POST['comments'])."', '".date('Y-m-d H:i')."')");

  			//check if this cp is adjusted from any other budget
			$select=mysqli_query($db,"select * from tblcpadjustment where cpID='".$_POST['cpID']."'");
			$num=mysqli_num_rows($select);
			if($num>0){
			   while($row=mysqli_fetch_array($select)){
					 $refbID = $row['refbID'];
					 $select_b=mysqli_query($db,"select * from tblbudget where bID='".$refbID."'");
					 $row_b=mysqli_fetch_array($select_b);
					 $bConsumed=$row_b['bConsumed'] - $row['bAmount']; 
					 $bRemaining=$row_b['bTotal'] - $bConsumed;
					 $update=mysqli_query($db,"update tblbudget set bConsumed='".$bConsumed."',bRemaining='".$bRemaining."'
					 where bID='".$refbID."'");
					 
				     $bConsumed="";$bRemaining="";$refbID="";
			   }	
			}  
			$delete=mysqli_query($db,"delete from tblcpadjustment where cpID='".$_POST['cpID']."'"); 
            $delete=mysqli_query($db,'delete from tblcpapprovals where cpID="'.$_POST['cpID'].'"');
   
  $select=mysqli_query($db,"select dEmail from tbldepts where dID='".$_POST['TDept']."'");
  $row=mysqli_query($db,$select);
  $to      = $row['dEmail'];
  $email   = 'cep@packages.com.pk';
  $subject = 'CEP Form Rejected' ;
  $message = 'Your capex form is rejected.Please login into Capex portal to see further.CP No is '.$_POST['cpID'];
   
   mail($to, $subject , $message, "From: $email" );



}



if($_POST['action']=='rejected'){
if($_SESSION['tID']==1){
$update=mysqli_query($db,"update tblcp set cpDepartment_Flag='3',cpBC_Flag='3',cpBUM_Flag='3' where cpID='".$_POST['cpID']."'");
$select=mysqli_query($db,"select cpBC from tblcp where cpID='".$_POST['cpID']."'");
$row=mysqli_fetch_array($select);

$insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
values('".$_POST['cpID']."', '".$_SESSION['dID']."', '".$_POST['TDept']."','".mysqli_escape_string($db,$_POST['comments'])."', 
'".date('Y-m-d H:i')."')");

}elseif($_SESSION['tID']==2){
$update=mysqli_query($db,"update tblcp set cpDepartment_Flag='3',cpBC_Flag='3' where cpID='".$_POST['cpID']."'");
$insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
values('".$_POST['cpID']."', '".$_POST['FDept']."', '".$_POST['TDept']."','".mysqli_escape_string($db,$_POST['comments'])."', 
'".date('Y-m-d H:i')."')");
}elseif($_SESSION['tID']==3){
$update=mysqli_query($db,"update tblcp set cpDepartment_Flag='3',cpHOD_Flag='3' where cpID='".$_POST['cpID']."'");
$insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
values('".$_POST['cpID']."', '".$_POST['FDept']."', '".$_POST['TDept']."','".mysqli_escape_string($db,$_POST['comments'])."', 
'".date('Y-m-d H:i')."')");
}

			$select_cp=mysqli_query($db,"select * from tblcp where cpID='".$_POST['cpID']."'");
			$row_cp=mysqli_fetch_array($select_cp);
			$cpTot=$row_cp['cpTot'];

			//check if this cp is adjusted from any other budget
			$select=mysqli_query($db,"select * from tblcpadjustment where cpID='".$_POST['cpID']."'");
			$num=mysqli_num_rows($select);
			if($num>0){
			   while($row=mysqli_fetch_array($select)){
					 $refbID = $row['refbID'];
					 $select_b=mysqli_query($db,"select * from tblbudget where bID='".$refbID."'");
					 $row_b=mysqli_fetch_array($select_b);
					 $bConsumed=$row_b['bConsumed'] - $row['bAmount']; 
					 $bRemaining=$row_b['bTotal'] - $bConsumed;
					 $update=mysqli_query($db,"update tblbudget set bConsumed='".$bConsumed."',bRemaining='".$bRemaining."'
					 where bID='".$refbID."'");
					 
				     $bConsumed="";$bRemaining="";$refbID="";
			   }	
			$delete=mysqli_query($db,"delete from tblcpadjustment where cpID='".$_POST['cpID']."'");   
			//update cp budget amount in budget
			//$select_br=mysqli_query($db,"select * from tblbudget where bID='".$cpBudgetRef."'");
			//$row_br=mysqli_fetch_array($select_br);
			//$bConsumed_br=$row_br['bConsumed'] - $cpTot; 
			//$update=mysqli_query($db,update tblbudget set bConsumed='".$bConsumed_br."' where bID='".$cpBudgetRef."'");	
			}



}

if($_GET['action']=="insert"){
	
	$cpCostL = str_replace( ',', '', $_POST['cpCostL'] );	
	$cpCostI = str_replace( ',', '', $_POST['cpCostI'] );	
	$cpCDL = str_replace( ',', '', $_POST['cpCDL'] );	
	$cpCDI = str_replace( ',', '', $_POST['cpCDI'] );	
	$cpOthersL = str_replace( ',', '', $_POST['cpOthersL'] );	
	$cpOthersI = str_replace( ',', '', $_POST['cpOthersI'] );	
	$cpGSTL = str_replace( ',', '', $_POST['cpGSTL'] );	
	$cpGSTI = str_replace( ',', '', $_POST['cpGSTI'] );	
	
	$cpFCA = str_replace( ',', '', $_POST['cpFCA'] );	
	$cpFCR = str_replace( ',', '', $_POST['cpFCR'] );	
	
	
	


if($_POST['cpCostL']==""){
   $cpCostL="0";	
}
if($_POST['cpCostI']==""){
   $cpCostI="0";	
}	
if($_POST['cpCDL']==""){
   $cpCDL="0";	
}	
if($_POST['cpCDI']==""){
   $cpCDI="0";	
}	
if($_POST['cpOthersL']==""){
   $cpOthersL="0";	
}	
if($_POST['cpOthersI']==""){
   $cpOthersI="0";	
}	
if($_POST['cpGSTL']==""){
   $cpGSTL="0";	
}	
if($_POST['cpGSTI']==""){
   $cpGSTI="0";	
}	

if($_POST['cpFCA']==""){
   $cpFCA="0";	
}

if($_POST['cpFCR']==""){
   $cpFCR="0";	
}	
echo $_POST['cpDBudget'];

if($_POST['cpDBudget']==4){
   $cpSBudgetRef=$_POST['cpSBudgetRefNo'];	
}elseif($_POST['cpDBudget']==3){
   $cpSBudgetRef=$_POST['cpSBudgetRef'];	
}


if($_POST['cpBudgetRef']==''){
	
	$cpBudgetRef=0;
}else{
	$cpBudgetRef=$_POST['cpBudgetRef'];
}
$cpTot=( $cpCostL * 1 ) + ( $cpCostI  * 1 ) + ( $cpCDL * 1 ) + ( $cpCDI * 1 ) + ( $cpOthersL * 1 ) + 
         ( $cpOthersI * 1 ) + ( $cpGSTL * 1 ) + ( $cpGSTI * 1 );
if(isset($_SESSION['dBC_BUM_HOD'])){

//insert into cp table 
$insert=mysqli_query($db,"insert into tblcp 
	(cpDepartment, cpCC, 
	cpDate, 
	cpDBudget, 
	cpBudgetRef,
	cpSBudgetRef,
	cpEDate, 
	cpWERI, 
	cpCid, 
	cpDetail, 
	cpDAssetName, 
	cpEmail,
	cpExtNo,
	cpOIHA, 
	cpCostL, 
	cpCostI, 
	cpCur, 
	cpFCA, 
	cpFCR, 
	cpCDL, 
	cpCDI, 
	cpOthersL, 
	cpOthersI, 
	cpGSTL, 
	cpGSTI,
	cpTot
	)
	values
	('".$_POST['cpDepartment']."', '".$_POST['cpCC']."', '".date('Y-m-d')."', '".$_POST['cpDBudget']."', '".$cpBudgetRef."', 
	'".mysqli_escape_string($db,$cpSBudgetRef)."', '".$_POST['cpEDate']."',
	'".mysqli_escape_string($db,$_POST['cpWERI'])."',
	'".$_POST['cpCid']."', 
	'".mysqli_escape_string($db,$_POST['cpDetail'])."', 
	'".mysqli_escape_string($db,$_POST['cpDAssetName'])."',
	'".mysqli_escape_string($db,$_POST['cpEmail'])."',
	'".$_POST['cpExtNo']."',
	'".$_POST['cpOIHA']."',
	'".$cpCostL."', 
	'".$cpCostI."',  
	'".$_POST['cpCur']."',
	'".$cpFCA."',  
	'".$cpFCR."',   
	'".$cpCDL."',  
	'".$cpCDI."',  
	'".$cpOthersL."',  
	'".$cpOthersI."',  
	'".$cpGSTL."',  
	'".$cpGSTI."', 
	'".$cpTot."')");
	

    $select=mysqli_query($db,"select cpID from tblcp order by cpID desc limit 0,1");
	$row=mysqli_fetch_array($select);
    $cpID=$row['cpID'];

$select_ht=mysqli_query($db,"select * from tbldepts where dID='".$_SESSION['dBC_BUM_HOD']."'");
$row_ht=mysqli_fetch_array($select_ht);

//check user type and update incharge flag according to the type.
if($row_ht['tID']==1){
   
   $update=mysqli_query($db,"update tblcp set cpBUM='".$_SESSION['dBC_BUM_HOD']."',cpBUM_Flag='1' where cpID='".$cpID."'");
   
}elseif($row_ht['tID']==2){
   
   $update=mysqli_query($db,"update tblcp set cpBC='".$_SESSION['dBC_BUM_HOD']."',cpBC_Flag='1' where cpID='".$cpID."'");
   
}elseif($row_ht['tID']==3){

   if($_SESSION['dID']!=$_SESSION['dBC_BUM_HOD']){
      $update=mysqli_query($db,"update tblcp set cpHOD='".$_SESSION['dBC_BUM_HOD']."',cpHOD_Flag='1' where cpID='".$cpID."'");
   }else{
      $update=mysqli_query($db,"update tblcp set cpHOD='".$_SESSION['dBC_BUM_HOD']."',cpHOD_Flag='2',cpHOD_Date='".date('Y-m-d')."',cpEH_Flag='1' where cpID='".$cpID."'");
   }
   
}

//upload files
if($_FILES["files1"]["name"]!=""){	 
$temp = explode(".", $_FILES["files1"]["name"]);
$cpQuotation1 = $temp[0].round(microtime(true)) . rand() . '.' . end($temp);
move_uploaded_file($_FILES["files1"]["tmp_name"], "img/quotations/" . $cpQuotation1);
$insert_q=mysqli_query($db,"insert into tblcpquotations(cpID, cpQuotation) values('".$cpID."', '".$cpQuotation1."')");
} 

if($_FILES["files2"]["name"]!=""){	 
$temp = explode(".", $_FILES["files2"]["name"]);
$cpQuotation2 = $temp[0].round(microtime(true)) . rand() . '.' . end($temp);
move_uploaded_file($_FILES["files2"]["tmp_name"], "img/quotations/" . $cpQuotation2);
$insert_q=mysqli_query($db,"insert into tblcpquotations(cpID, cpQuotation) values('".$cpID."', '".$cpQuotation2."')");
} 

if($_FILES["files3"]["name"]!=""){	 
$temp = explode(".", $_FILES["files3"]["name"]);
$cpQuotation3 = $temp[0].round(microtime(true)) . rand() . '.' . end($temp);
move_uploaded_file($_FILES["files3"]["tmp_name"], "img/quotations/" . $cpQuotation3);
$insert_q=mysqli_query($db,"insert into tblcpquotations(cpID, cpQuotation) values('".$cpID."', '".$cpQuotation3."')");
} 

   $dept=$_SESSION['department'];
   $pos = strpos($dept, 'USER');
   if($_SESSION['bMDept']!='BUFC' and $_SESSION['bMDept']!='BUFP' and $_SESSION['bMDept']!='BUCP' ){
   //adjust budget other then BU's
   $cp_amount_after_mb=0;
  //select total amount of the main budget
   $select_main=mysqli_query($db,"select * from tblbudget where bID='".$_POST['cpBudgetRef']."'");
   $row_main=mysqli_fetch_array($select_main);
   $bTotal=$row_main['bTotal'];
   $bConsumed = $row_main['bConsumed'];
   $mb_Total=$bTotal - $bConsumed;
   
   
   
	   
	   
   $cp_amount_after_mb=$mb_Total - $cpTot;
  
   if($cp_amount_after_mb < 0){
	  //going to adjust main budget

	  //update main budget set consumed equal to total and remainig 0.
	  $ad1_up=mysqli_query($db,"update tblbudget set bConsumed='".$row_main['bTotal']."',bRemaining='0' 
	                    where bID='".$_POST['cpBudgetRef']."'");

	  $ad1_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
	        values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef']."', '".$mb_Total."')");
			
	  //end of main budget
	  
	  $cp_amount_after_mb = $cp_amount_after_mb * (-1);
	  //1st adjustment
      $select_ab1=mysqli_query($db,"select * from tblbudget where bID='".$_POST['cpBudgetRef2']."'");
      $row_ab1=mysqli_fetch_array($select_ab1);
      $bTotal_ab1=$row_ab1['bTotal'] - $row_ab1['bConsumed'];	
      $cp_amount_after_ab1=$bTotal_ab1 - $cp_amount_after_mb;	  
	  
	  if($cp_amount_after_ab1 < 0){
	  //adjust first budget
	  $ad2_up=mysqli_query($db,"update tblbudget set bConsumed='".$row_ab1['bTotal']."',bRemaining='0' 
	           where bID='".$_POST['cpBudgetRef2']."'");

	  $ad2_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
	           values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef2']."', '".$bTotal_ab1."')");
	  
      //end of first budget
	  
			$cp_amount_after_ab1 = $cp_amount_after_ab1 * (-1);
			//2nd adjustment
			$select_ab2=mysqli_query($db,"select * from tblbudget where bID='".$_POST['cpBudgetRef3']."'");
            $row_ab2=mysqli_fetch_array($select_ab2);
            $bTotal_ab2=$row_ab2['bTotal'] - $row_ab2['bConsumed'];	
            $cp_amount_after_ab2=$bTotal_ab2 - $cp_amount_after_ab1;	

            if($cp_amount_after_ab2 < 0){
			  //adjust 2nd budget  
			  $ad3_up=mysqli_query($db,"update tblbudget set bConsumed='".$row_ab2['bTotal']."',bRemaining='0' 
			  where bID='".$_POST['cpBudgetRef3']."'");
			  //echo "<br>";
			  $ad3_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
					   values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef3']."', 
					  '".$bTotal_ab2."')");  
			  
               
              //end of 2nd budget		

			  
				$cp_amount_after_ab2 = $cp_amount_after_ab2 * (-1);
				//3rd adjustment
				$select_ab3=mysqli_query($db,"select * from tblbudget where bID='".$_POST['cpBudgetRef4']."'");
				$row_ab3=mysqli_fetch_array($select_ab3);
				$bTotal_ab3=$row_ab3['bTotal'] - $row_ab3['bConsumed'];	
				$cp_amount_after_ab3=$bTotal_ab3 - $cp_amount_after_ab2;		
					
					
					if($cp_amount_after_ab3 < 0){
					  
					   //echo "<br>";	  
					   $ad4_up=mysqli_query($db,"update tblbudget set bConsumed='".$row_ab3['bTotal']."',bRemaining='0' 
					   where bID='".$_POST['cpBudgetRef4']."'");
					   //echo "<br>";
					   $ad4_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
					   values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef4']."', 
					   '".$bTotal_ab3."')");  
					   
					   $cp_amount_after_ab3 = $cp_amount_after_ab3 * (-1);
					   //4th adjustment
						$select_ab4=mysqli_query($db,"select * from tblbudget where bID='".$_POST['cpBudgetRef5']."'");
						$row_ab4=mysqli_fetch_array($select_ab4);
						$bTotal_ab4=$row_ab4['bTotal'] - $row_ab4['bConsumed'];	
						$cp_amount_after_ab4=$bTotal_ab4 - $cp_amount_after_ab3;
					    
						if($cp_amount_after_ab4 < 0){
							
						   //echo "<br>";	  
						   $ad5_up=mysqli_query($db,"update tblbudget set bConsumed='".$row_ab4['bTotal']."',bRemaining='0' 
						   where bID='".$_POST['cpBudgetRef5']."'");
						   //echo "<br>";
						   $ad5_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
						   values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef5']."', 
						   '".$bTotal_ab4."')");  
						   
						   $cp_amount_after_ab4 = $cp_amount_after_ab4 * (-1);
						   //5th adjustment
							$select_ab5=mysqli_query($db,"select * from tblbudget where bID='".$_POST['cpBudgetRef6']."'");
							$row_ab5=mysqli_fetch_array($select_ab5);
							$bTotal_ab5=$row_ab5['bTotal'] - $row_ab5['bConsumed'];	
							$cp_amount_after_ab5=$bTotal_ab5 - $cp_amount_after_ab4;
						   
						    if($cp_amount_after_ab5 < 0){
								
							   //echo "<br>";	  
							   $ad6_up=mysqli_query($db,"update tblbudget set bConsumed='".$row_ab5['bTotal']."',bRemaining='0' 
							   where bID='".$_POST['cpBudgetRef6']."'");
							   //echo "<br>";
							   $ad6_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
							   values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef6']."', 
							   '".$bTotal_ab5."')");  
							}else{
								//5th adjustment
								$ba5Consumed =  $row_ab5['bConsumed'] +  $cp_amount_after_ab4;
								$ba5Remaining = $row_ab5['bTotal'] - $ba5Consumed;
								//echo "<br>";	  
								$ad7_up=mysqli_query($db,"update tblbudget set bConsumed='".$ba5Consumed."',bRemaining='".$ba5Remaining."' 
								where bID='".$_POST['cpBudgetRef6']."'");
								//echo "<br>";
								$ad7_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
								values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef6']."', 
								'".$cp_amount_after_ab4."')");
								
							}	
						   
						   
						   
							
						}else{
							
							//4th adjustment
							$ba4Consumed =  $row_ab4['bConsumed'] +  $cp_amount_after_ab3;
							$ba4Remaining = $row_ab4['bTotal'] - $ba4Consumed;
							$ad8_up=mysqli_query($db,"update tblbudget set bConsumed='".$ba4Consumed."',bRemaining='".$ba4Remaining."' 
							where bID='".$_POST['cpBudgetRef5']."'");
							//echo "<br>";
							$ad8_up=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
							values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef5']."', 
							'".$cp_amount_after_ab3."')");
						}	
						
						
						
						
					
					}else{
					   //3rd adjustment
						$ba3Consumed =  $row_ab3['bConsumed'] +  $cp_amount_after_ab2;
					    $ba3Remaining = $row_ab3['bTotal'] - $ba3Consumed;
					    $ad9_up=mysqli_query($db,"update tblbudget set bConsumed='".$ba3Consumed."',bRemaining='".$ba3Remaining."' 
					    where bID='".$_POST['cpBudgetRef4']."'");
					    //echo "<br>";
					    $ad9_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
						values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef4']."', 
						'".$cp_amount_after_ab2."')");	
						
					}
					
					
					
					
					
			}else{
			  //2nd adjustment	
			  $ba2Consumed =  $row_ab2['bConsumed'] +  $cp_amount_after_ab1;
			  $ba2Remaining = $row_ab2['bTotal'] - $ba2Consumed;
			  $ad10_up=mysqli_query($db,"update tblbudget set bConsumed='".$ba2Consumed."',bRemaining='".$ba2Remaining."' 
			  where bID='".$_POST['cpBudgetRef3']."'");
			  //echo "<br>";
			  $ad10_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
				values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef3']."', '".$cp_amount_after_ab1."')");	
				
			} 
			
			
			
			
	  }else{
		  //1st adjustment
		  
		  //echo "<br>";
		  $ba1Consumed =  $row_ab1['bConsumed'] +  $cp_amount_after_mb;
		  $b1Total=$row_ab1['bTotal'];
	      $ba1Remaining = $b1Total - $ba1Consumed;
	      $ad11_up=mysqli_query($db,"update tblbudget set bConsumed='".$ba1Consumed."',bRemaining='".$ba1Remaining."' 
	      where bID='".$_POST['cpBudgetRef2']."'");
	      //echo "<br>";
	      $ad11_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
	        values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef2']."', '".$cp_amount_after_mb."'	)");	
	  }
	   
   }else{
    //echo "first if else";
	//update main budget set consumed equal to total and remainig 0.
	//sum consumed + cp amount then update
	  $bConsumed=$row_main['bConsumed'];
	  $bConsumed = $bConsumed  +  $cpTot;
	  $bTotal=$row_main['bTotal'];
	  $bRemaining = $bTotal - $bConsumed;
	 
	  //echo "<br>";
	  $ad12_up=mysqli_query($db,"update tblbudget set bConsumed='".$bConsumed."',bRemaining='".$bRemaining."' 
	  where bID='".$_POST['cpBudgetRef']."'");
	  //echo "<br>";
	  $ad12_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
	        values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef']."', '".$cpTot."')");	
   }
   }


  /*$to      = $row_ht['dEmail'];
  $email   = 'cep@packages.com.pk';
  $subject = 'New CEP Form Approval' ;
  $message = 'There is new cep form is waiting for your approval.CEP No is '.$cpID;
   
  mail($to, $subject , $message, "From: $email" );*/

  echo "controllar 2";
header("location:index.php");


}else{
	echo "controllar 3";
	header("location:index.php?session=logut");
	
}
}


if($_GET['action']=="update_inv"){
if($_POST['cpINV_Flag']==2){
  if($_SESSION['dID']=='15'){   

  $update=mysqli_query($db,"update tblcp set cpINV_Flag='".$_POST['cpINV_Flag']."',cpINV_Date='".date('Y-m-d')."',
                       cpINV_GLNo='".$_POST['cpINV_GLNo']."',cpINV_IO='".$_POST['cpINV_IO']."',cpINV_CPNO='".$_POST['cpINV_CPNO']."'  
                       where cpID='".$_GET['cpID']."'");
   
   
   }
   
   
  if($_POST['cpCid']=='7'){ 
  $to      = 'yousaf.hasnain@packages.com.pk';
  $email   = 'cep@packages.com.pk';
  $subject = 'New CEP Form Approval' ;
  $message = 'There is new cep form is waiting for your approval and assigned PR No.CEP No is '.$_GET['cpID'];
   
  mail($to, $subject , $message, "From: $email" );
  }else{
  
  $select_pan=mysqli_query($db,"select cpEmail from tblcp where cpID='".$_GET['cpID']."'"); 
  $row_pan=mysqli_fetch_array($select_pan);
  $to=$row_pan['cpEmail'];
  $email   = 'cep@packages.com.pk';
  $subject = 'CEP Form Approved' ;
  $message = 'Your cep form is approved now.CEP No is '.$_GET['cpID'];
   
  mail($to, $subject , $message, "From: $email" );  
  } 
}else{
	
		  $select_pan=mysqli_query($db,"select cpEmail from tblcp where cpID='".$_GET['cpID']."'"); 
		  $row_pan=mysqli_fetch_array($select_pan);
		  $to=$row_pan['cpEmail'];
		  $email   = 'cep@packages.com.pk';
		  $subject = 'CEP Form Rejected From Inventory';  
		  $message = 'Your cep form is rejected.CEP No is '.$_GET['cpID'];
   
          mail($to, $subject , $message, "From: $email" ); 
		  
	  if($_POST['comments']!=""){
		 $select_cp=mysqli_query($db,"select * from tblcp where cpID='".$_GET['cpID']."'");
		 $row_cp=mysqli_fetch_array($select_cp);		 
		 $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
							  values('".$_GET['cpID']."', '".$_SESSION['dID']."', '".$row_cp['cpDepartment']."',
									 '".mysqli_escape_string($db,$_POST['comments'])."', '".date('Y-m-d H:i')."')");
									 
 									 
									 
		  $select_email=mysqli_query($db,"select tID,dEmail from tbldepts where dID='".$row_cp['cpDepartment']."'");
		  $row_email=mysqli_fetch_array($select_email);
									 
		    $to      = $row_email['dEmail'];
		    $email   = 'cep@packages.com.pk';				 
		    $subject = 'Comments by Inventory For the CEP '.$_GET['cpID'];
		    $message = mysqli_real_escape_string($db,$_POST['comments']);
		   
		    mail($to, $subject , $message, "From: $email" );
		  
		    $delete=mysqli_query($db,'delete from tblcpapprovals where cpID="'.$_GET['cpID'].'"');

		   
		    if($row_email['tID']==1){
			$update=mysqli_query($db,"update tblcp set cpBC_Flag='3',cpBUM_Flag='0',cpEH_Flag='0',cpIA_FLAG='0' 
			                     cpINV_Flag='".$_POST['cpINV_Flag']."'
			                     where cpID='".$_POST['cpID']."'");

			
			}elseif($row_email['tID']==2){
			$update=mysqli_query($db,"update tblcp set cpDepartment_Flag='3',cpBC_Flag='0',cpEH_Flag='0',cpIA_FLAG='0' 
			                     cpINV_Flag='".$_POST['cpINV_Flag']."' 
			                     where cpID='".$_GET['cpID']."'");

			}elseif($row_email['tID']==3){

                if($row_cp['cpCid']=='7'){
			       $update=mysqli_query($db,"update tblcp set cpDepartment_Flag='3',cpHOD_Flag='0',cpEH_Flag='1',cpIA_FLAG='1',
 				                        cpINV_Flag='".$_POST['cpINV_Flag']."' 
			                            where cpID='".$_GET['cpID']."'");				
				}elseif($row_cp['cpCid']=='6'){
			       $update=mysqli_query($db,"update tblcp set cpDepartment_Flag='3',cpHOD_Flag='0',cpEH_Flag='1',cpIA_FLAG='1',
				                        cpINV_Flag='".$_POST['cpINV_Flag']."'
			                            where cpID='".$_GET['cpID']."'");				
				}else{
			       $update=mysqli_query($db,"update tblcp set cpDepartment_Flag='3',cpHOD_Flag='0',cpEH_Flag='2',cpIA_FLAG='1',
			                            cpINV_Flag='".$_POST['cpINV_Flag']."'
										where cpID='".$_GET['cpID']."'");				
				}
								 

			}
			

		    $delete=mysqli_query($db,'delete from tblcpapprovals where cpID="'.$_GET['cpID'].'"');
   

			$select_cp=mysqli_query($db,"select * from tblcp where cpID='".$_GET['cpID']."'");
			$row_cp=mysqli_fetch_array($select_cp);
			$cpTot=$row_cp['cpTot'];

			//check if this cp is adjusted from any other budget
			$select=mysqli_query($db,"select * from tblcpadjustment where cpID='".$_GET['cpID']."'");
			$num=mysqli_num_rows($select);
			if($num>0){
			   while($row=mysqli_fetch_array($select)){
					 $refbID = $row['refbID'];
					 $select_b=mysqli_query($db,"select * from tblbudget where bID='".$refbID."'");
					 $row_b=mysqli_fetch_array($select_b);
					 $bConsumed=$row_b['bConsumed'] - $row['bAmount']; 
					 $bRemaining=$row_b['bTotal'] - $bConsumed;
					 $update=mysqli_query($db,"update tblbudget set bConsumed='".$bConsumed."',bRemaining='".$bRemaining."'
					 where bID='".$refbID."'");
					 
				     $bConsumed="";$bRemaining="";$refbID="";
			   }	
			$delete=mysqli_query($db,"delete from tblcpadjustment where cpID='".$_GET['cpID']."'");   
			
			}



			
	   }

}  
   header("location:index.php");
}

if($_GET['action']=="update-erp"){

  $update=mysqli_query($db,"update tblcp set cpERP_Flag='2',cpERP_PR='".$_POST['cpERP_PR']."' where cpID='".$_GET['cpID']."'");
  
   header("location:pending-for-pr-list.php");
  
  
}


if($_GET['action']=="update_erp"){

  //if($_SESSION['dID']=='6'){   
  $select_cp=mysqli_query($db,"select * from tblcp where cpID='".$_GET['cpID']."'");
  $row_cp=mysqli_fetch_array($select_cp);	
  $update=mysqli_query($db,"update tblcp set cpERP_Flag='2',cpERP_PR='".$_POST['cpERP_PR']."',
                       cp_ERP_Date='".date('Y-m-d')."',cp_SP_Flag='0' where cpID='".$_GET['cpID']."'");
   
   //}
  $cpERP_PR=$_POST['cpERP_PR']; 
  $to      = 'umair.riaz@packages.com.pk';
  $email   = 'cep@packages.com.pk';
  $subject = 'PR Raised againist CEP no '.$_GET['cpID'];
  if($cpERP_PR!=0){
  $message = 'PR No ('.$cpERP_PR.') raised against CP No '.$_GET['cpID'].' in CAPEX Portal.';
  //email for supply chain
  $to      = 'umair.riaz@packages.com.pk';
  $email   = 'cep@packages.com.pk';
  $subject = 'New CEP Form '.$_GET['cpID'];
  $message = 'Please raised PO against PR No '.$cpERP_PR; 
  }else{
  $message = 'Your CP No '.$_GET['cpID'].' is completed in CAPEX Portal.';
  } 
  mail($to, $subject , $message, "From: $email" );   
  if($row_cp['cpCid']=='7'){
  header("location:pending-for-pr-list.php");
  }else{ 
  header("location:pending-list.php");
  }
}

if($_GET['action']=="update_sm"){
  if($_POST['cp_SP_Flag']==2){
  $update=mysqli_query($db,"update tblcp set cp_SP_Flag='".$_POST['cp_SP_Flag']."',cp_SP_PO='".$_POST['cp_SP_PO']."',
                       cp_SP_Date='".date('Y-m-d')."' where cpID='".$_GET['cpID']."'");

          $select=mysqli_query($db,"select cpID from tblcp where cpID='".$_GET['cpID']."'");
	      $row=mysqli_fetch_array($select);
		  $select_email=mysqli_query($db,"select tID,dEmail from tbldepts where dID='".$row['cpDepartment']."'");
		  $row_email=mysqli_fetch_array($select_email);
		  $to      = 'yousaf.hasnain@packages.com.pk';
		  $email   = 'cep@packages.com.pk';
		  $subject = 'PO Raised againist CP no '.$_GET['cpID'];
		  $cp_SP_PO=$_POST['cp_SP_PO'];
		  $message = 'PO No ('.$cp_SP_PO.') raised against CEP No '.$_GET['cpID'].' in CAPEX Portal.';
		   
		  mail($to, $subject , $message, "From: $email" );   
   		  
  }else{
	  
	      
	  if($_POST['comments']!=""){
		 $select_cp=mysqli_query($db,"select * from tblcp where cpID='".$_GET['cpID']."'");
		 $row_cp=mysqli_fetch_array($select_cp);		 
		 $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
							  values('".$_GET['cpID']."', '".$_SESSION['dID']."', '".$row_cp['cpDepartment']."',
									 '".mysqli_escape_string($db,$_POST['comments'])."', '".date('Y-m-d H:i')."')");
		  $select_email=mysqli_query($db,"select tID,dEmail from tbldepts where dID='".$row_cp['cpDepartment']."'");
		  $row_email=mysqli_fetch_array($select_email);
									 
		    $to      = $row_email['dEmail'].',hassan.arif@packages.com.pk';
		    $email   = 'cep@packages.com.pk';				 
		    $subject = 'Comments by Supply Chain For the CEP '.$_GET['cpID'];
		    $message = mysqli_real_escape_string($db,$_POST['comments']);
		   
		    mail($to, $subject , $message, "From: $email" );
		  
		    $delete=mysqli_query($db,'delete from tblcpapprovals where cpID="'.$_GET['cpID'].'"');

		   
		    if($row_email['tID']==1){
			$update=mysqli_query($db,"update tblcp set cpBC_Flag='3',cpBUM_Flag='0',cpEH_Flag='0',cpIA_FLAG='0' 
			                     cpINV_Flag='0',cpERP_Flag='0',cp_SP_Flag='".$_POST['cp_SP_Flag']."'
			                     where cpID='".$_POST['cpID']."'");
			
			}elseif($_SESSION['tID']==2){
			$update=mysqli_query($db,"update tblcp set cpDepartment_Flag='3',cpBC_Flag='0',cpEH_Flag='0',cpIA_FLAG='0' 
			                     cpINV_Flag='0',cpERP_Flag='0',cp_SP_Flag='".$_POST['cp_SP_Flag']."'
			                     where cpID='".$_GET['cpID']."'");

			}elseif($_SESSION['tID']==3){

                if($row_cp['cpCid']=='7'){
			       $update=mysqli_query($db,"update tblcp set cpDepartment_Flag='3',cpHOD_Flag='0',cpEH_Flag='1',cpIA_FLAG='1',
 				                        cpINV_Flag='0',cpERP_Flag='0',cp_SP_Flag='".$_POST['cp_SP_Flag']."'
			                            where cpID='".$_GET['cpID']."'");				
				}elseif($row_cp['cpCid']=='6'){
			       $update=mysqli_query($db,"update tblcp set cpDepartment_Flag='3',cpHOD_Flag='0',cpEH_Flag='1',cpIA_FLAG='1',
				                        cpINV_Flag='0',cpERP_Flag='0',cp_SP_Flag='".$_POST['cp_SP_Flag']."'
			                            where cpID='".$_GET['cpID']."'");				
				}else{
			       $update=mysqli_query($db,"update tblcp set cpDepartment_Flag='3',cpHOD_Flag='0',cpEH_Flag='2',cpIA_FLAG='1',
			                            cpINV_Flag='0',cpERP_Flag='0',cp_SP_Flag='".$_POST['cp_SP_Flag']."'
										where cpID='".$_GET['cpID']."'");				
				}
								 
			}
							  
	   }
  }

  header("location:sm-pending-list.php");
   
}



if($_GET['action']=="update_coa"){
  $update=mysqli_query($db,"update tblcp set cpCOA_Flag='".$_POST['cpCOA_Flag']."',cpCOA_Date='".date('Y-m-d')."',cpINV_CFO_MD='".$_POST['cpINV_CFO_MD']."'
                       where cpID='".$_GET['cpID']."'");
  
  if($_POST['comments']!=""){
	 $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
						  values('".$_GET['cpID']."', '".$_SESSION['dID']."', '".$_POST['cpINV_CFO_MD']."',
								 '".mysqli_escape_string($db,$_POST['comments'])."', '".date('Y-m-d H:i')."')");
								 
	  $to      = 'umair.riaz@packages.com.pk';					 
	  $subject = 'Comments by COA For the CEP '.$_GET['cpID'];
	  $message = mysqli_real_escape_string($db,$_POST['comments']);
	   
	  mail($to, $subject , $message, "From: $email" );
	  
						  
   }
   header("location:coa-pending-list.php");
}

if($_GET['action']=="update_hhh"){
   $select_cp=mysqli_query($db,"select * from tblcp where cpID='".$_GET['cpID']."'");
   $row_cp=mysqli_fetch_array($select_cp);		
ECHO $_POST['cpHOP_HOE_HCD_Flag'];   
  if($_POST['cpHOP_HOE_HCD_Flag']==2){
  $update=mysqli_query($db,"update tblcpapprovals set cpAStatus='".$_POST['cpHOP_HOE_HCD_Flag']."',cpADate='".date('Y-m-d')."',
                       cpATime='".date('H:i')."'
                       where cpAID='".$_SESSION['dID']."' and cpID='".$_GET['cpID']."'");

	  	  $select_email=mysqli_query($db,"select * from tbldepts where dID='".$_SESSION['dID']."'");
		  $row_email=mysqli_fetch_array($select_email);
	  
	  	  $select_pan=mysqli_query($db,"select cpEmail from tblcp where cpID='".$_GET['cpID']."'"); 
		  $row_pan=mysqli_fetch_array($select_pan);
		  $to=$row_pan['cpEmail'];
		  $email   = 'cep@packages.com.pk';
		  $subject = 'CEP Form Approved From '.$row_pan['dName'];  
		  $message = 'Your cep form is approved.CEP No is '.$_GET['cpID'];
   
          mail($to, $subject , $message, "From: $email" ); 
					   

					   
  if($_SESSION['dID']==14){					   
  $update2=mysqli_query($db,"update tblcp set cpPBack='".$_POST['cpPBack']."',cpIRR='".$_POST['cpIRR']."',cpINV_Flag='1' where cpID='".$_GET['cpID']."'");				   
  }else{
  $update2=mysqli_query($db,"update tblcp set cpINV_Flag='1' where cpID='".$_GET['cpID']."'");				   
  }					   
  if($_POST['comments']!=""){
         $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
							  values('".$_GET['cpID']."', '".$_SESSION['dID']."', '".$row_cp['cpDepartment']."',
									 '".mysqli_escape_string($db,$_POST['comments'])."', '".date('Y-m-d H:i')."')");  
  
  }					   
  
  

if($_POST['md']=='on'){
$md=59;  

$select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$md."'"); 
$row_hhh=mysqli_fetch_array($select_hhh);
$dEmail=$row_hhh['dEmail'];

$insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
		  values('".$_GET['cpID']."', '".$md."', '1'	)"); 

			 
$to = $dEmail;
$subject = "CAPEX form approval";
$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
$cpAmount=$cpTot;
$cpBudgeted=$_POST['cpDBudget'];

if($cpBudgeted==1){
$cpBudgeted='No';
}elseif($cpBudgeted==2){
$cpBudgeted='Yes';
}elseif($cpBudgeted==3){
$cpBudgeted='Strategic';
}


$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>CAPEX form is pending to be approved in your log in. 

</p>
<table>
<tr>
<th>Please click on link to approve/reject:</th>
<th></th>
</tr>
<tr>
<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
<th></th>
</tr>
<tr>
<td>Detail of Proposal</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
</tr>
<tr>
<td>Capex Amount</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
</tr>
<tr>
<td>Budgeted</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
</tr>
<tr>
<td><br></td>
<td></td>
</tr>
<tr>
<td></td>
<td>This is a system generated email. Please do not 

reply.</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

mail($to,$subject,$message,$headers);

} 
if($_POST['inv']=='on'){

$hcd=15;  

$select_hhh=mysqli_query($db,"select * from tbldepts where dID='15'"); 
$row_hhh=mysqli_fetch_array($select_hhh);
$dEmail=$row_hhh['dEmail'];

/*$insert=mysqli_query($db,insert into tblcpapprovals (cpID, cpAID,cpAStatus)
		  values('".$_GET['cpID']."', '".$hcd."', '2'	)"); 							 */

$update=mysqli_query($db,"update tblcp set cpINV_Flag='1' where cpID='".$_GET['cpID']."'");		
$to = $dEmail;
$subject = "CAPEX form approval";
$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
$cpAmount=$cpTot;
$cpBudgeted=$_POST['cpDBudget'];

if($cpBudgeted==1){
$cpBudgeted='No';
}elseif($cpBudgeted==2){
$cpBudgeted='Yes';
}elseif($cpBudgeted==3){
$cpBudgeted='Strategic';
}


$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>CAPEX form is pending to be approved in your log in. 

</p>
<table>
<tr>
<th>Please click on link to approve/reject:</th>
<th></th>
</tr>
<tr>
<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
<th></th>
</tr>
<tr>
<td>Detail of Proposal</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
</tr>
<tr>
<td>Capex Amount</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
</tr>
<tr>
<td>Budgeted</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
</tr>
<tr>
<td><br></td>
<td></td>
</tr>
<tr>
<td></td>
<td>This is a system generated email. Please do not 

reply.</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

mail($to,$subject,$message,$headers);
}   
					   
  
  
  
  
  
  
  }else{
	  
	  	  $select_email=mysqli_query($db,"select * from tbldepts where dID='".$_SESSION['dID']."'");
		  $row_email=mysqli_fetch_array($select_email);
	  
	  	  $select_pan=mysqli_query($db,"select cpEmail from tblcp where cpID='".$_GET['cpID']."'"); 
		  $row_pan=mysqli_fetch_array($select_pan);
		  $to=$row_pan['cpEmail'];
		  $email   = 'cep@packages.com.pk';
		  $subject = 'CEP Form Rejected From '.$row_pan['dName'];  
		  $message = 'Your cep form is rejected.CEP No is '.$_GET['cpID'];
   
          mail($to, $subject , $message, "From: $email" ); 
	  
	  if($_POST['comments']!=""){
		
		 $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
							  values('".$_GET['cpID']."', '".$_SESSION['dID']."', '".$row_cp['cpDepartment']."',
									 '".mysqli_escape_string($db,$_POST['comments'])."', '".date('Y-m-d H:i')."')");

									 
		    $to      = $row_email['dEmail'];
		    $email   = 'cep@packages.com.pk';				 
		    $subject = 'Comments by HOP/HOE/HCD For the CEP '.$_GET['cpID'];
		    $message = mysqli_real_escape_string($db,$_POST['comments']);
		   
		    mail($to, $subject , $message, "From: $email" );

		    $delete=mysqli_query($db,'delete from tblcpapprovals where cpID="'.$_GET['cpID'].'"');

		   
			if($_SESSION['tID']==1){
			$update=mysqli_query($db,"update tblcp set cpDepartment_Flag='3',cpBC_Flag='3',cpBUM_Flag='3' where cpID='".$_GET['cpID']."'");

			}elseif($_SESSION['tID']==2){
			$update=mysqli_query($db,"update tblcp set cpDepartment_Flag='3',cpBC_Flag='3' where cpID='".$_GET['cpID']."'");
			
			}elseif($_SESSION['tID']==3){
			$update=mysqli_query($db,"update tblcp set cpDepartment_Flag='3',cpHOD_Flag='3' where cpID='".$_GET['cpID']."'");
			
			}

			$select_cp=mysqli_query($db,"select * from tblcp where cpID='".$_GET['cpID']."'");
			$row_cp=mysqli_fetch_array($select_cp);
			$cpTot=$row_cp['cpTot'];

			//check if this cp is adjusted from any other budget
			$select=mysqli_query($db,"select * from tblcpadjustment where cpID='".$_GET['cpID']."'");
			$num=mysqli_num_rows($select);
			if($num>0){
			   while($row=mysqli_fetch_array($select)){
					 $refbID = $row['refbID'];
					 $select_b=mysqli_query($db,"select * from tblbudget where bID='".$refbID."'");
					 $row_b=mysqli_fetch_array($select_b);
					 $bConsumed=$row_b['bConsumed'] - $row['bAmount']; 
					 $bRemaining=$row_b['bTotal'] - $bConsumed;
					 $update=mysqli_query($db,"update tblbudget set bConsumed='".$bConsumed."',bRemaining='".$bRemaining."'
					 where bID='".$refbID."'");
					 
				     $bConsumed="";$bRemaining="";$refbID="";
			   }	
			$delete=mysqli_query($db,"delete from tblcpadjustment where cpID='".$_GET['cpID']."'");   
			
			}
			
			
	   }
   }
   header("location:index.php");
}


if($_GET['action']=="update_ia"){
    $cpID = $_GET['cpID'];
	if($_POST['cpIA_FLAG']==3){ 

		$select=mysqli_query($db,"select cpDepartment from tblcp where cpID='".$cpID."'");
		$row=mysqli_fetch_array($select);
		$select_ht=mysqli_query($db,"select * from tbldepts where dID='".$row['cpDepartment']."'");
        $row_ht=mysqli_fetch_array($select_ht);
		   if($row_ht['tID']==1){
			   $update=mysqli_query($db,"update tblcp set cpBC_Flag='1',cpBUM_Flag='0',cpEH_Flag='1',cpIA_FLAG='3'
			                        where cpID='".$_GET['cpID']."'");
			   $select=mysqli_query($db,"select cpBC from tblcp where cpID='".$_GET['cpID']."'");
			   $row=mysqli_fetch_array($select);
			   
			   $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
									values('".$_GET['cpID']."', '8', '".$row['cpDepartment']."',
									'".mysqli_escape_string($db,$_POST['comments'])."', '".date('Y-m-d H:i')."')");
			   
			}elseif($row_ht['tID']==2){
			   $update=mysqli_query($db,"update tblcp set cpDepartment_Flag='0',cpBC_Flag='0',cpEH_Flag='1',cpIA_FLAG='3'
			                        where cpID='".$_GET['cpID']."'");
			   $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
									values('".$_GET['cpID']."', '8', '".$row['cpDepartment']."',
									'".mysqli_escape_string($db,$_POST['comments'])."', '".date('Y-m-d H:i')."')");
			}elseif($row_ht['tID']==3){
			
			   $update=mysqli_query($db,"update tblcp set cpDepartment_Flag='3',cpHOD_Flag='0',cpBC_Flag='0',
			                        cpBUM_Flag='0',cpEH_Flag='1',cpIA_FLAG='3' 
			                        where cpID='".$_GET['cpID']."'");
			   $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
									values('".$_GET['cpID']."', '8', '".$row['cpDepartment']."',
									'".mysqli_escape_string($db,$_POST['comments'])."', '".date('Y-m-d H:i')."')");
			}
		

 
}else{ 
 
	$update=mysqli_query($db,"update tblcp set cpIA_FLAG='".$_POST['cpIA_FLAG']."',cpIA_Date='".date('Y-m-d')."' 
	where cpID='".$_GET['cpID']."'");
	
	if($_POST['inv']!='on'){ 
	$delete=mysqli_query($db,'delete from tblcpapprovals where cpID="'.$_GET['cpID'].'"');
	}
	if($_POST['cpIA_FLAG']==2){  
	  if($_POST['hop']=='on'){
		 $hop=9;  
		 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
							  values('".$_GET['cpID']."', '".$hop."', '1'	)"); 
	  }
	
	  if($_POST['hoe']=='on'){
		 $hoe=10;  
		 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
							  values('".$_GET['cpID']."', '".$hoe."', '1'	)"); 
	  }
	 
	  if($_POST['hcd']=='on'){
		 $hcd=11;  
		 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
							  values('".$_GET['cpID']."', '".$hcd."', '1'	)"); 
	  }

	  if($_POST['ghit']=='on'){
		 $ghit=19;  
		 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
							  values('".$_GET['cpID']."', '".$ghit."', '1'	)"); 
	  }
	 
	  if($_POST['ghhr']=='on'){
		 $ghhr=20;  
		 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
							  values('".$_GET['cpID']."', '".$ghhr."', '1'	)"); 
	  }
	
	  if($_POST['coa']=='on'){
		 $coa=12;  
		 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
							  values('".$_GET['cpID']."', '".$coa."', '1'	)"); 
	  }
	
	  if($_POST['cfo']=='on'){
		 $cfo=13;  
		 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
							  values('".$_GET['cpID']."', '".$cfo."', '1'	)"); 
	  }  
	
	  if($_POST['md']=='on'){
		 $md=14;  
		 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
							  values('".$_GET['cpID']."', '".$md."', '1'	)"); 
	  } 
	  if($_POST['inv']=='on'){
         $update=mysqli_query($db,"update tblcp set cpINV_Flag='1' where cpID='".$_GET['cpID']."'");		
		 
	  }   
	} 
}
  if($_POST['comments']!=""){
	 $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
						  values('".$_GET['cpID']."', '8', '8',
								 '".mysqli_escape_string($db,$_POST['comments'])."', '".date('Y-m-d H:i')."')");
								 
	  //$to      = 'umair.riaz@packages.com.pk';					 
	  //$subject = 'Comments by IA For the CP '.$_GET['cpID'];
	  //$message = mysqli_real_escape_string($db,$_POST['comments']);
	   
	  //mail($to, $subject , $message, "From: $email" );
	  
						  
   }
   header("location:ia-pending-list.php");
}


if($_GET['action']=="update"){
	
	$cpCostL = str_replace( ',', '', $_POST['cpCostL'] );	
	$cpCostI = str_replace( ',', '', $_POST['cpCostI'] );	
	$cpCDL = str_replace( ',', '', $_POST['cpCDL'] );	
	$cpCDI = str_replace( ',', '', $_POST['cpCDI'] );	
	$cpOthersL = str_replace( ',', '', $_POST['cpOthersL'] );	
	$cpOthersI = str_replace( ',', '', $_POST['cpOthersI'] );	
	$cpGSTL = str_replace( ',', '', $_POST['cpGSTL'] );	
	$cpGSTI = str_replace( ',', '', $_POST['cpGSTI'] );	
	$cpFCA = str_replace( ',', '', $_POST['cpFCA'] );	
	$cpFCR = str_replace( ',', '', $_POST['cpFCR'] );	
	
	
$cpTot=( $cpCostL * 1 ) + ( $cpCostI  * 1 ) + ( $cpCDL * 1 ) + ( $cpCDI * 1 ) + ( $cpOthersL * 1 ) + 
         ( $cpOthersI * 1 ) + ( $cpGSTL * 1 ) + ( $cpGSTI * 1 );	
	
if(isset($_SESSION['dBC_BUM_HOD'])){
      if($_POST['cpCid']=='7'){					  
	  $email   = 'suleman.javed@packages.com.pk';
	  $cpEH_Flag= '1';
	  }
	  elseif($_POST['cpCid']=='6'){					  
	  $email   = 'mobin.javed@packages.com.pk';
	  $cpEH_Flag= '1';
	  }else{				  
	  $email   = 'cep@packages.com.pk';
	  $cpEH_Flag= '1';
	  }

if($_GET['c']=='true'){
  if($_POST['comments']!=""){
	 $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
						  values('".$_GET['cpID']."', '".$_SESSION['dID']."', '8',
								 '".mysqli_escape_string($db,$_POST['comments'])."', '".date('Y-m-d H:i')."')");
	  
	  $select=mysqli_query($db,"select * from tblcp where cpID='".$_GET['cpID']."'");
	  $row=mysqli_fetch_array($select);
	  
		  
	 
	  
	  
	  $to      = ' 	suleman.javed@packages.com.pk';					  
	  
	  
	  $subject = $_POST['cpCid'].' Comments for CEP '.$_GET['cpID'];
	  $message = mysqli_real_escape_string($db,$_POST['comments']);
	   
	  mail($to, $subject , $message, "From: $email" );
	  
	  //added by umair on 22.07.2020
$update=mysqli_query($db,"update tblcp set cpEH_Flag='2',cpIA_FLAG='1' where cpID='".$_GET['cpID']."'");
					  
					
$delete=mysqli_query($db,'delete from tblcpapprovals where cpID="'.$_GET['cpID'].'"');

if($_POST['hop']=='on'){
$hop=9;  


$select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$hop."'"); 
$row_hhh=mysqli_fetch_array($select_hhh);
$dEmail=$row_hhh['dEmail'];

$insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
		  values('".$_GET['cpID']."', '".$hop."', '1'	)"); 

$to = $dEmail;
$subject = "CAPEX form approval";
$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
$cpAmount=$cpTot;
$cpBudgeted=$_POST['cpDBudget'];

if($cpBudgeted==1){
$cpBudgeted='No';
}elseif($cpBudgeted==2){
$cpBudgeted='Yes';
}elseif($cpBudgeted==3){
$cpBudgeted='Strategic';
}


$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>CAPEX form is pending to be approved in your log in. 

</p>
<table>
<tr>
<th>Please click on link to approve/reject:</th>
<th></th>
</tr>
<tr>
<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
<th></th>
</tr>
<tr>
<td>Detail of Proposal</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
</tr>
<tr>
<td>Capex Amount</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
</tr>
<tr>
<td>Budgeted</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
</tr>
<tr>
<td><br></td>
<td></td>
</tr>
<tr>
<td></td>
<td>This is a system generated email. Please do not 

reply.</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

mail($to,$subject,$message,$headers);
}

if($_POST['gsm']=='on'){
$gsm=57;  
$select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$gsm."'"); 
$row_hhh=mysqli_fetch_array($select_hhh);
$dEmail=$row_hhh['dEmail'];

$insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
		  values('".$_GET['cpID']."', '".$gsm."', '1'	)"); 

$to = $dEmail;
$subject = "CAPEX form approval";
$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
$cpAmount=$cpTot;
$cpBudgeted=$_POST['cpDBudget'];

if($cpBudgeted==1){
$cpBudgeted='No';
}elseif($cpBudgeted==2){
$cpBudgeted='Yes';
}elseif($cpBudgeted==3){
$cpBudgeted='Strategic';
}


$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>CAPEX form is pending to be approved in your log in. 

</p>
<table>
<tr>
<th>Please click on link to approve/reject:</th>
<th></th>
</tr>
<tr>
<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
<th></th>
</tr>
<tr>
<td>Detail of Proposal</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
</tr>
<tr>
<td>Capex Amount</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
</tr>
<tr>
<td>Budgeted</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
</tr>
<tr>
<td><br></td>
<td></td>
</tr>
<tr>
<td></td>
<td>This is a system generated email. Please do not 

reply.</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

mail($to,$subject,$message,$headers);
}

if($_POST['hcd']=='on'){
$hcd=11;  

$select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$hcd."'"); 
$row_hhh=mysqli_fetch_array($select_hhh);
$dEmail=$row_hhh['dEmail'];

$insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
		  values('".$_GET['cpID']."', '".$hcd."', '1'	)"); 

$to = $dEmail;
$subject = "CAPEX form approval";
$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
$cpAmount=$cpTot;
$cpBudgeted=$_POST['cpDBudget'];

if($cpBudgeted==1){
$cpBudgeted='No';
}elseif($cpBudgeted==2){
$cpBudgeted='Yes';
}elseif($cpBudgeted==3){
$cpBudgeted='Strategic';
}


$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>CAPEX form is pending to be approved in your log in. 

</p>
<table>
<tr>
<th>Please click on link to approve/reject:</th>
<th></th>
</tr>
<tr>
<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
<th></th>
</tr>
<tr>
<td>Detail of Proposal</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
</tr>
<tr>
<td>Capex Amount</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
</tr>
<tr>
<td>Budgeted</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
</tr>
<tr>
<td><br></td>
<td></td>
</tr>
<tr>
<td></td>
<td>This is a system generated email. Please do not 

reply.</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

mail($to,$subject,$message,$headers);
}

if($_POST['ghit']=='on'){
$ghit=19;  
$select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$ghit."'"); 
$row_hhh=mysqli_fetch_array($select_hhh);
$dEmail=$row_hhh['dEmail'];

$insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
		  values('".$_GET['cpID']."', '".$ghit."', '1'	)"); 

$to = $dEmail;
$subject = "CAPEX form approval";
$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
$cpAmount=$cpTot;
$cpBudgeted=$_POST['cpDBudget'];

if($cpBudgeted==1){
$cpBudgeted='No';
}elseif($cpBudgeted==2){
$cpBudgeted='Yes';
}elseif($cpBudgeted==3){
$cpBudgeted='Strategic';
}


$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>CAPEX form is pending to be approved in your log in. 

</p>
<table>
<tr>
<th>Please click on link to approve/reject:</th>
<th></th>
</tr>
<tr>
<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
<th></th>
</tr>
<tr>
<td>Detail of Proposal</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
</tr>
<tr>
<td>Capex Amount</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
</tr>
<tr>
<td>Budgeted</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
</tr>
<tr>
<td><br></td>
<td></td>
</tr>
<tr>
<td></td>
<td>This is a system generated email. Please do not 

reply.</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

mail($to,$subject,$message,$headers);
}

if($_POST['ghhr']=='on'){
$ghhr=20;  

$select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$ghhr."'"); 
$row_hhh=mysqli_fetch_array($select_hhh);
$dEmail=$row_hhh['dEmail'];

$insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
		  values('".$_GET['cpID']."', '".$ghhr."', '1'	)"); 

$to = $dEmail;
$subject = "CAPEX form approval";
$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
$cpAmount=$cpTot;
$cpBudgeted=$_POST['cpDBudget'];

if($cpBudgeted==1){
$cpBudgeted='No';
}elseif($cpBudgeted==2){
$cpBudgeted='Yes';
}elseif($cpBudgeted==3){
$cpBudgeted='Strategic';
}


$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>CAPEX form is pending to be approved in your log in. 

</p>
<table>
<tr>
<th>Please click on link to approve/reject:</th>
<th></th>
</tr>
<tr>
<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
<th></th>
</tr>
<tr>
<td>Detail of Proposal</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
</tr>
<tr>
<td>Capex Amount</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
</tr>
<tr>
<td>Budgeted</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
</tr>
<tr>
<td><br></td>
<td></td>
</tr>
<tr>
<td></td>
<td>This is a system generated email. Please do not 

reply.</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

mail($to,$subject,$message,$headers);

}

if($_POST['coa']=='on'){
$coa=12;  

$select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$coa."'"); 
$row_hhh=mysqli_fetch_array($select_hhh);
$dEmail=$row_hhh['dEmail'];

$insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
		  values('".$_GET['cpID']."', '".$coa."', '1'	)"); 

$to = $dEmail;
$subject = "CAPEX form approval";
$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
$cpAmount=number_format($cpTot);
$cpBudgeted=$_POST['cpDBudget'];

if($cpBudgeted==1){
$cpBudgeted='No';
}elseif($cpBudgeted==2){
$cpBudgeted='Yes';
}elseif($cpBudgeted==3){
$cpBudgeted='Strategic';
}


$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>CAPEX form is pending to be approved in your log in. 

</p>
<table>
<tr>
<th>Please click on link to approve/reject:</th>
<th></th>
</tr>
<tr>
<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
<th></th>
</tr>
<tr>
<td>Detail of Proposal</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
</tr>
<tr>
<td>Capex Amount</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
</tr>
<tr>
<td>Budgeted</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
</tr>
<tr>
<td><br></td>
<td></td>
</tr>
<tr>
<td></td>
<td>This is a system generated email. Please do not 

reply.</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

mail($to,$subject,$message,$headers);

}

if($_POST['cfo']=='on'){
$cfo=13;  
$select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$cfo."'"); 
$row_hhh=mysqli_fetch_array($select_hhh);
$dEmail=$row_hhh['dEmail'];

$insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
		  values('".$_GET

['cpID']."', '".$cfo."', '1'	)"); 
$to = $dEmail;
$subject = "CAPEX form approval";
$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
$cpAmount=$cpTot;
$cpBudgeted=$_POST['cpDBudget'];

if($cpBudgeted==1){
$cpBudgeted='No';
}elseif($cpBudgeted==2){
$cpBudgeted='Yes';
}elseif($cpBudgeted==3){
$cpBudgeted='Strategic';
}


$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>CAPEX form is pending to be approved in your log in. 

</p>
<table>
<tr>
<th>Please click on link to approve/reject:</th>
<th></th>
</tr>
<tr>
<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
<th></th>
</tr>
<tr>
<td>Detail of Proposal</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
</tr>
<tr>
<td>Capex Amount</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
</tr>
<tr>
<td>Budgeted</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
</tr>
<tr>
<td><br></td>
<td></td>
</tr>
<tr>
<td></td>
<td>This is a system generated email. Please do not 

reply.</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

mail($to,$subject,$message,$headers);

}  

if($_POST['md']=='on'){
$md=14;  

$select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$md."'"); 
$row_hhh=mysqli_fetch_array($select_hhh);
$dEmail=$row_hhh['dEmail'];

$insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
		  values('".$_GET['cpID']."', '".$md."', '1'	)"); 

			 
$to = $dEmail;
$subject = "CAPEX form approval";
$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
$cpAmount=$cpTot;
$cpBudgeted=$_POST['cpDBudget'];

if($cpBudgeted==1){
$cpBudgeted='No';
}elseif($cpBudgeted==2){
$cpBudgeted='Yes';
}elseif($cpBudgeted==3){
$cpBudgeted='Strategic';
}


$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>CAPEX form is pending to be approved in your log in. 

</p>
<table>
<tr>
<th>Please click on link to approve/reject:</th>
<th></th>
</tr>
<tr>
<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
<th></th>
</tr>
<tr>
<td>Detail of Proposal</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
</tr>
<tr>
<td>Capex Amount</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
</tr>
<tr>
<td>Budgeted</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
</tr>
<tr>
<td><br></td>
<td></td>
</tr>
<tr>
<td></td>
<td>This is a system generated email. Please do not 

reply.</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

mail($to,$subject,$message,$headers);

} 
if($_POST['inv']=='on'){

$hcd=11;  

$select_hhh=mysqli_query($db,"select * from tbldepts where dID='15'"); 
$row_hhh=mysqli_fetch_array($select_hhh);
$dEmail=$row_hhh['dEmail'];

/*$insert=mysqli_query($db,insert into tblcpapprovals (cpID, cpAID,cpAStatus)
		  values('".$_GET['cpID']."', '".$hcd."', '2'	)"); 			*/				 

$update=mysqli_query($db,"update tblcp set cpINV_Flag='1' where cpID='".$_GET['cpID']."'");		
$to = $dEmail;
$subject = "CAPEX form approval";
$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
$cpAmount=$cpTot;
$cpBudgeted=$_POST['cpDBudget'];

if($cpBudgeted==1){
$cpBudgeted='No';
}elseif($cpBudgeted==2){
$cpBudgeted='Yes';
}elseif($cpBudgeted==3){
$cpBudgeted='Strategic';
}


$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>CAPEX form is pending to be approved in your log in. 

</p>
<table>
<tr>
<th>Please click on link to approve/reject:</th>
<th></th>
</tr>
<tr>
<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
<th></th>
</tr>
<tr>
<td>Detail of Proposal</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
</tr>
<tr>
<td>Capex Amount</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
</tr>
<tr>
<td>Budgeted</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
</tr>
<tr>
<td><br></td>
<td></td>
</tr>
<tr>
<td></td>
<td>This is a system generated email. Please do not 

reply.</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

mail($to,$subject,$message,$headers);
}   
					   


if($_POST['hoe']=='on'){

$hoe=10;  

$select_hhh=mysqli_query($db,"select * from tbldepts where dID='10'"); 
$row_hhh=mysqli_fetch_array($select_hhh);
$dEmail=$row_hhh['dEmail'];

$insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
		  values('".$_GET['cpID']."', '".$hoe."', '1'	)"); 
		  
$to = $dEmail;
$subject = "CAPEX form approval";
$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
$cpAmount=$cpTot;
$cpBudgeted=$_POST['cpDBudget'];

if($cpBudgeted==1){
$cpBudgeted='No';
}elseif($cpBudgeted==2){
$cpBudgeted='Yes';
}elseif($cpBudgeted==3){
$cpBudgeted='Strategic';
}


$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>CAPEX form is pending to be approved in your log in. 

</p>
<table>
<tr>
<th>Please click on link to approve/reject:</th>
<th></th>
</tr>
<tr>
<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
<th></th>
</tr>
<tr>
<td>Detail of Proposal</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
</tr>
<tr>
<td>Capex Amount</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
</tr>
<tr>
<td>Budgeted</td>
<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
</tr>
<tr>
<td><br></td>
<td></td>
</tr>
<tr>
<td></td>
<td>This is a system generated email. Please do not 

reply.</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

mail($to,$subject,$message,$headers);
}   

						  
   }	
}else{



if($_POST['cpCostL']==""){
   $cpCostL="0";	
}
if($_POST['cpCostI']==""){
   $cpCostI="0";	
}	
if($_POST['cpCDL']==""){
   $cpCDL="0";	
}	
if($_POST['cpCDI']==""){
   $cpCDI="0";	
}	
if($_POST['cpOthersL']==""){
   $cpOthersL="0";	
}	
if($_POST['cpOthersI']==""){
   $cpOthersI="0";	
}	
if($_POST['cpGSTL']==""){
   $cpGSTL="0";	
}	
if($_POST['cpGSTI']==""){
   $cpGSTI="0";	
}	

if($_POST['cpFCA']==""){
   $cpFCA="0";	
}

if($_POST['cpFCR']==""){
   $cpFCR="0";	
}	

if($_POST['cpDBudget']==1){
   $cpSBudgetRef=$_POST['cpSBudgetRef2'];	
}

if($_POST['cpDBudget']==3){
   $cpSBudgetRef=$_POST['cpSBudgetRef'];	
}

if($_SESSION['tID']==2){
		 
		$update=mysqli_query($db,"update tblcp set cpDepartment_Flag='1',cpCC='".$_POST['cpCC']."', 
		    cpEDate='".$_POST['cpEDate']."',
		    cpWERI='".mysqli_escape_string($db,$_POST['cpWERI'])."',
			cpCid='".$_POST['cpCid']."', 
			cpDetail='".mysqli_escape_string($db,$_POST['cpDetail'])."',
			cpDAssetName='".mysqli_escape_string($db,$_POST['cpDAssetName'])."',	
			cpOIHA='".$_POST['cpOIHA']."',
			cpCostL='".$cpCostL."', 
			cpCostI='".$cpCostI."', 
			cpCur='".$_POST['cpCur']."',
			cpFCA='".$cpFCA."',
			cpFCR='".$cpFCR."',
			cpCDL='".$cpCDL."', 
			cpCDI='".$cpCDI."', 
			cpOthersL='".$cpOthersL."', 
			cpOthersI='".$cpOthersI."', 
			cpGSTL='".$cpGSTL."', 
			cpGSTI='".$cpGSTI."', 
			cpTot='".$cpTot."',
			cpPBack='".$_POST['cpPBack']."',cpIRR='".$_POST['cpIRR']."' where cpID='".$_GET['cpID']."'");

}else{
		$update=mysqli_query($db,"update tblcp set cpDepartment_Flag='1',cpCC='".$_POST['cpCC']."', 
		    cpEDate='".$_POST['cpEDate']."',
		    cpWERI='".mysqli_escape_string($db,$_POST['cpWERI'])."',
			cpCid='".$_POST['cpCid']."', 
			cpDetail='".mysqli_escape_string($db,$_POST['cpDetail'])."',
			cpDAssetName='".mysqli_escape_string($db,$_POST['cpDAssetName'])."',	
			cpOIHA='".$_POST['cpOIHA']."'
			 where cpID='".$_GET['cpID']."'");	
	
}       
			$select_ht=mysqli_query($db,"select * from tbldepts where dID='".$_SESSION['dBC_BUM_HOD']."'");
			$row_ht=mysqli_fetch_array($select_ht);

			
			$dept=$_SESSION['department'];
		    $pos = strpos($dept, 'USER');
if($_POST['cpDBudgettype']==2){			
   if($_SESSION['tID']==2 or ($pos !== false and $_SESSION['bMDept']!='BUFC' and $_SESSION['bMDept']!='BUFP' and $_SESSION['bMDept']!='BUCP')){
    $cpID=$_GET['cpID'];
   //adjust budget other then BU's
   $cp_amount_after_mb=0;
  //select total amount of the main budget
   $select_main=mysqli_query($db,"select * from tblbudget where bID='".$_POST['cpBudgetRef']."'");
   $row_main=mysqli_fetch_array($select_main);
   $bTotal=$row_main['bTotal'];
   $bConsumed = $row_main['bConsumed'];
   $mb_Total=$bTotal - $bConsumed;
   
   $update=mysqli_query($db,"update tblcp set cpPBack='".$_POST['cpPBack']."',cpIRR='".$_POST['cpIRR']."'
				        where cpID='".$cpID."'");
   
	   
	   
   $cp_amount_after_mb=$mb_Total - $cpTot;
  
   if($cp_amount_after_mb < 0){
	  //going to adjust main budget

	  //update main budget set consumed equal to total and remainig 0.
	  $ad1_up=mysqli_query($db,"update tblbudget set bConsumed='".$row_main['bTotal']."',bRemaining='0' 
	                    where bID='".$_POST['cpBudgetRef']."'");

	  $ad1_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
	        values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef']."', '".$mb_Total."')");
			
	  //end of main budget
	  
	  $cp_amount_after_mb = $cp_amount_after_mb * (-1);
	  //1st adjustment
      $select_ab1=mysqli_query($db,"select * from tblbudget where bID='".$_POST['cpBudgetRef2']."'");
      $row_ab1=mysqli_fetch_array($select_ab1);
      $bTotal_ab1=$row_ab1['bTotal'] - $row_ab1['bConsumed'];	
      $cp_amount_after_ab1=$bTotal_ab1 - $cp_amount_after_mb;	  
	  
	  if($cp_amount_after_ab1 < 0){
	  //adjust first budget
	  $ad2_up=mysqli_query($db,"update tblbudget set bConsumed='".$row_ab1['bTotal']."',bRemaining='0' 
	           where bID='".$_POST['cpBudgetRef2']."'");

	  $ad2_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
	           values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef2']."', '".$bTotal_ab1."')");
	  
      //end of first budget
	  
			$cp_amount_after_ab1 = $cp_amount_after_ab1 * (-1);
			//2nd adjustment
			$select_ab2=mysqli_query($db,"select * from tblbudget where bID='".$_POST['cpBudgetRef3']."'");
            $row_ab2=mysqli_fetch_array($select_ab2);
            $bTotal_ab2=$row_ab2['bTotal'] - $row_ab2['bConsumed'];	
            $cp_amount_after_ab2=$bTotal_ab2 - $cp_amount_after_ab1;	

            if($cp_amount_after_ab2 < 0){
			  //adjust 2nd budget  
			  $ad3_up=mysqli_query($db,"update tblbudget set bConsumed='".$row_ab2['bTotal']."',bRemaining='0' 
			  where bID='".$_POST['cpBudgetRef3']."'");
			  //echo "<br>";
			  $ad3_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
					   values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef3']."', 
					  '".$bTotal_ab2."')");  
			  
               
              //end of 2nd budget		

			  
				$cp_amount_after_ab2 = $cp_amount_after_ab2 * (-1);
				//3rd adjustment
				$select_ab3=mysqli_query($db,"select * from tblbudget where bID='".$_POST['cpBudgetRef4']."'");
				$row_ab3=mysqli_fetch_array($select_ab3);
				$bTotal_ab3=$row_ab3['bTotal'] - $row_ab3['bConsumed'];	
				$cp_amount_after_ab3=$bTotal_ab3 - $cp_amount_after_ab2;		
					
					
					if($cp_amount_after_ab3 < 0){
					  
					   //echo "<br>";	  
					   $ad4_up=mysqli_query($db,"update tblbudget set bConsumed='".$row_ab3['bTotal']."',bRemaining='0' 
					   where bID='".$_POST['cpBudgetRef4']."'");
					   //echo "<br>";
					   $ad4_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
					   values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef4']."', 
					   '".$bTotal_ab3."')");  
					   
					   $cp_amount_after_ab3 = $cp_amount_after_ab3 * (-1);
					   //4th adjustment
						$select_ab4=mysqli_query($db,"select * from tblbudget where bID='".$_POST['cpBudgetRef5']."'");
						$row_ab4=mysqli_fetch_array($select_ab4);
						$bTotal_ab4=$row_ab4['bTotal'] - $row_ab4['bConsumed'];	
						$cp_amount_after_ab4=$bTotal_ab4 - $cp_amount_after_ab3;
					    
						if($cp_amount_after_ab4 < 0){
							
						   //echo "<br>";	  
						   $ad5_up=mysqli_query($db,"update tblbudget set bConsumed='".$row_ab4['bTotal']."',bRemaining='0' 
						   where bID='".$_POST['cpBudgetRef5']."'");
						   //echo "<br>";
						   $ad5_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
						   values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef5']."', 
						   '".$bTotal_ab4."')");  
						   
						   $cp_amount_after_ab4 = $cp_amount_after_ab4 * (-1);
						   //5th adjustment
							$select_ab5=mysqli_query($db,"select * from tblbudget where bID='".$_POST['cpBudgetRef6']."'");
							$row_ab5=mysqli_fetch_array($select_ab5);
							$bTotal_ab5=$row_ab5['bTotal'] - $row_ab5['bConsumed'];	
							$cp_amount_after_ab5=$bTotal_ab5 - $cp_amount_after_ab4;
						   
						    if($cp_amount_after_ab5 < 0){
								
							   //echo "<br>";	  
							   $ad6_up=mysqli_query($db,"update tblbudget set bConsumed='".$row_ab5['bTotal']."',bRemaining='0' 
							   where bID='".$_POST['cpBudgetRef6']."'");
							   //echo "<br>";
							   $ad6_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
							   values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef6']."', 
							   '".$bTotal_ab5."')");  
							}else{
								//5th adjustment
								$ba5Consumed =  $row_ab5['bConsumed'] +  $cp_amount_after_ab4;
								$ba5Remaining = $row_ab5['bTotal'] - $ba5Consumed;
								//echo "<br>";	  
								$ad7_up=mysqli_query($db,"update tblbudget set bConsumed='".$ba5Consumed."',bRemaining='".$ba5Remaining."' 
								where bID='".$_POST['cpBudgetRef6']."'");
								//echo "<br>";
								$ad7_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
								values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef6']."', 
								'".$cp_amount_after_ab4."')");
								
							}	
						   
						   
						   
							
						}else{
							
							//4th adjustment
							$ba4Consumed =  $row_ab4['bConsumed'] +  $cp_amount_after_ab3;
							$ba4Remaining = $row_ab4['bTotal'] - $ba4Consumed;
							$ad8_up=mysqli_query($db,"update tblbudget set bConsumed='".$ba4Consumed."',bRemaining='".$ba4Remaining."' 
							where bID='".$_POST['cpBudgetRef5']."'");
							//echo "<br>";
							$ad8_up=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
							values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef5']."', 
							'".$cp_amount_after_ab3."')");
						}	
						
						
						
						
					
					}else{
					   //3rd adjustment
						$ba3Consumed =  $row_ab3['bConsumed'] +  $cp_amount_after_ab2;
					    $ba3Remaining = $row_ab3['bTotal'] - $ba3Consumed;
					    $ad9_up=mysqli_query($db,"update tblbudget set bConsumed='".$ba3Consumed."',bRemaining='".$ba3Remaining."' 
					    where bID='".$_POST['cpBudgetRef4']."'");
					    //echo "<br>";
					    $ad9_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
						values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef4']."', 
						'".$cp_amount_after_ab2."')");	
						
					}
					
					
					
					
					
			}else{
			  //2nd adjustment	
			  $ba2Consumed =  $row_ab2['bConsumed'] +  $cp_amount_after_ab1;
			  $ba2Remaining = $row_ab2['bTotal'] - $ba2Consumed;
			  $ad10_up=mysqli_query($db,"update tblbudget set bConsumed='".$ba2Consumed."',bRemaining='".$ba2Remaining."' 
			  where bID='".$_POST['cpBudgetRef3']."'");
			  //echo "<br>";
			  $ad10_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
				values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef3']."', '".$cp_amount_after_ab1."')");	
				
			} 
			
			
			
			
	  }else{
		  //1st adjustment
		  
		  //echo "<br>";
		  $ba1Consumed =  $row_ab1['bConsumed'] +  $cp_amount_after_mb;
		  $b1Total=$row_ab1['bTotal'];
	      $ba1Remaining = $b1Total - $ba1Consumed;
	      $ad11_up=mysqli_query($db,"update tblbudget set bConsumed='".$ba1Consumed."',bRemaining='".$ba1Remaining."' 
	      where bID='".$_POST['cpBudgetRef2']."'");
	      //echo "<br>";
	      $ad11_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
	        values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef2']."', '".$cp_amount_after_mb."'	)");	
	  }
	   
   }else{
    //echo "first if else";
	//update main budget set consumed equal to total and remainig 0.
	//sum consumed + cp amount then update
	  $bConsumed=$row_main['bConsumed'];
	  $bConsumed = $bConsumed  +  $cpTot;
	  $bTotal=$row_main['bTotal'];
	  $bRemaining = $bTotal - $bConsumed;
	 
	  //echo "<br>";
	  $ad12_up=mysqli_query($db,"update tblbudget set bConsumed='".$bConsumed."',bRemaining='".$bRemaining."' 
	  where bID='".$_POST['cpBudgetRef']."'");
	  //echo "<br>";
	  $ad12_in=mysqli_query($db,"insert into tblcpadjustment (cpID, bID, refbID, bAmount	)
	        values('".$cpID."', '".$_POST['cpBudgetRef']."','".$_POST['cpBudgetRef']."', '".$cpTot."')");	
   }
   }
   
   
}else{
	
	
	$select_main=mysqli_query($db,"select * from tblsbudget where sbID='".$_POST['cpsBudgetRefid']."'");
   $row_main=mysqli_fetch_array($select_main);
   $sbTotal=$row_main['sbTotal'];
   $sbConsumed = $row_main['sbConsumed'];
   $sbConsumed = $sbConsumed  +  $cpTot;
   $sbRemaining = $sbTotal - $sbConsumed;
	
	  //echo "<br>";
	  $ad12_up=mysqli_query($db,"update tblsbudget set sbConsumed='".$sbConsumed."',sbRemaining='".$sbRemaining."' 
	  where sbID='".$_POST['cpsBudgetRefid']."'");
	
	
}
  
			//BC UPDATE				
			if($row_ht['tID']==1){
				
			   if($row_ht['tID']==$_SESSION['tID']){
                  //$update=mysqli_query($db,update tblcp set cpBUM='".$_SESSION['dBC_BUM_HOD']."',
				                       //cpBUM_Flag='2',cpBUM_Date='".date('Y-m-d')."',cpIA_FLAG='1'  where cpID='".$_GET['cpID']."'");
									   
					 $update=mysqli_query($db,"update tblcp set cpBUM='".$_SESSION['dBC_BUM_HOD']."',
				                       cpBUM_Flag='2',cpBUM_Date='".date('Y-m-d')."' where cpID='".$_GET['cpID']."'");				   
					if($_POST['comments']!=""){
						 
						 $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
											  values('".$_GET['cpID']."', '".$_SESSION['dID']."', '".$_SESSION['dBC_BUM_HOD']."',
													 '".mysqli_escape_string($db,$_POST['comments'])."', '".date('Y-m-d H:i')."')");
						  					  
						  
						  
						  					 
					}
					  if($_POST['cpCid']==7 or $_POST['cpCid']==6){					  
					  //$to      = 'umair.riaz@packages.com.pk';
					  $update=mysqli_query($db,"update tblcp set cpEH_Flag='1',cpIA_FLAG='2',cpIA_Date='".date('Y-m-d')."' where cpID='".$_GET['cpID']."'");
					  }else{
					  $update=mysqli_query($db,"update tblcp set cpEH_Flag='2',cpIA_FLAG='2',cpIA_Date='".date('Y-m-d')."' where cpID='".$_GET['cpID']."'");
					  	
					  
						  $delete=mysqli_query($db,'delete from tblcpapprovals where cpID="'.$_GET['cpID'].'"');

							if($_POST['hoe']=='on'){

							$hoe=10;  

							$select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$hoe."'"); 
							$row_hhh=mysqli_fetch_array($select_hhh);
							$dEmail=$row_hhh['dEmail'];

							$insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
									  values('".$_GET['cpID']."', '".$hoe."', '1'	)"); 
									  
							$to = $dEmail;
							$subject = "CAPEX form approval";
							$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
							$cpAmount=$cpTot;
							$cpBudgeted=$_POST['cpDBudget'];

							if($cpBudgeted==1){
							$cpBudgeted='No';
							}elseif($cpBudgeted==2){
							$cpBudgeted='Yes';
							}elseif($cpBudgeted==3){
							$cpBudgeted='Strategic';
							}


							$message = "
							<html>
							<head>
							<title>HTML email</title>
							</head>
							<body>
							<p>CAPEX form is pending to be approved in your log in. 

							</p>
							<table>
							<tr>
							<th>Please click on link to approve/reject:</th>
							<th></th>
							</tr>
							<tr>
							<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
							<th></th>
							</tr>
							<tr>
							<td>Detail of Proposal</td>
							<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
							</tr>
							<tr>
							<td>Capex Amount</td>
							<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
							</tr>
							<tr>
							<td>Budgeted</td>
							<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
							</tr>
							<tr>
							<td><br></td>
							<td></td>
							</tr>
							<tr>
							<td></td>
							<td>This is a system generated email. Please do not 

							reply.</td>
							</tr>
							</table>
							</body>
							</html>
							";

							// Always set content-type when sending HTML email
							$headers = "MIME-Version: 1.0" . "\r\n";
							$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

							// More headers
							$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

							mail($to,$subject,$message,$headers);
							}   


	
						  if($_POST['hop']=='on'){
							 $hop=9;  
							 
							   $select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$hop."'"); 
							   $row_hhh=mysqli_fetch_array($select_hhh);
							   $dEmail=$row_hhh['dEmail'];
							 
							 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
												  values('".$_GET['cpID']."', '".$hop."', '1'	)"); 
												  
							 //email for hop
                                $to = $dEmail;
								$subject = "CAPEX form approval";
								$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
								$cpAmount=$cpTot;
								$cpBudgeted=$_POST['cpDBudget'];

								if($cpBudgeted==1){
								   $cpBudgeted='No';
								}elseif($cpBudgeted==2){
								   $cpBudgeted='Yes';
								}elseif($cpBudgeted==3){
								   $cpBudgeted='Strategic';
								}


								$message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>CAPEX form is pending to be approved in your log in. </p>
								<table>
								<tr>
								<th>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								<tr>
								<td>Detail of Proposal</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
								</tr>
								<tr>
								<td>Capex Amount</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
								</tr>
								<tr>
								<td>Budgeted</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
								</tr>
								<tr>
								<td><br></td>
								<td></td>
								</tr>
								<tr>
								<td></td>
								<td>This is a system generated email. Please do not reply.</td>
								</tr>
								</table>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

								mail($to,$subject,$message,$headers);							 
												  
						  }
						
						  if($_POST['gsm']=='on'){
							 $gsm=57;  
							 
							 $select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$gsm."'"); 
							   $row_hhh=mysqli_fetch_array($select_hhh);
							   $dEmail=$row_hhh['dEmail'];
							 
							 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
												  values('".$_GET['cpID']."', '".$gsm."', '1'	)"); 


							 //email for gsm
                                $to = $dEmail;
								$subject = "CAPEX form approval";
								$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
								$cpAmount=$cpTot;
								$cpBudgeted=$_POST['cpDBudget'];

								if($cpBudgeted==1){
								   $cpBudgeted='No';
								}elseif($cpBudgeted==2){
								   $cpBudgeted='Yes';
								}elseif($cpBudgeted==3){
								   $cpBudgeted='Strategic';
								}


								$message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>CAPEX form is pending to be approved in your log in. </p>
								<table>
								<tr>
								<th>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								<tr>
								<td>Detail of Proposal</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
								</tr>
								<tr>
								<td>Capex Amount</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
								</tr>
								<tr>
								<td>Budgeted</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
								</tr>
								<tr>
								<td><br></td>
								<td></td>
								</tr>
								<tr>
								<td></td>
								<td>This is a system generated email. Please do not reply.</td>
								</tr>
								</table>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

								mail($to,$subject,$message,$headers);	
												  
						  }
						 
						  if($_POST['hcd']=='on'){
							 $hcd=11;  
							 
							 $select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$hcd."'"); 
							   $row_hhh=mysqli_fetch_array($select_hhh);
							   $dEmail=$row_hhh['dEmail'];
							 
							 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
												  values('".$_GET['cpID']."', '".$hcd."', '1'	)"); 
                                $to = $dEmail;
								$subject = "CAPEX form approval";
								$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
								$cpAmount=$cpTot;
								$cpBudgeted=$_POST['cpDBudget'];

								if($cpBudgeted==1){
								   $cpBudgeted='No';
								}elseif($cpBudgeted==2){
								   $cpBudgeted='Yes';
								}elseif($cpBudgeted==3){
								   $cpBudgeted='Strategic';
								}


								$message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>CAPEX form is pending to be approved in your log in. </p>
								<table>
								<tr>
								<th>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								<tr>
								<td>Detail of Proposal</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
								</tr>
								<tr>
								<td>Capex Amount</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
								</tr>
								<tr>
								<td>Budgeted</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
								</tr>
								<tr>
								<td><br></td>
								<td></td>
								</tr>
								<tr>
								<td></td>
								<td>This is a system generated email. Please do not reply.</td>
								</tr>
								</table>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

								mail($to,$subject,$message,$headers);													  
						  }
					
						  if($_POST['ghit']=='on'){
							 $ghit=19;  
							 
							  $select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$ghit."'"); 
							   $row_hhh=mysqli_fetch_array($select_hhh);
							   $dEmail=$row_hhh['dEmail'];
							 
							 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
												  values('".$_GET['cpID']."', '".$ghit."', '1'	)");
							    $to = $dEmail;
								$subject = "CAPEX form approval";
								$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
								$cpAmount=$cpTot;
								$cpBudgeted=$_POST['cpDBudget'];

								if($cpBudgeted==1){
								   $cpBudgeted='No';
								}elseif($cpBudgeted==2){
								   $cpBudgeted='Yes';
								}elseif($cpBudgeted==3){
								   $cpBudgeted='Strategic';
								}


								$message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>CAPEX form is pending to be approved in your log in. </p>
								<table>
								<tr>
								<th>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								<tr>
								<td>Detail of Proposal</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
								</tr>
								<tr>
								<td>Capex Amount</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
								</tr>
								<tr>
								<td>Budgeted</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
								</tr>
								<tr>
								<td><br></td>
								<td></td>
								</tr>
								<tr>
								<td></td>
								<td>This is a system generated email. Please do not reply.</td>
								</tr>
								</table>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

								mail($to,$subject,$message,$headers);					  
						  }
						 
						  if($_POST['ghhr']=='on'){
							   $ghhr=20;  
							   $select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$ghhr."'"); 
							   $row_hhh=mysqli_fetch_array($select_hhh);
							   $dEmail=$row_hhh['dEmail'];
							 
							 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
												  values('".$_GET['cpID']."', '".$ghhr."', '1'	)"); 
						  
						        $to = $dEmail;
								$subject = "CAPEX form approval";
								$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
								$cpAmount=$cpTot;
								$cpBudgeted=$_POST['cpDBudget'];

								if($cpBudgeted==1){
								   $cpBudgeted='No';
								}elseif($cpBudgeted==2){
								   $cpBudgeted='Yes';
								}elseif($cpBudgeted==3){
								   $cpBudgeted='Strategic';
								}


								$message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>CAPEX form is pending to be approved in your log in. </p>
								<table>
								<tr>
								<th>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								<tr>
								<td>Detail of Proposal</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
								</tr>
								<tr>
								<td>Capex Amount</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
								</tr>
								<tr>
								<td>Budgeted</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
								</tr>
								<tr>
								<td><br></td>
								<td></td>
								</tr>
								<tr>
								<td></td>
								<td>This is a system generated email. Please do not reply.</td>
								</tr>
								</table>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

								mail($to,$subject,$message,$headers);
						  }
						
						  if($_POST['coa']=='on'){
							 $coa=12;  
							 $select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$coa."'"); 
							   $row_hhh=mysqli_fetch_array($select_hhh);
							   $dEmail=$row_hhh['dEmail'];
							 
							 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
												  values('".$_GET['cpID']."', '".$coa."', '1'	)"); 
						  
						     $to = $dEmail;
								$subject = "CAPEX form approval";
								$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
								$cpAmount=number_format($cpTot);
								$cpBudgeted=$_POST['cpDBudget'];

								if($cpBudgeted==1){
								   $cpBudgeted='No';
								}elseif($cpBudgeted==2){
								   $cpBudgeted='Yes';
								}elseif($cpBudgeted==3){
								   $cpBudgeted='Strategic';
								}


								$message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>CAPEX form is pending to be approved in your log in. </p>
								<table>
								<tr>
								<th>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								<tr>
								<td>Detail of Proposal</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
								</tr>
								<tr>
								<td>Capex Amount</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
								</tr>
								<tr>
								<td>Budgeted</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
								</tr>
								<tr>
								<td><br></td>
								<td></td>
								</tr>
								<tr>
								<td></td>
								<td>This is a system generated email. Please do not reply.</td>
								</tr>
								</table>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

								mail($to,$subject,$message,$headers);
						  }
						
						  if($_POST['cfo']=='on'){
							 $cfo=13;  
							 
							  $select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$cfo."'"); 
							   $row_hhh=mysqli_fetch_array($select_hhh);
							   $dEmail=$row_hhh['dEmail'];
							 
							 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
												  values('".$_GET['cpID']."', '".$cfo."', '1'	)"); 
						  
						        $to = $dEmail;
								$subject = "CAPEX form approval";
								$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
								$cpAmount=$cpTot;
								$cpBudgeted=$_POST['cpDBudget'];

								if($cpBudgeted==1){
								   $cpBudgeted='No';
								}elseif($cpBudgeted==2){
								   $cpBudgeted='Yes';
								}elseif($cpBudgeted==3){
								   $cpBudgeted='Strategic';
								}


								$message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>CAPEX form is pending to be approved in your log in. </p>
								<table>
								<tr>
								<th>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								<tr>
								<td>Detail of Proposal</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
								</tr>
								<tr>
								<td>Capex Amount</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
								</tr>
								<tr>
								<td>Budgeted</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
								</tr>
								<tr>
								<td><br></td>
								<td></td>
								</tr>
								<tr>
								<td></td>
								<td>This is a system generated email. Please do not reply.</td>
								</tr>
								</table>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

								mail($to,$subject,$message,$headers);
						  }  
						
						  if($_POST['md']=='on'){
							 $md=14;  
							 
							 $select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$md."'"); 
							   $row_hhh=mysqli_fetch_array($select_hhh);
							   $dEmail=$row_hhh['dEmail'];
							 
							 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
												  values('".$_GET['cpID']."', '".$md."', '1'	)"); 
						  
						        $to = $dEmail;
								$subject = "CAPEX form approval";
								$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
								$cpAmount=$cpTot;
								$cpBudgeted=$_POST['cpDBudget'];

								if($cpBudgeted==1){
								   $cpBudgeted='No';
								}elseif($cpBudgeted==2){
								   $cpBudgeted='Yes';
								}elseif($cpBudgeted==3){
								   $cpBudgeted='Strategic';
								}


								$message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>CAPEX form is pending to be approved in your log in. </p>
								<table>
								<tr>
								<th>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								<tr>
								<td>Detail of Proposal</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
								</tr>
								<tr>
								<td>Capex Amount</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
								</tr>
								<tr>
								<td>Budgeted</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
								</tr>
								<tr>
								<td><br></td>
								<td></td>
								</tr>
								<tr>
								<td></td>
								<td>This is a system generated email. Please do not reply.</td>
								</tr>
								</table>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

								mail($to,$subject,$message,$headers);
						  } 
						  if($_POST['inv']=='on'){
							 
							 $hcd=11;  
							 
							  $select_hhh=mysqli_query($db,"select * from tbldepts where dID='15'"); 
							   $row_hhh=mysqli_fetch_array($select_hhh);
							   $dEmail=$row_hhh['dEmail'];
							 
							 
							 /*$insert=mysqli_query($db,insert into tblcpapprovals (cpID, cpAID, cpAStatus,cpADate)
												  values('".$_GET['cpID']."', '".$hcd."', '2','".date('Y-m-d')."')"); */
							 $update=mysqli_query($db,"update tblcp set cpINV_Flag='1' where cpID='".$_GET['cpID']."'");		
							 
							    $to = $dEmail;
								$subject = "CAPEX form approval";
								$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
								$cpAmount=$cpTot;
								$cpBudgeted=$_POST['cpDBudget'];

								if($cpBudgeted==1){
								   $cpBudgeted='No';
								}elseif($cpBudgeted==2){
								   $cpBudgeted='Yes';
								}elseif($cpBudgeted==3){
								   $cpBudgeted='Strategic';
								}


								$message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>CAPEX form is pending to be approved in your log in. </p>
								<table>
								<tr>
								<th>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								<tr>
								<td>Detail of Proposal</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
								</tr>
								<tr>
								<td>Capex Amount</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
								</tr>
								<tr>
								<td>Budgeted</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
								</tr>
								<tr>
								<td><br></td>
								<td></td>
								</tr>
								<tr>
								<td></td>
								<td>This is a system generated email. Please do not reply.</td>
								</tr>
								</table>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

								mail($to,$subject,$message,$headers);
						  }   
					 
					  }
					  				
			   }else{
			       
			       $update=mysqli_query($db,"update tblcp set cpDepartment_Flag='1',
				   cpBC_Flag='2',cpBC_Date='".date('Y-m-d')."',
				   cpBUM='".$_SESSION['dBC_BUM_HOD']."',cpBUM_Flag='1',cpEH_Flag='0'  
				   where cpID='".$_GET['cpID']."'");
					if($_POST['comments']!=""){
						 
						 $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
											  values('".$_GET['cpID']."', '".$_SESSION['dID']."', '".$_SESSION['dBC_BUM_HOD']."',
													 '".mysqli_escape_string($db,$_POST['comments'])."', '".date('Y-m-d H:i')."')");
					
						 if($_POST['cpCid']=='7'){					  
						  $to      = 'suleman.javed@packages.com.pk';
						  $email   = 'cep@packages.com.pk';
						  $subject = 'Need Comments for CEP '.$_GET['cpID'];
						   $message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>Dear Sir, </p>
								
								<p>CAPEX form is pending to be comment in your log in. </p>
								<table>
								<tr>
								<th style='text-align:left;'>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								
								
								</table>
								<p>This is a system generated email. Please do not reply.</p>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cep@packages.com.pk>' . "\r\n";
					            mail($to,$subject,$message,$headers);
						  }
						  elseif($_POST['cpCid']=='6'){					  
						  $to      = 'mobin.javed@packages.com.pk';
						  $email   = 'cep@packages.com.pk';
						  $subject = 'Need Comments for CEP '.$_GET['cpID'];
						   $message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>Dear Sir, </p>
								
								<p>CAPEX form is pending to be comment in your log in. </p>
								<table>
								<tr>
								<th style='text-align:left;'>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								
								
								</table>
								<p>This is a system generated email. Please do not reply.</p>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cep@packages.com.pk>' . "\r\n";
					            mail($to,$subject,$message,$headers);
						  }
					  }
					  
					  if($_POST['cpCid']==7 or $_POST['cpCid']==6){					  
					  //$to      = 'umair.riaz@packages.com.pk';
					  $update=mysqli_query($db,"update tblcp set cpBUM_Flag='1',cpEH_Flag='1' where cpID='".$_GET['cpID']."'");
					  }else{
					  $update=mysqli_query($db,"update tblcp set cpBUM_Flag='1',cpEH_Flag='2' where cpID='".$_GET['cpID']."'");
					  }	
					  
					  
					  					
			    }	
			}elseif($row_ht['tID']==2){
			   		   

			   $update=mysqli_query($db,"update tblcp set cpDepartment_Flag='1',cpBC='".$_SESSION['dBC_BUM_HOD']."',cpBC_Flag='1',
			                        cpEH_Flag='".$cpEH_Flag."' where cpID='".$_GET['cpID']."'");
			   if($_POST['comments']!=""){
					 $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
					     		          values('".$_GET['cpID']."', '".$_SESSION['dID']."', '".$_SESSION['dBC_BUM_HOD']."',
										         '".mysqli_escape_string($db,$_POST['comments'])."', '".date('Y-m-d H:i')."')");
			   
                      if($_POST['cpCid']=='7'){					  
					  $to      = 'suleman.javed@packages.com.pk';
					  $email   = 'cep@packages.com.pk';
					  $subject = 'Need Comments for CEP '.$_GET['cpID'];
					   $message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>Dear Sir, </p>
								
								<p>CAPEX form is pending to be comment in your log in. </p>
								<table>
								<tr>
								<th style='text-align:left;'>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								
								
								</table>
								<p>This is a system generated email. Please do not reply.</p>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cep@packages.com.pk>' . "\r\n";
					            mail($to,$subject,$message,$headers);
					  }
					  elseif($_POST['cpCid']=='6'){					  
					  $to      = 'mobin.javed@packages.com.pk';
					  $email   = 'cep@packages.com.pk';
					  $subject = 'Need Comments for CEP '.$_GET['cpID'];
					   $message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>Dear Sir, </p>
								
								<p>CAPEX form is pending to be comment in your log in. </p>
								<table>
								<tr>
								<th style='text-align:left;'>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								
								
								</table>
								<p>This is a system generated email. Please do not reply.</p>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cep@packages.com.pk>' . "\r\n";
					            mail($to,$subject,$message,$headers);
					  }
			   }
                
                      
					  
					  
					  if($_POST['cpCid']==7 or $_POST['cpCid']==6){					  
					  //$to      = 'umair.riaz@packages.com.pk';
					  $update=mysqli_query($db,"update tblcp set cpEH_Flag='1' where cpID='".$_GET['cpID']."'");
					  }else{
					  $update=mysqli_query($db,"update tblcp set cpEH_Flag='2' where cpID='".$_GET['cpID']."'");
					  }	
					  

						
												  
             			   
			}elseif($row_ht['tID']==3){
			
			   if($_SESSION['dID']!=$_SESSION['dBC_BUM_HOD']){
				  $update=mysqli_query($db,"update tblcp set cpDepartment_Flag='1',cpHOD='".$_SESSION['dBC_BUM_HOD']."',cpHOD_Flag='1'
				                       where cpID='".$_GET['cpID']."'");
			      if($_POST['comments']!=""){
					 $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
					     		          values('".$_GET['cpID']."', '".$_POST['cpDepartment']."', '".$_SESSION['dBC_BUM_HOD']."',
										  '".mysqli_escape_string($db,$_POST['comments'])."', '".date('Y-m-d H:i')."')");
				   }
			   
			   }else{
				  $update=mysqli_query($db,"update tblcp set cpDepartment_Flag='1',cpHOD='".$_SESSION['dBC_BUM_HOD']."',cpHOD_Flag='2',
				                       cpHOD_Date='".date('Y-m-d')."',cpEH_Flag='".$cpEH_Flag."'
									   where cpID='".$_GET['cpID']."'");
                  if($_POST['comments']!=""){
					 $insert=mysqli_query($db,"insert into tblcpcomments (cpID, cpFDepartment,cpTDepartment, cpComments, cpCDateTime) 
					     		          values('".$_GET['cpID']."', '".$_SESSION['dID']."', '8',
										         '".mysqli_escape_string($db,$_POST['comments'])."', '".date('Y-m-d H:i')."')");
										  
					  if($_POST['cpCid']=='7'){					  
					  $to      = 'suleman.javed@packages.com.pk';
					  $email   = 'cep@packages.com.pk';
					  $subject = 'Need Comments for CEP '.$_GET['cpID'];
					  $message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>Dear Sir, </p>
								
								<p>CAPEX form is pending to be comment in your log in. </p>
								<table>
								<tr>
								<th style='text-align:left;'>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								
								
								</table>
								<p>This is a system generated email. Please do not reply.</p>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cep@packages.com.pk>' . "\r\n";
					            mail($to,$subject,$message,$headers);
					  }
					  elseif($_POST['cpCid']=='6'){					  
					  $to      = 'mobin.javed@packages.com.pk';
					  $email   = 'cep@packages.com.pk';
					  $subject = 'Need Comments for CEP '.$_GET['cpID'];
					  $message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>Dear Sir, </p>
								
								<p>CAPEX form is pending to be comment in your log in. </p>
								<table>
								<tr>
								<th style='text-align:left;'>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								
								
								</table>
								<p>This is a system generated email. Please do not reply.</p>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cep@packages.com.pk>' . "\r\n";
					            mail($to,$subject,$message,$headers);
					  }
				   }	  
					 
					  if($_POST['cpCid']==7 or $_POST['cpCid']==6){					  
					  //$to      = 'umair.riaz@packages.com.pk';
					   $update=mysqli_query($db,"update tblcp set cpEH_Flag='1',cpIA_FLAG='1' where cpID='".$_GET['cpID']."'");
					  }else{
					   $update=mysqli_query($db,"update tblcp set cpEH_Flag='2',cpIA_FLAG='1' where cpID='".$_GET['cpID']."'");
					  
					
				          $delete=mysqli_query($db,'delete from tblcpapprovals where cpID="'.$_GET['cpID'].'"');
	

						  if($_POST['coa']=='on'){
							 $coa=14;  
							 
							 $select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$coa."'"); 
							   $row_hhh=mysqli_fetch_array($select_hhh);
							   $dEmail=$row_hhh['dEmail'];
							 
							 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
												  values('".$_GET['cpID']."', '".$coa."', '1'	)"); 
						  
						  		$to = $dEmail;
								$subject = "CAPEX form approval";
								$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
								$cpAmount=number_format($cpTot);
								$cpBudgeted=$_POST['cpDBudget'];

								if($cpBudgeted==1){
								   $cpBudgeted='No';
								}elseif($cpBudgeted==2){
								   $cpBudgeted='Yes';
								}elseif($cpBudgeted==3){
								   $cpBudgeted='Strategic';
								}


								$message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>CAPEX form is pending to be approved in your log in. </p>
								<table>
								<tr>
								<th>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								<tr>
								<td>Detail of Proposal</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
								</tr>
								<tr>
								<td>Capex Amount</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
								</tr>
								<tr>
								<td>Budgeted</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
								</tr>
								<tr>
								<td><br></td>
								<td></td>
								</tr>
								<tr>
								<td></td>
								<td>This is a system generated email. Please do not reply.</td>
								</tr>
								</table>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

								mail($to,$subject,$message,$headers);
						  
						  }
						
						  if($_POST['md']=='on'){
							 $md=59;  
							 
							  $select_hhh=mysqli_query($db,"select * from tbldepts where dID='".$md."'"); 
							   $row_hhh=mysqli_fetch_array($select_hhh);
							   $dEmail=$row_hhh['dEmail'];
							 
							 $insert=mysqli_query($db,"insert into tblcpapprovals (cpID, cpAID, cpAStatus)
												  values('".$_GET['cpID']."', '".$md."', '1'	)"); 
						  
						  													  
						        $to = $dEmail;
								$subject = "CAPEX form approval";
								$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
								$cpAmount=$cpTot;
								$cpBudgeted=$_POST['cpDBudget'];

								if($cpBudgeted==1){
								   $cpBudgeted='No';
								}elseif($cpBudgeted==2){
								   $cpBudgeted='Yes';
								}elseif($cpBudgeted==3){
								   $cpBudgeted='Strategic';
								}


								$message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>CAPEX form is pending to be approved in your log in. </p>
								<table>
								<tr>
								<th>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								<tr>
								<td>Detail of Proposal</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
								</tr>
								<tr>
								<td>Capex Amount</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
								</tr>
								<tr>
								<td>Budgeted</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
								</tr>
								<tr>
								<td><br></td>
								<td></td>
								</tr>
								<tr>
								<td></td>
								<td>This is a system generated email. Please do not reply.</td>
								</tr>
								</table>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

								mail($to,$subject,$message,$headers);
						  
						  } 
						  if($_POST['inv']=='on'){
							 
                             $hcd=15;  
							 
							 $select_hhh=mysqli_query($db,"select * from tbldepts where dID='15'"); 
							   $row_hhh=mysqli_fetch_array($select_hhh);
							   $dEmail=$row_hhh['dEmail'];
							 
							 /*$insert=mysqli_query($db,insert into tblcpapprovals (cpID, cpAID, cpAStatus)
												  values('".$_GET['cpID']."', '".$hcd."', '2'	)"); 							 */
							  
							 $update=mysqli_query($db,"update tblcp set cpINV_Flag='1' where cpID='".$_GET['cpID']."'");		
							 $to = $dEmail;
								$subject = "CAPEX form approval";
								$cpDetail=mysqli_real_escape_string($db,$_POST['cpDetail']);
								$cpAmount=$cpTot;
								$cpBudgeted=$_POST['cpDBudget'];

								if($cpBudgeted==1){
								   $cpBudgeted='No';
								}elseif($cpBudgeted==2){
								   $cpBudgeted='Yes';
								}elseif($cpBudgeted==3){
								   $cpBudgeted='Strategic';
								}


								$message = "
								<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p>CAPEX form is pending to be approved in your log in. </p>
								<table>
								<tr>
								<th>Please click on link to approve/reject:</th>
								<th></th>
								</tr>
								<tr>
								<th><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>http://intranet.packages.com.pk/intranet_packages/request-initiation>CapexForm</a></th>
								<th></th>
								</tr>
								<tr>
								<td>Detail of Proposal</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpDetail."</a></td>
								</tr>
								<tr>
								<td>Capex Amount</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpAmount."</a></td>
								</tr>
								<tr>
								<td>Budgeted</td>
								<td><a href='http://intranet.packages.com.pk/intranet_packages/request-initiation' target='_blank'>".$cpBudgeted."</a></td>
								</tr>
								<tr>
								<td><br></td>
								<td></td>
								</tr>
								<tr>
								<td></td>
								<td>This is a system generated email. Please do not reply.</td>
								</tr>
								</table>
								</body>
								</html>
								";

								// Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

								mail($to,$subject,$message,$headers);
						  }   
					   
						}					  
				   								   
			   }
						   
			}
			
			
			
			
}
             

            if($_FILES["files11"]["name"]!=""){	 
			
			$temp = explode(".", $_FILES["files11"]["name"]);
			$cpQuotation1 = $temp[0].round(microtime(true)) . rand() . '.' . end($temp);
			move_uploaded_file($_FILES["files11"]["tmp_name"], "img/quotations/" . $cpQuotation1);
			$insert_q=mysqli_query($db,"insert into tblcpquotations(cpID, cpQuotation) values('".$_GET['cpID']."', '".$cpQuotation1."')");
			} 

			if($_FILES["files22"]["name"]!=""){	 
			$temp = explode(".", $_FILES["files22"]["name"]);
			$cpQuotation2 = $temp[0].round(microtime(true)) . rand() . '.' . end($temp);
			move_uploaded_file($_FILES["files22"]["tmp_name"], "img/quotations/" . $cpQuotation2);
			$insert_q=mysqli_query($db,"insert into tblcpquotations(cpID, cpQuotation) values('".$_GET['cpID']."', '".$cpQuotation2."')");
			} 

			if($_FILES["files33"]["name"]!=""){	 
			$temp = explode(".", $_FILES["files33"]["name"]);
			$cpQuotation3 = $temp[0].round(microtime(true)) . rand() . '.' . end($temp);
			move_uploaded_file($_FILES["files33"]["tmp_name"], "img/quotations/" . $cpQuotation3);
			$insert_q=mysqli_query($db,"insert into tblcpquotations(cpID, cpQuotation) values('".$_GET['cpID']."', '".$cpQuotation3."')");
			}
			
            header("location:index.php");
}

}
if($_GET['delete']=='capex'){
   $delete1=mysqli_query($db,'delete from tblcp where cpID="'.base64_decode($_GET['cpID']).'"');
   $delete2=mysqli_query($db,'delete from tblcpapprovals where cpID="'.base64_decode($_GET['cpID']).'"');
   $delete3=mysqli_query($db,'delete from tblcpcomments where cpID="'.base64_decode($_GET['cpID']).'"');
   $select=mysqli_query($db,'select * from tblcpquotations where cpID="'.base64_decode($_GET['cpID']).'"');
   while($row=mysqli_fetch_array($select)){
          $file='img/quotations/'.$row['cpQuotation'];
          unlink($file);
   }
   
   $delete4=mysqli_query($db,'delete from tblcpquotations where cpID="'.base64_decode($_GET['cpID']).'"');
   header("location:pending-list.php");
}
if($_POST['GET_LIST1']=='get_list1'){
	
	$html='<select id="cpBYes2" name="cpBYes2"  style="width:500px;" onchange="check_budget(this.value);">
										<option value=""></option>';
										$select_b=mysqli_query($db,"select * from tblbudget where bMDept='".$_POST['bMDep']."' and bID!='".$_POST['cpBudgetRef']."' order by bDesc asc");
										while($row_b=mysqli_fetch_array($select_b)){ 
										$remainig=$row_b['bTotal'] - $row_b['bConsumed'];
										if($remainig>0){
										$html.='<option value="'.$row_b['bID'].'">'.$row_b['bDesc'].'('.$row_b['bDept'].')----Cost='.number_format($row_b['bTotal']).'----Remaining Cost='.number_format($remainig).'</option>';
										}
										
										 }
	$html.='</select> <a href="javascript:" onclick="get_b_list2('.$_POST['cpBudgetRef'].');" id="bl2">+ Adjust Budget</a><div id="blist2"></div>';
	echo $html;
}

if($_POST['GET_LIST2']=='get_list2'){
	
	$html='<select id="cpBYes3" name="cpBYes3"  style="border-bottom:1px dashed;border-top:none;border-left:none;border-right:none;width:500px;" onchange="check_budget(this.value);">
										<option value=""></option>';
										$select_b=mysqli_query($db,"select * from tblbudget where bMDept='".$_POST['bMDep']."' order by bDesc asc");
										while($row_b=mysqli_fetch_array($select_b)){ 
										$remainig=$row_b['bTotal'] - $row_b['bConsumed'];
										 if($remainig>0){
										$html.='<option value="'.$row_b['bID'].'">'.$row_b['bDesc'].'('.$row_b['bDept'].')----Cost='.number_format($row_b['bTotal']).'----Remaining Cost='.number_format($remainig).'</option>';
										  }
										 }
	$html.='</select> ';
	echo $html;
}

if($_POST['CHECK_BUDGET']=='check_budget'){
	$cpRAmount="";
    $FAMOUNT=$_POST['FAMOUNT'];
	if($FAMOUNT<0){
	   $bADAmount = $FAMOUNT * (-1);	
		
	}
	$BID=$_POST['BID'];
	$CPID=$_POST['CPID'];
	$select_b=mysqli_query($db,"select * from tblbudget where bID='".$BID."'");
	$row_b=mysqli_fetch_array($select_b);
	$bTotal=$row_b['bTotal'];
	$bConsumed=$row_b['bConsumed'];
	$remainig=$bTotal-$bConsumed;
	$cpRAmount=$remainig - $bADAmount;
	
	//echo $_SESSION['tbid'];
	//if(!isset($_SESSION['tbid'])){
		
		//$_SESSION['tbid']=rand(); 
		//$insert_t=mysqli_query('insert into tbltembadjust (tempID, bID, cpID, cpRAmount, bADAmount)
	                          // values("'.$_SESSION['tbid'].'", "'.$BID.'", "'.$CPID.'", "'.$cpRAmount.'", "'.$bADAmount.'")');
		
	//}//else{
		
		//$delete=mysqli
	//}
	
	echo $cpRAmount;
}
if($_POST['adjust_amount']=="adjust_amount"){
	
	$adjusted=$_POST['adjusted'];
	
	$select=mysqli_query($db,"select * from tblbudget where bID='".$_POST['id']."'");
	$row=mysqli_fetch_array($select);
	
	$remainig=$row['bTotal']-$row['bConsumed'];
	$final_adjusted=$remainig+$adjusted;
	echo $final_adjusted;
	
	
}
if($_POST['show_cat']=='show_cat'){
	if($_POST['id']==3){
	$html=' <select id="cpCid" name="cpCid" required ><option value=""></option>';
	 $select_cat=mysqli_query($db,"select * from tblcategory where cID!='6' and cStatus='1' order by cName");
	 while($row_cat=mysqli_fetch_array($select_cat)){

	$html.='<option value="'.$row_cat['cID'].'" class="even">'.$row_cat['cName'].'</option>';
	}
	$html.='</select">';
	}else{
	$html=' <select id="cpCid" name="cpCid" required ><option value=""></option>';
	 $select_cat=mysqli_query($db,"select * from tblcategory where cStatus='1' order by cName");
	 while($row_cat=mysqli_fetch_array($select_cat)){

	$html.='<option value="'.$row_cat['cID'].'" class="even">'.$row_cat['cName'].'</option>';
	}
	$html.='</select">';		
		
	}
	
	echo $html;
	
	
	
}
if($_POST['check_ca']=='check_ca'){
	if($_SESSION['bMDept']!='BUFC' and $_SESSION['bMDept']!='BUFP' and $_SESSION['bMDept']!='BUCP'){
	
	$cpBudgetRef=$_POST['cpBudgetRef'];
	$cpTot=$_POST['cpTot'];
	$select=mysqli_query($db,"select * from tblbudget where bID='".$cpBudgetRef."'");
	$row=mysqli_fetch_array($select);
	
	$remainig=$row['bTotal']-$row['bConsumed'];
	$diff=$cpTot-$remainig;
		if($diff>0){
			echo '
									<b style="color:red;" id="bad">Budgeted Amount is '.number_format($remainig).'.Please Adjust Amount = '.number_format($diff).'.</b> <input type="hidden" name="adjusted" id="adjusted" value="'.$diff*(-1).'">';
		}else{
			
			echo "0";
		}
		
    }else{
		
		echo "0";
	}
	
}	


if($_POST['check_ca2']=='check_ca2'){
	
	
	$cpSBudgetRef=$_POST['cpSBudgetRef'];
	$cpTot=$_POST['cpTot'];
	
	$select=mysqli_query($db,"select * from tblsbudget where sbID='".$cpSBudgetRef."'");
	$row=mysqli_fetch_array($select);
	
	$remainig=$row['sbTotal']-$row['sbConsumed'];
	//$diff=$cpTot-$remainig;
		if($cpTot>$remainig){
			echo '1';
		}else{
			
			echo "0";
		}

}
if($_GET['action']=='insert-suggestion'){
	
	
	$insert=mysqli_query($db,"insert into tblsuggestions (dID, sDescription,sDate) 
									values('".$_SESSION['dID']."', '".mysqli_escape_string($db,$_POST['sDescription'])."',
									'".date('Y-m-d H:i')."')");
	$select2=mysqli_query($db,"select dName from tbldepts where dID='".$_SESSION['dID']."'");
	$row2=mysqli_fetch_array($select2);	
    $dName=$row2['dName'];	
	$to = 'suleman.javed@packages.com.pk,amjad.shaikh@packages.com.pk,kazam.mahmood@packages.com.pk,
	maheen.khan@packages.com.pk,umair.riaz@packages.com.pk';
	//$to = 'umair.riaz@packages.com.pk,kazam.mahmood@packages.com.pk';
	$subject = "New Suggestion For Capex Form";
	$sDescription=$_POST['sDescription'];
	


	$message = "
	<html>
	<head>
	<title>HTML email</title>
	</head>
	<body>
	
	<table>
		
	<tr>
	<td><b>Detail of Suggestion</b></td>
	<td></td>
	</tr>
	
	<tr>
	<td><textarea name='sDescription' cols='50' rows='3'  id='sDescription' readonly><pre>".$sDescription."</pre></textarea></td>
	<td></td>
	</tr>
	
	<tr>
	<td>Created By:</td>
	<td></td>
	</tr>
	<tr>
	<td>".$dName."</td>
	<td></td>
	</tr>
	<tr>
	<td><br></td>
	<td></td>
	</tr>
	
	</table>
	</body>
	</html>
	";

	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// More headers
	$headers .= 'From: <cp@packages.com.pk>' . "\r\n";

	mail($to,$subject,$message,$headers);								
									
									
	header("location:suggestions.php");
	
}	

?>