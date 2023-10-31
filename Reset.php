<?php
session_start();
//require("connect.php");
require("DB/config.php");
require 'class.phpmailer.php';
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
$ck=$_SESSION['SMC_Login'];
if($ck=="yes")
{
	header("location:DashBoard/");
	exit;
} 
$a=0;
if(isset($_GET['FKEY']) && isset($_GET['FID']) )
{
	
	$fkey = $_GET['FKEY'];
	$fid= $_GET['FID'];
	$sql ="SELECT * FROM Faculty WHERE Faculty_ID=:fid and Forgot_Key=:fkey ";
    	$query= $dbh -> prepare($sql);
    	$query-> bindParam(':fid', $fid, PDO::PARAM_STR);
    	$query-> bindParam(':fkey', $fkey, PDO::PARAM_STR);
    	$query-> execute();
    	$results=$query->fetchAll(PDO::FETCH_OBJ);
    	if($query->rowCount() <= 0)
   	{
   	  	$a=2;
		$_SESSION['a']=$a;
		$_SESSION['msg']="Sorry Link got expired....!";
   	}
   	else
   	{
   		$a=22;
		$_SESSION['a']=$a;
		//$_SESSION['msg']="Genuine....!";
   	}
}
if(isset($_POST['Submit']))
{

	$fkey = $_POST['FKEY'];
	$fid = $_POST['FID'];
	$pass1 = $_POST['pass1'];
	
	$a=0;
	
	$sql ="Update Faculty set Password=:pass1 WHERE Faculty_ID=:fid and Forgot_Key=:fkey  ";
    	$query= $dbh -> prepare($sql);
    	$query-> bindParam(':pass1', $pass1, PDO::PARAM_STR);
    	$query-> bindParam(':fid', $fid, PDO::PARAM_STR);
    	$query-> bindParam(':fkey', $fkey, PDO::PARAM_STR);
    	$query-> execute();
    	//$results=$query->fetchAll(PDO::FETCH_OBJ);
    	if($query->rowCount() > 0)
   	{
   	
   		
			$a=2;
			$_SESSION['a']=$a;
			$_SESSION['msg']="Successfully Updated Your Password..";
			
			$sql ="Update Faculty set Forgot_Key='' WHERE Faculty_ID=:fid";
    			$query= $dbh -> prepare($sql);
    			$query-> bindParam(':fid', $fid, PDO::PARAM_STR);
    			$query-> execute();
	}
	else
	{        
			$a=2;
			$_SESSION['a']=$a;
			$_SESSION['msg']="Sorry you have entered same password..";
	}	
		
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Smart Campus</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="" />

	

	<!-- Custom Theme files -->
	 <link href="css/login-style.css" rel="stylesheet" type="text/css" media="all" />
	 <link href="css/login-font-awesome.min.css" rel="stylesheet" type="text/css" media="all" />
	<!-- //Custom Theme files -->

	<!-- web font -
	<link href="//fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet">
	<!-- //web font -->

</head>
<body>

<!-- main -->
<div class="w3layouts-main"> 
	<div class="bg-layer"><br><br>
		<h1>Smart Campus</h1><br>
		<div class="header-main">
			<div class="main-icon">
				<h3>Reset Password</h3> <br>
			</div>
			
			<div class="header-left-bottom">
			<?php  
			 if($_SESSION['a']==22) 
			 {
		        ?>
				<form action="Reset.php" method="post">
					<input type="hidden" style="display: none;" name="FID" id="FID" value="<?php echo $fid; ?>" />
					<input type="hidden" style="display: none;" name="FKEY" id="FKEY" value="<?php echo $fkey; ?>" />
					
					<div class="icon1">
						<input id="pass1" name="pass1" type="password" placeholder="New Password" required=""/>
						<label  class="fa fa-lock input-icon"></label>
					</div>
					
					<div class="icon1">
						<input id="pass2" name="pass2" type="password" placeholder="Confirm Password" required=""/>
						<label  class="fa fa-lock input-icon"></label>
					</div>
					
					
					<div class="bottom">
						<input type="submit" class="btn" id="Submit" name="Submit" value="Update Password"
						 onclick="return Validate()"/>
					</div>
					<div class="links" style="color:orange;font-weight:bold"><center><br>
					<?php 
						if($_SESSION['a']==1){
						echo $_SESSION['msg'];
						$_SESSION['a']=0;
						}?> <span><a style="color:white;font-size:15px" href="index.php">Sign In Here</a></span>
						</center>	
					</div>
				</form>
			<?php  
			  $_SESSION['a']=0;
			 }
			 else if($_SESSION['a']==2)
			 {?>
			 <div class="links" style="color:orange;font-weight:bold">
			 <?php
			 echo "<center>".$_SESSION['msg'];
			 ?><br><br><u>
			 <a style="color:white;font-size:15px" href="index.php">Sign In Here</a></u>
			 </center></div>
			 <?php
			 }
		        ?>	
			</div>
			
		</div>
		
		<!-- copyright -->
		<div class="copyright">
			<p>SmartCampus@Nmamit : 2021 &hearts; Students EMS</p>
		</div>
		<!-- //copyright --> 
	</div>
</div>	
<!-- //main -->

<script type="text/javascript">
    function Validate() {
        var password = document.getElementById("pass1").value;
        var confirmPassword = document.getElementById("pass2").value;
        if (password != confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }
        return true;
    }
</script>

</body>
</html>
