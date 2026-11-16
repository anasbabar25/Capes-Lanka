<?php include("include/conn.php");?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>Capital Expenditure Proposal  - Login </title>
<link rel="icon" href="logo.png" type="image/x-icon">
<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" href="assets/icon.css?family=Material+Icons" type="text/css">

<!-- Custom Css -->
<link rel="stylesheet" href="assets/css/main.css"/>

</head>

<body class="theme-cyan authentication">
<div class="container">
    <div class="card-top"></div>
    <div class="card">
        <h1 class="title"><span>Capital Expenditure Proposal - </span>Login <span class="msg">Sign in to start your session</span></h1>
        <div class="body">
            <form action="controllar.php" method="POST">
                <div class="input-group icon before_span">
                    <span class="input-group-addon"> <i class="zmdi zmdi-account"></i> </span>
                    <div class="form-line">
					 <select name="tID" id="tID" class="form-control" onchange="get_list(this.value);" required>
                     <option value=""></option>
                    <?php 
					$select=mysqli_query($db,'select * from tblusertypes order by tID asc');
                    while($row=mysqli_fetch_array($select)){
                    ?>
                    <option value="<?php echo $row['tID'];?>" <?php if($_GET['t']==$row['tID']){echo "selected='selected'";}?>><?php echo $row['tName'];?></option>
                    <?php } ?>                                             
                </select>
						
                    </div>
                </div>
				
				 <div class="input-group icon before_span">
                    <span class="input-group-addon"> <i class="zmdi zmdi-account"></i> </span>
                    <div class="form-line">
					<div id='getlist'>
					<select name="department" id="department" class="form-control">
                                                
                                                <?php if(isset($_GET['p'])=='in'){?>
                                                
                                                <option value="<?php echo $_GET['department'];?>"  class="head2"><?php echo $_GET['department'];?></option>
                                                <?php }else{?>
                                                <option value=""></option>
                                                <?php } ?>
                                                
                                                
                                            </select>
											</div>
						
                    </div>
                </div>
				
				 
				
                <div class="input-group icon before_span">
                    <span class="input-group-addon"> <i class="zmdi zmdi-lock"></i> </span>
                    <div class="form-line">
                        <input type="password" class="form-control" name="dpass" id="dpass" placeholder="Password" required>
                    </div>
                </div>
                <div>
                   
                    <div class="text-center">
                        <input type="submit" class="btn btn-raised waves-effect g-bg-cyan" value="Login">
                        
                    </div>
                    <!--<div class="text-center"> <a href="forgot-password.php">Forgot Password?</a></div>-->
                </div>
            </form>
        </div>
    </div>    
</div>
<div class="theme-bg"></div>

<!-- Jquery Core Js --> 
<script src="assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
<script src="assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->

<script src="assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->

<script>
    


function get_list(tID){



   $.post("get-list3.php",{TID:tID},function(data){
			   
document.getElementById("getlist").innerHtml=$("#getlist").html(data);
  });  

}

    </script>

</body>

</html>