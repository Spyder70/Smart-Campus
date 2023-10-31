<?php
session_start();
ob_start();
$_SESSION['SMC_Login']="";
$_SESSION['a']="";

//require("connect.php");
require("DB/config.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
$ck=$_SESSION['SMC_Login'];
if($ck=="yes")
{
	header("location:DashBoard/");
	exit;
}
if(isset($_POST['Submit']))
{
        $Frfx=0;
        if(isset($_SERVER['HTTP_USER_AGENT']))
        { $agent=$_SERVER['HTTP_USER_AGENT'];}
          if((strpos($agent,"Chrome")==TRUE) or (strpos($agent,"CHROME")==TRUE)){$Frfx=1;}

	$username = $_POST['user'];
	$password = $_POST['password'];

	$a=0;

	$sql ="SELECT * FROM Faculty WHERE Faculty_ID=:username and Password=:password";
    	$query= $dbh -> prepare($sql);
    	$query-> bindParam(':username', $username, PDO::PARAM_STR);
    	$query-> bindParam(':password', $password, PDO::PARAM_STR);
    	$query-> execute();
    	$results=$query->fetchAll(PDO::FETCH_OBJ);
    	if(($query->rowCount() > 0) and ($Frfx==1) )
   	{


		foreach($results as $result)
		{
			$_SESSION['F_ID']=$result->Faculty_ID;
			$_SESSION['F_Name']=$result->Name;
            		$_SESSION['F_Role']=$result->Role;
			$_SESSION['F_Email']=$result->Email;
			$_SESSION['F_Dept']=$result->Department;
			$_SESSION['F_Desig']=$result->Designation;

			$_SESSION['SMC_Login']="yes";   //Logged In
			$_SESSION['msg_err']="0";
		}
		if($username===$password)
		{
		header("location:ChangePassword/ChangePassword.php");
		exit;
		}
		header("location:DashBoard/");
		exit;
		ob_end_flush();
	}
	else
	{
		$a=1;
		$_SESSION['a']=$a;
		$_SESSION['msg']="Invalid Login.!";
		if($Frfx==0){$_SESSION['msg']="Please Use Google Chrome.!";}

	}
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="images/favicon.ico">

<div class="header" style="color:blue;text-align:center;  background: #fff;  padding-top: -10px; ">
  <h1>Header</h1>
  <p style="color:#000099;text-align:left;  font-size:40px;font-weight:bold;   margin-top: -700px;">Architecture School</p>
</div>
<title>architecture-school</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">




	<!-- Custom Theme files -->
	 <link href="css/login-style.css" rel="stylesheet" type="text/css" media="all" />
	 <link href="css/login-font-awesome.min.css" rel="stylesheet" type="text/css" media="all" />
	<!-- //Custom Theme files -->

	<!-- web font -
	<link href="//fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet">
	    web font -->
<!---=========  Header links starts ========-------->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<!---=========  Header links ends========-------->
</head>
<body>

<!-- main -->
<!-------============= Nav Bar starts ==============------>
	<!-- Just an image -->
	<nav class="navbar navbar-light bg-light">
		<a class="navbar-brand" href="#">
			<img src="./images/logo.png" width="400" height="50" alt="">
		</a>
	</nav>
	<!-------============= Nav Bar starts ==============------>

<div class="w3layouts-main">

	<div class="bg-layer">
	<style>
            .blink {
                animation: blinker 1.5s linear infinite;
                color:#000099;
				font-weight: bold;
                font-family: fantasy;
				font-size:40px;
			background-color:white;
			padding: ;
            }
            @keyframes blinker {
                10% {
                    opacity: 0;
                }
            }
        </style>
		<h1><b><marquee class="blink" direction="left" scrollamount="20">Architecture-School &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Architecture-School &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Architecture-School</marquee></b></h1>
		<div class="header-main">
			
			<div class="main-icon">
			<h3 style="Margin-bottom:15px;margin-top:-10px;font-weight:bold;"></h3>
				<span class="fa"><img height="60em" src="images/main1.png"></span>
				<div class="links" style='margin-top:-10px;Margin-bottom:5px;'>
						<span style='font-weight:bold;color:gold;'><?php
						if($_SESSION['a']==1){
						echo $_SESSION['msg'];
						$_SESSION['a']=0;
						}?></span>
					</div>
			</div>

			<div class="header-left-bottom">

				<form action="index.php" method="post">

					<div class="icon1">
						<input id="user" name="user" type="text" placeholder="User name" required=""/>
						<label  class="fa fa-user input-icon"></label>
					</div>
					<div class="icon1">
						<input id="password" name="password" type="password" placeholder="Password" required=""/>
						<label  class="fa fa-lock input-icon"></label>
					</div>

					<div class="bottom">
						<input type="submit" class="btn" id="Submit" name="Submit" value="Log In"/>
					</div>
					<div class="links">
						<span>	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="Forgot.php">Forgot Password ?  Click Here</a></span>
					</div>
				</form>
			</div>

		</div>
<style>
      p {
        text-align: center;
        color: #000099;
      }
      p span {
        background-color: #000099;
      }    </style>
		<!-- copyright -->
		<div class="copyright">
		    <p>
      <span>architectureschool@Nmamit : 20121 &hearts; Students MCA</span>
    </p>
		
		</div>
		<!-- //copyright -->
	</div>
</div>
<!-- //main -->

</body>
</html>