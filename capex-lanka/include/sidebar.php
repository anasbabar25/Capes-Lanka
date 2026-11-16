     
	<aside id="leftsidebar" class="sidebar"> 
        <!-- User Info -->
        <div class="user-info">
            <div class="admin-image"> <img src="logo.png" alt=""> </div>
            <div class="admin-action-info"> <span>Welcome</span>
                <h3>
				<?php 
				 if($_SESSION['department']=='HHH' OR $_SESSION['department']=='INV'){
					 
					 $select_dn=mysqli_query($db,"select dName from tbldepts where dID='".$_SESSION['dID']."'");
					 $row_dn=mysqli_fetch_array($select_dn);
					 if($row_dn['dName']=='COA'){
						 echo "Financial Controller";
					 }else{
						 echo $row_dn['dName'];
					 }
					 
					 
				 }else{ echo $_SESSION['department']; }
				 ?>
				</h3>
                <ul>
                    <li><a href="change-password.php" title="Change Password"><i class="zmdi zmdi-account"></i></a></li>
                       <li><a href="logout.php" title="sign out" ><i class="zmdi zmdi-sign-in"></i></a></li>
                </ul>
            </div>
           
        </div>
        <!-- #User Info --> 
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">MAIN NAVIGATION</li>
                <li class="active open"><a href="index.php"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
				
				 <li><a href="javascript:void(0);" class="menu-toggle waves-effect waves-block toggled"><i class="zmdi zmdi-balance col-cyan"></i><span>Capex </span> </a>
                    <ul class="ml-menu">
					    <?php $dept=$_SESSION['department'];
						 $pos = strpos($dept, 'USER');
						 
					    if ($pos !== false){?>
						<li><a href="new-capex.php">New Capex </a></li> 
						<?php } ?>
						<!--<li><a href="pending-list.php">Pending List</a></li>
						<li><a href="rejected-list.php">Rejected List</a></li>-->
                           


                         <?php 
						 if($_SESSION['tID']==2){
						 ?>
						
						 
						 <li> <a href="budget/admin/budgeted-file.php" target="_blank">Budget File</a></li>
						  <li> <a href="budget/admin/sbudgeted-file.php" target="_blank">Strategic Budget File</a></li>
                         <?php 
						 }
						 ?>
						 

                         <?php 
						 if($_SESSION['department']=='INV'){
						 ?>
						 <!--<li> <a href="http://172.16.25.250/pkgs/capex/pc/inv-pending-list.php" target="_blank">CAPEX 2022</a></li>
						 <li> <a href="http://172.16.25.250/pkgs/capex2019/inv-pending-list.php" target="_blank">CAPEX 2019</a></li>
						  <li><a href="http://172.16.25.250/pkgs/capex/pc2020/index.php" target="_blank">PCL CAPEX 2020</a></li>
						 <li><a href="http://172.16.25.250/pkgs/capex/pkgs2023/index.php" target="_blank">PKGS CAPEX 2023</a></li>
						 <li><a href="http://172.16.25.250/pkgs/capex/jan-june-20203/inv-pending-list/inv-pending-list.php" target="_blank">CAPEX Jan-June 2023</a></li>
						 <li><a href="http://172.16.25.250/pkgs/capex/pc/july-dec-2020/budget/admin/cep-cfile-for-inv-july-dec-2020.php" target="_blank">CEP Completed File July-Dec 2020</a></li>-->
						 <li><a href="budget/admin/new-budgeted-file-for-inv.php" target="_blank">New Budget File 2023</a></li>
						 <li><a href="budget/admin/new-sbudgeted-file-for-inv.php" target="_blank">New Strategic Budget File 2023</a></li>
						 <!--<li><a href="budget/admin/new-budgeted-file-for-inv.php" target="_blank">New Budget File 2020</a></li>
						 <li><a href="budget/admin/new-sbudgeted-file-for-inv.php" target="_blank">New Strategic Budget File 2020</a></li>
						 <li> <a href="http://172.16.25.250/pkgs/capex/pc/july-dec-2020/budget/admin/budgeted-file-for-inv.php" target="_blank">Budget File 2020(Old)</a></li>-->
						 <li><a href="budget/admin/cep-cfile-for-inv.php" target="_blank">CEP Completed File</a></li>
						 <li> <a href="budget/admin/cep-file-for-inv.php" target="_blank">CEP File W/O Budgeted</a></li>
						 <li> <a href="budget/admin/o-budgeted-file-for-inv.php" target="_blank">Over Budgeted File</a></li>
						 <li> <a href="budget/admin/budget-stop.php" target="_blank">Over Budgeted File Stop</a></li>
						 
                         <?php 
						 }
						 ?>
						 
                    </ul>
                </li>
               
                 <?php if($row_dn['dName']=='INV' or $row_dn['dName']=='COA'){?>
                <li class="active open"><a href="suggestions.php"><i class="zmdi zmdi-assignment-o"></i><span>Suggestions</span></a></li>
				 <?php } ?>
               
            </ul>
        </div>
        <!-- #Menu -->
    </aside>
    